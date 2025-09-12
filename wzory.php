<?php
$pageTitle = "Wzory";



// Header/Footer z katalogu wyżej
require __DIR__ . '/layout/header.php';

// INC
require __DIR__ . '/inc/downloads.php';
require __DIR__ . '/inc/tabela.php';
?>

<h1 class="mb-3 bip-box-title">
  <i class="bi bi-info-circle" aria-hidden="true"></i>
  <span>Wzory</span>
</h1>


<section class="mb-4" aria-labelledby="sec-files-heading">
  <h2 id="sec-files-heading" class="h5 mb-3">Pliki do pobrania (wzorzec)</h2>
  <?php
    $attachments = [
      [ 'label' => 'Logo BIP (JPG, lokalny przyklad) przykładowy tekst dalszy', 'href' => asset('biplogo.jpg'), 'date' => '2024-06-01' ],
      [ 'label' => 'Przykladowy PDF (zewnetrzny)', 'href' => 'https://example.com/file.pdf', 'size' => '', 'date' => '2024-05-10' ],
      [ 'label' => 'Regulamin (manualny opis)', 'href' => asset('biplogo.png'), 'ext' => 'pdf', 'size' => '1.2 MB', 'date' => '2024-01-01' ],
      [ 'label' => 'Regulamin (manualny opis)', 'href' => asset('biplogo.png'), 'ext' => 'doc', 'size' => '1.2 MB', 'date' => '2024-01-01' ],
      [ 'label' => 'Regulamin (manualny opis)', 'href' => asset('biplogo.png'), 'ext' => 'xls', 'size' => '1.2 MB', 'date' => '2024-01-01' ],
    ];
    render_attachments_table($attachments);
  ?>
</section>

<section class="mb-4" aria-labelledby="sec-links2-heading">
  <h2 id="sec-links2-heading" class="h5 mb-3">Odniesienia do podstron z data (wzorzec)</h2>
  <?php
    // Example data for subpages links with publication date
    $pageLinks2 = [
      [ 'label' => 'Ogloszenia',  'href' => '/ogloszenia',  'date' => '2024-06-15' ],
      [ 'label' => 'Przetargi',   'href' => '/przetargi',   'date' => '2024-06-10' ],
      [ 'label' => 'Aktualnosci', 'href' => '/aktualnosci', 'date' => '2024-06-05' ],
    ];
    render_links_table_with_date($pageLinks2);
  ?>
</section>

<!-- treść strony... -->
 
 <section class="mb-4" aria-labelledby="sec-links-heading">
   <h2 id="sec-links-heading" class="h5 mb-3">Odniesienia do podstron (wzorzec)</h2>
   <?php
     // Example data for subpages links
     $pageLinks = [
       [ 'label' => 'Ogloszenia',  'href' => '/ogloszenia' ],
       [ 'label' => 'Przetargi',   'href' => '/przetargi' ],
       [ 'label' => 'Aktualnosci', 'href' => '/aktualnosci' ],
     ];
     render_links_table($pageLinks);
   ?>
 </section>

 <?php require __DIR__ . '/layout/footer.php'; ?>
