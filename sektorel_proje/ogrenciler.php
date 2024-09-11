<?php
require_once("header.php");
session_start();
$kullanici_id = isset($_SESSION["kullanici_id"]) ? $_SESSION["kullanici_id"] : 0; // Oturum açan kullanıcının id'sini al
?>

<body>
    <div class="container py-3">
        <?php
        require_once("navbar.php");
        ?>

        <main>
            <div class="container mt-5">
                <h3>Öğrenciler</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Öğrenci No</th>
                            <th scope="col">Ad Soyad</th>
                            <th scope="col">E-posta</th>
                            <th scope="col">Dönem</th>
                            <th scope="col">Öğretmen</th>
                            <td>
                                <a href="ogrenciekle.php" class="btn btn-success btn-sm">Öğrenci Ekle</a>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once("baglanti.php");

                        $sorgu = "SELECT o.*, g.adsoyad as ogretmen_adsoyad FROM ogrenciler o LEFT JOIN ogretmenler g ON o.ogretmen_id = g.ogretmen_id";
                        $sonuc = mysqli_query($baglanti, $sorgu);

                        if (mysqli_num_rows($sonuc) > 0) {
                            while ($row = mysqli_fetch_assoc($sonuc)) {
                                echo "<tr>";
                                echo "<th scope='row'>" . $row['ogrenci_id'] . "</th>";
                                echo "<td>" . $row['ogrenci_no'] . "</td>";
                                echo "<td>" . $row['adsoyad'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['donem'] . "</td>";
                                echo "<td>" . $row['ogretmen_adsoyad'] . "</td>";
                                echo "<td>
                                        <a href='ogrenciekle.php?id=" . $row['ogrenci_id'] . "' class='btn btn-primary btn-sm'>Düzenle</a> 
                                        <a href='ogrencisil.php?id=" . $row['ogrenci_id'] . "' class='btn btn-danger btn-sm'>Sil</a>            
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Veritabanında hiç öğrenci bulunamadı.</td></tr>";
                        }

                        mysqli_close($baglanti);
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