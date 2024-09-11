<?php
include("baglanti.php");

$username_err = "";
$email_err = "";
$parola_err = "";
$parolatkr_err = "";
$tc_kimlik_no_err = "";
$adsoyad_err = "";
$telefonno_err = "";
$dogumyili_err = "";

if (isset($_POST["kaydol"])) {

    // Kullanıcı adı doğrulama
    if (empty($_POST["kullaniciadi"])) {
        $username_err = "Kullanıcı adı boş geçilemez.";
    } else if (strlen($_POST["kullaniciadi"]) < 6) {
        $username_err = "Kullanıcı adı en az 6 karakterden oluşmalıdır.";
    } else if (!preg_match('/^[a-z\d_]{5,20}$/i', $_POST["kullaniciadi"])) {
        $username_err = "Kullanıcı adı büyük küçük harf ve rakamlardan oluşmalıdır.";
    } else {
        $username = $_POST["kullaniciadi"];
    }

    // Email doğrulama
    if (empty($_POST["email"])) {
        $email_err = "Email alanı boş geçilemez.";
    } else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Geçersiz email formatı.";
    } else {
        $email = $_POST["email"];
    }

    // Şifre doğrulama
    if (empty($_POST["parola"])) {
        $parola_err = "Şifre boş geçilemez.";
    } else {
        $parola = password_hash($_POST["parola"], PASSWORD_DEFAULT);
    }

    // Şifre tekrar
    if (empty($_POST["parolatkr"])) {
        $parolatkr_err = "Şifre tekrar kısmı boş geçilemez.";
    } else if ($_POST["parola"] != $_POST["parolatkr"]) {
        $parolatkr_err = "Şifreler eşleşmiyor.";
    } else {
        $parolatkr = $_POST["parolatkr"];
    }

    if (empty($_POST["tc_kimlik_no"])) {
        $tc_kimlik_no_err = "TC kimlik numarası boş geçilemez.";
    } else if (!preg_match('/^[0-9]{11}$/', $_POST["tc_kimlik_no"])) {
        $tc_kimlik_no_err = "TC kimlik numarası 11 rakamdan oluşmalıdır.";
    } else {
        $tc_kimlik_no = $_POST["tc_kimlik_no"];
    }

    if (empty($_POST["adsoyad"])) {
        $adsoyad_err = "Ad soyad boş geçilemez.";
    } else {
        $adsoyad = $_POST["adsoyad"];
    }

    if (empty($_POST["telefonno"])) {
        $telefonno_err = "Telefon numarası boş geçilemez.";
    } else {
        $telefonno = $_POST["telefonno"];
    }

    if (empty($_POST["dogumyili"])) {
        $dogumyili_err = "Doğum yılı boş geçilemez.";
    } else {
        $dogumyili = $_POST["dogumyili"];
    }

    if (isset($username) && isset($email) && isset($parola) && isset($tc_kimlik_no) && isset($adsoyad) && isset($telefonno) && isset($dogumyili)) {
        $ekle = "INSERT INTO ogretmenler (kullanici_adi, email, parola, tc_kimlik_no, adsoyad, telefonno, dogumyili) VALUES ('$username','$email','$parola','$tc_kimlik_no','$adsoyad','$telefonno','$dogumyili')";
        $calistirekle = mysqli_query($baglanti, $ekle);

        if ($calistirekle) {
            echo '<div class="alert alert-success" role="alert">Kayıt başarılı bir şekilde eklendi.</div>';
            header("Location: giris.php");
            exit();
        } else {
            echo '<div class="alert alert-danger" role="alert">Kayıt eklenirken bir hata oluştu.</div>';
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
    <title>Öğretmen Kayıt İşlemi</title>
</head>

<body>
    <div class="container py-5">
        <div class="card p-5">
            <h2 class="text-center">Kayıt Sayfası</h2>
            <form action="kayit.php" method="POST">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="kullaniciadi" class="form-label">Kullanıcı Adı</label>
                                <input type="text" class="form-control <?php if (!empty($username_err)) { echo "is-invalid"; } ?>" id="kullaniciadi" name="kullaniciadi">
                                <div class="invalid-feedback"><?php echo $username_err; ?></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control <?php if (!empty($email_err)) { echo "is-invalid"; } ?>" id="email" name="email">
                                <div class="invalid-feedback"><?php echo $email_err; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="parola" class="form-label">Şifre</label>
                                <input type="password" class="form-control <?php if (!empty($parola_err)) { echo "is-invalid"; } ?>" id="parola" name="parola">
                                <div class="invalid-feedback"><?php echo $parola_err; ?></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="parolatkr" class="form-label">Şifre Tekrar</label>
                                <input type="password" class="form-control <?php if (!empty($parolatkr_err)) { echo "is-invalid"; } ?>" id="parolatkr" name="parolatkr">
                                <div class="invalid-feedback"><?php echo $parolatkr_err; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="tc_kimlik_no" class="form-label">TC Kimlik Numarası</label>
                                <input type="text" class="form-control <?php if (!empty($tc_kimlik_no_err)) { echo "is-invalid"; } ?>" id="tc_kimlik_no" name="tc_kimlik_no">
                                <div class="invalid-feedback"><?php echo $tc_kimlik_no_err; ?></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="adsoyad" class="form-label">Ad Soyad</label>
                                <input type="text" class="form-control <?php if (!empty($adsoyad_err)) { echo "is-invalid"; } ?>" id="adsoyad" name="adsoyad">
                                <div class="invalid-feedback"><?php echo $adsoyad_err; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="telefonno" class="form-label">Telefon Numarası</label>
                                <input type="text" class="form-control <?php if (!empty($telefonno_err)) { echo "is-invalid"; } ?>" id="telefonno" name="telefonno">
                                <div class="invalid-feedback"><?php echo $telefonno_err; ?></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="dogumyili" class="form-label">Doğum Yılı</label>
                                <input type="date" class="form-control <?php if (!empty($dogumyili_err)) { echo "is-invalid"; } ?>" id="dogumyili" name="dogumyili">
                                <div class="invalid-feedback"><?php echo $dogumyili_err; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col text-center"> 
                        <div class="btn-container">
                            <button type="submit" name="kaydol" class="btn btn-primary">Kayıt Ol</button>
                        </div>
                    </div>  
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>
</html>