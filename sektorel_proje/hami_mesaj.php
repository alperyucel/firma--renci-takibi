<?php
require_once("header.php");
require_once("baglanti.php");
session_start();

// Kullanıcı oturumunu kontrol et
if (!isset($_SESSION["ogretmen_id"])) {
    // Oturum yoksa giriş sayfasına yönlendir
    header("Location: giris.php");
    exit;
}

$ogretmen_id = $_SESSION["ogretmen_id"];
$kullanici_adi = isset($_SESSION["kullanici_adi"]) ? $_SESSION["kullanici_adi"] : "Bilinmiyor";

$hami_id = isset($_GET["id"]) ? $_GET["id"] : null;

if ($hami_id && is_numeric($hami_id)) {
    // Hami bilgilerini getir
    $sorgu = "
        SELECT hamiler.*, firmalar.firma_adi 
        FROM hamiler 
        LEFT JOIN firmalar ON hamiler.firma_id = firmalar.firma_id 
        WHERE hamiler.hami_id = '$hami_id'";
    $sonuc = mysqli_query($baglanti, $sorgu);

    if ($sonuc && mysqli_num_rows($sonuc) > 0) {
        $hami = mysqli_fetch_assoc($sonuc);
    } else {
        echo "Hata: " . $sorgu . "<br>" . mysqli_error($baglanti);
        $hami = null; // Hami bilgisi bulunamazsa null yap
    }

    // Eğer form gönderildiyse mesajı kaydet
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["mesaj"])) {
        $mesaj = $_POST["mesaj"];
        // Mesajı veritabanına ekleme işlemi
        $ekle_sorgusu = "INSERT INTO mesajlar (gonderen_id, alici_id, mesaj, mesaj_tarihi) 
                        VALUES ('$ogretmen_id', '$hami_id', '$mesaj', NOW())";

        $ekle_sonuc = mysqli_query($baglanti, $ekle_sorgusu);

        if (!$ekle_sonuc) {
            echo "Hata: " . $ekle_sorgusu . "<br>" . mysqli_error($baglanti);
        }
    }

    // Mesajları çekme işlemi (yeniden eskiye doğru sıralı)
    $sorgu_mesajlar = "
        SELECT mesajlar.*, ogretmenler.kullanici_adi 
        FROM mesajlar 
        LEFT JOIN ogretmenler ON mesajlar.gonderen_id = ogretmenler.ogretmen_id
        WHERE mesajlar.alici_id = '$hami_id'
        ORDER BY mesajlar.mesaj_tarihi DESC";

    $sonuc_mesajlar = mysqli_query($baglanti, $sorgu_mesajlar);
} else {
    echo "Hata: Hami ID belirtilmedi.";
    $hami = null;
}
?>

<body>
    <div class="container py-3">
        <?php require_once("navbar.php"); ?>
        <main>
            <div class="container mt-5">
                <div class="card mb-3">
                    <div class="card-header">
                        <h4>Hami Bilgileri</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($hami): ?>
                            <p class="text-start"><strong>Hami Adı Soyadı:</strong> <?php echo htmlspecialchars($hami['hami_adsoyad']); ?></p>
                            <p class="text-start"><strong>Telefon Numarası:</strong> <?php echo htmlspecialchars($hami['telefonno']); ?></p>
                            <p class="text-start"><strong>Firma:</strong> <?php echo htmlspecialchars($hami['firma_adi']); ?></p>
                            <p class="text-start"><strong>Hami Değerlendirme Görüşü:</strong> <?php echo htmlspecialchars($hami['hami_degerlendirme']); ?></p>
                        <?php else: ?>
                            <p>Hami bilgisi bulunamadı.</p>
                        <?php endif; ?>
                    </div>
                </div><hr>
                <form action="hami_mesaj.php?id=<?php echo htmlspecialchars($hami_id); ?>" method="POST">
                    <div class="mb-3">
                        <label for="mesaj"><strong><h4>Mesaj Yaz:</h4></strong></label>
                        <textarea class="form-control" id="mesaj" name="mesaj" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Gönder</button>
                </form>

                <h4>Mesajlar</h4>
                <?php
                // Mesajları ekrana yazdırma
                if ($sonuc_mesajlar && mysqli_num_rows($sonuc_mesajlar) > 0) {
                    while ($mesaj = mysqli_fetch_assoc($sonuc_mesajlar)) {
                        echo "<div class='card mb-3 text-start'>";
                        echo "<div class='card-header'><strong>Gönderen:</strong> " . htmlspecialchars($mesaj['kullanici_adi']) . "</div>";
                        echo "<div class='card-body'>";
                        echo "<p class='card-text'>" . htmlspecialchars($mesaj['mesaj']) . "</p>";
                        echo "</div>";
                        echo "<div class='card-footer text-muted'>";
                        echo "<p class='card-text'><strong>Gönderim Tarihi:</strong> " . htmlspecialchars($mesaj['mesaj_tarihi']) . "</p>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Mesaj bulunamadı.</p>";
                }
                ?>
            </div>
        </main>
    </div>
</body>
<?php 
require_once("scripts.php"); 
?>