<?php header('Cache-Control: no-store'); ?><!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#0f1424">
<title>Controle do Terceirão</title>
<link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🎓</text></svg>">
<style>
:root{
  --bg:#0f1424; --bg2:#161c31; --card:#1b2238; --line:#2a3352; --txt:#eef1fa; --mut:#97a0bd;
  --gold:#f2c14e; --ok:#3ecf8e; --warn:#f5a524; --bad:#f25f5c; --info:#6aa7ff; --r:16px;
}
*{box-sizing:border-box;-webkit-tap-highlight-color:transparent}
html,body{margin:0;background:var(--bg);color:var(--txt);font:15px/1.45 system-ui,-apple-system,"Segoe UI",Roboto,sans-serif}
button,input,select,textarea{font:inherit;color:inherit}
.wrap{max-width:880px;margin:0 auto;padding:16px 14px 110px}
header{display:flex;align-items:flex-start;gap:12px;justify-content:space-between;margin:6px 0 14px}
h1{font-size:22px;margin:0;letter-spacing:-.3px}
h1 span{color:var(--gold)}
.sub{color:var(--mut);font-size:13px;margin-top:4px}
.btn{border:1px solid var(--line);background:var(--bg2);border-radius:12px;padding:9px 13px;cursor:pointer;white-space:nowrap}
.btn:active{transform:scale(.97)}
.btn.pri{background:var(--gold);color:#1b1500;border-color:var(--gold);font-weight:600}
.btn.bad{border-color:#5a2a33;color:#ff9a98}
.btn.sm{padding:6px 10px;font-size:13px;border-radius:10px}
.stats{display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-bottom:14px}
@media(min-width:640px){.stats{grid-template-columns:repeat(4,1fr)}}
.stat{background:var(--card);border:1px solid var(--line);border-radius:var(--r);padding:12px 14px}
.stat b{display:block;font-size:19px;margin-top:2px}
.stat small{color:var(--mut);font-size:12px}
.bar{height:7px;background:#0c1020;border-radius:9px;overflow:hidden;margin-top:8px}
.bar i{display:block;height:100%;background:linear-gradient(90deg,var(--gold),var(--ok));border-radius:9px}
.tabs{display:flex;gap:8px;overflow-x:auto;padding-bottom:4px;margin-bottom:10px;scrollbar-width:none}
.tabs::-webkit-scrollbar{display:none}
.tab{flex:none;border:1px solid var(--line);background:transparent;border-radius:999px;padding:7px 14px;cursor:pointer;color:var(--mut)}
.tab.on{background:var(--txt);color:var(--bg);border-color:var(--txt);font-weight:600}
.tools{display:flex;gap:8px;margin-bottom:10px;flex-wrap:wrap}
.tools input,.tools select{background:var(--bg2);border:1px solid var(--line);border-radius:12px;padding:9px 12px}
.tools input{flex:1;min-width:160px}
.chips{display:flex;gap:6px;flex-wrap:wrap;margin-bottom:12px}
.chip{border:1px solid var(--line);background:transparent;border-radius:999px;padding:5px 11px;font-size:13px;color:var(--mut);cursor:pointer}
.chip.on{border-color:var(--gold);color:var(--gold)}
.list{display:flex;flex-direction:column;gap:8px}
.al{background:var(--card);border:1px solid var(--line);border-radius:var(--r);padding:12px 14px;cursor:pointer;display:grid;grid-template-columns:1fr auto;gap:4px 10px;align-items:center}
.al:active{background:#20294a}
.al .nm{font-weight:600}
.al .tm{color:var(--mut);font-size:12px}
.dots{display:flex;gap:4px;grid-column:1/-1;margin-top:6px}
.dot{flex:1;height:6px;border-radius:4px;background:#2a3352}
.dot.ok{background:var(--ok)} .dot.par{background:var(--warn)} .dot.late{background:var(--bad)}
.badge{font-size:12px;border-radius:999px;padding:3px 9px;font-weight:600;white-space:nowrap}
.b-ok{background:rgba(62,207,142,.15);color:var(--ok)}
.b-warn{background:rgba(245,165,36,.15);color:var(--warn)}
.b-bad{background:rgba(242,95,92,.15);color:#ff8a87}
.b-info{background:rgba(106,167,255,.15);color:var(--info)}
.money{font-variant-numeric:tabular-nums;text-align:right;font-size:13px;color:var(--mut)}
.money b{color:var(--txt);font-size:15px}
.empty{color:var(--mut);text-align:center;padding:30px 0}
.adminbar{position:fixed;left:0;right:0;bottom:0;background:rgba(15,20,36,.94);backdrop-filter:blur(8px);border-top:1px solid var(--line);padding:10px 14px calc(10px + env(safe-area-inset-bottom));display:flex;gap:8px;justify-content:center;flex-wrap:wrap;z-index:5}
.fab{position:fixed;right:16px;bottom:calc(18px + env(safe-area-inset-bottom));z-index:5;box-shadow:0 8px 24px rgba(0,0,0,.4)}
/* modal */
.ov{position:fixed;inset:0;background:rgba(5,8,18,.65);display:none;align-items:flex-end;justify-content:center;z-index:20}
.ov.on{display:flex}
.sheet{background:var(--bg2);border:1px solid var(--line);border-radius:22px 22px 0 0;width:100%;max-width:620px;max-height:92vh;overflow:auto;padding:18px 16px calc(22px + env(safe-area-inset-bottom));animation:up .22s ease}
@media(min-width:700px){.ov{align-items:center}.sheet{border-radius:22px}}
@keyframes up{from{transform:translateY(40px);opacity:.4}to{transform:none;opacity:1}}
.sh{display:flex;justify-content:space-between;align-items:flex-start;gap:10px;margin-bottom:12px}
.sh h2{margin:0;font-size:19px}
.x{background:none;border:0;font-size:24px;line-height:1;color:var(--mut);cursor:pointer;padding:0 4px}
.grid{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin:8px 0 14px}
.mes{border:1px solid var(--line);border-radius:12px;padding:9px 8px;text-align:center;background:var(--card)}
.mes small{display:block;color:var(--mut);font-size:12px}
.mes b{font-size:15px}
.mes.ok{border-color:rgba(62,207,142,.5)} .mes.ok b{color:var(--ok)}
.mes.par{border-color:rgba(245,165,36,.55)} .mes.par b{color:var(--warn)}
.mes.late{border-color:rgba(242,95,92,.45)} .mes.late b{color:#ff8a87}
.mes.fut b{color:var(--mut)}
.mes.click{cursor:pointer} .mes.click:active{transform:scale(.96)}
.sec{font-size:12px;text-transform:uppercase;letter-spacing:.08em;color:var(--mut);margin:16px 0 6px}
.kv{display:grid;grid-template-columns:1fr auto;gap:6px 12px;background:var(--card);border:1px solid var(--line);border-radius:14px;padding:12px 14px}
.kv span{color:var(--mut)} .kv b{text-align:right;font-variant-numeric:tabular-nums}
.kv .tot{border-top:1px solid var(--line);padding-top:8px;margin-top:2px}
.pg{display:flex;justify-content:space-between;align-items:center;gap:8px;padding:8px 0;border-bottom:1px solid var(--line);font-size:14px}
.pg:last-child{border:0}
.row{display:flex;gap:8px;flex-wrap:wrap;margin-top:14px}
label{display:block;font-size:13px;color:var(--mut);margin:10px 0 4px}
.f{width:100%;background:var(--bg);border:1px solid var(--line);border-radius:12px;padding:10px 12px}
.two{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.quick{display:flex;gap:6px;flex-wrap:wrap;margin-top:10px}
.hint{color:var(--mut);font-size:12px;margin-top:6px}
.toast{position:fixed;left:50%;bottom:90px;transform:translateX(-50%);background:var(--txt);color:var(--bg);padding:10px 16px;border-radius:12px;font-weight:600;z-index:40;opacity:0;transition:.2s;pointer-events:none}
.toast.on{opacity:1}
.loading{color:var(--mut);text-align:center;padding:60px 0}
</style>
</head>
<body>
<div class="wrap">
  <header>
    <div>
      <h1 id="titulo">Controle do <span>Terceirão</span> 🎓</h1>
      <div class="sub" id="regras"></div>
    </div>
    <button class="btn sm" id="btnAdmin">🔒 Admin</button>
  </header>

  <div id="app"><div class="loading">Carregando…</div></div>
</div>

<button class="btn pri fab" id="btnZap">📲 Resumo p/ WhatsApp</button>
<div class="adminbar" id="adminbar" style="display:none">
  <button class="btn sm pri" data-a="novoAluno">+ Aluno</button>
  <button class="btn sm" data-a="novaTurma">+ Turma</button>
  <button class="btn sm" data-a="config">⚙️ Config</button>
  <button class="btn sm" data-a="csv">⬇️ Planilha</button>
  <button class="btn sm" data-a="zap">📲 WhatsApp</button>
  <button class="btn sm bad" data-a="logout">Sair</button>
</div>

<div class="ov" id="ov"><div class="sheet" id="sheet"></div></div>
<div class="toast" id="toast"></div>

<script>
const MESES = ['', 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
const MESES_L = ['', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
const TIPOS = { rifa: '🎟️ Rifa', festa: '🎉 Convidado festa', extra: '➕ Extra' };
let D = null, S = { turma: 'todas', q: '', filtro: 'todos', ordem: 'nome' };

const $ = s => document.querySelector(s);
const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
const brl = v => 'R$ ' + (Math.round((+v || 0) * 100) / 100).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
const brl0 = v => 'R$ ' + (+v || 0).toLocaleString('pt-BR', { maximumFractionDigits: 2 });
function toast(t) { const e = $('#toast'); e.textContent = t; e.classList.add('on'); clearTimeout(e._t); e._t = setTimeout(() => e.classList.remove('on'), 1800); }

async function api(acao, body) {
  const r = await fetch('api.php?acao=' + acao, body ? { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(body), credentials: 'same-origin' } : { credentials: 'same-origin' });
  let j; try { j = await r.json(); } catch { throw new Error('O servidor não respondeu direito.'); }
  if (!r.ok || j.erro) throw new Error(j.erro || 'Erro');
  return j;
}
async function carregar() {
  try { D = await api('dados'); render(); }
  catch (e) { $('#app').innerHTML = '<div class="empty">⚠️ ' + esc(e.message) + '<br><br><button class="btn" onclick="carregar()">Tentar de novo</button></div>'; }
}
async function acao(nome, body, msg) {
  try { await api(nome, body); await carregar(); if (msg) toast(msg); return true; }
  catch (e) { alert(e.message); return false; }
}

// ---------- cálculos ----------
function meses() { const a = +D.config.mes_inicio || 3, b = +D.config.mes_fim || 11, o = []; for (let m = a; m <= b; m++) o.push(m); return o; }
function decorridos() { const h = D.hoje.mes; return meses().filter(m => m <= h).length; }
function calc(a) {
  const ms = meses(), vm = a.valor_mensal || 50, soma = t => a.pags.filter(p => p.tipo === t).reduce((s, p) => s + p.valor, 0);
  const pagoMens = ms.reduce((s, m) => s + (a.mens[m] || 0), 0) + Object.keys(a.mens).filter(m => !ms.includes(+m)).reduce((s, m) => s + a.mens[m], 0);
  const extra = soma('extra'), festaPago = soma('festa'), rifaPago = soma('rifa');
  const metaMens = vm * ms.length, festaDev = a.conv_festa_extra * (+D.config.valor_convidado_festa || 0);
  const devido = metaMens + festaDev, pago = pagoMens + extra + festaPago;
  const falta = Math.max(0, devido - pago), credito = Math.max(0, pago - devido);
  const esperado = vm * decorridos(), atrasoV = Math.max(0, esperado - (pagoMens + extra));
  const rifaDev = a.rifa_qtd * (+D.config.rifa_preco || 0), rifaFalta = Math.max(0, rifaDev - rifaPago);
  let st;
  if (falta <= 0.009) st = { k: 'ok', t: 'Quitado ✓' };
  else if (atrasoV <= 0.009) st = { k: 'info', t: 'Em dia' };
  else { const n = Math.ceil(atrasoV / vm - 0.001); st = { k: n >= 3 ? 'bad' : 'warn', t: n === 1 ? '1 mês atrasado' : n + ' meses atrasados' }; }
  return { vm, pagoMens, extra, festaPago, rifaPago, metaMens, festaDev, devido, pago, falta, credito, rifaDev, rifaFalta, st };
}
function estadoMes(a, m) {
  const v = a.mens[m] || 0, vm = a.valor_mensal || 50;
  if (v >= vm - 0.009) return 'ok';
  if (v > 0) return 'par';
  return m <= D.hoje.mes ? 'late' : 'fut';
}
const turmaNome = id => (D.turmas.find(t => +t.id === +id) || {}).nome || '—';

function filtrados() {
  const q = S.q.trim().toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '');
  let l = D.alunos.filter(a => S.turma === 'todas' || +a.turma_id === +S.turma)
    .filter(a => !q || a.nome.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '').includes(q))
    .map(a => ({ a, c: calc(a) }));
  if (S.filtro === 'devendo') l = l.filter(x => x.c.falta > 0);
  if (S.filtro === 'atrasado') l = l.filter(x => x.c.st.k === 'warn' || x.c.st.k === 'bad');
  if (S.filtro === 'quitado') l = l.filter(x => x.c.falta <= 0);
  if (S.filtro === 'rifa') l = l.filter(x => x.c.rifaFalta > 0);
  if (S.ordem === 'falta') l.sort((x, y) => y.c.falta - x.c.falta || x.a.nome.localeCompare(y.a.nome));
  else if (S.ordem === 'pago') l.sort((x, y) => y.c.pago - x.c.pago);
  else l.sort((x, y) => x.a.nome.localeCompare(y.a.nome, 'pt-BR'));
  return l;
}

// ---------- tela principal ----------
function render() {
  document.title = D.config.titulo || 'Controle do Terceirão';
  const t = (D.config.titulo || 'Controle do Terceirão').split(' ');
  $('#titulo').innerHTML = esc(t.slice(0, -1).join(' ')) + ' <span>' + esc(t.slice(-1)[0]) + '</span> 🎓';
  $('#regras').textContent = D.config.regras || '';
  $('#btnAdmin').textContent = D.admin ? '✅ Admin' : '🔒 Admin';
  $('#adminbar').style.display = D.admin ? 'flex' : 'none';
  $('#btnZap').style.display = D.admin ? 'none' : '';

  const base = D.alunos.filter(a => S.turma === 'todas' || +a.turma_id === +S.turma).map(calc);
  const arrec = base.reduce((s, c) => s + c.pago, 0), meta = base.reduce((s, c) => s + c.devido, 0);
  const falta = base.reduce((s, c) => s + c.falta, 0), quit = base.filter(c => c.falta <= 0).length;
  const rifaP = base.reduce((s, c) => s + c.rifaPago, 0), rifaD = base.reduce((s, c) => s + c.rifaDev, 0);
  const pct = meta ? Math.min(100, arrec / meta * 100) : 0;

  $('#app').innerHTML = `
  <div class="stats">
    <div class="stat"><small>Arrecadado</small><b>${brl0(arrec)}</b><div class="bar"><i style="width:${pct}%"></i></div></div>
    <div class="stat"><small>Meta (${meses().length} meses)</small><b>${brl0(meta)}</b><small>${pct.toFixed(0)}% atingido</small></div>
    <div class="stat"><small>Falta arrecadar</small><b style="color:#ff8a87">${brl0(falta)}</b></div>
    <div class="stat"><small>Quitados</small><b>${quit} / ${base.length}</b>${rifaD > 0 || rifaP > 0 ? `<small>🎟️ Rifa: ${brl0(rifaP)} de ${brl0(rifaD)}</small>` : ''}</div>
  </div>
  <div class="tabs">
    <button class="tab ${S.turma === 'todas' ? 'on' : ''}" data-t="todas">Todas</button>
    ${D.turmas.map(t => `<button class="tab ${+S.turma === +t.id ? 'on' : ''}" data-t="${t.id}">${esc(t.nome)}</button>`).join('')}
  </div>
  <div class="tools">
    <input id="q" placeholder="🔎 Procurar nome…" value="${esc(S.q)}">
    <select id="ordem">
      <option value="nome" ${S.ordem === 'nome' ? 'selected' : ''}>A–Z</option>
      <option value="falta" ${S.ordem === 'falta' ? 'selected' : ''}>Quem deve mais</option>
      <option value="pago" ${S.ordem === 'pago' ? 'selected' : ''}>Quem pagou mais</option>
    </select>
  </div>
  <div class="chips">
    ${[['todos', 'Todos'], ['devendo', 'Devendo'], ['atrasado', 'Atrasados'], ['quitado', 'Quitados'], ['rifa', '🎟️ Rifa pendente']].map(([k, n]) => `<button class="chip ${S.filtro === k ? 'on' : ''}" data-f="${k}">${n}</button>`).join('')}
  </div>
  <div class="list" id="lista">${htmlLista()}</div>`;
}

function htmlLista() {
  const l = filtrados();
  return l.length ? l.map(({ a, c }) => `
      <div class="al" data-id="${a.id}">
        <div><div class="nm">${esc(a.nome)}</div><div class="tm">${S.turma === 'todas' ? esc(turmaNome(a.turma_id)) + ' · ' : ''}${brl0(c.vm)}/mês${c.rifaFalta > 0 ? ' · 🎟️ deve rifa' : ''}</div></div>
        <div class="money"><span class="badge b-${c.st.k}">${c.st.t}</span><div style="margin-top:4px"><b>${brl0(c.pago)}</b> / ${brl0(c.devido)}</div></div>
        <div class="dots">${meses().map(m => `<span class="dot ${estadoMes(a, m)}" title="${MESES[m]}"></span>`).join('')}</div>
      </div>`).join('') : '<div class="empty">Ninguém aqui 👀</div>';
}

// ---------- detalhe do aluno ----------
function abrir(html) { $('#sheet').innerHTML = html; $('#ov').classList.add('on'); }
function fechar() { $('#ov').classList.remove('on'); }

function detalhe(id) {
  const a = D.alunos.find(x => x.id === +id); if (!a) return fechar();
  const c = calc(a), adm = D.admin;
  abrir(`
    <div class="sh"><div><h2>${esc(a.nome)}</h2><div class="sub">${esc(turmaNome(a.turma_id))} · <span class="badge b-${c.st.k}">${c.st.t}</span></div></div><button class="x" data-a="fechar">×</button></div>
    <div class="sec">Mensalidades ${adm ? '<span style="text-transform:none;letter-spacing:0">— toque no mês para marcar</span>' : ''}</div>
    <div class="grid">${meses().map(m => {
      const v = a.mens[m], e = estadoMes(a, m);
      return `<div class="mes ${e} ${adm ? 'click' : ''}" ${adm ? `data-mes="${m}" data-aid="${a.id}"` : ''}><small>${MESES_L[m]}</small><b>${v ? brl0(v) : (e === 'fut' ? '—' : 'Não pagou')}</b></div>`;
    }).join('')}</div>
    <div class="kv">
      <span>Mensalidade combinada</span><b>${brl(c.vm)}</b>
      <span>Pago em mensalidades</span><b>${brl(c.pagoMens)}</b>
      ${c.extra ? `<span>Pagamentos extras</span><b>${brl(c.extra)}</b>` : ''}
      <span>Convidados no jantar</span><b>${a.conv_jantar ?? '—'}</b>
      <span>Convidados extras na festa</span><b>${a.conv_festa_extra} ${c.festaDev ? '(' + brl0(c.festaDev) + ', pago ' + brl0(c.festaPago) + ')' : ''}</b>
      <span class="tot">Total devido</span><b class="tot">${brl(c.devido)}</b>
      <span>Total pago</span><b style="color:var(--ok)">${brl(c.pago)}</b>
      <span>${c.credito > 0 ? 'Pagou a mais' : 'Falta pagar'}</span><b style="color:${c.credito > 0 ? 'var(--info)' : (c.falta > 0 ? '#ff8a87' : 'var(--ok)')}">${brl(c.credito > 0 ? c.credito : c.falta)}</b>
    </div>
    <div class="sec">🎟️ Rifa</div>
    <div class="kv">
      <span>Números pegos</span><b>${a.rifa_qtd}</b>
      <span>Valor a prestar</span><b>${+D.config.rifa_preco ? brl(c.rifaDev) : '<span style="color:var(--mut)">preço não definido</span>'}</b>
      <span>Prestou</span><b style="color:var(--ok)">${brl(c.rifaPago)}</b>
      ${c.rifaDev ? `<span>Falta</span><b style="color:${c.rifaFalta ? '#ff8a87' : 'var(--ok)'}">${brl(c.rifaFalta)}</b>` : ''}
    </div>
    ${a.pags.length ? `<div class="sec">Outros pagamentos</div><div class="kv" style="display:block">${a.pags.map(p => `
      <div class="pg"><div>${TIPOS[p.tipo] || p.tipo} <b>${brl(p.valor)}</b><div class="hint" style="margin:0">${p.data ? p.data.split('-').reverse().join('/') : ''} ${esc(p.obs || '')}</div></div>
      ${adm ? `<button class="btn sm bad" data-delp="${p.id}">Apagar</button>` : ''}</div>`).join('')}</div>` : ''}
    ${a.obs ? `<div class="sec">Observação</div><div class="kv" style="display:block">${esc(a.obs)}</div>` : ''}
    ${adm ? `<div class="row">
      <button class="btn pri" data-pag="${a.id}">+ Pagamento (rifa/festa/extra)</button>
      <button class="btn" data-edit="${a.id}">✏️ Editar aluno</button>
    </div>` : ''}
  `);
}

function editarMes(aid, m) {
  const a = D.alunos.find(x => x.id === +aid), v = a.mens[m] || '';
  const vals = [...new Set([a.valor_mensal, 50, 60, 70])].filter(Boolean);
  abrir(`
    <div class="sh"><div><h2>${MESES_L[m]}</h2><div class="sub">${esc(a.nome)}</div></div><button class="x" data-back="${a.id}">×</button></div>
    <label>Valor pago</label>
    <input class="f" id="vmes" inputmode="decimal" placeholder="Ex.: 50" value="${v ? String(v).replace('.', ',') : ''}">
    <div class="quick">${vals.map(x => `<button class="btn sm" data-q="${x}">${brl0(x)}</button>`).join('')}</div>
    <div class="row">
      <button class="btn pri" id="okMes">Salvar</button>
      ${v ? '<button class="btn bad" id="limpaMes">Não pagou (limpar)</button>' : ''}
      <button class="btn" data-back="${a.id}">Voltar</button>
    </div>`);
  const salvar = async val => { if (await acao('mensalidade', { aluno_id: a.id, mes: m, valor: val }, 'Salvo ✓')) detalhe(a.id); };
  $('#sheet').querySelectorAll('[data-q]').forEach(b => b.onclick = () => salvar(b.dataset.q));
  $('#okMes').onclick = () => salvar($('#vmes').value);
  if ($('#limpaMes')) $('#limpaMes').onclick = () => salvar(null);
  $('#vmes').addEventListener('keydown', e => { if (e.key === 'Enter') { e.preventDefault(); salvar($('#vmes').value); } });
  setTimeout(() => { $('#vmes').focus(); $('#vmes').select(); }, 250);
}

function novoPagamento(aid) {
  const a = D.alunos.find(x => x.id === +aid), hoje = new Date().toISOString().slice(0, 10);
  abrir(`
    <div class="sh"><div><h2>Novo pagamento</h2><div class="sub">${esc(a.nome)}</div></div><button class="x" data-back="${a.id}">×</button></div>
    <label>Tipo</label>
    <select class="f" id="ptipo"><option value="rifa">🎟️ Rifa (prestação de conta)</option><option value="festa">🎉 Convidado extra da festa</option><option value="extra">➕ Extra / outro</option></select>
    <div class="two"><div><label>Valor (R$)</label><input class="f" id="pval" inputmode="decimal" placeholder="Ex.: 50"></div>
    <div><label>Data</label><input class="f" id="pdata" type="date" value="${hoje}"></div></div>
    <label>Observação (opcional)</label><input class="f" id="pobs" placeholder="Ex.: pagou no Pix">
    <div class="row"><button class="btn pri" id="okPag">Salvar</button><button class="btn" data-back="${a.id}">Voltar</button></div>`);
  $('#okPag').onclick = async () => {
    if (await acao('add_pagamento', { aluno_id: a.id, tipo: $('#ptipo').value, valor: $('#pval').value, data: $('#pdata').value, obs: $('#pobs').value }, 'Pagamento registrado ✓')) detalhe(a.id);
  };
}

function formAluno(id) {
  const a = id ? D.alunos.find(x => x.id === +id) : { turma_id: S.turma !== 'todas' ? S.turma : (D.turmas[0] || {}).id, nome: '', valor_mensal: 50, conv_jantar: 4, conv_festa_extra: 0, rifa_qtd: 0, obs: '' };
  abrir(`
    <div class="sh"><h2>${id ? 'Editar aluno' : 'Novo aluno'}</h2><button class="x" ${id ? `data-back="${id}"` : 'data-a="fechar"'}>×</button></div>
    <label>Nome</label><input class="f" id="fnome" value="${esc(a.nome)}">
    <label>Turma</label><select class="f" id="fturma">${D.turmas.map(t => `<option value="${t.id}" ${+t.id === +a.turma_id ? 'selected' : ''}>${esc(t.nome)}</option>`).join('')}</select>
    <div class="two">
      <div><label>Convidados no jantar</label><input class="f" id="fjan" type="number" min="0" value="${a.conv_jantar ?? ''}"></div>
      <div><label>Mensalidade (R$)</label><input class="f" id="fvm" inputmode="decimal" value="${String(a.valor_mensal).replace('.', ',')}"></div>
    </div>
    <div class="hint">Regra da planilha: R$ 50 com até 4 convidados, +R$ 10 por convidado a mais. <a href="#" id="regra" style="color:var(--gold)">Aplicar regra</a></div>
    <div class="two">
      <div><label>Convidados extras na festa</label><input class="f" id="ffes" type="number" min="0" value="${a.conv_festa_extra}"></div>
      <div><label>🎟️ Números da rifa</label><input class="f" id="frifa" type="number" min="0" value="${a.rifa_qtd}"></div>
    </div>
    <div class="hint">Convidado extra da festa = quem vai só na festa (não no jantar). Taxa única de ${brl0(D.config.valor_convidado_festa)} cada.</div>
    <label>Observação</label><input class="f" id="fobs" value="${esc(a.obs || '')}">
    <div class="row">
      <button class="btn pri" id="okAl">Salvar</button>
      ${id ? '<button class="btn bad" id="delAl">Excluir aluno</button>' : ''}
    </div>`);
  $('#regra').onclick = e => { e.preventDefault(); const j = +$('#fjan').value || 0; $('#fvm').value = 50 + 10 * Math.max(0, j - 4); };
  $('#okAl').onclick = async () => {
    const ok = await acao('salvar_aluno', { id: id || null, turma_id: $('#fturma').value, nome: $('#fnome').value, valor_mensal: $('#fvm').value, conv_jantar: $('#fjan').value, conv_festa_extra: $('#ffes').value, rifa_qtd: $('#frifa').value, obs: $('#fobs').value }, 'Salvo ✓');
    if (ok) id ? detalhe(id) : fechar();
  };
  if (id) $('#delAl').onclick = async () => { if (confirm('Excluir ' + a.nome + ' e TODOS os pagamentos dele(a)? Não dá pra desfazer.')) { if (await acao('excluir_aluno', { id }, 'Excluído')) fechar(); } };
}

function formConfig() {
  const c = D.config;
  abrir(`
    <div class="sh"><h2>⚙️ Configurações</h2><button class="x" data-a="fechar">×</button></div>
    <label>Título</label><input class="f" id="ctit" value="${esc(c.titulo)}">
    <div class="two">
      <div><label>Primeiro mês</label><select class="f" id="cini">${MESES_L.slice(1).map((n, i) => `<option value="${i + 1}" ${+c.mes_inicio === i + 1 ? 'selected' : ''}>${n}</option>`).join('')}</select></div>
      <div><label>Último mês</label><select class="f" id="cfim">${MESES_L.slice(1).map((n, i) => `<option value="${i + 1}" ${+c.mes_fim === i + 1 ? 'selected' : ''}>${n}</option>`).join('')}</select></div>
    </div>
    <div class="two">
      <div><label>🎟️ Preço do número da rifa</label><input class="f" id="crifa" inputmode="decimal" value="${String(c.rifa_preco || 0).replace('.', ',')}"></div>
      <div><label>Taxa convidado festa</label><input class="f" id="cfes" inputmode="decimal" value="${String(c.valor_convidado_festa || 0).replace('.', ',')}"></div>
    </div>
    <label>Regras (aparece no topo)</label><textarea class="f" id="creg" rows="3">${esc(c.regras)}</textarea>
    <div class="sec">Turmas</div>
    ${D.turmas.map(t => `<div class="pg"><span>${esc(t.nome)}</span><button class="btn sm" data-rent="${t.id}">Renomear</button></div>`).join('')}
    <div class="row"><button class="btn pri" id="okCfg">Salvar</button></div>`);
  $('#okCfg').onclick = async () => { if (await acao('config', { titulo: $('#ctit').value, mes_inicio: $('#cini').value, mes_fim: $('#cfim').value, rifa_preco: $('#crifa').value, valor_convidado_festa: $('#cfes').value, regras: $('#creg').value }, 'Configurações salvas ✓')) fechar(); };
}

function login() {
  if (D.admin) return;
  abrir(`
    <div class="sh"><h2>🔒 Entrar como admin</h2><button class="x" data-a="fechar">×</button></div>
    <div class="sub">Só quem cuida do dinheiro precisa entrar. A turma vê tudo sem senha.</div>
    <label>Senha</label><input class="f" id="senha" type="password" autocomplete="current-password">
    <div class="row"><button class="btn pri" id="okLog">Entrar</button></div>`);
  const go = async () => { if (await acao('login', { senha: $('#senha').value }, 'Modo admin ligado ✓')) fechar(); };
  $('#okLog').onclick = go; $('#senha').addEventListener('keydown', e => { if (e.key === 'Enter') { e.preventDefault(); go(); } });
  setTimeout(() => $('#senha').focus(), 250);
}

// ---------- exportações ----------
function textoZap() {
  const l = filtrados().sort((x, y) => x.a.nome.localeCompare(y.a.nome, 'pt-BR'));
  const tit = S.turma === 'todas' ? 'Todas as turmas' : turmaNome(S.turma);
  const hoje = new Date().toLocaleDateString('pt-BR');
  let t = `*🎓 ${D.config.titulo || 'Controle do Terceirão'}*\n_${tit} — atualizado em ${hoje}_\n\n`;
  l.forEach(({ a, c }) => {
    t += (c.falta <= 0 ? '✅' : c.st.k === 'info' ? '🟦' : '❌') + ' ' + a.nome + ' — ' + (c.falta <= 0 ? 'quitado' : 'falta ' + brl0(c.falta)) + (c.rifaFalta > 0 ? ` (rifa: falta ${brl0(c.rifaFalta)})` : '') + '\n';
  });
  const arr = l.reduce((s, x) => s + x.c.pago, 0), fal = l.reduce((s, x) => s + x.c.falta, 0);
  t += `\n💰 Arrecadado: ${brl0(arr)}\n📉 Falta: ${brl0(fal)}\n\n🔗 ${location.href.split('#')[0]}`;
  return t;
}
async function zap() {
  const t = textoZap();
  try { await navigator.clipboard.writeText(t); toast('Copiado! Cola no grupo 📋'); }
  catch { window.open('https://wa.me/?text=' + encodeURIComponent(t), '_blank'); }
}
function csv() {
  const ms = meses(), sep = ';';
  const cab = ['Turma', 'Aluno', 'Mensalidade', ...ms.map(m => MESES_L[m]), 'Extras', 'Conv. jantar', 'Conv. festa extra', 'Festa pago', 'Total devido', 'Total pago', 'Falta', 'Rifa números', 'Rifa prestou', 'Rifa falta', 'Situação'];
  const lin = D.alunos.slice().sort((a, b) => a.turma_id - b.turma_id || a.nome.localeCompare(b.nome)).map(a => {
    const c = calc(a), n = v => String(v || 0).replace('.', ',');
    return [turmaNome(a.turma_id), a.nome, n(c.vm), ...ms.map(m => a.mens[m] ? n(a.mens[m]) : ''), n(c.extra), a.conv_jantar ?? '', a.conv_festa_extra, n(c.festaPago), n(c.devido), n(c.pago), n(c.falta), a.rifa_qtd, n(c.rifaPago), n(c.rifaFalta), c.st.t];
  });
  const txt = '﻿' + [cab, ...lin].map(r => r.map(v => '"' + String(v).replace(/"/g, '""') + '"').join(sep)).join('\r\n');
  const url = URL.createObjectURL(new Blob([txt], { type: 'text/csv;charset=utf-8' }));
  const el = document.createElement('a'); el.href = url; el.download = 'controle-terceirao-' + new Date().toISOString().slice(0, 10) + '.csv'; el.click();
  setTimeout(() => URL.revokeObjectURL(url), 2000);
}

// ---------- eventos ----------
let downNoFundo = false; // só fecha a janela se o clique começou E terminou fora dela (evita fechar ao selecionar texto)
document.addEventListener('mousedown', e => { downNoFundo = e.target === $('#ov'); });
document.addEventListener('click', async e => {
  const t = e.target.closest('button,[data-id],[data-mes],a[data-x]'); if (!t) { if (e.target === $('#ov') && (downNoFundo || e.pointerType !== 'mouse')) fechar(); return; }
  const d = t.dataset;
  if (d.t) { S.turma = d.t; render(); }
  else if (d.f) { S.filtro = d.f; render(); }
  else if (d.id && t.classList.contains('al')) detalhe(d.id);
  else if (d.mes) editarMes(d.aid, +d.mes);
  else if (d.back) detalhe(d.back);
  else if (d.pag) novoPagamento(d.pag);
  else if (d.edit) formAluno(d.edit);
  else if (d.delp) { if (confirm('Apagar esse pagamento?')) { const aid = D.alunos.find(a => a.pags.some(p => +p.id === +d.delp)).id; if (await acao('del_pagamento', { id: d.delp }, 'Apagado')) detalhe(aid); } }
  else if (d.rent) { const tt = D.turmas.find(x => +x.id === +d.rent); const n = prompt('Novo nome da turma:', tt.nome); if (n) { await acao('salvar_turma', { id: tt.id, nome: n }, 'Turma renomeada'); formConfig(); } }
  else if (d.a === 'fechar') fechar();
  else if (d.a === 'novoAluno') formAluno(null);
  else if (d.a === 'novaTurma') { const n = prompt('Nome da nova turma:'); if (n) acao('salvar_turma', { nome: n }, 'Turma criada ✓'); }
  else if (d.a === 'config') formConfig();
  else if (d.a === 'csv') csv();
  else if (d.a === 'zap') zap();
  else if (d.a === 'logout') { if (confirm('Sair do modo admin?')) acao('logout', {}, 'Saiu do modo admin'); }
});
$('#btnAdmin').onclick = login;
$('#btnZap').onclick = zap;
document.addEventListener('input', e => { if (e.target.id === 'q' && !e.isComposing) { S.q = e.target.value; $('#lista').innerHTML = htmlLista(); } });
document.addEventListener('compositionend', e => { if (e.target.id === 'q') { S.q = e.target.value; $('#lista').innerHTML = htmlLista(); } });
document.addEventListener('change', e => { if (e.target.id === 'ordem') { S.ordem = e.target.value; render(); } });
document.addEventListener('keydown', e => { if (e.key === 'Escape') fechar(); });
carregar();
</script>
</body>
</html>
