<?php
require_once("header.php");
require_once("baglanti.php");
session_start();
$kullanici_id = isset($_SESSION["kullanici_id"]) ? $_SESSION["kullanici_id"] : 0; // Oturum açan kullanıcının id'sini al

// Öğretmen düzenleme modunda mı?
$editing = isset($_GET['id']);
$row = [];
if ($editing) {
    $hami_id = $_GET['id'];
    // Haminin bilgilerini getirme işlemi
    $sorgu = "SELECT * FROM hamiler WHERE hami_id = '$hami_id'";
    $sonuc = mysqli_query($baglanti, $sorgu);

    if (mysqli_num_rows($sonuc) > 0) {
        // Düzenleme modunda
        $row = mysqli_fetch_assoc($sonuc);
    } else {
        echo "Hami bulunamadı.";
    }
}

// Firmaları getirme işlemi
$firmaSorgu = "SELECT * FROM firmalar";
$firmaSonuc = mysqli_query($baglanti, $firmaSorgu);
?>

<body>
    <div class="container py-3">
        <?php
        require_once("navbar.php");
        ?>

        <main>
            <div class="container mt-5">
                <h3><?php echo $editing ? "Hamiyi Düzenle" : "Yeni Hami Ekle"; ?></h3>
                <form action="hami_islem.php" method="POST">
                    <?php if ($editing) : ?>
                        <input type="hidden" name="hami_id" value="<?php echo $row['hami_id']; ?>">
                    <?php endif; ?>
                    <div class="card p-3">
                        <h5>Hami Detayları</h5>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="hami_adsoyad" class="form-label">İsim Soyisim</label>
                                    <input type="text" class="form-control" name="hami_adsoyad" value="<?php echo isset($row['hami_adsoyad']) ? $row['hami_adsoyad'] : ''; ?>" aria-describedby="hami_adsoyadHelp">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="telefonno" class="form-label">Telefon</label>
                                    <input type="text" class="form-control" name="telefonno" value="<?php echo isset($row['telefonno']) ? $row['telefonno'] : ''; ?>" aria-describedby="telefonnoHelp">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="firma_id" class="form-label">Firma</label>
                                    <select class="form-select" name="firma_id">
                                        <?php
                                        if (mysqli_num_rows($firmaSonuc) > 0) {
                                            while ($firma = mysqli_fetch_assoc($firmaSonuc)) {
                                                echo "<option value='" . $firma['firma_id'] . "'" . (isset($row['firma_id']) && $row['firma_id'] == $firma['firma_id'] ? " selected" : "") . ">" . $firma['firma_adi'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="hami_degerlendirme" class="form-label">Değerlendirme Görüşü</label>
                                    <input type="text" class="form-control" name="hami_degerlendirme" value="<?php echo isset($row['hami_degerlendirme']) ? $row['hami_degerlendirme'] : ''; ?>" aria-describedby="hami_degerlendirmeHelp">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="btn-container">
                                <button type="submit" name="<?php echo $editing ? 'hami_guncelle' : 'hami_ekle'; ?>" class="btn btn-primary">Kaydet</button>
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