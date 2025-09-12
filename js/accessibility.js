/* js/accessibility.js
   - A− / A / A+ (75–200%, zapamiętywane w localStorage)
   - Wysoki kontrast (toggle, zapamiętywane)
   - Usprawnienia klawiatury dla akordeonu menu (↑ ↓ ← → Home End)
   - Drobne ulepszenia nawigacyjne (skip-link)
*/
(function () {
  /* ========== 1) Ustawienia początkowe z pamięci ========== */
  var htmlEl = document.documentElement;
  var btnDec = document.getElementById('fontDec');
  var btnInc = document.getElementById('fontInc');
  var btnReset = document.getElementById('fontReset');
  var btnContrast = document.getElementById('contrastToggle');

  var savedScale = parseInt(localStorage.getItem('fontScale') || '100', 10);
  var savedHc = localStorage.getItem('highContrast') === '1';

  if (!isNaN(savedScale)) htmlEl.style.fontSize = savedScale + '%';
  if (savedHc) {
    document.body.classList.add('high-contrast');
    if (btnContrast) btnContrast.setAttribute('aria-pressed', 'true');
  }

  /* ========== 2) Skala czcionki ========== */
  function clamp(n, min, max) { return Math.max(min, Math.min(max, n)); }
  function currentScalePct() {
    // 1rem w Bootstrap ≈ 16px (bez zmian bazowych) – to nam wystarczy.
    var px = parseFloat(getComputedStyle(htmlEl).fontSize);
    if (!px || isNaN(px)) return 100;
    return Math.round((px / 16) * 100);
  }
  function setScale(pct) {
    var clamped = clamp(pct, 75, 200); // dostępnościowy zakres
    htmlEl.style.fontSize = clamped + '%';
    localStorage.setItem('fontScale', String(clamped));
  }

  btnDec && btnDec.addEventListener('click', function () { setScale(currentScalePct() - 10); });
  btnInc && btnInc.addEventListener('click', function () { setScale(currentScalePct() + 10); });
  btnReset && btnReset.addEventListener('click', function () { setScale(100); });

  /* ========== 3) Wysoki kontrast ========== */
  btnContrast && btnContrast.addEventListener('click', function () {
    var on = document.body.classList.toggle('high-contrast');
    btnContrast.setAttribute('aria-pressed', on ? 'true' : 'false');
    localStorage.setItem('highContrast', on ? '1' : '0');
  });

  /* ========== 4) Skip link – fokus do treści ========== */
  document.querySelectorAll('.skip-link[href^="#"]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var id = a.getAttribute('href').slice(1);
      var target = document.getElementById(id);
      if (target) {
        // daj chwilę na przewinięcie
        setTimeout(function () { target.setAttribute('tabindex', '-1'); target.focus(); }, 0);
      }
    });
  });

  /* ========== 5) Klawiatura dla akordeonu (menu) ========== */
  function initMenuKeyboard(containerId) {
    var root = document.getElementById(containerId);
    if (!root) return;

    function headerBtns() { return Array.prototype.slice.call(root.querySelectorAll('.accordion-button')); }
    function panelLinks() {
      return Array.prototype.slice.call(
        root.querySelectorAll('.accordion-collapse.show .list-group-item a, .accordion-collapse.collapsing .list-group-item a')
      );
    }
    function focusHeader(i) {
      var btns = headerBtns();
      if (!btns.length) return;
      var idx = Math.max(0, Math.min(i, btns.length - 1));
      btns[idx].focus();
    }
    function nextHeader(currentBtn, dir) {
      var btns = headerBtns();
      var idx = btns.indexOf(currentBtn);
      if (idx === -1) return;
      btns[(idx + dir + btns.length) % btns.length].focus();
    }
    function isExpanded(btn) { return btn.getAttribute('aria-expanded') === 'true'; }
    function expand(btn) { if (!isExpanded(btn)) btn.click(); }
    function collapse(btn) { if (isExpanded(btn)) btn.click(); }

    root.addEventListener('keydown', function (e) {
      var t = e.target;
      var isHeader = t.classList && t.classList.contains('accordion-button');
      var isLink = t.tagName === 'A' && t.closest('.accordion-collapse');

      if (isHeader) {
        switch (e.key) {
          case 'ArrowDown': e.preventDefault(); nextHeader(t, +1); break;
          case 'ArrowUp':   e.preventDefault(); nextHeader(t, -1); break;
          case 'Home':      e.preventDefault(); focusHeader(0);    break;
          case 'End':       e.preventDefault(); focusHeader(headerBtns().length - 1); break;
          case 'ArrowRight':
            e.preventDefault();
            if (!isExpanded(t)) { expand(t); }
            else {
              var panel = document.querySelector(t.getAttribute('data-bs-target'));
              var firstLink = panel ? panel.querySelector('.list-group-item a') : null;
              if (firstLink) firstLink.focus();
            }
            break;
          case 'ArrowLeft': e.preventDefault(); collapse(t); break;
        }
      }

      if (isLink) {
        var links = panelLinks();
        var i = links.indexOf(t);
        if (i === -1) return;
        switch (e.key) {
          case 'ArrowDown': e.preventDefault(); if (i < links.length - 1) links[i + 1].focus(); break;
          case 'ArrowUp':
            e.preventDefault();
            if (i > 0) links[i - 1].focus();
            else {
              var collapseEl = t.closest('.accordion-collapse');
              var headerId = collapseEl && collapseEl.getAttribute('aria-labelledby');
              var headerBtn = headerId ? document.getElementById(headerId).querySelector('.accordion-button') : null;
              headerBtn && headerBtn.focus();
            }
            break;
          case 'ArrowLeft':
            e.preventDefault();
            var cEl = t.closest('.accordion-collapse');
            var hId = cEl && cEl.getAttribute('aria-labelledby');
            var hBtn = hId ? document.getElementById(hId).querySelector('.accordion-button') : null;
            hBtn && hBtn.focus();
            break;
          case 'Home': e.preventDefault(); focusHeader(0); break;
          case 'End':  e.preventDefault(); focusHeader(headerBtns().length - 1); break;
        }
      }
    });
  }

  // Inicjalizacja obu egzemplarzy, jeśli istnieją
  initMenuKeyboard('sidebarAccordion');
  initMenuKeyboard('mobileAccordion');

  /* ========== 6) Drobnostka: zamknij offcanvas po kliknięciu linku (fallback) ========== */
  // Renderer menu dodaje data-bs-dismiss="offcanvas" w mobile, ale na wszelki wypadek:
  var offcanvas = document.getElementById('mobileMenu');
  if (offcanvas) {
    offcanvas.addEventListener('click', function (e) {
      var a = e.target.closest('a[href]');
      if (!a) return;
      // Bootstrap sam zamknie, jeśli jest data-bs-dismiss; jeśli nie – spróbujmy ręcznie
      if (!a.hasAttribute('data-bs-dismiss')) {
        try {
          var oc = bootstrap && bootstrap.Offcanvas.getInstance(offcanvas);
          if (oc) oc.hide();
        } catch (_) {}
      }
    });
  }
  /* ========== 7) Offset offcanvas ponizej sticky headera ========== */
  function updateToolbarOffset(){
    try{
      var bar = document.querySelector('.access-toolbar');
      var h = bar ? Math.round(bar.getBoundingClientRect().height) : 0;
      document.documentElement.style.setProperty('--toolbar-offset', h + 'px');
    }catch(_){ /* no-op */ }
  }
  // Oblicz na starcie, na resize i przy otwieraniu offcanvas
  updateToolbarOffset();
  window.addEventListener('resize', updateToolbarOffset);
  document.addEventListener('shown.bs.offcanvas', updateToolbarOffset);
  document.addEventListener('show.bs.offcanvas', updateToolbarOffset);
})();
