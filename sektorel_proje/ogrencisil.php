<?php
require_once("baglanti.php");

if(isset($_GET['id'])){
    $ogrenci_id = $_GET['id'];

    // Öğrenciyi silme sorgusu
    $sorgu = "DELETE FROM ogrenciler WHERE ogrenci_id='$ogrenci_id'";

    // Sorguyu çalıştır ve sonucu kontrol et
    if(mysqli_query($baglanti, $sorgu)){
        // Başarılı silme mesajı
        header("Location: ogrenciler.php");
        exit();
    } else{
        echo "Hata: " . mysqli_error($baglanti);
    }
} else {
    echo "Öğrenci ID'si belirtilmedi.";
}

mysqli_close($baglanti);
?>