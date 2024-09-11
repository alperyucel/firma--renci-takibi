<?php
require_once("baglanti.php");

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Öğretmeni silme işlemi
    $silSorgu = "DELETE FROM ogretmenler WHERE ogretmen_id = '$userId'";
    $silSonuc = mysqli_query($baglanti, $silSorgu);

    if ($silSonuc) {
        header("Location: ogretmenler.php");
        exit();
    } else {
        echo "Hata: " . mysqli_error($baglanti);
    }
} else {
    echo "Geçersiz bir kullanıcı IDsi.";
}
?>