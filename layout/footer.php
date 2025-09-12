    </main> <!-- /main -->
  </div> <!-- /.row -->
</div> <!-- /.container-fluid -->

<!-- Offcanvas (menu mobilne) -->
<div class="offcanvas offcanvas-start below-header" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
  <div class="offcanvas-header">
    <h2 class="h5 offcanvas-title" id="mobileMenuLabel">Menu</h2>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Zamknij menu"></button>
  </div>
  <div class="offcanvas-body">
    <?php
      // Menu mobilne. dismissOnClick=true by zamykać po wyborze.
      render_menu(bip_menu(), [
        'idPrefix'     => 'm',
        'accordionId'  => 'mobileAccordion',
        'ariaLabel'    => 'Menu główne (mobilne)',
        'flush'        => false,
        'listFlush'    => true,
        'linkClass'    => '',
        'dismissOnClick'=> true,
      ]);
    ?>
  </div>
</div>

<!-- Stopka globalna -->
<footer class="bg-body-tertiary border-top mt-auto py-4 site-footer">
  <div class="container d-flex flex-column flex-sm-row align-items-start gap-2 justify-content-between">
 
  </div>
</div>

  <!-- Nowa, 4‑kolumnowa stopka -->
  <div class="container mt-3">
    <div class="row g-4 align-items-start site-footer-cols">

      <!-- 1) Dane spółki -->
      <div class="col-12 col-lg-3 footer-col">
        <h2 class="h6 mb-3">Dane spółki</h2>
        <address class="mb-0">
          <strong>Nazwa Spółki Sp. z o.o.</strong><br>
          ul. Przykładowa 1, 00-000 Miasto<br>
          NIP: 000-000-00-00, REGON: 000000000<br>
          e-mail: kontakt@bip24.pl</a><br>
          tel.: +48 123 456 789</a>
        </address>
      </div>

      <!-- 2) Informacje (linki) -->
      <div class="col-12 col-lg-3 footer-col">
        <h2 class="h6 mb-3">Informacje</h2>
        <ul class="list-unstyled mb-0">
          <li><a href="<?= bip_href('/sitemap') ?>">Mapa strony</a></li>
          <li><a href="<?= bip_href('/dostepnosc') ?>">Deklaracja dostępności</a></li>
          <li><a href="<?= bip_href('/instrukcjabip') ?>">Instrukcja Obsługi BIP</a></li>
          <li><a href="<?= bip_href('/rejestrzmian/rejestrzmian') ?>">Jednolity Rejestr Zmian</a></li>
        </ul>
      </div>

      <!-- 3) Polityki i statystyki (przyciski) -->
      <div class="col-12 col-lg-3 footer-col">
        <h2 class="h6 mb-3">Polityki i statystyki</h2>
          <ul class="list-unstyled mb-0">
          <li><a href="<?= bip_href('/polityka-prywatnosci') ?>">Polityka prywatności</a></li>
          <li><a href="<?= bip_href('/polityka-cookies') ?>">Polityka cookies</a></li>
          <li><a href="<?= bip_href('/statystyka-odwiedzin') ?>">Statystyka odwiedzin</a></li>
        </ul>
      </div>

      <!-- 4) Logo BIP -->
      <div class="col-12 col-lg-3 footer-col text-lg-end">
        <h2 class="visually-hidden">Logo BIP</h2>
        <img src="<?= asset('biplogo.png') ?>" alt="BIP" height="40" class="img-fluid">
        <p class="text-muted small mt-2 mb-0">&copy; <?= date('Y') ?> Biuletyn Informacji Publicznej</p>
      </div>

    </div>
  </div>
</footer>

<!-- Skrypty. Defer poprawia First Contentful Paint -->
<script src="<?= asset('../js/bootstrap.bundle.min.js') ?>" defer></script>
<script src="<?= asset('../js/accessibility.js') ?>" defer></script>

<!-- Fallback dla użytkowników bez JS -->
<noscript>
  <div class="alert alert-warning text-center m-0" role="alert">
    Ta strona działa lepiej z włączoną obsługą JavaScript.
  </div>
</noscript>

</body>
</html>
