<?php
require_once("header.php");
require_once("baglanti.php");
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
                <h3>Hamiler</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">İsim Soyisim</th>
                            <th scope="col">Telefon</th>
                            <th scope="col">Firma</th>
                            <th scope="col">Değerlendirme Görüşü</th>
                            <td>
                                <a href="hami_ekle.php" class="btn btn-success btn-sm">Yeni Hami Ekle</a>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sorgu = "SELECT h.hami_id, h.hami_adsoyad, h.telefonno, f.firma_adi, h.hami_degerlendirme 
                                  FROM hamiler h 
                                  LEFT JOIN firmalar f ON h.firma_id = f.firma_id";
                        $sonuc = mysqli_query($baglanti, $sorgu);

                        if (mysqli_num_rows($sonuc) > 0) {
                            while ($row = mysqli_fetch_assoc($sonuc)) {
                                echo "<tr>";
                                echo "<th scope='row'>" . $row['hami_id'] . "</th>";
                                echo "<td>" . $row['hami_adsoyad'] . "</td>";
                                echo "<td>" . $row['telefonno'] . "</td>";
                                echo "<td>" . $row['firma_adi'] . "</td>";
                                echo "<td>" . $row['hami_degerlendirme'] . "</td>";
                                echo "<td>
                                        <a href='hami_ekle.php?id=" . $row['hami_id'] . "' class='btn btn-primary btn-sm'>Düzenle</a> 
                                        <a href='hami_sil.php?id=" . $row['hami_id'] . "' class='btn btn-danger btn-sm'>Sil</a>
                                        <a href='hami_mesaj.php?id=" . $row['hami_id'] . "' class='btn btn-info btn-sm'>Mesaj</a>            
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Veritabanında hiç hami bulunamadı.</td></tr>";
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