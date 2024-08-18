<?php
// Učitaj podatke iz txt fajla
$dataFilePath = 'data.csv';

// Proveri da li fajl postoji
if (file_exists($dataFilePath)) {
    // Preusmeri korisnika da preuzme txt fajl
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="data.csv"');
    readfile($dataFilePath);
    exit;
} else {
    // Ako fajl ne postoji, prikaži poruku o grešci
    echo 'Fajl nije pronađen.';
}
?>
