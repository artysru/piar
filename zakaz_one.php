<?php

$User_ID = $_POST['User_ID']; //id Пользователя
$Subdivision_ID = '166'; // Компонент заказов
$Sub_Class_ID = '246'; //Раздел Заказов
$Parrent = $_POST['Parrent']; //Родитель заказа
$Object = $_POST['Object']; //Объект заказа
$Price = $_POST['Price'];


//Перебираем массивы, пришедшие из быстрых покупок


//Обработка дат бронирования
$dateStartDay = $_POST['dateStartDay']; $dateStartMonth = $_POST['dateStartMonth']; $dateStartYear = $_POST['dateStartYear'];
$dateEndMonth = $_POST['dateEndMonth']; $dateEndYear = $_POST['dateEndYear'];
$dateEnd = $dateEndMonth.'-'.$dateEndYear;
$todayDate = date('d.m.Y');
$dateStart = $dateStartDay.'-'.$dateStartMonth.'-'.$dateStartYear;
echo '<br>Сегодня: '.$todayDate;
echo '<br>'.$dateStart;
echo '<br> Дата окончания показа: '.$dateEnd.'<br>';
$valueDayMonth = cal_days_in_month(CAL_GREGORIAN, $dateStartMonth, $dateStartYear); //Считаем кол-во дней заданного месяца

echo '<br> Дней в месяце '.$valueDayMonth;
$dayWithMonth = $valueDayMonth - $dateStartDay; //Высчитываем кол-во дней для оплаты первого месяца
echo '<br> Дней заданного месяца для оплаты: '.$dayWithMonth;
//Если день месяца первый - не считаем по дням, берем в расчет месяц
if ($dateStartDay == '01'){
$sumForFirstMonth = $Price;
}
//иначе считаем по дням
else {
$sumForFirstMonth =  ( $Price / $valueDayMonth ) * $dayWithMonth; //Считаем сумму к оплате по дням за первый месяц
$sumForFirstMonth = round($sumForFirstMonth); //Округляем сумму
}
$firstDayForNextMonth = '01-'.date('m-Y', strtotime('+ 1 month', strtotime($dateStart))); // Находим первый день следующего месяца
echo '<br> Первый день следующего месяца для показа: '.$firstDayForNextMonth;
echo "<div style='background:#deebfd; width:300px'>Сумма к оплате за первый месяц ".$dateStart." составит  ".$sumForFirstMonth."</div>";


$theEndDayforShow =  cal_days_in_month(CAL_GREGORIAN, $dateEndMonth, $dateEndYear);//Находим последний день даты окончания показа 

$theEndDayforShow =  cal_days_in_month(CAL_GREGORIAN, $dateEndMonth, $dateEndYear);//Находим последний день даты окончания показа
$theEndDateForShow = $theEndDayforShow.'-'.$dateEnd; //Дата окончания показа
echo '<br>последний день даты окончания показа: '.$theEndDateForShow;
$firstDateStart = new DateTime($theEndDateForShow); //Считаем месяцы для оплаты

$sumForDay = $Price / 30; //Берем среднее кол-во дней 30 и делим на сумму / мес, чтобы узнать стоимость щита за 1 день

$lastDateStart = new DateTime($firstDayForNextMonth);
$intervalDate = $firstDateStart->diff($lastDateStart);
echo '<br>Интервал: '.$intervalDate->format('%a');

//$resultSum =  ($sumForDay * $intervalDate->format('%a')) + $sumForFirstMonth;  //Вычисляем сумму за весь период и прибавляем к сумме оплату за 1ый месяц
//$resultSum = round($resultSum);
//$resultSum = $sumForFirstMonth + ($Price * ceil($valMonth));
// считаем месяцы по дням
$valMonth = ($intervalDate->format('%a')/365)*12;
// Получаем сумму за все месяцы, кроме первого
$resultSumMonth = ceil($valMonth) * $Price;
// Складываем суммы первого месяца и остальных, получая итоговую сумму
$resultSum = $sumForFirstMonth + $resultSumMonth;
echo $dayWithMonth;
echo "<br>Сумма счета за первый месяц: ".$sumForFirstMonth."<br>";
echo "<br>Сумма счета за остальные месяцы: ".$resultSum."<br>";




echo '<br> Итоговая сумма за весь период съема щита: '.$resultSum;

//Расчет скидок


//Вывод результатов поста и инсерт в базу
echo '<br>'.$User_ID.' | '.$Subdivision_ID.' | '.$Sub_Class_ID.' | '.$Parrent.' | '.$Object.' | '.$Price;
$nc_core->db->connect( $dbuser='huid1040_natech', $dbpassword='sd2kJ823', $dbhost='mysql-1040.huid.hoster.ru');
$sql = 'INSERT INTO Message168(User_ID, Subdivision_ID, Sub_Class_ID, summ, dateStart, dateEnd, Object, Price, Parrent, daysVal) 
VALUES("'.$User_ID.'", "166", "246", "'.$resultSum.'", "'.$dateStart.'", "'.$theEndDateForShow.'",  "'.$Object.'",  "'.$Price.'", "'.$Parrent.'" , "'.$intervalDate->format("%a").'")';
if(mysql_query($sql))
{echo '<script type="text/javascript">alert("Заказ успешно добавлен");</script>';}
//header("Location: http://piar.geocomm.ru/shop/zakaz/");
?>

if ((isset($_POST['oneMonth']))&&($_POST['oneMonth'] == 'oneMonth')){
$theEndDayforShow =  cal_days_in_month(CAL_GREGORIAN, $dateEndMonth, $dateEndYear);//Находим последний день даты окончания показа
$theEndDateForShow = date('d-m-Y', strtotime('+ 1 month', strtotime($dateStart)));
$resultSum = $Price;
}