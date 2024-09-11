<?php
require_once("baglanti.php");
session_start();

if (isset($_POST['hami_ekle'])) {
    $hami_adsoyad = $_POST['hami_adsoyad'];
    $telefonno = $_POST['telefonno'];
    $firma_id = $_POST['firma_id'];
    $hami_degerlendirme = $_POST['hami_degerlendirme'];

    $sorgu = "INSERT INTO hamiler (hami_adsoyad, telefonno, firma_id, hami_degerlendirme) VALUES ('$hami_adsoyad', '$telefonno', '$firma_id', '$hami_degerlendirme')";
    if (mysqli_query($baglanti, $sorgu)) {
        header("Location: hamiler.php");
    } else {
        echo "Hata: " . $sorgu . "<br>" . mysqli_error($baglanti);
    }
}

if (isset($_POST['hami_guncelle'])) {
    $hami_id = $_POST['hami_id'];
    $hami_adsoyad = $_POST['hami_adsoyad'];
    $telefonno = $_POST['telefonno'];
    $firma_id = $_POST['firma_id'];
    $hami_degerlendirme = $_POST['hami_degerlendirme'];

    $sorgu = "UPDATE hamiler SET hami_adsoyad='$hami_adsoyad', telefonno='$telefonno', firma_id='$firma_id', hami_degerlendirme='$hami_degerlendirme' WHERE hami_id='$hami_id'";
    if (mysqli_query($baglanti, $sorgu)) {
        header("Location: hamiler.php");
    } else {
        echo "Hata: " . $sorgu . "<br>" . mysqli_error($baglanti);
    }
}

mysqli_close($baglanti);
?>