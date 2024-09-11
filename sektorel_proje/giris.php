<?php
include("baglanti.php");

$tc_kimlik_no_err = ""; 
$parola_err = "";
$username_err = "";

if (isset($_POST["giris"])) {
    // Kullanıcı adı doğrulama
    if (empty($_POST["kullaniciadi"])) {
        $username_err = "Kullanıcı adı boş geçilemez.";
    } else {
        $username = $_POST["kullaniciadi"];
    }

    // TC Kimlik No doğrulama
    if (empty($_POST["tc_kimlik_no"])) {
        $tc_kimlik_no_err = "TC kimlik numarası boş geçilemez.";
    } else if (!preg_match('/^[0-9]{11}$/', $_POST["tc_kimlik_no"])) {
        $tc_kimlik_no_err = "TC kimlik numarası 11 rakamdan oluşmalıdır.";
    } else {
        $tc_kimlik_no = $_POST["tc_kimlik_no"];
    }

    // Şifre doğrulama 
    if (empty($_POST["parola"])) {
        $parola_err = "Şifre boş geçilemez.";
    } else {
        $parola = $_POST["parola"];
    }

    if (isset($username) && isset($tc_kimlik_no) && isset($parola)) {
        $secim = "SELECT * FROM ogretmenler WHERE kullanici_adi ='$username' AND tc_kimlik_no ='$tc_kimlik_no'";
        $calistir = mysqli_query($baglanti, $secim);
        $kayitsayisi = mysqli_num_rows($calistir); // ya 0 ya 1

        if ($kayitsayisi > 0) {
            $ilgilikayit = mysqli_fetch_assoc($calistir);
            $hashlisifre = $ilgilikayit["parola"];

            if (password_verify($parola, $hashlisifre)) {
                session_start();
                $_SESSION["ogretmen_id"] = $ilgilikayit["ogretmen_id"];
                $_SESSION["kullanici_adi"] = $ilgilikayit["kullanici_adi"];
                $_SESSION["email"] = $ilgilikayit["email"];
                header("Location: anasayfa.php");
                exit;
            } else {
                echo '<div class="alert alert-danger" role="alert">Parola yanlış.</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Kullanıcı adı veya TC kimlik numarası yanlış.</div>';
        }

        mysqli_close($baglanti);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <title>Öğretmen Giriş Ekranı</title>
</head>
<body>
<div class="container p-5">
    <div class="card p-5">
        <h2 class="text-center">Giriş Sayfası</h2>
        <form action="giris.php" method="POST">
            <div class="mb-3">
                <label for="kullaniciadi" class="form-label">Kullanıcı Adı</label>
                <input type="text" class="form-control <?php if (!empty($username_err)) { echo "is-invalid"; } ?>" id="kullaniciadi" name="kullaniciadi">
                <div class="invalid-feedback"><?php echo $username_err; ?></div>
            </div>
            <div class="mb-3">
                <label for="tc_kimlik_no" class="form-label">TC Kimlik Numarası</label>
                <input type="text" class="form-control <?php if (!empty($tc_kimlik_no_err)) { echo "is-invalid"; } ?>" id="tc_kimlik_no" name="tc_kimlik_no">
                <div class="invalid-feedback"><?php echo $tc_kimlik_no_err; ?></div>
            </div>
            <div class="mb-3">
                <label for="parola" class="form-label">Şifre</label>
                <input type="password" class="form-control <?php if (!empty($parola_err)) { echo "is-invalid"; } ?>" id="parola" name="parola">
                <div class="invalid-feedback"><?php echo $parola_err; ?></div>
            </div>
            <button type="submit" name="giris" class="btn btn-primary">Giriş Yap</button>
            <a href="kayit.php" class="btn btn-success">Kaydol</a>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>
</html>