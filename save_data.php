<?php
$data = json_decode(file_get_contents('php://input'), true);
if ($data) {
    $file = fopen('data.csv', 'w');
    foreach ($data as $row) {
        fputcsv($file, $row);
    }
    fclose($file);
    echo "Podaci su uspešno snimljeni!";
} else {
    echo "Greška pri snimanju podataka.";
}
?>
