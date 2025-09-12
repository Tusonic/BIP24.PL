<?php
declare(strict_types=1);

// Simple links table helpers (ASCII-only comments)
// Renders a compact table of links to subpages
// Item keys:
// - label (string, required): visible text
// - href  (string, required): link URL (relative like '/ogloszenia' or absolute)

if (!function_exists('render_links_table')) {
  function render_links_table(array $items, array $opts = []): void {
    $caption = $opts['caption'] ?? 'Odniesienia do podstron';
    echo '<table class="table align-middle mb-0">';
    echo '<caption class="visually-hidden">' . htmlspecialchars($caption, ENT_QUOTES, 'UTF-8') . '</caption>';
    echo '<thead><tr>';
    echo '<th scope="col" style="width:2.5rem"></th>';
    echo '<th scope="col">Nazwa</th>';
    echo '</tr></thead><tbody>';

    foreach ($items as $it) {
      $label = (string)($it['label'] ?? '');
      $href  = (string)($it['href'] ?? '');
      if ($label === '' || $href === '') continue;
      $url = bip_href($href);

      echo '<tr>';
      echo '<td class="text-muted"><i class="bi bi-arrow-right-circle" aria-hidden="true"></i></td>';
      echo '<td><a class="link-primary" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</a></td>';
      echo '</tr>';
    }

    echo '</tbody></table>';
  }
}

// Version with publication date column at the end
if (!function_exists('render_links_table_with_date')) {
  function render_links_table_with_date(array $items, array $opts = []): void {
    $caption = $opts['caption'] ?? 'Odniesienia do podstron';
    echo '<table class="table align-middle mb-0">';
    echo '<caption class="visually-hidden">' . htmlspecialchars($caption, ENT_QUOTES, 'UTF-8') . '</caption>';
    echo '<thead><tr>';
    echo '<th scope="col" style="width:2.5rem"></th>';
    echo '<th scope="col">Nazwa</th>';
    echo '<th scope="col" class="text-end text-nowrap" style="width:1%">Data publikacji</th>';
    echo '</tr></thead><tbody>';

    foreach ($items as $it) {
      $label = (string)($it['label'] ?? '');
      $href  = (string)($it['href'] ?? '');
      $date  = (string)($it['date'] ?? '');
      if ($label === '' || $href === '') continue;
      $url = bip_href($href);

      echo '<tr>';
      echo '<td class="text-muted"><i class="bi bi-arrow-right-circle" aria-hidden="true"></i></td>';
      echo '<td><a class="link-primary" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</a></td>';
      echo '<td class="text-end text-nowrap">' . ($date !== '' ? htmlspecialchars($date, ENT_QUOTES, 'UTF-8') : '&mdash;') . '</td>';
      echo '</tr>';
    }

    echo '</tbody></table>';
  }
}
