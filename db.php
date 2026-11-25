<?php
require_once __DIR__ . '/config.php';

function db(): PDO {
    static $pdo = null;
    if ($pdo) return $pdo;
    $opts = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];
    $base = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';charset=utf8mb4';
    try {
        $pdo = new PDO($base . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $opts);
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), '1049') === false) throw $e; // banco não existe (só acontece no XAMPP)
        $pdo = new PDO($base, DB_USER, DB_PASS, $opts);
        $pdo->exec('CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        $pdo->exec('USE `' . DB_NAME . '`');
    }
    instalar($pdo);
    return $pdo;
}

function instalar(PDO $pdo): void {
    $pdo->exec("CREATE TABLE IF NOT EXISTS config (
        chave VARCHAR(40) PRIMARY KEY, valor VARCHAR(255)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    $pdo->exec("CREATE TABLE IF NOT EXISTS turmas (
        id INT AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(80) NOT NULL, ordem INT DEFAULT 0) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    $pdo->exec("CREATE TABLE IF NOT EXISTS alunos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        turma_id INT NOT NULL,
        nome VARCHAR(100) NOT NULL,
        valor_mensal DECIMAL(8,2) NOT NULL DEFAULT 50,
        conv_jantar INT NULL,
        conv_festa_extra INT NOT NULL DEFAULT 0,
        rifa_qtd INT NOT NULL DEFAULT 0,
        obs VARCHAR(255) NULL,
        INDEX(turma_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    $pdo->exec("CREATE TABLE IF NOT EXISTS mensalidades (
        aluno_id INT NOT NULL, mes TINYINT NOT NULL, valor DECIMAL(8,2) NOT NULL,
        atualizado_em DATETIME NULL,
        PRIMARY KEY (aluno_id, mes)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    $pdo->exec("CREATE TABLE IF NOT EXISTS pagamentos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        tipo VARCHAR(20) NOT NULL,
        valor DECIMAL(8,2) NOT NULL,
        data DATE NULL,
        obs VARCHAR(255) NULL,
        INDEX(aluno_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $ja = (int)$pdo->query("SELECT COUNT(*) FROM config WHERE chave='instalado'")->fetchColumn();
    if ($ja) return;

    $cfg = [
        'titulo' => 'Controle do Terceirão',
        'mes_inicio' => '3', 'mes_fim' => '11',
        'valor_convidado_festa' => '50',
        'rifa_preco' => '0',
        'regras' => 'Mínimo R$ 50/mês (formando + 4 convidados no jantar). R$ 50 por convidado da festa diferente do jantar (taxa única).',
        'instalado' => date('Y-m-d H:i:s'),
    ];
    $st = $pdo->prepare('INSERT INTO config (chave, valor) VALUES (?, ?)');
    foreach ($cfg as $k => $v) $st->execute([$k, $v]);

    // Dados importados da planilha DOC-20261105-WA0030.xlsx
    $seed = [['turma'=>'Informática Vespertino','alunos'=>[['nome'=>'Ana Clara','mens'=>[3=>50,4=>50,5=>50],'vm'=>50,'j'=>4,'f'=>0],['nome'=>'Arthur Eduardo','mens'=>[3=>50,4=>50,5=>50,6=>50,7=>50,8=>50,9=>70,10=>70,11=>70],'vm'=>50,'j'=>null,'f'=>0],['nome'=>'Cassio Souza','mens'=>[3=>50,4=>40,5=>50,6=>50,7=>50],'vm'=>50,'j'=>4,'f'=>0],['nome'=>'Cayo Rodrigues','mens'=>[3=>50,4=>50],'vm'=>50,'j'=>4,'f'=>0],['nome'=>'Darliane Arza','mens'=>[3=>60,4=>60,5=>60,6=>60],'vm'=>60,'j'=>5,'f'=>0],['nome'=>'Dercley Maciel','mens'=>[3=>50,4=>50,5=>50,6=>50,7=>50,8=>50],'vm'=>50,'j'=>4,'f'=>0],['nome'=>'Enzo Ryan','mens'=>[3=>50,4=>50],'vm'=>50,'j'=>4,'f'=>0],['nome'=>'Laís Carvalho','mens'=>[3=>70,4=>70,5=>70,6=>70,7=>70,8=>70],'vm'=>70,'j'=>6,'f'=>0],['nome'=>'Levi Oliveira','mens'=>[],'vm'=>50,'j'=>null,'f'=>0],['nome'=>'Marcus Vinicius','mens'=>[3=>40,4=>50],'vm'=>50,'j'=>4,'f'=>0],['nome'=>'Maria Luma','mens'=>[3=>50,4=>50,5=>50,6=>50],'vm'=>50,'j'=>4,'f'=>0],['nome'=>'Sthephany Lastra','mens'=>[],'vm'=>50,'j'=>null,'f'=>0],['nome'=>'Will Guilherme','mens'=>[3=>50,4=>50,5=>50],'vm'=>50,'j'=>4,'f'=>0]]],['turma'=>'Informática Matutino','alunos'=>[['nome'=>'Anaclara','mens'=>[3=>50,4=>50,5=>50,6=>50,7=>50],'vm'=>50,'j'=>4,'f'=>0],['nome'=>'Esther Jimenez','mens'=>[3=>70,4=>70,5=>70,6=>70,7=>70,8=>70],'vm'=>70,'j'=>6,'f'=>5],['nome'=>'Esthefany Ojopi','mens'=>[3=>70,4=>70,5=>70,6=>70,7=>70],'vm'=>70,'j'=>6,'f'=>0],['nome'=>'Maria Eduarda','mens'=>[3=>60,4=>70,5=>60,6=>70],'vm'=>70,'j'=>null,'f'=>0]]],['turma'=>'Biotec Vespertino','alunos'=>[['nome'=>'Eduarda','mens'=>[3=>50,4=>50,5=>50,6=>50,7=>50],'vm'=>50,'j'=>null,'f'=>0],['nome'=>'Kamila','mens'=>[3=>50,4=>50,5=>50,6=>40],'vm'=>50,'j'=>null,'f'=>0],['nome'=>'Thales','mens'=>[],'vm'=>50,'j'=>null,'f'=>0],['nome'=>'Helena','mens'=>[3=>50,4=>50,5=>50,6=>50,7=>50,8=>50],'vm'=>50,'j'=>null,'f'=>0],['nome'=>'Emanuele','mens'=>[3=>50,4=>50,5=>50,6=>50],'vm'=>50,'j'=>null,'f'=>0],['nome'=>'Daniel','mens'=>[3=>50,4=>50,5=>50,6=>50,7=>50,8=>50,9=>50,10=>50],'vm'=>50,'j'=>null,'f'=>0],['nome'=>'Thais','mens'=>[3=>50,4=>50,5=>50,6=>50,7=>50,8=>50,9=>50,10=>50,11=>50],'vm'=>50,'j'=>null,'f'=>0],['nome'=>'Mariene','mens'=>[3=>70,4=>70,5=>70,6=>70,7=>70,8=>70,9=>70],'vm'=>70,'j'=>null,'f'=>0],['nome'=>'Lorena','mens'=>[3=>50],'vm'=>50,'j'=>null,'f'=>0],['nome'=>'Vitória','mens'=>[3=>50,4=>50,5=>50,6=>50],'vm'=>50,'j'=>null,'f'=>0],['nome'=>'Iza','mens'=>[3=>70],'vm'=>70,'j'=>null,'f'=>0],['nome'=>'Isabela','mens'=>[3=>50,4=>50,5=>50],'vm'=>50,'j'=>null,'f'=>0],['nome'=>'João G.','mens'=>[3=>50,4=>50,5=>50,6=>50,7=>50],'vm'=>50,'j'=>null,'f'=>0],['nome'=>'N. Paulino','mens'=>[3=>50,4=>50,5=>50,6=>50,7=>50],'vm'=>50,'j'=>null,'f'=>0],['nome'=>'Ana Clara','mens'=>[3=>70,4=>70,5=>70,6=>70,7=>70,8=>70],'vm'=>70,'j'=>null,'f'=>0],['nome'=>'Jheniffer','mens'=>[],'vm'=>50,'j'=>null,'f'=>0],['nome'=>'Meyer','mens'=>[3=>50,4=>50,5=>50,6=>50,7=>50,8=>50],'vm'=>50,'j'=>null,'f'=>0]]]];
    $insT = $pdo->prepare('INSERT INTO turmas (nome, ordem) VALUES (?, ?)');
    $insA = $pdo->prepare('INSERT INTO alunos (turma_id, nome, valor_mensal, conv_jantar, conv_festa_extra) VALUES (?, ?, ?, ?, ?)');
    $insM = $pdo->prepare('INSERT INTO mensalidades (aluno_id, mes, valor) VALUES (?, ?, ?)');
    foreach ($seed as $i => $t) {
        $insT->execute([$t['turma'], $i + 1]);
        $tid = (int)$pdo->lastInsertId();
        foreach ($t['alunos'] as $a) {
            $insA->execute([$tid, $a['nome'], $a['vm'], $a['j'], $a['f']]);
            $aid = (int)$pdo->lastInsertId();
            foreach ($a['mens'] as $mes => $v) $insM->execute([$aid, $mes, $v]);
            if ($a['nome'] === 'Esther Jimenez') {
                $pdo->prepare("UPDATE alunos SET conv_festa_extra=0, obs='Na planilha: Festa = 5 convidados (conferir se algum é diferente do jantar)' WHERE id=?")->execute([$aid]);
                $pdo->prepare("INSERT INTO pagamentos (aluno_id, tipo, valor, obs) VALUES (?, 'extra', 200, 'Extra anotado na planilha')")->execute([$aid]);
            }
        }
    }
}

function cfg_all(): array {
    $out = [];
    foreach (db()->query('SELECT chave, valor FROM config') as $r) $out[$r['chave']] = $r['valor'];
    return $out;
}
