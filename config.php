<?php
declare(strict_types=1);

/* ŚCIEŻKI I BASE_URL (wykrywane automatycznie) */
define('APP_PATH', __DIR__);

$docRoot = isset($_SERVER['DOCUMENT_ROOT'])
  ? rtrim(str_replace('\\','/', $_SERVER['DOCUMENT_ROOT']), '/')
  : '';
$appPath = str_replace('\\','/', APP_PATH);
$base = '/'.ltrim($docRoot !== '' ? str_replace($docRoot, '', $appPath) : '', '/');
if ($base === '/0' || $base === '//') $base = '/';
define('BASE_URL', $base === '' ? '/' : $base);

/* Pomocnicy */
function app_require(string $rel): void {
  require_once APP_PATH.'/'.ltrim($rel, '/\\');
}
function asset(string $path): string {
  return (BASE_URL === '/' ? '' : BASE_URL) . '/' . ltrim($path,'/');
}

/* Polyfill (gdyby PHP<8) */
if (!function_exists('str_starts_with')) {
  function str_starts_with(string $haystack, string $needle): bool {
    return $needle === '' ? true : strncmp($haystack, $needle, strlen($needle)) === 0;
  }
}
if (!function_exists('str_ends_with')) {
  function str_ends_with(string $haystack, string $needle): bool {
    return $needle === '' ? true : substr($haystack, -strlen($needle)) === $needle;
  }
}
