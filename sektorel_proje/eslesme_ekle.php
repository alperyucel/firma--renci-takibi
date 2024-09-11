<?php
require_once("header.php");
require_once("baglanti.php");
session_start();
$kullanici_id = isset($_SESSION["kullanici_id"]) ? $_SESSION["kullanici_id"] : 0; // Oturum açan kullanıcının id'sini al

// Eşleşmemiş öğrencileri veritabanından çekme
$ogrenciler = mysqli_query($baglanti, "
    SELECT ogrenci_id, ogrenci_no, adsoyad 
    FROM ogrenciler 
    WHERE ogrenci_id NOT IN (SELECT ogrenci_id FROM eslesmeler)
");
$firmalar = mysqli_query($baglanti, "SELECT firma_id, firma_adi FROM firmalar");
$hamiler = mysqli_query($baglanti, "SELECT hami_id, hami_adsoyad FROM hamiler");
$donemler = mysqli_query($baglanti, "SELECT DISTINCT donem FROM ogrenciler");

// Eğer form gönderildiyse
if(isset($_POST['eslesme_ekle'])){
    // Formdan gelen verileri al
    $ogrenci_id = $_POST['ogrenci_id'];
    $firma_id = $_POST['firma_id'];
    $hami_id = $_POST['hami_id'];
    $donem = $_POST['donem'];
    $notu = $_POST['notu'];

    // Veritabanına ekleme sorgusu
    $sorgu = "INSERT INTO eslesmeler (ogrenci_id, firma_id, hami_id, donem, notu) VALUES ('$ogrenci_id', '$firma_id', '$hami_id', '$donem', '$notu')";

    // Sorguyu çalıştır ve sonucu kontrol et
    if(mysqli_query($baglanti, $sorgu)){
        // Başarılı ekleme mesajı
        header("Location: eslesmeler.php");
        exit();
    } else{
        echo "Hata: " . mysqli_error($baglanti);
    }
}
?>

<body>
    <div class="container py-3">
        <?php require_once("navbar.php"); ?>

        <main>
            <div class="container mt-5">
                <h3>Yeni Eşleşme Ekle</h3>
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
                                            echo "<option value='{$ogrenci['ogrenci_id']}'>{$ogrenci['adsoyad']} ({$ogrenci['ogrenci_no']})</option>";
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
                                            echo "<option value='{$firma['firma_id']}'>{$firma['firma_adi']}</option>";
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
                                            echo "<option value='{$hami['hami_id']}'>{$hami['hami_adsoyad']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="donem" class="form-label">Dönem</label>
                                    <select class="form-select" name="donem" required>
                                        <option value="" disabled selected></option>
                                        <?php
                                        while ($donem = mysqli_fetch_assoc($donemler)) {
                                            echo "<option value='{$donem['donem']}'>{$donem['donem']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="notu" class="form-label">Notu</label>
                                    <input type="text" class="form-control" name="notu" aria-describedby="notuHelp" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="btn-container">
                                <button type="submit" name="eslesme_ekle" class="btn btn-primary">Ekle</button>
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