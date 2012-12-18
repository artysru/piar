<?php
//dump($_POST);
//Принимаем данные поста
if (((isset($_POST['Orders_Arr']))&&(isset($_POST['sub_Arr']))&&(($_POST['Orders_Arr']!='')&&($_POST['dateStartDay_Arr']!='')&&($_POST['dateStartMonth_Arr']!='')&&($_POST['dateStartYear_Arr']!='')&&($_POST['dateEndMonth_Arr']!='')&&($_POST['dateEndYear_Arr']!='')))){
$countsCh = $_POST['counts'];
$Orders_Arr = $_POST['Orders_Arr'];
$sub_Arr = $_POST['sub_Arr'];
$dateStartDay_Arr = $_POST['dateStartDay_Arr'];
$dateStartMonth_Arr = $_POST['dateStartMonth_Arr']; 
$dateStartYear_Arr = $_POST['dateStartYear_Arr'];
$dateEndMonth_Arr = $_POST['dateEndMonth_Arr']; 
$dateEndYear_Arr = $_POST['dateEndYear_Arr'];
$todayDate_Arr = date('d.m.Y');
//Заводим счетчик на ноль
//$countsCh это счетчик формы, который передает ключ массива, по которому совершаются интерации
$a = 0;
foreach ($countsCh as $a=>$k){
//все действия которые мы выполняем в цикле

$select_fast_by = mysql_query("SELECT User_ID, Article, Price, Parrent FROM Message163 WHERE Message_ID = ".$Orders_Arr[$k]."");
while ($row = mysql_fetch_array($select_fast_by)){

$dateStart_Arr = $dateStartDay_Arr[$k].'-'.$dateStartMonth_Arr[$k].'-'.$dateStartYear_Arr[$k];
$dateEnd_Arr = $dateEndMonth_Arr[$k].'-'.$dateEndYear_Arr[$k];
echo '<br>'.$dateStart_Arr;
echo '<br> Дата окончания показа: '.$dateEnd_Arr.'<br>';

$valueDayMonth_Arr = cal_days_in_month(CAL_GREGORIAN, $dateStartMonth_Arr[$k], $dateStartYear_Arr[$k]); //Считаем кол-во дней заданного месяца
echo '<br> Дней в месяце '.$valueDayMonth_Arr;
$dayWithMonth_Arr = $valueDayMonth_Arr - $dateStartDay_Arr[$k]; //Высчитываем кол-во дней для оплаты первого месяца
echo '<br> Дней заданного месяца для оплаты: '.$dayWithMonth_Arr;
$sumForFirstMonth_Arr =  ( $row['Price'] / $valueDayMonth_Arr ) * $dayWithMonth_Arr; //Считаем сумму к оплате по дням за первый месяц
$sumForFirstMonth_Arr = round($sumForFirstMonth_Arr); //Округляем сумму
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
$resultSum_Arr =  ($sumForDay_Arr * $intervalDate_Arr->format('%a')) + $sumForFirstMonth_Arr;  //Вычисляем сумму за весь период и прибавляем к сумме оплату за 1ый месяц
$resultSum_Arr = round($resultSum_Arr);
echo '<br> Итоговая сумма за весь период съема щита: '.$resultSum_Arr;
//Конец - обработчик цен
$nc_core->db->connect( $dbuser='huid1040_natech', $dbpassword='sd2kJ823', $dbhost='mysql-1040.huid.hoster.ru');
$sql = 'INSERT INTO Message168(User_ID, Subdivision_ID, Sub_Class_ID, summ, dateStart, dateEnd, Object, Price, Parrent, daysVal) 
VALUES("'.$row["User_ID"].'", "166", "246", "'.$resultSum_Arr.'", "'.$dateStart_Arr.'", "'.$theEndDateForShow_Arr.'",  "'.$row["Article"].'",  "'.$row["Price"].'", "'.$row["Parrent"].'" , "'.$intervalDate_Arr->format("%a").'")';
if(mysql_query($sql))
{echo '<script type="text/javascript">alert("Заказ успешно добавлен");</script>';}
//echo $dateStartDay_Arr[$k].', '.$dateStartMonth_Arr[$k].', '.$dateStartYear_Arr[$k].', '.$dateEndMonth_Arr[$k].', '.$dateEndYear_Arr[$k].', '.$Orders_Arr[$k];
}
}
}

?>