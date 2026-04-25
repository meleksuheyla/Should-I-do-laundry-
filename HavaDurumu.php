<?php

class HavaDurumu {

    public $il;
    public $ilce;
    public $veri;

    function __construct($il, $ilce){
        $this->il = $il;
        $this->ilce = $ilce;
    }

    function veriGetir(){
        $yer = urlencode($this->il . " " . $this->ilce);
        $api = file_get_contents("https://wttr.in/".$yer."?format=j1");
        $this->veri = json_decode($api, true);
    }

    function durumGetir(){
        return strtolower($this->veri["current_condition"][0]["weatherDesc"][0]["value"]);
    }

    function sicaklikGetir(){
        return $this->veri["current_condition"][0]["temp_C"];
    }

    function ruzgarGetir(){
        return $this->veri["current_condition"][0]["windspeedKmph"];
    }

    function yorumYap(){

        $durum = $this->durumGetir();
        $sicaklik = $this->sicaklikGetir();
        $ruzgar = $this->ruzgarGetir();

        if(strpos($durum,"rain") !== false){
            return " Çamaşır serme, yağmur var kurumaz !";
        }

        if($ruzgar > 25){
            return " Çok rüzgar var, çamaşır uçabilir !";
        }

        if($sicaklik > 30){
            return " Çok sıcak, çamaşır hemen kurur! ser ser ";
        }

        if(strpos($durum,"cloud") !== false){
            return " Ser ama geç kurur ,  hatta  kurur mu bilemem .";
        }

        $durum = strtolower($durum);

        if(strpos($durum,"sun") !== false || strpos($durum,"clear") !== false){
            return "Hava süper, gönül rahatlığıyla ser! ";
    }
        

        return " Hava durumu net değil ";
    }
}
?>