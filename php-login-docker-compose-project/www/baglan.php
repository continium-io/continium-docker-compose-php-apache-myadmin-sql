<?php

session_start(); ob_start();


if(!empty($_ENV['MYSQL_HOST']))
   $host = $_ENV['MYSQL_HOST'];
else
   $host = 'firat-mysql-app';


if(!empty($_ENV['MYSQL_USER']))
   $user = $_ENV['MYSQL_USER'];
else
   $user = 'firatuser';



if(!empty($_ENV['MYSQL_PASSWORD']))
   $pass = $_ENV['MYSQL_PASSWORD'];
else
   $pass = 'moepass';


if(!empty($_ENV['MYSQL_DB']))
   $db_name = $_ENV['MYSQL_DB'];
else
   $db_name = 'firat_db';

$conn = new mysqli($host, $user, $pass, $db_name);


try{
	$VeritabaniBaglantisi	=	new PDO("mysql:host=$host;dbname=$db_name;charset=UTF8", $user,$pass);
	
}catch(PDOException $Hata){
	echo "Bağlantı Hatası<br />" . $Hata->GetMessage();
	die();
}

function Filtre($Deger){
	$Bir	=	trim($Deger);
	$Iki	=	strip_tags($Bir);
	$Uc		=	htmlspecialchars($Iki, ENT_QUOTES);
	$Sonuc	=	$Uc;
	return $Sonuc;
}

$ZamanDamgasi	=	time();

if(isset($_SESSION["Kullanici"])){
	$UyelerSorgusu			=	$VeritabaniBaglantisi->prepare("SELECT * FROM uyeler WHERE kullaniciadi=?");
	$UyelerSorgusu->execute([$_SESSION["Kullanici"]]);
	$UyelerKayitSayisi		=	$UyelerSorgusu->rowCount();
	$UyelerKaydi			=	$UyelerSorgusu->fetch(PDO::FETCH_ASSOC);
	
	if($UyelerKayitSayisi>0){
		$UyeninAdiSoyadi	=	$UyelerKaydi["adisoyadi"];
	}else{
		$UyeninAdiSoyadi	=	"";
	}
}

?>