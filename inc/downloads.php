<?php
declare(strict_types=1);

// Downloads helpers (ASCII-only comments)
// - wz_format_bytes(int): human readable size
// - wz_local_path_from_url(string): map URL to local file path inside APP_PATH
// - render_attachments_table(array, array): render a Bootstrap table of files

if (!function_exists('wz_format_bytes')) {
  function wz_format_bytes(int $bytes): string {
    if ($bytes < 1024) return $bytes . ' B';
    $units = ['KB', 'MB', 'GB', 'TB'];
    $i = -1; $v = (float)$bytes;
    do { $v /= 1024; $i++; } while ($v >= 1024 && $i < count($units) - 1);
    return number_format($v, ($v < 10 ? 1 : 0)) . ' ' . $units[$i];
  }
}

if (!function_exists('wz_local_path_from_url')) {
  function wz_local_path_from_url(string $url): string {
    $path = parse_url($url, PHP_URL_PATH) ?: '';
    if ($path === '') return '';
    $base = defined('BASE_URL') ? (string)BASE_URL : '/';
    if ($base !== '/' && str_starts_with($path, $base . '/')) {
      $rel = substr($path, strlen($base) + 1);
    } elseif ($base !== '/' && $path === $base) {
      $rel = '';
    } else {
      $rel = ltrim($path, '/');
    }
    $fs = rtrim(APP_PATH, '/\\') . '/' . $rel;
    return is_file($fs) ? $fs : '';
  }
}

if (!function_exists('render_attachments_table')) {
  function render_attachments_table(array $items, array $opts = []): void {
    $caption = $opts['caption'] ?? 'Pliki do pobrania';
    echo '<div class="table-responsive">';
    echo '<table class="table align-middle">';
    echo '<caption class="visually-hidden">' . htmlspecialchars($caption, ENT_QUOTES, 'UTF-8') . '</caption>';
    echo '<thead><tr>';
    echo '<th scope="col">Zalacznik</th>';
    echo '<th scope="col" class="text-nowrap">Data publikacji</th>';
    echo '<th scope="col" class="text-nowrap">Rozszerzenie</th>';
    echo '<th scope="col" class="text-nowrap">Wielkosc</th>';
    echo '</tr></thead><tbody>';

    foreach ($items as $it) {
      $label = (string)($it['label'] ?? '');
      $href  = (string)($it['href'] ?? '');
      if ($label === '' || $href === '') continue;

      $url = bip_href($href);
      $ext = isset($it['ext']) && $it['ext'] !== '' ? (string)$it['ext'] : '';
      if ($ext === '') {
        $p = parse_url($url, PHP_URL_PATH) ?: '';
        $ext = $p !== '' ? (string)pathinfo($p, PATHINFO_EXTENSION) : '';
        $ext = $ext !== '' ? strtolower($ext) : '';
      }
      $extLower = strtolower($ext);
      // Choose icon by extension
      $iconClass = 'bi bi-file-earmark';
      if ($extLower === 'pdf') {
        $iconClass = 'bi bi-file-earmark-pdf';
      } elseif (in_array($extLower, ['doc','docx','dot','dotx'], true)) {
        $iconClass = 'bi bi-file-earmark-word';
      } elseif (in_array($extLower, ['xls','xlsx','csv','ods'], true)) {
        $iconClass = 'bi bi-file-earmark-excel';
      } elseif ($extLower !== '') {
        $iconClass = 'bi bi-file-earmark-text';
      }

      $dateLabel = isset($it['date']) && $it['date'] !== '' ? (string)$it['date'] : '';
      $sizeLabel = isset($it['size']) && $it['size'] !== '' ? (string)$it['size'] : '';
      if ($sizeLabel === '') {
        $fs = wz_local_path_from_url($url);
        if ($fs !== '') {
          $bytes = @filesize($fs);
          if (is_int($bytes) && $bytes >= 0) {
            $sizeLabel = wz_format_bytes($bytes);
          }
        }
      }

      echo '<tr>';
      echo '<td>'
         . '<a class="link-primary d-inline-flex align-items-center gap-4" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '" download title="Pobierz" aria-label="Pobierz: ' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '">'
         . '<i class="bi bi-download" aria-hidden="true"></i>'
         . '<span>' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</span>'
         . '</a>'
         . '</td>';
      echo '<td>' . ($dateLabel !== '' ? htmlspecialchars($dateLabel, ENT_QUOTES, 'UTF-8') : '&mdash;') . '</td>';
      echo '<td>'
           . '<i class="'.htmlspecialchars($iconClass, ENT_QUOTES, 'UTF-8').' me-2" aria-hidden="true"></i>'
           . ($ext !== '' ? htmlspecialchars(strtoupper($ext), ENT_QUOTES, 'UTF-8') : '&mdash;')
           . '</td>';
      echo '<td>' . ($sizeLabel !== '' ? htmlspecialchars($sizeLabel, ENT_QUOTES, 'UTF-8') : '&mdash;') . '</td>';
      echo '</tr>';
    }

    echo '</tbody></table>';
    echo '</div>';
  }
}
