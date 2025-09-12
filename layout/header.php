<?php
// Konfiguracja i menu
require_once __DIR__ . '/../config.php';
app_require('menu.php');

// Ustal tytuł dokumentu — fallback gdy $pageTitle nie ustawione
$documentTitle = isset($pageTitle) ? "{$pageTitle} – BIP" : "BIP – Platforma";
?>
<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Tytuł dokumentu -->
  <title><?= htmlspecialchars($documentTitle, ENT_QUOTES, 'UTF-8') ?></title>

  <!-- CSS (Bootstrap zawsze przed style.css) -->
  <link href="<?= asset('css/bootstrap.min.css') ?>" rel="stylesheet">
  <link href="<?= asset('css/style.css') ?>" rel="stylesheet">

  <!-- Ikony Bootstrap Icons: lokalnie -->
  <link href="<?= asset('css/bootstrap-icons.css') ?>" rel="stylesheet">

  <!-- Wydajność: lekkie hinty. Usuń, jeśli CSP/Polityka wymaga minimalizmu -->
  <link rel="preload" href="<?= asset('biplogo.jpg') ?>" as="image">
</head>

<!--
  body ma klasę bg-body by szanować zmienne Bootstrapa oraz tryb high-contrast
-->
<body class="bg-body">

<!-- Link przeskoku dla czytników ekranowych/klawiatury -->
<a class="skip-link" href="#main-content">Przejdź do treści głównej</a>

<!-- Toolbar dostępności (sticky, nad treścią) -->
<div class="access-toolbar sticky-top border-bottom bg-body-tertiary">
  <div class="container-fluid d-flex flex-wrap align-items-center gap-2 py-2">
    <div class="d-flex align-items-center gap-2 me-auto" aria-label="Logotypy">
      <img src="<?= asset('biplogo.png') ?>" alt="BIP" height="32" class="img-fluid">
      <img src="<?= asset('epuaplogo.png') ?>" alt="ePUAP" height="32" class="img-fluid">
    </div>
    <strong class="me-auto">BIP – dostępność</strong>

     <!-- Przycisk menu mobilnego (otwiera offcanvas) -->
    <button class="btn btn-outline-secondary d-md-none ms-2" type="button"
            data-bs-toggle="offcanvas" data-bs-target="#mobileMenu"
            aria-controls="mobileMenu" aria-label="Otwórz menu">
      Menu
    </button>

    <!-- Kontrola rozmiaru fontu (aria-label dla czytników) -->
    <div class="btn-group" role="group" aria-label="Zmiana rozmiaru czcionki">
      <button class="btn btn-outline-secondary" id="fontDec" type="button" aria-label="Zmniejsz czcionkę">A−</button>
      <button class="btn btn-outline-secondary" id="fontReset" type="button" aria-label="Resetuj rozmiar czcionki">A</button>
      <button class="btn btn-outline-secondary" id="fontInc" type="button" aria-label="Zwiększ czcionkę">A+</button>
    </div>

    <!-- Przełącznik wysokiego kontrastu: aria-pressed aktualizuj w JS -->
    <button class="btn btn-outline-secondary" id="contrastToggle" type="button"
            aria-pressed="false" aria-label="Przełącz wysoki kontrast">
      <i class="bi bi-circle-half" aria-hidden="true"></i>
      <span class="visually-hidden">Wysoki kontrast</span>
    </button>

   

    <a href="/rejestrzmian/rejestrzmian" class="btn btn-outline-secondary ms-2" title="Jednolity Rejestr Zmian" aria-label="Jednolity Rejestr Zmian">
      <i class="bi bi-info-circle" aria-hidden="true"></i>
      <span class="d-none d-sm-inline ms-1">Rejestr zmian</span>
    </a>

    <a href="/instrukcjabip" class="btn btn-outline-secondary ms-2" title="Instrukcja Obsługi BIP" aria-label="Instrukcja Obsługi BIP">
      <i class="bi bi-question-circle" aria-hidden="true"></i>
      <span class="d-none d-sm-inline ms-1">Instrukcja BIP</span>
    </a>

    <a href="/dostepnosc" class="btn btn-outline-secondary ms-2" title="Deklaracja dostępności" aria-label="Deklaracja dostępności">
      <i class="bi bi-universal-access-circle" aria-hidden="true"></i>
      <span class="d-none d-sm-inline ms-1">Dostępność</span>
    </a>

    <a href="/sitemap" class="btn btn-outline-secondary sitemap-button ms-2" title="Mapa strony" aria-label="Mapa strony">
<i class="bi bi-diagram-3" aria-hidden="true"></i>
<span class="d-none d-sm-inline ms-1">Mapa strony</span>
</a>

  </div>
</div>

<!-- Hero (grafika u góry). Lazy + decoding dla wydajności -->
<section class="hero" aria-label="Grafika nagłówkowa">
  <img src="<?= asset('biplogo.jpg') ?>"
       alt="Grafika nagłówkowa BIP"
       loading="lazy" decoding="async" fetchpriority="low">
</section>

<!-- Layout: Sidebar + Treść -->
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar (desktop) jako region nawigacji -->
    <aside class="sidebar col-md-3 d-none d-md-block min-vh-100 bg-body" aria-label="Menu główne">
      <div class="p-3">
        <h2 class="h5 mb-3 bip-box-title">
          <i class="bi bi-list" aria-hidden="true"></i>
          <span>Menu</span>
        </h2>
        <?php
          // Menu boczne (desktop). Upewnij się, że render_menu generuje prawidłowe aria-* dla akordeonu.
          render_menu(bip_menu(), [
            'idPrefix'     => 'd',
            'accordionId'  => 'sidebarAccordion',
            'ariaLabel'    => 'Menu główne (desktop)',
            'flush'        => true,
            'listFlush'    => true,
            'linkClass'    => 'text-decoration-none',
            'dismissOnClick'=> false,
          ]);
        ?>
      </div>
    </aside>

    <!-- Treść główna. tabindex="-1" dla poprawnego focusu po skip linku -->
    <main id="main-content" class="col-12 col-md-9 p-3" tabindex="-1" role="main" aria-label="Treść główna">