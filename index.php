<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="utf-8">
<title>Çamaşır Yıkamalı Mıyım?</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    text-align:center;
    font-family: Arial;
    background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)),
    url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1600&q=80');
    background-size: cover;
    background-position:center;
    color:white;
    transition: 0.5s;
}

.kutu {
    background: rgba(0,0,0,0.7);
    padding:30px;
    margin-top:80px;
    border-radius:15px;
}

img {
    width:100px;
}
</style>

<script>
var veriler =
 {
"Antalya": ["Manavgat","Muratpaşa","Konyaaltı"],
"Hatay":["Samandağ","Antakya","İskenderun"],
"Aydın":["Karacasu","Nazilli","Kuyucak"],
"Muğla":["Bodrum","Fethiye","Milas"],
"İzmir":["Bornova","Konak","Buca"],
"İstanbul": ["Kadıköy","Beşiktaş","Üsküdar"],
"Mersin":["Mezitli","Yenişehir","Toroslar"],
"Konya":["Selçuklu","Meram","Karatay"],
"Ankara": ["Çankaya","Keçiören","Yenimahalle"]
};



function ilceGetir(){
    var il = document.getElementById("il").value;
    var ilce = document.getElementById("ilce");

    ilce.innerHTML = "<option>İlçe seçiniz</option>";

    if(veriler[il]){
        veriler[il].forEach(function(x){
            ilce.innerHTML += "<option>" + x + "</option>";
        });
    }
}
</script>

</head>

<body>

<div class="container">

<div class="kutu mx-auto col-md-6 shadow-lg">

<h1 class="mb-4"> Çamaşır Yıkamalı Mıyım?</h1>

<form method="POST">

<select id="il" name="il" class="form-select mb-3" onchange="ilceGetir()">
<option value="">İl seçiniz</option>
<script>
for(var key in veriler){
    document.write("<option>"+key+"</option>");
}
</script>
</select>

<select id="ilce" name="ilce" class="form-select mb-3">
<option>İlçe seçiniz</option>
</select>

<button type="submit" class="btn btn-primary w-100">Hava Durumu</button>

</form>

<?php

if(isset($_POST["il"]) && $_POST["il"] != ""){

require_once "HavaDurumu.php";

$il = $_POST["il"];
$ilce = $_POST["ilce"];

$hava = new HavaDurumu($il, $ilce);
$hava->veriGetir();

$durum = $hava->durumGetir();
$sicaklik = $hava->sicaklikGetir();
$ruzgar = $hava->ruzgarGetir();
$yorum = $hava->yorumYap();

echo "<hr>";
echo "<h3>$il $ilce</h3>";
echo "<p> $sicaklik °C |  $ruzgar km/s</p>";
echo "<h2 class='mt-3'>$yorum</h2>";


// YAĞMUR
if(strpos($durum,"rain") !== false){

    echo "<img src='https://cdn-icons-png.flaticon.com/512/414/414974.png' class='mt-3'>";

    echo "<style>
    body{
    background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
    url('https://images.unsplash.com/photo-1527766833261-b09c3163a791?auto=format&fit=crop&w=1600&q=80');
    }
    </style>";
}


// BULUTLU
elseif(strpos($durum,"cloud") !== false){

    echo "<img src='https://cdn-icons-png.flaticon.com/512/1163/1163624.png' class='mt-3'>";

    echo "<style>
    body{
    background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
    url('https://images.unsplash.com/photo-1499346030926-9a72daac6c63?auto=format&fit=crop&w=1600&q=80');
    }
    </style>";
}


// GÜNEŞ
elseif(strpos($durum,"sun") !== false || strpos($durum,"clear") !== false){

    echo "<img src='https://cdn-icons-png.flaticon.com/512/1163/1163661.png' class='mt-3'>";

    echo "<style>
    body{
    background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)),
    url('https://images.unsplash.com/photo-1501973801540-537f08ccae7b?auto=format&fit=crop&w=1600&q=80');
    }
    </style>";
}

}
?>

</div>

</div>

</body>
</html>