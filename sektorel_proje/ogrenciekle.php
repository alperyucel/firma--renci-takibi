<?php
require_once("header.php");
require_once("baglanti.php");
session_start();
$kullanici_id = isset($_SESSION["kullanici_id"]) ? $_SESSION["kullanici_id"] : 0; // Oturum açan kullanıcının id'sini al

// Düzenleme modunda mı kontrolü
$editing = isset($_GET['id']);
$row = [];
if ($editing) {
    $ogrenciId = $_GET['id'];
    // Öğrenciyi getirme işlemi
    $sorgu = "SELECT * FROM ogrenciler WHERE ogrenci_id = '$ogrenciId'";
    $sonuc = mysqli_query($baglanti, $sorgu);

    if (mysqli_num_rows($sonuc) > 0) {
        // Düzenleme modunda
        $row = mysqli_fetch_assoc($sonuc);
    } else {
        echo "Öğrenci bulunamadı.";
    }
}
?>

<body>
    <div class="container py-3">
        <?php require_once("navbar.php"); ?>

        <main>
            <div class="container mt-5">
                <h3><?php echo $editing ? "Öğrenciyi Düzenle" : "Yeni Öğrenci Ekle"; ?></h3>
                <form action="ogrenciduzenle.php" method="POST">
                    <?php if ($editing) : ?>
                        <input type="hidden" name="ogrenciId" value="<?php echo $row['ogrenci_id']; ?>">
                    <?php endif; ?>
                    <div class="card p-3">
                        <h5>Öğrenci Detayları</h5>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="ogrenci_no" class="form-label">Öğrenci No</label>
                                    <input type="text" class="form-control" name="ogrenci_no" value="<?php echo isset($row['ogrenci_no']) ? $row['ogrenci_no'] : ''; ?>" aria-describedby="ogrenciNoHelp">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="adsoyad" class="form-label">Ad Soyad</label>
                                    <input type="text" class="form-control" name="adsoyad" value="<?php echo isset($row['adsoyad']) ? $row['adsoyad'] : ''; ?>" aria-describedby="adsoyadHelp">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="email" class="form-label">E-posta</label>
                                    <input type="text" class="form-control" name="email" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>" aria-describedby="emailHelp">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="donem" class="form-label">Dönem</label>
                                    <input type="text" class="form-control" name="donem" value="<?php echo isset($row['donem']) ? $row['donem'] : ''; ?>" aria-describedby="donemHelp">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="ogretmen_id" class="form-label">Öğretmen</label>
                                    <select class="form-select" name="ogretmen_id" id="ogretmen_id" required>
                                        <?php
                                        $ogretmen_sorgu = "SELECT * FROM ogretmenler";
                                        $ogretmen_sonuc = mysqli_query($baglanti, $ogretmen_sorgu);
                                        while ($ogretmen_row = mysqli_fetch_assoc($ogretmen_sonuc)) {
                                            $selected = isset($row['ogretmen_id']) && $row['ogretmen_id'] == $ogretmen_row['ogretmen_id'] ? 'selected' : '';
                                            echo "<option value='" . $ogretmen_row['ogretmen_id'] . "' $selected>" . $ogretmen_row['adsoyad'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="btn-container">
                                <button type="submit" name="<?php echo $editing ? 'ogrenciguncelle' : 'ogrenciekle'; ?>" class="btn btn-primary"><?php echo $editing ? "Kaydet" : "Ekle"; ?></button>
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