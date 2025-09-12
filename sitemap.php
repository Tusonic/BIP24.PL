<?php

$pageTitle = "Mapa strony";
require __DIR__ . '/layout/header.php';

// Funkcja rysująca mapę strony na podstawie bip_menu()
function render_sitemap(array $menu): void {
  echo '<div class="sitemap">';
  foreach ($menu as $section) {
    $title = htmlspecialchars($section['title'] ?? '', ENT_QUOTES, 'UTF-8');
    $items = (array)($section['items'] ?? []);
    $isLinkOnly = empty($items) && !empty($section['href']);
    $sectionUrl = '';
    if ($isLinkOnly) {
      $href = (string)$section['href'];
      $sectionUrl = htmlspecialchars(bip_href($href), ENT_QUOTES, 'UTF-8');
    }

    echo '<section class="mb-4">';
    // If section has no submenu but has href, make the heading a link
    if ($isLinkOnly) {
      echo '<h2 class="h5 mb-3"><a class="link-primary" href="'.$sectionUrl.'">'.$title.'</a></h2>';
    } else {
      echo '<h2 class="h5 mb-3">'.$title.'</h2>';
    }

    if ($items) {
      echo '<ul class="list-unstyled ms-3">';
      foreach ($items as $it) {
        $label = htmlspecialchars((string)($it['label'] ?? ''), ENT_QUOTES, 'UTF-8');
        $href  = (string)($it['href'] ?? '#');
        $url   = htmlspecialchars(bip_href($href), ENT_QUOTES, 'UTF-8');
        echo '<li class="mb-1"><a class="link-primary" href="'.$url.'">'.$label.'</a></li>';
      }
      echo '</ul>';
    } else if ($isLinkOnly) {
      // Sekcja typu "link" (bez podmenu) — potraktuj jako pojedynczą stronę
      // heading is clickable; nothing to list
    } else {
      echo '<p class="text-muted">Brak podstron w tej sekcji.</p>';
    }

    echo '</section>';
  }
  echo '</div>';
}
?>

<h1 class="mb-3 bip-box-title">
  <i class="bi bi-diagram-3" aria-hidden="true"></i>
  <span>Mapa strony</span>
</h1>
<p class="text-muted">Poniżej znajduje się pełna lista sekcji i podstron dostępnych w BIP.</p>
<hr class="my-4">

<?php render_sitemap( bip_menu() ); ?>

<?php require __DIR__ . '/layout/footer.php'; ?>
