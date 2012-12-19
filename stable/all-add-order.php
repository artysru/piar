%Header
";
//dump($_POST);
//Принимаем данные поста
if ((isset($_POST['Orders_Arr']))&&(isset($_POST['sub_Arr']))){
$countsCh = $_POST['counts'];
$Orders_Arr = $_POST['Orders_Arr'];
$sub_Arr = $_POST['sub_Arr'];
$dateStartDay_Arr = $_POST['dateStartDay_Arr'];
$dateStartMonth_Arr = $_POST['dateStartMonth_Arr']; 
$dateStartYear_Arr = $_POST['dateStartYear_Arr'];
$dateEndMonth_Arr = $_POST['dateEndMonth_Arr']; 
$dateEndYear_Arr = $_POST['dateEndYear_Arr'];
$forOneMonth = $_POST['oneMonth_Arr'];
$todayDate_Arr = date('d.m.Y');
//Заводим счетчик на ноль
//$countsCh это счетчик формы, который передает ключ массива, по которому совершаются итерации
$a = 0;
foreach ($countsCh as $a=>$k){
//все действия которые мы выполняем в цикле

$select_fast_by = mysql_query("SELECT User_ID, Article, Price, Parrent FROM Message163 WHERE Message_ID = ".$Orders_Arr[$k]."");
while ($row = mysql_fetch_array($select_fast_by)){

$dateStart_Arr = $dateStartDay_Arr[$k].'-'.$dateStartMonth_Arr[$k].'-'.$dateStartYear_Arr[$k];
$dateEnd_Arr = $dateEndMonth_Arr[$k].'-'.$dateEndYear_Arr[$k];
$Price = $row['Price'];
echo '<br>'.$dateStart_Arr;
echo '<br> Дата окончания показа: '.$dateEnd_Arr.'<br>';
if (($dateStartDay_Arr[$k] != '')&&($dateStartMonth_Arr[$k] != '')&&($dateStartYear_Arr[$k] != '')&&($dateEndMonth_Arr[$k] != '')&&($dateEndYear_Arr[$k] != '')){
$valueDayMonth_Arr = cal_days_in_month(CAL_GREGORIAN, $dateStartMonth_Arr[$k], $dateStartYear_Arr[$k]); //Считаем кол-во дней заданного месяца
echo '<br> Дней в месяце '.$valueDayMonth_Arr;
$dayWithMonth_Arr = $valueDayMonth_Arr - $dateStartDay_Arr[$k]; //Высчитываем кол-во дней для оплаты первого месяца

//Если день месяца первый - не считаем по дням, берем в расчет месяц
if ($dateStartDay_Arr[$k] == '01'){
$sumForFirstMonth_Arr = $Price;
}
//иначе считаем по дням
else {
$sumForFirstMonth_Arr =  ( $Price / $valueDayMonth_Arr ) * $dayWithMonth_Arr; //Считаем сумму к оплате по дням за первый месяц
$sumForFirstMonth_Arr = round($sumForFirstMonth_Arr); //Округляем сумму
}

$sumForFirstMonth_Arr =  ( $Price / $valueDayMonth_Arr ) * $dayWithMonth_Arr; //Считаем сумму к оплате по дням за первый месяц
$sumForFirstMonth_Arr = round($sumForFirstMonth_Arr); //Округляем сумму
$firstDayForNextMonth_Arr = '01-'.date('m-Y', strtotime('+ 1 month', strtotime($dateStart_Arr))); // Находим первый день следующего месяца
echo '<br> Первый день следующего месяца для показа: '.$firstDayForNextMonth_Arr;
echo "<div style='background:#deebfd; width:300px'>Сумма к оплате за первый месяц ".$dateStart_Arr." составит  ".$sumForFirstMonth_Arr."</div>";
$theEndDayforShow_Arr =  cal_days_in_month(CAL_GREGORIAN, $dateEndMonth_Arr[$k], $dateEndYear_Arr[$k]); //Находим последний день даты окончания показа 
$theEndDateForShow_Arr = $theEndDayforShow_Arr.'-'.$dateEnd_Arr; //Дата окончания показа
echo '<br>последний день даты окончания показа: '.$theEndDateForShow_Arr;
$firstDateStart_Arr = new DateTime($theEndDateForShow_Arr); //Считаем месяцы для оплаты

$sumForDay_Arr = $Price / 30; //Берем среднее кол-во дней 30 и делим на сумму / мес, чтобы узнать стоимость щита за 1 день
$lastDateStart_Arr = new DateTime($firstDayForNextMonth_Arr);

$intervalDate_Arr = $firstDateStart_Arr->diff($lastDateStart_Arr);
$dateInterval_Arr = $intervalDate_Arr->format("%a");

// считаем месяцы по дням
$valMonth_Arr = ($intervalDate_Arr->format('%a')/365)*12;
// Получаем сумму за все месяцы, кроме первого
$resultSumMonth_Arr = ceil($valMonth_Arr) * $Price;
// Складываем суммы первого месяца и остальных, получая итоговую сумму
$resultSum_Arr = $sumForFirstMonth_Arr + $resultSumMonth_Arr;

echo "<br>Сумма счета за первый месяц: ".$sumForFirstMonth_Arr."<br>";
echo "<br>Сумма счета за все месяцы: ".$resultSum_Arr."<br>";
}

elseif  ((isset($_POST['oneMonth_Arr']))&&($forOneMonth[$k] == 'oneMonth_Arr')){
$theEndDateForShow_Arr = date('d-m-Y', strtotime('+ 1 month', strtotime($dateStart_Arr)));
$resultSum_Arr = $Price;
$dateInterval_Arr = 30;
}

if ((ceil($valMonth_Arr)) >= 5){
$discont_1 = 0.05;
$resultSum_Arr = $resultSum_Arr -($resultSum_Arr*$discont_1);
$resultSum_Arr = round($resultSum_Arr);
$discontFrs = $resultSum_Arr*$discont_1;
echo 'экономия за счет мес.: '.round($resultSum_Arr*$discont_1);
}


elseif ((ceil($valMonth_Arr)) >= 10){
$discont_1 = 0.10;
$resultSum_Arr = $resultSum_Arr -($resultSum_Arr*$discont_1);
$resultSum_Arr = round($resultSum_Arr);
$discontFrs = $resultSum_Arr*$discont_1;
echo 'экономия: '.round($resultSum_Arr*$discont_1);
}

elseif ((ceil($valMonth_Arr)) >= 15){
$discont_1 = 0.15;
$resultSum_Arr = $resultSum_Arr -($resultSum_Arr*$discont_1);
$resultSum_Arr = round($resultSum_Arr);
$discontFrs = $resultSum_Arr*$discont_1;
echo 'экономия: '.round($resultSum_Arr*$discont_1);
}

echo '<br> Итоговая сумма за весь период съема щита: '.$resultSum_Arr;
//$resultSum_Arr =  ($sumForDay_Arr * $intervalDate_Arr->format('%a')) + $sumForFirstMonth_Arr;  //Вычисляем сумму за весь период и прибавляем к сумме оплату за 1ый месяц
//$resultSum_Arr = round($resultSum_Arr);
//echo '<br> Итоговая сумма за весь период съема щита: '.$resultSum_Arr;
//Конец - обработчик цен
$nc_core->db->connect( $dbuser='huid1040_natech', $dbpassword='sd2kJ823', $dbhost='mysql-1040.huid.hoster.ru');
$sql = 'INSERT INTO Message168(User_ID, Subdivision_ID, Sub_Class_ID, summ, dateStart, dateEnd, discont_1, Object, Price, Parrent, daysVal, firstDayMonthForPaid, sumForFirstMonth, lastDatForPaid) 
VALUES("'.$row["User_ID"].'", "166", "246", "'.$resultSum_Arr.'", "'.$dateStart_Arr.'", "'.$theEndDateForShow_Arr.'", "'.$discont_1.'",  "'.$row["Article"].'",  "'.$Price.'", "'.$row["Parrent"].'", "'.$dateInterval_Arr.'"
, "'.$firstDayForNextMonth_Arr.'", "'.$sumForFirstMonth_Arr.'", "'.$theEndDateForShow_Arr.'")';
if(mysql_query($sql))
{echo '<script type="text/javascript">alert("Заказ успешно добавлен");</script>';}
//echo $dateStartDay_Arr[$k].', '.$dateStartMonth_Arr[$k].', '.$dateStartYear_Arr[$k].', '.$dateEndMonth_Arr[$k].', '.$dateEndYear_Arr[$k].', '.$Orders_Arr[$k];
}
}
}
echo "