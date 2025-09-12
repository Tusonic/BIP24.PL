<?php
declare(strict_types=1);

/* ===== 1) DRZEWO MENU ===== */
if (!function_exists('bip_menu')) {
  function bip_menu(): array {
    return [
      [
        'title' => 'Informacje publiczne',
        'slug'  => 'info',
        'items' => [
          ['label' => 'Historia',       'href' => '/informacje/historia'],
          ['label' => 'Statut',         'href' => '/informacje/statut'],
          ['label' => 'Regulaminy',     'href' => '/informacje/regulaminy'],
        ],
      ],
      [
        'title' => 'Organizacja',
        'slug'  => 'org',
        'items' => [
          ['label' => 'Władze',         'href' => '/organizacja/wladze'],
          ['label' => 'Struktura',      'href' => '/organizacja/struktura'],
        ],
      ],
      [
        'title' => 'Prawo',
        'slug'  => 'law',
        'items' => [
          ['label' => 'Ustawy',         'href' => '/prawo/ustawy'],
          ['label' => 'Rozporządzenia', 'href' => '/prawo/rozporzadzenia'],
        ],
      ],
      [
        'title' => 'Kontakt',
        'slug'  => 'kontakt',
        'href'  => '/kontakt',
      ],
    ];
  }
}

/* ===== 2) HELPERY ===== */
if (!function_exists('bip_base_url')) {
  function bip_base_url(): string {
    $b = defined('BASE_URL') ? (string)BASE_URL : '/';
    return $b === '' ? '/' : ($b === '/' ? '/' : rtrim($b,'/'));
  }
}
if (!function_exists('bip_href')) {
  function bip_href(string $href): string {
    if (preg_match('~^https?://~i', $href)) return $href;
    if (isset($href[0]) && $href[0] === '/') {
      $base = bip_base_url();
      return $base === '/' ? $href : $base.$href;
    }
    return $href;
  }
}
if (!function_exists('bip_normalize_path')) {
  function bip_normalize_path(string $p): string {
    if ($p === '' || $p === null) return '/';
    if ($p !== '/' && str_ends_with($p,'/')) $p = rtrim($p,'/');
    return $p === '' ? '/' : $p;
  }
}
if (!function_exists('bip_current_path')) {
  function bip_current_path(): string {
    $uriPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $base = bip_base_url();
    if ($base !== '/' && str_starts_with($uriPath, $base.'/')) {
      $uriPath = substr($uriPath, strlen($base));
    } elseif ($uriPath === $base) {
      $uriPath = '/';
    }
    return bip_normalize_path($uriPath);
  }
}
if (!function_exists('bip_is_active')) {
  function bip_is_active(string $href, string $current): bool {
    $path = bip_normalize_path(parse_url($href, PHP_URL_PATH) ?: '/');
    $cur  = bip_normalize_path($current);
    return $path === $cur;
  }
}
/* Sekcja aktywna (np. /prawo/* aktywuje „Prawo”) */
if (!function_exists('bip_is_section_active')) {
  function bip_is_section_active(array $section, string $current): bool {
    foreach ((array)($section['items'] ?? []) as $it) {
      if (bip_is_active((string)($it['href'] ?? '/'), $current)) return true;
    }
    // jeśli chcesz: aktywuj też po prefiksie np. /prawo/*
    if (!empty($section['items'][0]['href'])) {
      $first = bip_normalize_path(parse_url($section['items'][0]['href'], PHP_URL_PATH) ?: '/');
      return $first !== '/' && str_starts_with($current, rtrim($first, '/'));
    }
    return false;
  }
}

