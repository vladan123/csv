<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Cene</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .editable {
            background-color: #f9f9f9;
        }
        .editable:hover {
            background-color: #e9e9e9;
        }
    </style>
</head>
<body>
    <table id="dataTable">
        <thead>
            <tr>
                <th width = "32%">Šifra</th>
                <th width = "32%">Cena</th>
                <th width = "32%">Naziv</th>
                <th width = "4%">Akcije</th>
            </tr>
        </thead>
        <tbody>
            <!-- Podaci će biti učitani ovde -->
        </tbody>
    </table>
    <br>
    <button class="btn btn-success" onclick="addRow()">Dodaj Red</button>
    <button class="btn btn-primary" onclick="saveData()">Snimi Podatke</button>
    <a href="down.php" target="_blank"><button class="btn btn-danger">Download</button></a>

    <script>
        // Funkcija za dodavanje novog reda
        function addRow() {
            var table = document.getElementById("dataTable").getElementsByTagName('tbody')[0];
            var newRow = table.insertRow();
            
            for (var i = 0; i < 3; i++) {
                var newCell = newRow.insertCell(i);
                newCell.contentEditable = "true";
                newCell.className = "editable";
                newCell.innerHTML = "";
            }

            var actionCell = newRow.insertCell(3);
            actionCell.innerHTML = '<button onclick="deleteRow(this)">Obriši</button>';
        }

        // Funkcija za brisanje reda
        function deleteRow(button) {
            var row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }

        // Funkcija za snimanje podataka
        function saveData() {
            var table = document.getElementById("dataTable");
            var data = [];

            for (var i = 1, row; row = table.rows[i]; i++) {
                var rowData = [];
                for (var j = 0, col; col = row.cells[j]; j++) {
                    if (j < 3) {
                        rowData.push(col.textContent.trim());
                    }
                }
                data.push(rowData);
            }

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "save_data.php", true);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xhr.send(JSON.stringify(data));

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert("Podaci su uspešno snimljeni!");
                }
            };
        }

        // Funkcija za učitavanje podataka
        function loadData() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "load_data.php", true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
                    var table = document.getElementById("dataTable").getElementsByTagName('tbody')[0];
                    table.innerHTML = "";

                    data.forEach(function(rowData) {
                        var newRow = table.insertRow();
                        for (var i = 0; i < 3; i++) {
                            var newCell = newRow.insertCell(i);
                            newCell.contentEditable = "true";
                            newCell.className = "editable";
                            newCell.textContent = rowData[i];
                        }
                        var actionCell = newRow.insertCell(3);
                        actionCell.innerHTML = '<button onclick="deleteRow(this)">Obriši</button>';
                    });
                }
            };
            xhr.send();
        }

        // Učitaj podatke kada se stranica učita
        window.onload = loadData;
    </script>
</body>
</html>
