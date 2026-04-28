<?php
// Begin Really Simple Security key
define('RSSSL_KEY', getenv_docker('RSSSL_KEY', 'gRzrkyg1ulloMAo29ApW0mbPdV6BMcofrh2qMZMWvhx3rjft5zc4bB1oCKiINkxE'));
// END Really Simple Security key

function getenv_docker($env, $default) {
    if ($fileEnv = getenv($env . '_FILE')) {
        return rtrim(file_get_contents($fileEnv), "\r\n");
    }

    if (($val = getenv($env)) !== false) {
        return $val;
    }

    return $default;
}

// Banco de dados
define('DB_NAME', getenv_docker('WORDPRESS_DB_NAME', 'wordpress'));
define('DB_USER', getenv_docker('WORDPRESS_DB_USER', 'wordpress'));
define('DB_PASSWORD', getenv_docker('WORDPRESS_DB_PASSWORD', 'wordpress'));
define('DB_HOST', getenv_docker('WORDPRESS_DB_HOST', 'mysql'));

define('DB_CHARSET', getenv_docker('WORDPRESS_DB_CHARSET', 'utf8mb4'));
define('DB_COLLATE', getenv_docker('WORDPRESS_DB_COLLATE', ''));

// Chaves e salts
define('AUTH_KEY',         getenv_docker('WORDPRESS_AUTH_KEY',         'deabc73704de19d2ead4fb336ce64c7aef6a6c49'));
define('SECURE_AUTH_KEY',  getenv_docker('WORDPRESS_SECURE_AUTH_KEY',  'f9336ca0ea328c55907c06e219951716089e0182'));
define('LOGGED_IN_KEY',    getenv_docker('WORDPRESS_LOGGED_IN_KEY',    'fe1384260e7cfabb47f0a9799b65f30861b0122f'));
define('NONCE_KEY',        getenv_docker('WORDPRESS_NONCE_KEY',        '46a335f7f4b96019fdc84b301476c1f91c5b5b5d'));
define('AUTH_SALT',        getenv_docker('WORDPRESS_AUTH_SALT',        'ab336d406556100aaabf188017107f5397659398'));
define('SECURE_AUTH_SALT', getenv_docker('WORDPRESS_SECURE_AUTH_SALT', 'a45bd1b0afa7469561bb69a26fa955848bd50c6a'));
define('LOGGED_IN_SALT',   getenv_docker('WORDPRESS_LOGGED_IN_SALT',   'edb3a87635f0c2678e3e3333d89284471ebb17eb'));
define('NONCE_SALT',       getenv_docker('WORDPRESS_NONCE_SALT',       '4e1f4a8c23c697c48cc33b29356d2dbca5a9c346'));

// Prefixo das tabelas
$table_prefix = getenv_docker('WORDPRESS_TABLE_PREFIX', 'wp_');

// Debug
define('WP_DEBUG', filter_var(getenv_docker('WORDPRESS_DEBUG', 'false'), FILTER_VALIDATE_BOOLEAN));
define('WP_DEBUG_LOG', filter_var(getenv_docker('WORDPRESS_DEBUG_LOG', 'false'), FILTER_VALIDATE_BOOLEAN));
define('WP_DEBUG_DISPLAY', filter_var(getenv_docker('WORDPRESS_DEBUG_DISPLAY', 'false'), FILTER_VALIDATE_BOOLEAN));

// URLs do WordPress via Coolify
define('WP_HOME', getenv_docker('WP_HOME', 'https://grupac.com.br'));
define('WP_SITEURL', getenv_docker('WP_SITEURL', 'https://grupac.com.br'));

// Correção para HTTPS atrás do proxy do Coolify / Traefik
if (
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false
) {
    $_SERVER['HTTPS'] = 'on';
}

if (
    isset($_SERVER['HTTP_X_FORWARDED_SSL']) &&
    $_SERVER['HTTP_X_FORWARDED_SSL'] === 'on'
) {
    $_SERVER['HTTPS'] = 'on';
}

// Configuração extra opcional via variável WORDPRESS_CONFIG_EXTRA
if ($configExtra = getenv_docker('WORDPRESS_CONFIG_EXTRA', '')) {
    eval($configExtra);
}

/* That's all, stop editing! Happy publishing. */

if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

require_once ABSPATH . 'wp-settings.php';
