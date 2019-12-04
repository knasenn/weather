
<h1>JSON weather</h1>
<form action="" method="post" class="loginBox"><br>
    <input type="text" name="ip" placeholder=<?= $adress ?> required><br>
    <input type="radio" name="dateChecked" value="plusweek" checked> en vecka fram<br>
    <input type="radio" name="dateChecked" value="minusmonth" > en månad bak<br>
    <input type="submit" value="Submit" >
</form>


<h2>Kmom03 - API</h2>
<b>Instruktioner</b><br>
Skriv in en ip adress eller lat,long(mellen -90.00 och +90.00) och klicka på "submit" för att få aktuell väderinfo.
(OBS! Separera lat long med ett kommatecken!)<br>
<b>Resultat</b><br>
Resultatatet returneras i JSON format. Nedan kan man se strukturen på hur en sådan fil kan seut.
<pre style="background-color: #eee;">
  {
      "ip": "8.8.8.8",
      "valid": "IP is a valid IPv4 address",
      "domain": "dns.google",
      "latitude": 37.419158935546875,
      "longitude": -122.07540893554688,
      "country_name": "United States",
      "region_name": "California"
  }
</pre>
