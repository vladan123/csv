<?php
// Učitajte autoloader generisan od strane Composera
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

// Funkcija za eksportovanje u XLS
function exportToXls($data, $filePath)
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $rowNumber = 1;
    foreach ($data as $rowData) {
        $colLetter = 'A';
        foreach ($rowData as $cellData) {
            $sheet->setCellValue($colLetter . $rowNumber, $cellData);
            $colLetter++;
        }
        $rowNumber++;
    }

    $writer = new Xls($spreadsheet);
    $writer->save($filePath);
}

// Učitaj podatke iz txt fajla
$dataFilePath = 'data.csv';
$data = [];

if (($file = fopen($dataFilePath, 'r')) !== false) {
    while (($row = fgetcsv($file)) !== false) {
        $data[] = $row;
    }
    fclose($file);
}

// Eksportuj u XLS
$xlsFilePath = 'data.xls';
exportToXls($data, $xlsFilePath);

echo "Podaci su uspešno izvezeni u $xlsFilePath!";
?>
