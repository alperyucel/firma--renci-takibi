<?php
require_once("baglanti.php");
session_start();

// Hata raporlamayı açalım
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['ziyaretEkle'])) {
        $ogretmen_id = $_POST['ogretmen_id'];
        $ogrenci_no = $_POST['ogrenci_no'];
        $hami_id = $_POST['hami_id'];
        $firma_id = $_POST['firma_id'];
        $ziyaret_turu = $_POST['ziyaret_turu'];
        $ziyaret_gorusu = $_POST['ziyaret_gorusu'];
        $ziyaret_tarihi = $_POST['ziyaret_tarihi'];

        $sorgu = "INSERT INTO ziyaretler (ogretmen_id, ogrenci_no, hami_id, firma_id, ziyaret_turu, ziyaret_gorusu, ziyaret_tarihi) VALUES ('$ogretmen_id', '$ogrenci_no', '$hami_id', '$firma_id', '$ziyaret_turu', '$ziyaret_gorusu', '$ziyaret_tarihi')";
        
        if (mysqli_query($baglanti, $sorgu)) {
            header("Location: ziyaretler.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Hata: " . mysqli_error($baglanti) . "</div>";
        }
        
    } elseif (isset($_POST['ziyaretGuncelle'])) {
        $ziyaretId = $_POST['ziyaretId'];
        $ogretmen_id = $_POST['ogretmen_id'];
        $ogrenci_no = $_POST['ogrenci_no'];
        $hami_id = $_POST['hami_id'];
        $firma_id = $_POST['firma_id'];
        $ziyaret_turu = $_POST['ziyaret_turu'];
        $ziyaret_gorusu = $_POST['ziyaret_gorusu'];
        $ziyaret_tarihi = $_POST['ziyaret_tarihi'];

        $sorgu = "UPDATE ziyaretler SET ogretmen_id='$ogretmen_id', ogrenci_no='$ogrenci_no', hami_id='$hami_id', firma_id='$firma_id', ziyaret_turu='$ziyaret_turu', ziyaret_gorusu='$ziyaret_gorusu', ziyaret_tarihi='$ziyaret_tarihi' WHERE ziyaret_id='$ziyaretId'";
        
        if (mysqli_query($baglanti, $sorgu)) {
            header("Location: ziyaretler.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Hata: " . mysqli_error($baglanti) . "</div>";
        }
    }

    mysqli_close($baglanti);
}
?>