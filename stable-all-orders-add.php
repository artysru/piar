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

//echo $dateStartDay_Arr[$k].', '.$dateStartMonth_Arr[$k].', '.$dateStartYear_Arr[$k].', '.$dateEndMonth_Arr[$k].', '.$dateEndYear_Arr[$k].', '.$Orders_Arr[$k];
}
}

?>