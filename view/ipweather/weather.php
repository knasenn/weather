<h1 style="color:red;"><?= $notValid ?></h1>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>OpenStreetMap &amp; OpenLayers - Marker Example</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
  <script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>

  <script>
/* OSM & OL example code provided by https://mediarealm.com.au/ */
var map;
var mapLat = <?= $latitude ?>;
var mapLng = <?= $longitude ?>;
var mapDefaultZoom = 10;
function initialize_map() {
map = new ol.Map({
target: "map",
layers: [
new ol.layer.Tile({
source: new ol.source.OSM({
url: "https://a.tile.openstreetmap.org/{z}/{x}/{y}.png"
})
})
],
view: new ol.View({
center: ol.proj.fromLonLat([mapLng, mapLat]),
zoom: mapDefaultZoom
})
});
}
function add_map_point(lat, lng) {
var vectorLayer = new ol.layer.Vector({
source:new ol.source.Vector({
features: [new ol.Feature({
geometry: new ol.geom.Point(ol.proj.transform([parseFloat(lng), parseFloat(lat)], 'EPSG:4326', 'EPSG:3857')),
})]
}),
style: new ol.style.Style({
image: new ol.style.Icon({
anchor: [0.5, 0.5],
anchorXUnits: "fraction",
anchorYUnits: "fraction",
src: "https://upload.wikimedia.org/wikipedia/commons/e/ec/RedDot.svg"
})
})
});
map.addLayer(vectorLayer);
}
</script>
</head>
<body onload="initialize_map(); add_map_point(<?= $latitude ?>, <?= $longitude ?>);">
  <div id="map" style="width: 35vw; height: 35vh;"></div>
</body>





<h1>Ip validator</h1>

<form>
<b>Return:</b> <?= $ipval ?><br>
<b>Domain:</b> <?= $host ?><br>
<b>Latitude:</b> <?= $latitude ?><br>
<b>Longitude:</b> <?= $longitude ?><br>
<b>Country:</b> <?= $country_name ?><br>
<b>Region:</b> <?= $region_name ?><br>
</form>


<h1>Weather report this week</h1>
<table class="prodBox">
  <tr class="first" align="left">
      <th>Datum </th>
      <th>Temp-min </th>
      <th>Temp-max </th>
      <th>humidity </th>
      <th>windspeed </th>
  </tr>
<?php $id = -1;
if ($resTempWeek != "") {
    foreach ($resTempWeek as $row) :
        $id++; ?>
    <tr>
        <td><?= $row->time ?></td>
        <td><?= $row->temperatureMin ?>deg</td>
        <td><?= $row->temperatureMax ?>deg</td>
        <td><?= $row->humidity ?></td>
        <td><?= $row->windSpeed ?>m/s</td>
    </tr>
    <?php endforeach;
}
?>
</table>

<h1>Weather report last month</h1>

<table class="prodBox">
  <tr class="first" align="left">
      <th>Datum </th>
      <th>Temp </th>
      <th>humidity </th>
      <th>windspeed </th>
  </tr>
<?php $id = -1;
if ($resTempMonth != "") {
    foreach ($resTempMonth as $row) :
        $id++; ?>
        <tr>
            <td><?= $row["currently"]["time"] ?></td>
            <td><?= $row["currently"]["temperature"] ?>deg</td>
            <td><?= $row["currently"]["humidity"] ?></td>
            <td><?= $row["currently"]["windSpeed"] ?>m/s</td>
        </tr>
    <?php endforeach;
}
?>
</table>
