<?php
require_once("baglanti.php");
session_start();

// Yeni firma ekleme işlemi
if (isset($_POST['firmaekle'])) {
    // Formdan gelen verileri al
    $firmaAdi = $_POST['firma_adi'];
    $adres = $_POST['adres'];
    $email = $_POST['email'];
    $telefon = $_POST['telefonno'];
    $yetkiliAdSoyad = $_POST['yetkili_adsoyad'];
    $kriterler = $_POST['kriterler'];

    // Veritabanına ekleme sorgusu
    $sorgu = "INSERT INTO firmalar (firma_adi, adres, email, telefonno, yetkili_adsoyad, kriterler) 
              VALUES ('$firmaAdi', '$adres', '$email', '$telefon', '$yetkiliAdSoyad', '$kriterler')";

    // Sorguyu çalıştır ve sonucu kontrol et
    if (mysqli_query($baglanti, $sorgu)) {
        // Başarılı ekleme mesajı
        header("Location: firmalar.php");
        exit();
    } else {
        echo "Hata: " . mysqli_error($baglanti);
    }
}

// Firma güncelleme işlemi
if (isset($_POST['firmaguncelle'])) {
    // Formdan gelen verileri al
    $firmaId = $_POST['firmaId'];
    $firmaAdi = $_POST['firmaAdi'];
    $adres = $_POST['adres'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];
    $yetkiliAdSoyad = $_POST['yetkiliAdSoyad'];
    $kriterler = $_POST['kriterler'];

    // Veritabanında güncelleme sorgusu
    $sorgu = "UPDATE firmalar 
              SET firma_adi='$firmaAdi', adres='$adres', email='$email', telefon='$telefon', yetkili_adsoyad='$yetkiliAdSoyad', kriterler='$kriterler' 
              WHERE firma_id='$firmaId'";

    // Sorguyu çalıştır ve sonucu kontrol et
    if (mysqli_query($baglanti, $sorgu)) {
        // Başarılı güncelleme mesajı
        header("Location: firmalar.php");
        exit();
    } else {
        echo "Hata: " . mysqli_error($baglanti);
    }
}

// Veritabanı bağlantısını kapat
mysqli_close($baglanti);
?>