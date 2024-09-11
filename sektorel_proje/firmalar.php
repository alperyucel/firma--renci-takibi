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
                <h3>Firmalar</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Firma Adı</th>
                            <th scope="col">Adres</th>
                            <th scope="col">E-posta</th>
                            <th scope="col">Telefon No</th>
                            <th scope="col">Yetkili Adı Soyadı</th>
                            <th scope="col">Kriterler</th>
                            <td>
                                <a href="firmaekle.php" class="btn btn-success btn-sm">Yeni Firma Ekle</a>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once("baglanti.php");

                        $sorgu = "SELECT * FROM firmalar";
                        $sonuc = mysqli_query($baglanti, $sorgu);

                        if (mysqli_num_rows($sonuc) > 0) {
                            while ($row = mysqli_fetch_assoc($sonuc)) {
                                echo "<tr>";
                                echo "<th scope='row'>" . $row['firma_id'] . "</th>";
                                echo "<td>" . $row['firma_adi'] . "</td>";
                                echo "<td>" . $row['adres'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['telefonno'] . "</td>";
                                echo "<td>" . $row['yetkili_adsoyad'] . "</td>";
                                echo "<td>" . $row['kriterler'] . "</td>";
                                echo "<td>
                                        <a href='firmaekle.php?id=" . $row['firma_id'] . "' class='btn btn-primary btn-sm'>Düzenle</a> 
                                        <a href='firma_sil.php?id=" . $row['firma_id'] . "' class='btn btn-danger btn-sm'>Sil</a>            
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Veritabanında hiç firma bulunamadı.</td></tr>";
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