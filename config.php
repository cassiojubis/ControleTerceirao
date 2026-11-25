<?php
// ============================================================
//  CONFIGURAÇÃO — Controle do Terceirão
//  Só precisa mexer aqui ANTES de subir para a Wasmer.
// ============================================================

// Senha de ADMIN guardada embaralhada (hash), pra não aparecer no GitHub.
// Para trocar a senha: me peça um hash novo, ou gere em https://phppasswordhash.com
define('ADMIN_SENHA_HASH', '$2y$10$cnXIXzKbANFtwbznzir5JOp1idQyGJ5ZcY.wU1KruNHu/lRhVeTsq');

// Banco de dados.
// Na Wasmer Edge, os dados do banco vêm sozinhos (variáveis DB_HOST, DB_NAME...).
// No XAMPP do seu PC, ele usa os valores da direita.
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_PORT', getenv('DB_PORT') ?: '3307');
define('DB_NAME', getenv('DB_NAME') ?: 'controle_terceirao');
define('DB_USER', getenv('DB_USERNAME') ?: (getenv('DB_USER') ?: 'root'));
define('DB_PASS', getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : '');

date_default_timezone_set('America/Porto_Velho');