/* ===== 3) RENDER ===== */
if (!function_exists('render_menu')) {
  function render_menu(array $menu, array $opts=[]): void {
    $idPrefix       = $opts['idPrefix']       ?? 'm';
    $accordionId    = $opts['accordionId']    ?? "{$idPrefix}-accordion";
    $ariaLabel      = $opts['ariaLabel']      ?? 'Menu';
    $flush          = (bool)($opts['flush']   ?? true);
    $listFlush      = (bool)($opts['listFlush'] ?? true);
    $dismissOnClick = (bool)($opts['dismissOnClick'] ?? false);

    $current = bip_current_path();

    echo '<nav aria-label="'.htmlspecialchars($ariaLabel).'">';
    echo '<div class="accordion'.($flush?' accordion-flush':'').'" id="'.htmlspecialchars($accordionId).'">';

    foreach ($menu as $section) {
      $title = (string)($section['title'] ?? '');
      $slug  = preg_replace('~[^a-z0-9_-]+~i','-', (string)($section['slug'] ?? $title));
      $items = (array)($section['items'] ?? []);

      $hid = "{$idPrefix}-h-{$slug}";
      $cid = "{$idPrefix}-c-{$slug}";

      if (empty($items) && !empty($section['href'])) {
         $href      = (string)$section['href'];
        $url       = bip_href($href);
        $active    = bip_is_active($href, $current);
        $collapsed = $active ? '' : ' collapsed';
        $aCls      = 'accordion-button bip-borderable'.$collapsed
                     .($active ? ' bip-active' : '').' bip-no-arrow';
     echo '<div class="accordion-item">';
         echo '<h3 class="accordion-header" id="'.htmlspecialchars($hid).'">';
         echo '<a class="'.htmlspecialchars($aCls).'" href="'.htmlspecialchars($url).'"'
              .($active ? ' aria-current="page"' : '').'>'
              .htmlspecialchars($title).'</a>';
         echo '</h3></div>';
         continue;
       }

      $sectionActive = bip_is_section_active($section, $current);

      $btnCollapsed = $sectionActive ? '' : ' collapsed';
      $ariaExp      = $sectionActive ? 'true' : 'false';
      $collapseCls  = 'accordion-collapse collapse'.($sectionActive?' show':'');

      echo '<div class="accordion-item">';

        echo '<h3 class="accordion-header" id="'.htmlspecialchars($hid).'">';
          $btnClasses = 'accordion-button'.$btnCollapsed.' bip-borderable'.($sectionActive ? ' bip-active' : '');
          echo '<button class="'.htmlspecialchars($btnClasses).'" type="button"'
             .' data-bs-toggle="collapse"'
             .' data-bs-target="#'.htmlspecialchars($cid).'"'
             .' aria-expanded="'.$ariaExp.'"'
             .' aria-controls="'.htmlspecialchars($cid).'">'
             . htmlspecialchars($title)
             . '</button>';
        echo '</h3>';

        echo '<div id="'.htmlspecialchars($cid).'" class="'.$collapseCls.'"'
           .' aria-labelledby="'.htmlspecialchars($hid).'"'
           .' data-bs-parent="#'.htmlspecialchars($accordionId).'">';

          echo '<div class="accordion-body p-0">';
            echo '<ul class="list-group'.($listFlush?' list-group-flush':'').'">';

              foreach ($items as $item) {
                $label  = (string)($item['label'] ?? '');
                $href   = (string)($item['href']  ?? '#');
                $active = bip_is_active($href, $current);

                // li zachowuje swoje stockowe style, ramkę rysujemy na <a>
                $liCls = 'list-group-item';
                $aCls  = 'bip-link bip-borderable'.($active ? ' bip-active' : '');
                $dismiss = $dismissOnClick ? ' data-bs-dismiss="offcanvas"' : '';
                $url = bip_href($href);

                echo '<li class="'.$liCls.'">';
                  echo '<a class="'.$aCls.'" href="'.htmlspecialchars($url).'"'
                       .($active ? ' aria-current="page"' : '')
                       .$dismiss.'>'
                       . htmlspecialchars($label)
                       . '</a>';
                echo '</li>';
              }

            echo '</ul>';
          echo '</div>';

        echo '</div>'; // collapse

      echo '</div>'; // item
    }

    echo '</div>';
    echo '</nav>';
  }
}