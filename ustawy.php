<?php
// Tytuł strony (używany w <title> i jako H1 na stronie)
$pageTitle = "Strona główna BIP";

// Wspólny nagłówek (HTML head, toolbar, hero, sidebar, otwarcie <main>)
require __DIR__ . '/layout/header.php';
?>

<!-- Główny tytuł strony (H1) — JEDEN na stronę -->
<h1 class="mb-3 bip-box-title">
  <i class="bi bi-info-circle" aria-hidden="true"></i>
  <span>Ustawy</span>
</h1>


<?php
// Wspólny footer (offcanvas + stopka + skrypty + zamknięcia tagów)
require __DIR__ . '/layout/footer.php';
