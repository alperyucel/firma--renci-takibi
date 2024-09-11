<?php
require_once("header.php");
require_once("baglanti.php");
session_start();
$kullanici_id = isset($_SESSION["kullanici_id"]) ? $_SESSION["kullanici_id"] : 0; // Oturum açan kullanıcının id'sini al

// Eşleşmeleri getirme işlemi
$sorgu = "SELECT eslesmeler.*, ogrenciler.adsoyad AS ogrenci_ad, firmalar.firma_adi, hamiler.hami_adsoyad 
          FROM eslesmeler 
          INNER JOIN ogrenciler ON eslesmeler.ogrenci_id = ogrenciler.ogrenci_id
          INNER JOIN firmalar ON eslesmeler.firma_id = firmalar.firma_id
          INNER JOIN hamiler ON eslesmeler.hami_id = hamiler.hami_id";
$sonuc = mysqli_query($baglanti, $sorgu);

?>

<body>
    <div class="container py-3">
        <?php require_once("navbar.php"); ?>

        <main>
            <div class="container mt-5">
                <h3>Eşleşmeler</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Öğrenci Adı</th>
                            <th scope="col">Firma Adı</th>
                            <th scope="col">Hami Ad Soyad</th>
                            <th scope="col">Dönem</th>
                            <th scope="col">Not</th>
                            <td>
                                <a href="eslesme_ekle.php" class="btn btn-success btn-sm">Eşleşme Ekle</a>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($sonuc) > 0) {
                            while ($row = mysqli_fetch_assoc($sonuc)) {
                                echo "<tr>";
                                echo "<th scope='row'>" . $row['eslesme_id'] . "</th>";
                                echo "<td>" . $row['ogrenci_ad'] . "</td>";
                                echo "<td>" . $row['firma_adi'] . "</td>";
                                echo "<td>" . $row['hami_adsoyad'] . "</td>";
                                echo "<td>" . $row['donem'] . "</td>";
                                echo "<td>" . $row['notu'] . "</td>";
                                echo "<td>
                                        <a href='eslesme_duzenle.php?id=" . $row['eslesme_id'] . "' class='btn btn-primary btn-sm'>Düzenle</a> 
                                        <a href='eslesme_sil.php?id=" . $row['eslesme_id'] . "' class='btn btn-danger btn-sm'>Sil</a>            
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Eşleşme bulunamadı.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
<?php 
require_once("scripts.php"); 
?>