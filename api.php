<?php
require_once __DIR__ . '/db.php';
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function token(): string { return hash_hmac('sha256', 'terceirao-admin-v1', ADMIN_SENHA_HASH); }
function is_admin(): bool { return isset($_COOKIE['adm']) && hash_equals(token(), (string)$_COOKIE['adm']); }
function sair(array $d, int $code = 200): void { http_response_code($code); echo json_encode($d, JSON_UNESCAPED_UNICODE); exit; }
function precisa_admin(): void { if (!is_admin()) sair(['erro' => 'Entre como admin primeiro.'], 403); }
function num($v): ?float {
    if ($v === null || $v === '') return null;
    $v = str_replace(['R$', ' '], '', (string)$v);
    if (strpos($v, ',') !== false) $v = str_replace(['.', ','], ['', '.'], $v);
    return is_numeric($v) ? round((float)$v, 2) : null;
}
function intn($v): ?int { return ($v === null || $v === '') ? null : max(0, (int)$v); }

try {
    $pdo = db();
    $acao = $_GET['acao'] ?? '';
    $in = json_decode(file_get_contents('php://input') ?: '[]', true) ?: [];

    if ($acao === 'dados') {
        $alunos = $pdo->query('SELECT * FROM alunos ORDER BY nome')->fetchAll();
        $mens = []; foreach ($pdo->query('SELECT aluno_id, mes, valor FROM mensalidades') as $m) $mens[$m['aluno_id']][$m['mes']] = (float)$m['valor'];
        $pags = []; foreach ($pdo->query('SELECT * FROM pagamentos ORDER BY id') as $p) { $p['valor'] = (float)$p['valor']; $pags[$p['aluno_id']][] = $p; }
        foreach ($alunos as &$a) {
            $a['id'] = (int)$a['id']; $a['turma_id'] = (int)$a['turma_id'];
            $a['valor_mensal'] = (float)$a['valor_mensal'];
            $a['conv_jantar'] = $a['conv_jantar'] === null ? null : (int)$a['conv_jantar'];
            $a['conv_festa_extra'] = (int)$a['conv_festa_extra']; $a['rifa_qtd'] = (int)$a['rifa_qtd'];
            $a['mens'] = (object)($mens[$a['id']] ?? []);
            $a['pags'] = $pags[$a['id']] ?? [];
        }
        $cfg = cfg_all(); unset($cfg['instalado']);
        sair([
            'admin' => is_admin(),
            'config' => $cfg,
            'turmas' => $pdo->query('SELECT id, nome FROM turmas ORDER BY ordem, id')->fetchAll(),
            'alunos' => $alunos,
            'hoje' => ['mes' => (int)date('n'), 'ano' => (int)date('Y')],
        ]);
    }

    if ($acao === 'login') {
        if (!password_verify((string)($in['senha'] ?? ''), ADMIN_SENHA_HASH)) { usleep(600000); sair(['erro' => 'Senha errada.'], 401); }
        $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
        setcookie('adm', token(), ['expires' => time() + 60 * 60 * 24 * 30, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax', 'secure' => $https]);
        sair(['ok' => true]);
    }
    if ($acao === 'logout') { setcookie('adm', '', ['expires' => 1, 'path' => '/']); sair(['ok' => true]); }

    // ---------- daqui pra baixo só admin ----------
    precisa_admin();

    if ($acao === 'mensalidade') {
        $aid = (int)($in['aluno_id'] ?? 0); $mes = (int)($in['mes'] ?? 0); $v = num($in['valor'] ?? null);
        if ($mes < 1 || $mes > 12 || !$aid) sair(['erro' => 'Dados inválidos.'], 400);
        if ($v === null || $v <= 0) $pdo->prepare('DELETE FROM mensalidades WHERE aluno_id=? AND mes=?')->execute([$aid, $mes]);
        else $pdo->prepare('INSERT INTO mensalidades (aluno_id, mes, valor, atualizado_em) VALUES (?,?,?,NOW()) ON DUPLICATE KEY UPDATE valor=VALUES(valor), atualizado_em=NOW()')->execute([$aid, $mes, $v]);
        sair(['ok' => true]);
    }

    if ($acao === 'salvar_aluno') {
        $nome = trim((string)($in['nome'] ?? ''));
        if ($nome === '') sair(['erro' => 'Coloque o nome.'], 400);
        $d = [(int)$in['turma_id'], mb_substr($nome, 0, 100), num($in['valor_mensal'] ?? 50) ?? 50, intn($in['conv_jantar'] ?? null),
              intn($in['conv_festa_extra'] ?? 0) ?? 0, intn($in['rifa_qtd'] ?? 0) ?? 0, mb_substr(trim((string)($in['obs'] ?? '')), 0, 255)];
        if (!empty($in['id'])) { $d[] = (int)$in['id'];
            $pdo->prepare('UPDATE alunos SET turma_id=?, nome=?, valor_mensal=?, conv_jantar=?, conv_festa_extra=?, rifa_qtd=?, obs=? WHERE id=?')->execute($d);
        } else $pdo->prepare('INSERT INTO alunos (turma_id, nome, valor_mensal, conv_jantar, conv_festa_extra, rifa_qtd, obs) VALUES (?,?,?,?,?,?,?)')->execute($d);
        sair(['ok' => true]);
    }

    if ($acao === 'excluir_aluno') {
        $id = (int)($in['id'] ?? 0);
        foreach (['mensalidades', 'pagamentos'] as $t) $pdo->prepare("DELETE FROM $t WHERE aluno_id=?")->execute([$id]);
        $pdo->prepare('DELETE FROM alunos WHERE id=?')->execute([$id]);
        sair(['ok' => true]);
    }

    if ($acao === 'add_pagamento') {
        $tipo = in_array($in['tipo'] ?? '', ['rifa', 'festa', 'extra'], true) ? $in['tipo'] : 'extra';
        $v = num($in['valor'] ?? null);
        if (!$v || $v <= 0) sair(['erro' => 'Valor inválido.'], 400);
        $data = preg_match('/^\d{4}-\d{2}-\d{2}$/', (string)($in['data'] ?? '')) ? $in['data'] : date('Y-m-d');
        $pdo->prepare('INSERT INTO pagamentos (aluno_id, tipo, valor, data, obs) VALUES (?,?,?,?,?)')
            ->execute([(int)$in['aluno_id'], $tipo, $v, $data, mb_substr(trim((string)($in['obs'] ?? '')), 0, 255)]);
        sair(['ok' => true]);
    }

    if ($acao === 'del_pagamento') { $pdo->prepare('DELETE FROM pagamentos WHERE id=?')->execute([(int)($in['id'] ?? 0)]); sair(['ok' => true]); }

    if ($acao === 'salvar_turma') {
        $nome = trim((string)($in['nome'] ?? '')); if ($nome === '') sair(['erro' => 'Coloque o nome da turma.'], 400);
        if (!empty($in['id'])) $pdo->prepare('UPDATE turmas SET nome=? WHERE id=?')->execute([$nome, (int)$in['id']]);
        else $pdo->prepare('INSERT INTO turmas (nome, ordem) VALUES (?, 99)')->execute([$nome]);
        sair(['ok' => true]);
    }

    if ($acao === 'config') {
        $perm = ['titulo', 'mes_inicio', 'mes_fim', 'valor_convidado_festa', 'rifa_preco', 'regras'];
        $st = $pdo->prepare('INSERT INTO config (chave, valor) VALUES (?, ?) ON DUPLICATE KEY UPDATE valor=VALUES(valor)');
        foreach ($perm as $k) if (array_key_exists($k, $in)) {
            $v = in_array($k, ['titulo', 'regras'], true) ? mb_substr(trim((string)$in[$k]), 0, 255) : (string)(num($in[$k]) ?? 0);
            $st->execute([$k, $v]);
        }
        sair(['ok' => true]);
    }

    sair(['erro' => 'Ação desconhecida.'], 400);
} catch (Throwable $e) {
    sair(['erro' => 'Erro no servidor: ' . $e->getMessage()], 500);
}
