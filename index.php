<?php require 'DataBase/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="script.js"></script>
    <style>
        td, th {
            padding: 5px;
        }
        table {
            margin-bottom: 30px;
        }
        .table3_button, .table2_button {
            color: -webkit-link;
            cursor: pointer;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <button id="table1_button">Вывести данные</button>
    <div id="table1"></div>
    <div id="table2"></div>
    <div id="table3"></div>
</body>
</html>
