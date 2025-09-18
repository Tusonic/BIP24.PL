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

<!-- POBIERANIE PLIKU - START -->

<section class="mb-4" aria-labelledby="sec-files-heading">
  <h2 id="sec-files-heading" class="h5 mb-3">Pliki do pobrania (wzorzec)</h2>
  <?php
    $attachments = [
      [ 'label' => 'Plik DOC lokalnie na serwerze - auto rozmiar oraz rozszerzenie', 'href' => asset('/download/wzory/plik.doc'), 'date' => '2025-10-04' ],
      [ 'label' => 'Odnośnik do pliku na zewnątrz', 'href' => 'https://tusonic.pl', 'size' => '13 MB', 'date' => '2024-05-10' ],
      [ 'label' => 'Plik pdf manual rozmiar oraz rozszerzenie', 'href' => asset('/download/wzory/plik.pdf'), 'ext' => 'pdf', 'size' => '1.2 MB', 'date' => '2024-05-10' ],
      [ 'label' => 'Plik doc manual rozmiar oraz rozszerzenie', 'href' => asset('/download/wzory/plik.doc'), 'ext' => 'doc', 'size' => '1.2 MB', 'date' => '2024-05-10' ],
      [ 'label' => 'Plik xls manual rozmiar oraz rozszerzenie', 'href' => asset('/download/wzory/plik.xls'), 'ext' => 'xls', 'size' => '1.2 MB', 'date' => '2024-05-10' ],
      [ 'label' => 'Plik pdf manual rozmiar oraz rozszerzenie', 'href' => asset('/download/wzory/plik.pdf'), 'ext' => 'pdf', 'size' => '1.2 MB', 'date' => '2024-05-10' ],
      [ 'label' => 'Plik docx manual rozmiar oraz rozszerzenie', 'href' => asset('/download/wzory/plik.docx'), 'ext' => 'docx', 'size' => '1.2 MB', 'date' => '2024-05-10' ],
      [ 'label' => 'Plik xlsx manual rozmiar oraz rozszerzenie', 'href' => asset('/download/wzory/plik.xlsx'), 'ext' => 'xlsx', 'size' => '1.2 MB', 'date' => '2024-05-10' ],
      [ 'label' => 'Plik pdf automatyczny rozmiar oraz rozszerzenie', 'href' => asset('/download/wzory/plik.pdf'), 'date' => '2024-05-10' ],
      [ 'label' => 'Plik docx automatyczny rozmiar oraz rozszerzenie', 'href' => asset('/download/wzory/plik.docx'), 'date' => '2024-05-10' ],
      [ 'label' => 'Plik xlsx automatyczny rozmiar oraz rozszerzenie', 'href' => asset('/download/wzory/plik.xls'), 'date' => '2024-05-10' ],
    ];
    render_attachments_table($attachments);
  ?>
</section>

<!-- POBIERANIE PLIKU - KONIEC -->

<!-- LINKI Z DATA - START -->
<section class="mb-4" aria-labelledby="sec-links2-heading">
  <h2 id="sec-links2-heading" class="h5 mb-3">Odniesienia do podstron z data (wzorzec)</h2>
  <?php
    // Example data for subpages links with publication date
    $pageLinks2 = [
      [ 'label' => 'Prawo - Ustawy - przykładowy opis',  'href' => '/ustawy/prawo',  'date' => '2025-10-04' ],
      [ 'label' => 'Prawo - Rozporządzenia -  przykładowy opis',   'href' => '/prawo/rozporzadzenia',   'date' => '2025-10-04' ],
      [ 'label' => 'Kontakt', 'href' => '/kontakt', 'date' => '2025-10-04' ],
    ];
    render_links_table_with_date($pageLinks2);
  ?>
</section>

<!-- LINKI Z DATA - KONIEC -->

<!-- LINKI BEZ DATY - START -->
 
 <section class="mb-4" aria-labelledby="sec-links-heading">
   <h2 id="sec-links-heading" class="h5 mb-3">Odniesienia do podstron (wzorzec)</h2>
   <?php
     // Example data for subpages links
     $pageLinks = [
       [ 'label' => 'Władze',  'href' => '/organizacja/wladze' ],
       [ 'label' => 'Struktura',   'href' => '/organizacja/struktura' ],
     ];
     render_links_table($pageLinks);
   ?>
 </section>

 <!-- LINKI BEZ DATY - KONIEC -->

 <?php require __DIR__ . '/layout/footer.php'; ?>
