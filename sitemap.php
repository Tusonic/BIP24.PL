<?php

$pageTitle = "Mapa strony";
require __DIR__ . '/layout/header.php';

// Funkcja rysująca mapę strony na podstawie bip_menu()
function render_sitemap(array $menu): void {
  echo '<div class="sitemap">';
  foreach ($menu as $section) {
    $title = htmlspecialchars($section['title'] ?? '', ENT_QUOTES, 'UTF-8');
    $items = (array)($section['items'] ?? []);

    echo '<section class="mb-4">';
    echo '<h2 class="h5 mb-3">'.$title.'</h2>';

    if ($items) {
      echo '<ul class="list-unstyled ms-3">';
      foreach ($items as $it) {
        $label = htmlspecialchars((string)($it['label'] ?? ''), ENT_QUOTES, 'UTF-8');
        $href  = (string)($it['href'] ?? '#');
        $url   = htmlspecialchars(bip_href($href), ENT_QUOTES, 'UTF-8');
        echo '<li class="mb-1"><a class="link-primary" href="'.$url.'">'.$label.'</a></li>';
      }
      echo '</ul>';
    } else {
      echo '<p class="text-muted">Brak podstron w tej sekcji.</p>';
    }

    echo '</section>';
  }
  echo '</div>';
}
?>

<h1 class="h2 mb-4">Mapa strony</h1>
<p class="text-muted">Poniżej znajduje się pełna lista sekcji i podstron dostępnych w BIP.</p>
<hr class="my-4">

<?php render_sitemap( bip_menu() ); ?>

<?php require __DIR__ . '/layout/footer.php'; ?>
