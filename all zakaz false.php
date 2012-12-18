<?php
$Orders_Arr = $_GET['Orders_Arr'];
$sub_Arr = $_GET['sub_Arr'];
$dateStartDay_Arr = $_GET['dateStartDay_Arr'];
$dateStartMonth_Arr = $_GET['dateStartMonth_Arr']; 
$dateStartYear_Arr = $_GET['dateStartYear_Arr'];
$dateEndMonth_Arr = $_GET['dateEndMonth_Arr']; 
$dateEndYear_Arr = $_GET['dateEndYear_Arr'];
$todayDate_Arr = date('d.m.Y');
foreach($arrs = array(&$Orders_Arr, &$dateStartDay_Arr, &$dateStartMonth_Arr, &$dateStartYear_Arr, &$dateEndMonth_Arr, &$dateEndYear_Arr) as $k => $v) {
if (($dateStartDay_Arr[$k])&&($dateStartMonth_Arr[$k])&&($dateStartYear_Arr[$k])&&($dateEndMonth_Arr[$k])&&($dateEndYear_Arr[$k])&&($Orders_Arr[$k])){
$select_fast_by = mysql_query("SELECT User_ID, Article, Price, Parrent FROM Message163 WHERE Message_ID = ".$Orders_Arr[$k]."");
while ($row = mysql_fetch_array($select_fast_by)){

$dateStart_Arr = $dateStartDay_Arr[$k].'-'.$dateStartMonth_Arr[$k].'-'.$dateStartYear_Arr[$k];
$dateEnd_Arr = $dateEndMonth_Arr[$k].'-'.$dateEndYear_Arr[$k];
echo '<br>'.$dateStart_Arr;
echo '<br> Дата окончания показа: '.$dateEnd_Arr.'<br>';
if (($dateStartDay_Arr != '')&&($dateStartMonth_Arr != '')&&($dateStartYear_Arr != '')&&($dateEndMonth_Arr != '')&&($dateEndYear_Arr != ''))
{
$valueDayMonth = cal_days_in_month(CAL_GREGORIAN, $dateStartMonth, $dateStartYear); //Считаем кол-во дней заданного месяца

echo '<br> Дней в месяце '.$valueDayMonth;
$dayWithMonth_Arr = $valueDayMonth_Arr - $dateStartDay_Arr; //Высчитываем кол-во дней для оплаты первого месяца
echo '<br> Дней заданного месяца для оплаты: '.$dayWithMonth;
//Если день месяца первый - не считаем по дням, берем в расчет месяц
if ($dateStartDay_Arr == '01'){
$sumForFirstMonth = $row['Price'];
}
//иначе считаем по дням
else {
$sumForFirstMonth =  ( $row['Price'] / $valueDayMonth ) * $dayWithMonth; //Считаем сумму к оплате по дням за первый месяц
$sumForFirstMonth = round($sumForFirstMonth); //Округляем сумму
}

$firstDayForNextMonth_Arr = '01-'.date('m-Y', strtotime('+ 1 month', strtotime($dateStart_Arr))); // Находим первый день следующего месяца
echo '<br> Первый день следующего месяца для показа: '.$firstDayForNextMonth_Arr;
echo "<div style='background:#deebfd; width:300px'>Сумма к оплате за первый месяц ".$dateStart_Arr." составит  ".$sumForFirstMonth_Arr."</div>";
$theEndDayforShow_Arr =  cal_days_in_month(CAL_GREGORIAN, $dateEndMonth_Arr[$k], $dateEndYear_Arr[$k]); //Находим последний день даты окончания показа 
$theEndDateForShow_Arr = $theEndDayforShow_Arr.'-'.$dateEnd_Arr; //Дата окончания показа
echo '<br>последний день даты окончания показа: '.$theEndDateForShow_Arr;
$firstDateStart_Arr = new DateTime($theEndDateForShow_Arr); //Считаем месяцы для оплаты

$sumForDay_Arr = $row['Price'] / 30; //Берем среднее кол-во дней 30 и делим на сумму / мес, чтобы узнать стоимость щита за 1 день
$lastDateStart_Arr = new DateTime($firstDayForNextMonth_Arr);


$intervalDate_Arr = $firstDateStart_Arr->diff($lastDateStart_Arr);
echo '<br>Интервал: '.$intervalDate_Arr->format("%a");
$dateInterval = $intervalDate_Arr->format("%a");
	$valMonth = ($intervalDate_Arr->format('%a')/365)*12;
// Получаем сумму за все месяцы, кроме первого
$resultSumMonth = ceil($valMonth) * $row['Price'];
// Складываем суммы первого месяца и остальных, получая итоговую сумму
$resultSum_Arr = $sumForFirstMonth_Arr + $resultSumMonth;

echo "<br>Сумма счета за первый месяц: ".$sumForFirstMonth_Arr."<br>";
echo "<br>Сумма счета за остальные месяцы: ".$resultSum_Arr."<br>";
	}
	
elseif ((isset($_POST['oneMonth']))&&($_POST['oneMonth'] == 'oneMonth')){
$theEndDateForShow_Arr = date('d-m-Y', strtotime('+ 1 month', strtotime($dateStart_Arr)));
$resultSum_Arr = $row['Price'];
$dateInterval = 30;
}

echo '<br> Итоговая сумма за весь период съема щита: '.$resultSum_Arr;
//Конец - обработчик цен
$nc_core->db->connect( $dbuser='huid1040_natech', $dbpassword='sd2kJ823', $dbhost='mysql-1040.huid.hoster.ru');
$sql = 'INSERT INTO Message168(User_ID, Subdivision_ID, Sub_Class_ID, summ, dateStart, dateEnd, Object, Price, Parrent, daysVal) 
VALUES("'.$row["User_ID"].'", "166", "246", "'.$resultSum_Arr.'", "'.$dateStart_Arr.'", "'.$theEndDateForShow_Arr.'",  "'.$row["Article"].'",  "'.$row["Price"].'", "'.$row["Parrent"].'" , "'.$dateInterval.'")';
if(mysql_query($sql))
{echo '<script type="text/javascript">alert("Заказ успешно добавлен");</script>';}
}
}
}

?>