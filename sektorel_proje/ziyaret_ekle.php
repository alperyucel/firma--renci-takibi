<?php
require_once("header.php");
require_once("baglanti.php");
session_start();
$kullanici_id = isset($_SESSION["kullanici_id"]) ? $_SESSION["kullanici_id"] : 0;

$editing = isset($_GET['id']);
$row = [];
if ($editing) {
    $ziyaretId = $_GET['id'];
    $sorgu = "SELECT * FROM ziyaretler WHERE ziyaret_id = '$ziyaretId'";
    $sonuc = mysqli_query($baglanti, $sorgu);

    if (mysqli_num_rows($sonuc) > 0) {
        $row = mysqli_fetch_assoc($sonuc);
    } else {
        echo "Ziyaret bulunamadı.";
    }
}

// Öğretmen, Öğrenci, Firma ve Hami listelerini getirme
$ogretmenler = mysqli_query($baglanti, "SELECT ogretmen_id, kullanici_adi FROM ogretmenler");
$ogrenciler = mysqli_query($baglanti, "SELECT ogrenci_id, ogrenci_no, adsoyad FROM ogrenciler");
$firmalar = mysqli_query($baglanti, "SELECT firma_id, firma_adi FROM firmalar");
$hamiler = mysqli_query($baglanti, "SELECT hami_id, hami_adsoyad FROM hamiler");
?>

<body>
    <div class="container py-3">
        <?php require_once("navbar.php"); ?>
        <main>
            <div class="container mt-5">
                <h3><?php echo $editing ? "Ziyareti Düzenle" : "Yeni Ziyaret Ekle"; ?></h3>
                <form action="ziyaret_process.php" method="POST">
                    <?php if ($editing) : ?>
                        <input type="hidden" name="ziyaretId" value="<?php echo $row['ziyaret_id']; ?>">
                    <?php endif; ?>
                    <div class="card p-3">
                        <h5>Ziyaret Detayları</h5>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="ogretmen_id" class="form-label">Öğretmen</label>
                                    <select class="form-select" name="ogretmen_id" required>
                                        <option value="" disabled selected></option>
                                        <?php
                                        while ($ogretmen = mysqli_fetch_assoc($ogretmenler)) {
                                            $selected = isset($row['ogretmen_id']) && $row['ogretmen_id'] == $ogretmen['ogretmen_id'] ? 'selected' : '';
                                            echo "<option value='{$ogretmen['ogretmen_id']}' $selected>{$ogretmen['kullanici_adi']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="ogrenci_no" class="form-label">Öğrenci Adı ve Numarası</label>
                                    <select class="form-select" name="ogrenci_no" required>
                                        <option value="" disabled selected></option>
                                        <?php
                                        while ($ogrenci = mysqli_fetch_assoc($ogrenciler)) {
                                            $selected = isset($row['ogrenci_no']) && $row['ogrenci_no'] == $ogrenci['ogrenci_no'] ? 'selected' : '';
                                            echo "<option value='{$ogrenci['ogrenci_no']}' $selected>{$ogrenci['adsoyad']} ({$ogrenci['ogrenci_no']})</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="hami_id" class="form-label">Hami</label>
                                    <select class="form-select" name="hami_id" required>
                                        <option value="" disabled selected></option>
                                        <?php
                                        while ($hami = mysqli_fetch_assoc($hamiler)) {
                                            $selected = isset($row['hami_id']) && $row['hami_id'] == $hami['hami_id'] ? 'selected' : '';
                                            echo "<option value='{$hami['hami_id']}' $selected>{$hami['hami_adsoyad']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="firma_id" class="form-label">Firma</label>
                                    <select class="form-select" name="firma_id" required>
                                        <option value="" disabled selected></option>
                                        <?php
                                        while ($firma = mysqli_fetch_assoc($firmalar)) {
                                            $selected = isset($row['firma_id']) && $row['firma_id'] == $firma['firma_id'] ? 'selected' : '';
                                            echo "<option value='{$firma['firma_id']}' $selected>{$firma['firma_adi']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="ziyaret_turu" class="form-label">Ziyaret Türü</label>
                                    <select class="form-select" id="ziyaret_turu" name="ziyaret_turu" required>
                                        <option value="" disabled selected></option>
                                        <option value="0" <?php echo (isset($row['ziyaret_turu']) && $row['ziyaret_turu'] == 0) ? 'selected' : ''; ?>>Telefon</option>
                                        <option value="1" <?php echo (isset($row['ziyaret_turu']) && $row['ziyaret_turu'] == 1) ? 'selected' : ''; ?>>Yüzyüze</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="ziyaret_tarihi" class="form-label">Ziyaret Tarihi</label>
                                    <input type="date" class="form-control" name="ziyaret_tarihi" value="<?php echo isset($row['ziyaret_tarihi']) ? $row['ziyaret_tarihi'] : ''; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="ziyaret_gorusu" class="form-label">Ziyaret Görüşü</label>
                                    <textarea class="form-control" id="ziyaret_gorusu" name="ziyaret_gorusu" rows="3" required><?php echo isset($row['ziyaret_gorusu']) ? $row['ziyaret_gorusu'] : ''; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="btn-container">
                                <button type="submit" name="<?php echo $editing ? 'ziyaretGuncelle' : 'ziyaretEkle'; ?>" class="btn btn-primary">Kaydet</button>
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