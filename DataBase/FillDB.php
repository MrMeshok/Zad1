<?php 
require 'config.php';

// $DB->query("INSERT INTO `Shops` (`name`, `address`, `timezone`) VALUES ('Москва', 'г. Москва, ул. Ленина, 65', 'GMT+3')");
// $DB->query("INSERT INTO `Shops` (`name`, `address`, `timezone`) VALUES ('Самара', 'г. Самара, ул. Ленина, 34', 'GMT+4')");
// $DB->query("INSERT INTO `Shops` (`name`, `address`, `timezone`) VALUES ('Якутск', 'г. Якутск, ул. Ленина, 125', 'GMT+9')");


// // $datetime = new DateTime('2019-11-01');
// $datetime->modify('+1 day');
// $datetime->modify('+1 sec');
// echo $datetime->format('Y-m-d H:i:s');



$datetime = new DateTime('01.11.2019 08:00:00');
$add_check = $DB->prepare("INSERT INTO `Checks` (`shop_id`, `done_at`, `sum`) VALUES (?, ?, ?)");
for ($i=0; $i < 92; $i++) {
    add_checks(1);
    add_checks(2);
    add_checks(3);
    $datetime->modify('+1 day');
}
function add_checks($shop_id)
{
    global $datetime;
    global $add_check;
    $checks_count = rand(50, 100);
    for ($i=0; $i < $checks_count; $i++) { 
        // echo $datetime->format('Y-m-d H:i:s').'<br>';
        // if ($datetime->format('H') >= 23) {
        //     echo "Перебор<br>";
        // }
        $sum = rand(90, 400);
        $add_check->execute(array($shop_id, $datetime->format('Y-m-d H:i:s'), $sum));
        $add_seconds = '+'.rand(290, 540).' sec';
        $datetime->modify($add_seconds);
    }
    $datetime->setTime("08", "00", "00");
}

 ?>