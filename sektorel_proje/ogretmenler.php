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
                <h3>Öğretmenler</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Kullanıcı Adı</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Ad Soyad</th>
                            <th scope="col">Telefon No</th>
                            <th scope="col">Doğum Yılı</th>
                            <th scope="col">TC Kimlik No</th>
                            <td>
                              <a href="ogretmenekle.php" type="button" class="btn btn-success btn-sm">Öğretmen Ekle</a>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once("baglanti.php");

                        $sorgu = "SELECT * FROM ogretmenler";
                        $sonuc = mysqli_query($baglanti, $sorgu);

                        if (mysqli_num_rows($sonuc) > 0) {
                            while ($row = mysqli_fetch_assoc($sonuc)) {
                                echo "<tr>";
                                echo "<th scope='row'>" . $row['ogretmen_id'] . "</th>";
                                echo "<td>" . $row['kullanici_adi'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['adsoyad'] . "</td>";
                                echo "<td>" . $row['telefonno'] . "</td>";
                                echo "<td>" . $row['dogumyili'] . "</td>";
                                echo "<td>" . $row['tc_kimlik_no'] . "</td>";
                                echo "<td>
                                        <a href='ogretmenekle.php?id=" . $row['ogretmen_id'] . "' class='btn btn-primary btn-sm'>Düzenle</a> 
                                        <a href='ogretmensil.php?id=" . $row['ogretmen_id'] . "' class='btn btn-danger btn-sm'>Sil</a>            
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>Veritabanında hiç öğretmen bulunamadı.</td></tr>";
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