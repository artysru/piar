<h1>Рекламная установка $f_Name, объекта $f_Parrent</h1>
";
$result = mysql_query("SELECT City, Street, House, Korpus, DopKorpus FROM Message162 WHERE $f_Parrent = Article");
while ($row = mysql_fetch_array($result)){
echo '<div id="City">'.$row["City"].'</div><div id="Street">'.$row["Street"].'</div><div id="House">'.$row["House"].'</div><div id="Korpus">'.$row["Korpus"].'</div><div id="DopKorpus">'.$row["DopKorpus"].'</div>';
}
echo "
<div>Цена за 1 мес.: <div id='price'>$f_Price</div></div>
<div>Артикул рекламной установки: $f_Article</div>
<div>Название: $f_Name</div>
<div>Размеры рекламной установки: $f_Width x $f_height мм.</div>
<div>Освещенность: ".opt_case($f_Light == 1, 'Имеется', 'Не имеется')."
<div>Родительский объект: $f_Parrent</div>
<div>Фото объекта: <br><img width='300' src='$f_image_1' /></div>
<div id='map' style='width:300px; height: 300px'></div>
<!--Подгружаем карту объекта, данные берем из Г, рай-на, ул. и тд.-->
 <script type='text/javascript'>
        ymaps.ready(init);
        function init () {
			search_query = document.getElementById('City').innerHTML+' '+document.getElementById('Street').innerHTML+' '+document.getElementById('House').innerHTML+' '+document.getElementById('Korpus').innerHTML;
            ymaps.geocode(search_query, { results: 1 }).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);
                window.myMap = new ymaps.Map('map', {
                    center: firstGeoObject.geometry.getCoordinates(),
                    zoom: 11
                }),
				myMap.controls
					.add('zoomControl')
					.add('typeSelector')
					.add('smallZoomControl', { right: 5, top: 75 })
					.add('mapTools');
				 myPlacemark = new ymaps.Placemark(firstGeoObject.geometry.getCoordinates());
				 myMap.geoObjects.add(myPlacemark);
            }, function (err) {
                alert(err.message);
            })
        }
    </script>
<!--Делаем заказ на детальном отображении реклам. установки-->
<form method='post' action='/shop/fast-order/'>
<input type='hidden' value='".$f_RowID."' name='Orders_Arr[]' />
<input type='hidden' value='1' id=hidden_".$f_RowID." name='counts[]' />
<input size=2 type='text' name='dateStartDay_Arr[]' />-<input size=2 type='text' name='dateStartMonth_Arr[]' />-<input size=3 type='text' name='dateStartYear_Arr[]' /> Дата начала показа
<br>
<div><input type='checkbox' id='oneMonth' onclick='check()' name='oneMonth_Arr[]' value='oneMonth_Arr[]' /> - Заказать на месяц</div>
<div id='dateEnd'>
<br>
<input size=2 type='text' name='dateEndMonth_Arr[]' />-<input size=3 type='text' name='dateEndYear_Arr[]' /> Дата окончания показа (мес., год.)
</div>
<br>
<div><input type='submit' name='sub_Arr' value='купить' /></div>
</form>
<script type='text/javascript'>
function check(){
if(document.getElementById('oneMonth').checked==true){
document.getElementById('dateEnd').setAttribute('style', 'display:none;');
document.getElementById('oneMonth').setAttribute('onclick','uncheck()');
}
}
function uncheck(){
document.getElementById('dateEnd').setAttribute('style', 'display:inherit;');
document.getElementById('oneMonth').setAttribute('onclick','check()');

}

function chPrice(val){
var summPrice = $f_Price * val;
document.getElementById('price').innerHTML = summPrice;
document.getElementById('inputPrice').value = summPrice;
}
</script>