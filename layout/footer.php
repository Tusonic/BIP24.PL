    </main> <!-- /main -->
  </div> <!-- /.row -->
</div> <!-- /.container-fluid -->

<!-- Offcanvas (menu mobilne) -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
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
<footer class="bg-body-tertiary border-top mt-auto py-4">
  <div class="container d-flex flex-column flex-sm-row align-items-start gap-2 justify-content-between">
    <p class="mb-0">
      © <?= date('Y') ?> Biuletyn Informacji Publicznej
      <span class="visually-hidden">— wszystkie prawa zastrzeżone</span>
    </p>
    <nav aria-label="Linki w stopce">
      <a href="<?= bip_href('/sitemap.php') ?>" class="me-3">Mapa strony</a>
      <!-- tutaj możesz dodać: Deklaracja dostępności, Polityka prywatności, itp. -->
    </nav>
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
