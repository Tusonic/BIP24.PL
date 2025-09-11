<?php
// Tytuł strony (używany w <title> i jako H1 na stronie)
$pageTitle = "Strona główna BIP";

// Wspólny nagłówek (HTML head, toolbar, hero, sidebar, otwarcie <main>)
require __DIR__ . '/layout/header.php';
?>

<!-- Główny tytuł strony (H1) — JEDEN na stronę -->
<h1 class="mb-3 bip-box-title">
  <i class="bi bi-house-door" aria-hidden="true"></i>
  <span>Strona główna</span>
</h1>

<!-- Sekcja z aktualnościami/treścią. aria-labelledby wskazuje nagłówek w sekcji -->
<section class="mb-4" aria-labelledby="sec-aktualnosci-heading">
  <h2 id="sec-aktualnosci-heading" class="h4 mb-3">
    <i class="bi bi-megaphone" aria-hidden="true"></i>
    <span>Aktualności</span>
  </h2>

  <!-- Prawidłowa struktura: nagłówki nie są wewnątrz <p> -->
  <p>To jest przykładowy akapit treści. Zastąp go właściwą zawartością.</p>
  <h3 class="h5">Podsekcja</h3>
  <p>Kolejny akapit opisujący szczegóły podsekcji.</p>
</section>

<!-- Dodatkowy przykład sekcji tematycznej -->
<section class="mb-4" aria-labelledby="sec-inne-info-heading">
  <h2 id="sec-inne-info-heading" class="h4 mb-3">
    <i class="bi bi-info-circle" aria-hidden="true"></i>
    <span>Inne informacje</span>
  </h2>

  <ul class="list-unstyled">
    <li class="mb-2">
      <i class="bi bi-file-earmark-text" aria-hidden="true"></i>
      <a href="#" class="link-primary">Przykładowy dokument</a>
    </li>
    <li class="mb-2">
      <i class="bi bi-calendar-event" aria-hidden="true"></i>
      <a href="#" class="link-primary">Przykładowe wydarzenie</a>
    </li>
  </ul>
</section>

<?php
// Wspólny footer (offcanvas + stopka + skrypty + zamknięcia tagów)
require __DIR__ . '/layout/footer.php';
