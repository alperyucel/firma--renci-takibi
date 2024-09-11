<?php
require_once("header.php");
require_once("baglanti.php");
session_start();
?>

<body>
    <div class="container py-3">
        <?php require_once("navbar.php"); ?>

        <main>
            <div class="container mt-5">
                <h3>Ziyaretler</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Öğretmen</th>  
                            <th scope="col">Öğrenci No</th>
                            <th scope="col">Hami Adı</th>  
                            <th scope="col">Firma Adı</th>
                            <th scope="col">Ziyaret Türü</th>
                            <th scope="col">Ziyaret Görüşü</th>
                            <th scope="col">Tarih</th>
                            <td>
                                <a href="ziyaret_ekle.php" class="btn btn-success btn-sm">Yeni Ziyaret Ekle</a>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sorgu = "SELECT z.*, o.kullanici_adi AS ogretmen_adi, h.hami_adsoyad, f.firma_adi FROM ziyaretler z 
                                  LEFT JOIN ogretmenler o ON z.ogretmen_id = o.ogretmen_id 
                                  LEFT JOIN hamiler h ON z.hami_id = h.hami_id 
                                  LEFT JOIN firmalar f ON z.firma_id = f.firma_id";  
                        $sonuc = mysqli_query($baglanti, $sorgu);

                        if (mysqli_num_rows($sonuc) > 0) {
                            while ($row = mysqli_fetch_assoc($sonuc)) {
                                $ziyaret_turu = $row['ziyaret_turu'] == 0 ? 'Telefon' : 'Yüzyüze';
                                echo "<tr>";
                                echo "<th scope='row'>" . $row['ziyaret_id'] . "</th>";
                                echo "<td>" . $row['ogretmen_adi'] . "</td>"; 
                                echo "<td>" . $row['ogrenci_no'] . "</td>";
                                echo "<td>" . $row['hami_adsoyad'] . "</td>"; 
                                echo "<td>" . $row['firma_adi'] . "</td>";
                                echo "<td>" . $ziyaret_turu . "</td>";
                                echo "<td>" . $row['ziyaret_gorusu'] . "</td>";
                                echo "<td>" . $row['ziyaret_tarihi'] . "</td>";
                                echo "<td>
                                        <a href='ziyaret_ekle.php?id=" . $row['ziyaret_id'] . "' class='btn btn-primary btn-sm'>Düzenle</a> 
                                        <a href='ziyaret_sil.php?id=" . $row['ziyaret_id'] . "' class='btn btn-danger btn-sm'>Sil</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9'>Veritabanında hiç ziyaret bulunamadı.</td></tr>";
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