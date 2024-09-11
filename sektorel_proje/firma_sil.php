<?php
require_once("baglanti.php");

// Silinecek firma ID'sini al
if(isset($_GET['id'])){
    $firma_id = $_GET['id'];

    // Silme sorgusu
    $sorgu = "DELETE FROM firmalar WHERE firma_id='$firma_id'";

    // Sorguyu çalıştır ve sonucu kontrol et
    if(mysqli_query($baglanti, $sorgu)){
        // Başarılı silme mesajı
        header("Location: firmalar.php");
        exit();
    } else{
        echo "Hata: " . mysqli_error($baglanti);
    }
} else{
    echo "Firma ID bulunamadı.";
}
?>