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
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <button id="table1">Вывести данные</button>
    <?php 

    function EnMonthsToRu($date){
        $ruMonths = array( 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь' );
        $enMonths = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
        return str_replace($enMonths, $ruMonths, $date);
    }

    $table1 = $DB->query("
        SELECT DATE_FORMAT(done_at,'%M %Y') AS Date,
        sum( if( shop_id = 1, sum, 0 ) ) AS Москва,  
        sum( if( shop_id = 2, sum, 0 ) ) AS Самара, 
        sum( if( shop_id = 3, sum, 0 ) ) AS Якутск
        FROM `Checks`
        GROUP BY Date
        ORDER BY YEAR(done_at)")->fetchAll();
    $month = 11;
    $year = 2019;
    $table2 = $DB->query("
        SELECT DATE_FORMAT(done_at,'%d.%m.%Y') AS Date,
        concat(sum(if( shop_id = 1, sum, 0 )), ' (', count(if(MONTH(done_at) = $month, id, 0)), ')') AS Москва,  
        concat(sum(if( shop_id = 2, sum, 0 )), ' (', count(if(MONTH(done_at) = $month, id, 0)), ')') AS Самара,  
        concat(sum(if( shop_id = 3, sum, 0 )), ' (', count(if(MONTH(done_at) = $month, id, 0)), ')') AS Якутск  
        FROM `Checks`
        WHERE YEAR(done_at) = $YEAR AND MONTH(done_at) = $month
        GROUP BY Date(done_at)")->fetchAll();
    $table3 = $DB->query("
        SELECT id, 
        DATE_FORMAT(done_at,'%d.%m.%Y %H:%i') AS Date, 
        sum 
        FROM `Checks` 
        WHERE shop_id = 1 AND DAY(done_at) = 1 
        AND MONTH(done_at) = 12 AND YEAR(done_at) = $YEAR")->fetchAll();
    ?>
    <table border=1>
        <tr>
            <th></th>
            <?
            $shops = $DB->query("SELECT name FROM `Shops` ")->fetchAll();
            foreach ($shops as $value) {
                echo "<th>".$value['name']."</th>";
            }?>
        </tr>
        <?foreach ($table1 as $key => $value) {
            echo "<tr>";
            echo "<td>".EnMonthsToRu($value['Date'])."</td>";
            echo "<td>".$value['Москва']."</td>";
            echo "<td>".$value['Самара']."</td>";
            echo "<td>".$value['Якутск']."</td>";
            echo "</tr>";
        }?>
    </table>
            <?$full_sum = $DB->query("SELECT sum(sum) as full_sum FROM `Checks`")->fetch();
            echo "Общая сумма:".$full_sum['full_sum'];?>

    <table border=1>
        <tr>
            <th></th>
            <?
            foreach ($shops as $value) {
                echo "<th>".$value['name']."</th>";
            }?>
        </tr>
        <?foreach ($table2 as $key => $value) {
            echo "<tr>";
            echo "<td>".$value['Date']."</td>";
            echo "<td>".$value['Москва']."</td>";
            echo "<td>".$value['Самара']."</td>";
            echo "<td>".$value['Якутск']."</td>";
            echo "</tr>";
        }?>
    </table>

    <table border=1>
        <tr>
            <th>Номер чека</th>
            <th>Дата и время (GMT+4)</th>
            <th>Сумма чека</th>
        </tr>
        <?foreach ($table3 as $key => $value) {
            echo "<tr>";
            echo "<td>".$value['id']."</td>";
            echo "<td>".$value['Date']."</td>";
            echo "<td>".$value['sum']."</td>";
            echo "</tr>";
        }?>
    </table>
</body>
</html>
