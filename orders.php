<?php
//Перебираем массивы, пришедшие из быстрых покупок
$User_ID_Arr = $_POST['User_ID_Arr']; //id Пользователя
$Subdivision_ID_Arr = '166'; // Компонент заказов
$Sub_Class_ID_Arr = '246'; //Раздел Заказов
$Parrent_Arr = $_POST['Parrent_Arr']; //Родитель заказа
$Object_Arr = $_POST['Object_Arr']; //Объект заказа
$Price_Arr = $_POST['Price_Arr'];

foreach ($User_ID_Arr as $k_u=>$User_ID_Arr)
foreach ($Subdivision_ID_Arr as $k_s=>$Subdivision_ID_Arr)
foreach ($Sub_Class_ID_Arr as $k_sc=>$Sub_Class_ID_Arr)
foreach ($Parrent_Arr as $k_p=>$Parrent_Arr)
foreach ($Object_Arr as $k_o=>$Object_Arr)
foreach ($Price_Arr as $k_pr=>$Price_Arr)

echo $User_ID_Arr.$Parrent_Arr;
//Обработка дат бронирования
$dateStartDay_Arr = $_POST['dateStartDay_Arr']; $dateStartMonth_Arr = $_POST['dateStartMonth_Arr']; $dateStartYear_Arr = $_POST['dateStartYear_Arr'];
foreach ($dateStartDay_Arr as $k_dsd=>$dateStartDay_Arr)
foreach ($dateStartMonth_Arr as $k_dsm=>$dateStartMonth_Arr)
foreach ($dateStartYear_Arr as $k_dsy=>$dateStartYear_Arr)
$dateEndMonth_Arr = $_POST['dateEndMonth_Arr']; $dateEndYear_Arr = $_POST['dateEndYear_Arr'];
foreach ($dateEndMonth_Arr as $k_dem=>$dateEndMonth_Arr)
foreach ($dateEndYear_Arr as $k_dey=>$dateEndYear_Arr)
$dateEnd_Arr = $dateEndMonth_Arr.'-'.$dateEndYear_Arr;
$todayDate_Arr = date('d.m.Y');
$dateStart_Arr = $dateStartDay_Arr.'-'.$dateStartMonth_Arr.'-'.$dateStartYear_Arr;
echo '<br>Сегодня: '.$todayDate;
echo '<br>'.$dateStart_Arr;
echo '<br> Дата окончания показа: '.$dateEnd_Arr.'<br>';
$valueDayMonth_Arr = cal_days_in_month(CAL_GREGORIAN, $dateStartMonth_Arr, $dateStartYear_Arr); //Считаем кол-во дней заданного месяца
echo '<br> Дней в месяце '.$valueDayMonth_Arr;
$dayWithMonth_Arr = $valueDayMonth_Arr - $dateStartDay_Arr; //Высчитываем кол-во дней для оплаты первого месяца
echo '<br> Дней заданного месяца для оплаты: '.$dayWithMonth_Arr;
$sumForFirstMonth_Arr =  ( $Price_Arr / $valueDayMonth_Arr ) * $dayWithMonth_Arr; //Считаем сумму к оплате по дням за первый месяц
$sumForFirstMonth_Arr = round($sumForFirstMonth_Arr); //Округляем сумму
$firstDayForNextMonth_Arr = '01-'.date('m-Y', strtotime('+ 1 month', strtotime($dateStart_Arr))); // Находим первый день следующего месяца
echo '<br> Первый день следующего месяца для показа: '.$firstDayForNextMonth_Arr;
echo "<div style='background:#deebfd; width:300px'>Сумма к оплате за первый месяц ".$dateStart_Arr." составит  ".$sumForFirstMonth_Arr."</div>";
$theEndDayforShow_Arr =  cal_days_in_month(CAL_GREGORIAN, $dateEndMonth_Arr, $dateEndYear_Arr);//Находим последний день даты окончания показа 
$theEndDateForShow_Arr = $theEndDayforShow_Arr.'-'.$dateEnd_Arr; //Дата окончания показа
echo '<br>последний день даты окончания показа: '.$theEndDateForShow_Arr;
$firstDateStart_Arr = new DateTime($theEndDateForShow_Arr); //Считаем месяцы для оплаты
$sumForDay_Arr = $Price_Arr / 30; //Берем среднее кол-во дней 30 и делим на сумму / мес, чтобы узнать стоимость щита за 1 день
$lastDateStart_Arr = new DateTime($firstDayForNextMonth_Arr);
$intervalDate_Arr = $firstDateStart_Arr->diff($lastDateStart_Arr);
echo '<br>Интервал: '.$intervalDate->format('%a');
$resultSum_Arr =  ($sumForDay_Arr * $intervalDate_Arr->format('%a')) + $sumForFirstMonth_Arr;  //Вычисляем сумму за весь период и прибавляем к сумме оплату за 1ый месяц
$resultSum_Arr = round($resultSum_Arr);
echo '<br> Итоговая сумма за весь период съема щита: '.$resultSum_Arr;

