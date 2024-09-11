<?php
require_once("baglanti.php");

// Yeni öğrenci eklemek için
if (isset($_POST['ogrenciekle'])) {
    // Formdan gelen verileri al
    $ogrenci_no = $_POST['ogrenci_no'];
    $adsoyad = $_POST['adsoyad'];
    $email = $_POST['email'];
    $donem = $_POST['donem'];
    $ogretmen_id = $_POST['ogretmen_id']; // Yeni eklenen öğretmen bilgisi

    // Veritabanına ekleme sorgusu
    $sorgu = "INSERT INTO ogrenciler (ogrenci_no, adsoyad, email, donem, ogretmen_id) VALUES ('$ogrenci_no', '$adsoyad', '$email', '$donem', '$ogretmen_id')";

    // Sorguyu çalıştır ve sonucu kontrol et
    if (mysqli_query($baglanti, $sorgu)) {
        // Başarılı ekleme mesajı
        header("Location: ogrenciler.php");
        exit();
    } else {
        echo "Hata: " . mysqli_error($baglanti);
    }
}

// Öğrenci güncellemek için
if (isset($_POST['ogrenciguncelle'])) {
    // Formdan gelen verileri al
    $ogrenci_id = $_POST['ogrenciId'];
    $ogrenci_no = $_POST['ogrenci_no'];
    $adsoyad = $_POST['adsoyad'];
    $email = $_POST['email'];
    $donem = $_POST['donem'];
    $ogretmen_id = $_POST['ogretmen_id']; // Yeni eklenen öğretmen bilgisi

    // Veritabanında güncelleme sorgusu
    $sorgu = "UPDATE ogrenciler SET ogrenci_no='$ogrenci_no', adsoyad='$adsoyad', email='$email', donem='$donem', ogretmen_id='$ogretmen_id' WHERE ogrenci_id='$ogrenci_id'";

    // Sorguyu çalıştır ve sonucu kontrol et
    if (mysqli_query($baglanti, $sorgu)) {
        // Başarılı güncelleme mesajı
        header("Location: ogrenciler.php");
        exit();
    } else {
        echo "Hata: " . mysqli_error($baglanti);
    }
}

// Veritabanı bağlantısını kapat
mysqli_close($baglanti);
?>