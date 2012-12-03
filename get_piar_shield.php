$f_AdminButtons
<table width=700>
<tr>
<td>Номер объекта: $f_Message_ID</td>
</tr>
<tr>
<td>Артикул: $f_Article</td>
</tr>
<tr>
<td>Субъект Федерации: $f_SubFed</td>
</tr>
<tr>
<td>Индекс: $f_Zip</td>
</tr>
<tr>
<td>Город: $f_City</td>
</tr>
<tr>
<td>Район Москвы: $f_regionMoscow</td>
</tr>
<tr>
<td>Улица $f_Street, дом $f_House, корпус $f_Korpus</td>
</tr>
<tr>
<td>Категория объекта $f_KategoryObject</td>
</tr>
<tr>
<td>Схема объекта:<br> <img width=300 src='$f_Scheme' /></td>
</tr>
<tr>
<td>Фото <br><img width=300 src='$f_image_1' /></td>
</tr>
<tr>
<td>Активность объекта: $f_Active</td>
</tr>
</table>

<br>
<form method='get' action=''>
Свободные: <input checked type='checkbox'  name='free' value='free' />
Занятые и зависимые: <input type='checkbox'  name='busy' value='busy' />
Демонтированные: <input type='checkbox'  name='notactive' value='notactive' />
<input type='submit' value='отправить' />
</form>
<h2>Рекламные установки по данному объекту</h2>
";
$value_cheak_free = "Free = 1";
$value_cheak_active = "Active = 1";
$value_cheak_depend = "(Message163.Article NOT IN (SELECT IZ1 FROM Message163 WHERE Parrent=".$f_Article." and (Free = 2 or Active=2))) AND (Message163.Article NOT IN (SELECT IZ2 FROM Message163 WHERE Parrent=".$f_Article." and (Free=2 or Active=2)))";
if ($_GET['free']=='free'){
$value_cheak_free = 1;
}
if ($_GET['busy']=='busy'){
$value_cheak_depend = "1=1";
$value_cheak_free = "1=1";
}
if ($_GET['notactive']=='notactive'){
$value_cheak_active = "1=1";
}
echo $allProduct;
echo "<table width=700><tr><td>Артикул</td><td>Название</td><td>Размер</td><td>Цена</td><td>Фото</td></tr>";
$result = mysql_query("SELECT Message163.Message_ID, Message163.Sub_Class_ID, Message163.Article, Message163.Name, Message163.height, Message163.Width, Message163.Free, Message163.Active, Message163.Price, Sub_Class.EnglishName FROM Message163 JOIN Sub_Class on Message163.Sub_Class_ID = Sub_Class.Sub_Class_ID and Parrent = ".$f_Article." and ".$value_cheak_active." and ".$value_cheak_free." ".$value_cheak_busy." WHERE ".$value_cheak_depend." ORDER BY Article");
while ($row = mysql_fetch_array($result)){
echo '<tr><td>'.$f_Article.'.'.$row["Article"].'</td><td><a href="/'.$current_sub['EnglishName'].'/'.$row["EnglishName"].'/'.$row["EnglishName"].'_'.$row["Message_ID"].'.html">'.$row["Name"].'</a></td><td>'.$row["Width"].' x '.$row["height"].'</td><td>'.$row["Price"].'</td><td><img width="90" src='.nc_file_path(163, $row["Message_ID"], "image_1", "h_").' /></td><td>'.$row["Free"].'</td><td>'.$row["Active"].'</td></tr>';
}
echo "</table>";
$result .="
