<?php
require_once("header.php");
require_once("baglanti.php");
session_start();
$kullanici_id = isset($_SESSION["kullanici_id"]) ? $_SESSION["kullanici_id"] : 0; // Oturum açan kullanıcının id'sini al

// Öğretmen düzenleme modunda mı?
$editing = isset($_GET['id']);
$row = [];
if ($editing) {
    $userId = $_GET['id'];
    // Öğretmeni getirme işlemi
    $sorgu = "SELECT * FROM ogretmenler WHERE ogretmen_id = '$userId'";
    $sonuc = mysqli_query($baglanti, $sorgu);

    if (mysqli_num_rows($sonuc) > 0) {
        // Düzenleme modunda
        $row = mysqli_fetch_assoc($sonuc);
    } else {
        echo "Kullanıcı bulunamadı.";
    }
}
?>

<body>
    <div class="container py-3">
        <?php
        require_once("navbar.php");
        ?>

        <main>
            <div class="container mt-5">
                <h3><?php echo $editing ? "Öğretmeni Düzenle" : "Yeni Öğretmen Ekle"; ?></h3>
                <form action="process.php" method="POST">
                    <?php if ($editing) : ?>
                        <input type="hidden" name="userId" value="<?php echo $row['ogretmen_id']; ?>">
                    <?php endif; ?>
                    <div class="card p-3">
                        <h5>Öğretmen Detayları</h5>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="adsoyad" class="form-label">Ad Soyad</label>
                                    <input type="text" class="form-control" name="adsoyad" value="<?php echo isset($row['adsoyad']) ? $row['adsoyad'] : ''; ?>" aria-describedby="adsoyadHelp">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>" aria-describedby="emailHelp">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="telefonno" class="form-label">Telefon No</label>
                                    <input type="text" class="form-control" name="telefonno" value="<?php echo isset($row['telefonno']) ? $row['telefonno'] : ''; ?>" aria-describedby="telefonnoHelp">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="dogumyili" class="form-label">Doğum Yılı</label>
                                    <input type="text" class="form-control" name="dogumyili" value="<?php echo isset($row['dogumyili']) ? $row['dogumyili'] : ''; ?>" aria-describedby="dogumyiliHelp">
                                </div>
                            </div>
                        </div>

                        <h5>Hesap Detayları</h5>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="kullaniciadi" class="form-label">Kullanıcı Adı</label>
                                    <input type="text" class="form-control" name="kullaniciadi" value="<?php echo isset($row['kullanici_adi']) ? $row['kullanici_adi'] : ''; ?>" aria-describedby="kullaniciadiHelp">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="sifre" class="form-label">Şifre</label>
                                    <input type="text" class="form-control" name="parola" value="" aria-describedby="sifreHelp">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="btn-container">
                                <button type="submit" name="<?php echo $editing ? 'ogretmenGuncelle' : 'ogretmenekle'; ?>" class="btn btn-primary">Kaydet</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
<?php
require_once("scripts.php");
?>