//Расчет скидок


//Вывод результатов поста и инсерт в базу
echo '<br>'.$User_ID_Arr.' | '.$Subdivision_ID_Arr.' | '.$Sub_Class_ID_Arr.' | '.$Parrent_Arr.' | '.$Object_Arr.' | '.$Price_Arr;
$nc_core->db->connect( $dbuser='huid1040_natech', $dbpassword='sd2kJ823', $dbhost='mysql-1040.huid.hoster.ru');
$sql_Arr = 'INSERT INTO Message168(User_ID, Subdivision_ID, Sub_Class_ID, Object, Price, Parrent) 
VALUES("'.$User_ID_Arr.'", "'.$Subdivision_ID_Arr.'", "'.$Sub_Class_ID_Arr.'", "'.$Object_Arr.'",  "'.$resultSum_Arr.'", "'.$Parrent_Arr.'")';
if(mysql_query($sql_Arr))
{echo '<script type="text/javascript">alert("Заказ успешно добавлен");</script>';}
//header("Location: http://piar.geocomm.ru/shop/zakaz/");

?>

%Header
";
//Перебираем массивы, пришедшие из быстрых покупок

//Загоняем массивы из формы быстрой покупки
if ((isset($_GET['Orders_Arr']))&&(isset($_GET['sub_Arr']))){
$Orders_Arr = $_GET['Orders_Arr'];
$sub_Arr = $_GET['sub_Arr'];
$dateStartDay_Arr = $_GET['dateStartDay_Arr'];
$dateStartMonth_Arr = $_POST['dateStartMonth_Arr']; 
$dateStartYear_Arr = $_POST['dateStartYear_Arr'];
$dateEndMonth_Arr = $_POST['dateEndMonth_Arr']; 
$dateEndYear_Arr = $_POST['dateEndYear_Arr'];
foreach($arrs = array(&$Orders_Arr, &$dateStartDay_Arr, &$dateStartMonth_Arr, &$dateStartYear_Arr, &$dateEndMonth_Arr, &$dateEndYear_Arr) as $k => $v) {

$select_fast_by = mysql_query("SELECT User_ID, Article, Price, Parrent FROM Message163 WHERE Message_ID = ".Orders_Arr[$k]."");
while ($row = mysql_fetch_array($select_fast_by)){

//Обработчик цен
$dateEnd_Arr = $dateEndMonth_Arr[$k].'-'.$dateEndYear_Arr[$k];
$todayDate_Arr = date('d.m.Y');
$dateStart_Arr = $dateStartDay_Arr[$k].'-'.$dateStartMonth_Arr[$k].'-'.$dateStartYear_Arr[$k];
echo '<br>Сегодня: '.$todayDate;
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
$theEndDayforShow_Arr =  cal_days_in_month(CAL_GREGORIAN, $dateEndMonth_Arr[$k], $dateEndYear_Arr[$k]);//Находим последний день даты окончания показа 
$theEndDateForShow_Arr = $theEndDayforShow_Arr.'-'.$dateEnd_Arr; //Дата окончания показа
echo '<br>последний день даты окончания показа: '.$theEndDateForShow_Arr;
$firstDateStart_Arr = new DateTime($theEndDateForShow_Arr); //Считаем месяцы для оплаты
$sumForDay_Arr = $row['Price'] / 30; //Берем среднее кол-во дней 30 и делим на сумму / мес, чтобы узнать стоимость щита за 1 день
$lastDateStart_Arr = new DateTime($firstDayForNextMonth_Arr);
$intervalDate_Arr = $firstDateStart_Arr->diff($lastDateStart_Arr);
echo '<br>Интервал: '.$intervalDate->format('%a');
$resultSum_Arr =  ($sumForDay_Arr * $intervalDate_Arr->format('%a')) + $sumForFirstMonth_Arr;  //Вычисляем сумму за весь период и прибавляем к сумме оплату за 1ый месяц
$resultSum_Arr = round($resultSum_Arr);
echo '<br> Итоговая сумма за весь период съема щита: '.$resultSum_Arr;
//Конец - обработчик цен
}
}


$nc_core->db->connect( $dbuser='huid1040_natech', $dbpassword='sd2kJ823', $dbhost='mysql-1040.huid.hoster.ru');
//$sql = 'INSERT INTO Message168(User_ID, Subdivision_ID, Sub_Class_ID, Object, Price, Parrent) 
//VALUES("'.$row["User_ID"].'", "166", "246", "'.$row["Article"].'",  "'.$row["Price"].'", "'.$row["Parrent"].'")';

if(mysql_query($sql))
{echo '<script type="text/javascript">alert("Заказ успешно добавлен");</script>';}
}
echo "












