<?php
$file = fopen('data.csv', 'r');
$data = [];

while (($row = fgetcsv($file)) !== false) {
    $data[] = $row;
}

fclose($file);
echo json_encode($data);
?>
