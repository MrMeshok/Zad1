<?
require 'config.php';

function EnMonthsToRu($date){
    $ruMonths = array( 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь' );
    $enMonths = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
    return str_replace($enMonths, $ruMonths, $date);
}

if ($_POST['id']) {
    $full_sum = $DB->query("SELECT sum(sum) as full_sum FROM `Checks`")->fetch();
    $shops = $DB->query("SELECT id, name FROM `Shops` ORDER BY id")->fetchAll();

    if ($_POST['id'] == 'table1_button') {
        $table1 = $DB->query("
            SELECT DATE_FORMAT(done_at,'%M %Y') AS Date,
            MONTH(done_at) AS month,
            year(done_at) AS year,
            sum( if( shop_id = 1, sum, 0 ) ) AS Москва,  
            sum( if( shop_id = 2, sum, 0 ) ) AS Самара, 
            sum( if( shop_id = 3, sum, 0 ) ) AS Якутск
            FROM `Checks`
            GROUP BY Date
            ORDER BY YEAR(done_at)")->fetchAll();
        echo json_encode(array($table1, $shops, $full_sum['full_sum']), JSON_FORCE_OBJECT);
    }
    if ($_POST['id'] == 'table2_button') {
        $month = $_POST['month'];
        $year = $_POST['year'];
        $table2 = $DB->query("
            SELECT DATE_FORMAT(done_at,'%d.%m.%Y (%a)') AS Date,
            MONTH(done_at) AS month,
            year(done_at) AS year,
            day(done_at) AS day,
            concat(sum(if( shop_id = 1, sum, 0 )), ' (', count(if(MONTH(done_at) = $month, id, 0)), ')') AS Москва,  
            concat(sum(if( shop_id = 2, sum, 0 )), ' (', count(if(MONTH(done_at) = $month, id, 0)), ')') AS Самара,  
            concat(sum(if( shop_id = 3, sum, 0 )), ' (', count(if(MONTH(done_at) = $month, id, 0)), ')') AS Якутск  
            FROM `Checks`
            WHERE YEAR(done_at) = $year AND MONTH(done_at) = $month
            GROUP BY Date(done_at)")->fetchAll();
        echo json_encode(array($table2, $shops), JSON_FORCE_OBJECT);
        }
    if ($_POST['id'] == 'table3_button') {
        $day = $_POST['day'];
        $month = $_POST['month'];
        $year = $_POST['year'];
        $table3_array = [];

        foreach ($shops as $value) {
            $id = $value['id'];
            ${"table$id"} = $DB->query("
                SELECT id, 
                DATE_FORMAT(done_at,'%d.%m.%Y %H:%i') AS Date, 
                sum 
                FROM `Checks` 
                WHERE shop_id = $id AND DAY(done_at) = $day
                AND MONTH(done_at) = $month AND YEAR(done_at) = $year")->fetchAll();
            $table3_array[$value['name']] = ${"table$id"};
        }

        echo json_encode($table3_array, JSON_FORCE_OBJECT);
    }
}

?>