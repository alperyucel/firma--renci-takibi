<?php
require_once("baglanti.php");
session_start();

if (isset($_GET['id'])) {
    $eslesme_id = $_GET['id'];

    // Silme sorgusu
    $sorgu = "DELETE FROM eslesmeler WHERE eslesme_id = '$eslesme_id'";

    if (mysqli_query($baglanti, $sorgu)) {
        header("Location: eslesmeler.php");
        exit();
    } else {
        echo "Hata: " . mysqli_error($baglanti);
    }
} else {
    header("Location: eslesmeler.php");
    exit();
}
?>