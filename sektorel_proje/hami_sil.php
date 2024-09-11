<?php
require_once("baglanti.php");

if(isset($_GET['id'])) {
    $hami_id = $_GET['id'];

    // Haminin veritabanından silinmesi
    $sorgu = "DELETE FROM hamiler WHERE hami_id='$hami_id'";
    
    if(mysqli_query($baglanti, $sorgu)) {
        header("Location: hamiler.php");
        exit();
    } else {
        echo "Hata: " . mysqli_error($baglanti);
    }
} else {
    echo "Geçersiz istek!";
}
?>