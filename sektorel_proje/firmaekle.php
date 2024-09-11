<?php
require_once("header.php");
require_once("baglanti.php");
session_start();
$kullanici_id = isset($_SESSION["kullanici_id"]) ? $_SESSION["kullanici_id"] : 0; // Oturum açan kullanıcının id'sini al

// Firma düzenleme modunda mı?
$editing = isset($_GET['id']);
$row = [];
if ($editing) {
    $firmaId = $_GET['id'];
    // Firmayı getirme işlemi
    $sorgu = "SELECT * FROM firmalar WHERE firma_id = '$firmaId'";
    $sonuc = mysqli_query($baglanti, $sorgu);

    if (mysqli_num_rows($sonuc) > 0) {
        // Düzenleme modunda
        $row = mysqli_fetch_assoc($sonuc);
    } else {
        echo "Firma bulunamadı.";
    }
}
?>

<body>
    <div class="container py-3">
        <?php require_once("navbar.php"); ?>

        <main>
            <div class="container mt-5">
                <h3><?php echo $editing ? "Firmayı Düzenle" : "Yeni Firma Ekle"; ?></h3>
                <form action="firmaguncelle.php" method="POST">
                    <?php if ($editing) : ?>
                        <input type="hidden" name="firmaId" value="<?php echo $row['firma_id']; ?>">
                    <?php endif; ?>
                    <div class="card p-3">
                        <h5>Firma Detayları</h5>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="firma_adi" class="form-label">Firma Adı</label>
                                    <input type="text" class="form-control" name="firma_adi" value="<?php echo isset($row['firma_adi']) ? $row['firma_adi'] : ''; ?>" aria-describedby="firma_adi_help">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="adres" class="form-label">Adres</label>
                                    <input type="text" class="form-control" name="adres" value="<?php echo isset($row['adres']) ? $row['adres'] : ''; ?>" aria-describedby="adres_help">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>" aria-describedby="email_help">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="telefonno" class="form-label">Telefon No</label>
                                    <input type="tel" class="form-control" name="telefonno" value="<?php echo isset($row['telefonno']) ? $row['telefonno'] : ''; ?>" aria-describedby="telefonno_help">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="yetkili_adsoyad" class="form-label">Yetkili Ad-Soyad</label>
                                    <input type="text" class="form-control" name="yetkili_adsoyad" value="<?php echo isset($row['yetkili_adsoyad']) ? $row['yetkili_adsoyad'] : ''; ?>" aria-describedby="yetkili_adsoyad_help">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="kriterler" class="form-label">Kriterler</label>
                                    <select class="form-select" name="kriterler" aria-describedby="kriterler_help">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="btn-container">
                                <button type="submit" name="<?php echo $editing ? 'firmaguncelle' : 'firmaekle'; ?>" class="btn btn-primary"><?php echo $editing ? "Güncelle" : "Ekle"; ?></button>
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