<?php
require_once("header.php");
require_once("baglanti.php");
session_start();
$kullanici_id = isset($_SESSION["kullanici_id"]) ? $_SESSION["kullanici_id"] : 0; // Oturum açan kullanıcının id'sini al

// Eşleşme ID'sini al
if (isset($_GET['id'])) {
    $eslesme_id = $_GET['id'];

    // Mevcut eşleşmeyi veritabanından al
    $sorgu = "SELECT * FROM eslesmeler WHERE eslesme_id = '$eslesme_id'";
    $sonuc = mysqli_query($baglanti, $sorgu);
    $eslesme = mysqli_fetch_assoc($sonuc);

    // Öğrenci, firma ve hami bilgilerini veritabanından çekme
    $ogrenciler = mysqli_query($baglanti, "SELECT ogrenci_id, ogrenci_no, adsoyad FROM ogrenciler");
    $firmalar = mysqli_query($baglanti, "SELECT firma_id, firma_adi FROM firmalar");
    $hamiler = mysqli_query($baglanti, "SELECT hami_id, hami_adsoyad FROM hamiler");

    // Eğer form gönderildiyse
    if(isset($_POST['eslesme_guncelle'])){
        // Formdan gelen verileri al
        $ogrenci_id = $_POST['ogrenci_id'];
        $firma_id = $_POST['firma_id'];
        $hami_id = $_POST['hami_id'];
        $donem = $_POST['donem'];
        $notu = $_POST['notu'];

        // Veritabanına güncelleme sorgusu
        $sorgu = "UPDATE eslesmeler SET ogrenci_id='$ogrenci_id', firma_id='$firma_id', hami_id='$hami_id', donem='$donem', notu='$notu' WHERE eslesme_id='$eslesme_id'";

        // Sorguyu çalıştır ve sonucu kontrol et
        if(mysqli_query($baglanti, $sorgu)){
            // Başarılı güncelleme mesajı
            header("Location: eslesmeler.php");
            exit();
        } else{
            echo "Hata: " . mysqli_error($baglanti);
        }
    }
} else {
    header("Location: eslesmeler.php");
    exit();
}
?>

<body>
    <div class="container py-3">
        <?php require_once("navbar.php"); ?>

        <main>
            <div class="container mt-5">
                <h3>Eşleşmeyi Düzenle</h3>
                <form action="" method="POST">
                    <div class="card p-3">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="ogrenci_id" class="form-label">Öğrenci</label>
                                    <select class="form-select" name="ogrenci_id" required>
                                        <option value="" disabled selected></option>
                                        <?php
                                        while ($ogrenci = mysqli_fetch_assoc($ogrenciler)) {
                                            $selected = ($ogrenci['ogrenci_id'] == $eslesme['ogrenci_id']) ? 'selected' : '';
                                            echo "<option value='{$ogrenci['ogrenci_id']}' $selected>{$ogrenci['adsoyad']} ({$ogrenci['ogrenci_no']})</option>";
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
                                            $selected = ($firma['firma_id'] == $eslesme['firma_id']) ? 'selected' : '';
                                            echo "<option value='{$firma['firma_id']}' $selected>{$firma['firma_adi']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="hami_id" class="form-label">Hami</label>
                                    <select class="form-select" name="hami_id" required>
                                        <option value="" disabled selected></option>
                                        <?php
                                        while ($hami = mysqli_fetch_assoc($hamiler)) {
                                            $selected = ($hami['hami_id'] == $eslesme['hami_id']) ? 'selected' : '';
                                            echo "<option value='{$hami['hami_id']}' $selected>{$hami['hami_adsoyad']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="donem" class="form-label">Dönem</label>
                                    <input type="text" class="form-control" name="donem" aria-describedby="donemHelp" value="<?php echo $eslesme['donem']; ?>" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="notu" class="form-label">Notu</label>
                                    <input type="text" class="form-control" name="notu" aria-describedby="notuHelp" value="<?php echo $eslesme['notu']; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="btn-container">
                                <button type="submit" name="eslesme_guncelle" class="btn btn-primary">Güncelle</button>
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