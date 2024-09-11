<?php
require_once("baglanti.php");

// Silme isteği var mı?
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $ziyaret_id = $_GET['id'];

    // Ziyareti sil
    $sorgu = "DELETE FROM ziyaretler WHERE ziyaret_id = '$ziyaret_id'";
    
    if (mysqli_query($baglanti, $sorgu)) {
        header("Location: ziyaretler.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Hata: " . mysqli_error($baglanti) . "</div>";
    }

    mysqli_close($baglanti);
} else {
    echo "<div class='alert alert-danger'>Geçersiz silme isteği!</div>";
}
?>