///////////////////////

$valueDayMonth_Arr = cal_days_in_month(CAL_GREGORIAN, $dateStartMonth_Arr[$k], $dateStartYear_Arr[$k]); //Считаем кол-во дней заданного месяца
echo '<br> Дней в месяце '.$valueDayMonth_Arr;
$dayWithMonth_Arr = $valueDayMonth_Arr - $dateStartDay_Arr[$k]; //Высчитываем кол-во дней для оплаты первого месяца
echo '<br> Дней заданного месяца для оплаты: '.$dayWithMonth_Arr;
$sumForFirstMonth_Arr =  ( $row['Price'] / $valueDayMonth_Arr ) * $dayWithMonth_Arr; //Считаем сумму к оплате по дням за первый месяц
$sumForFirstMonth_Arr = round($sumForFirstMonth_Arr); //Округляем сумму
$firstDayForNextMonth_Arr = '01-'.date('m-Y', strtotime('+ 1 month', strtotime($dateStart_Arr))); // Находим первый день следующего месяца
echo '<br> Первый день следующего месяца для показа: '.$firstDayForNextMonth_Arr;
echo "<div style='background:#deebfd; width:300px'>Сумма к оплате за первый месяц ".$dateStart_Arr." составит  ".$sumForFirstMonth_Arr."</div>";
$theEndDayforShow_Arr =  cal_days_in_month(CAL_GREGORIAN, $dateEndMonth_Arr[$k], $dateEndYear_Arr[$k]);//Находим последний день даты окончания показа 
$theEndDateForShow_Arr = $theEndDayforShow_Arr.'-'.$dateEnd_Arr; //Дата окончания показа
echo '<br>последний день даты окончания показа: '.$theEndDateForShow_Arr;
$firstDateStart_Arr = new DateTime($theEndDateForShow_Arr); //Считаем месяцы для оплаты
$sumForDay_Arr = $row['Price'] / 30; //Берем среднее кол-во дней 30 и делим на сумму / мес, чтобы узнать стоимость щита за 1 день
$lastDateStart_Arr = new DateTime($firstDayForNextMonth_Arr);
$intervalDate_Arr = $firstDateStart_Arr->diff($lastDateStart_Arr);
echo '<br>Интервал: '.$intervalDate->format('%a');
$resultSum_Arr =  ($sumForDay_Arr * $intervalDate_Arr->format('%a')) + $sumForFirstMonth_Arr;  //Вычисляем сумму за весь период и прибавляем к сумме оплату за 1ый месяц
$resultSum_Arr = round($resultSum_Arr);
echo '<br> Итоговая сумма за весь период съема щита: '.$resultSum_Arr;
//Конец - обработчик цен