<?
require 'config.php';

function EnMonthsToRu($date){
    $ruMonths = array( 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь' );
    $enMonths = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
    return str_replace($enMonths, $ruMonths, $date);
}

if ($_POST['id']) {
    $full_sum = $DB->query("SELECT sum(sum) as full_sum FROM `Checks`")->fetch();
    $shops = $DB->query("SELECT name FROM `Shops` ")->fetchAll();
    if ($_POST['id'] == 'table1') {
        $table1 = $DB->query("
            SELECT DATE_FORMAT(done_at,'%M %Y') AS Date,
            sum( if( shop_id = 1, sum, 0 ) ) AS Москва,  
            sum( if( shop_id = 2, sum, 0 ) ) AS Самара, 
            sum( if( shop_id = 3, sum, 0 ) ) AS Якутск
            FROM `Checks`
            GROUP BY Date
            ORDER BY YEAR(done_at)")->fetchAll();
        echo json_encode(array($table1, $shops, $full_sum['full_sum']), JSON_FORCE_OBJECT);
    }
    if ($_POST['id'] == 'table2') {
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
        }
    if ($_POST['id'] == 'table3') {
        $table3 = $DB->query("
            SELECT id, 
            DATE_FORMAT(done_at,'%d.%m.%Y %H:%i') AS Date, 
            sum 
            FROM `Checks` 
            WHERE shop_id = 1 AND DAY(done_at) = 1 
            AND MONTH(done_at) = 12 AND YEAR(done_at) = $YEAR")->fetchAll();
    }
}

?>