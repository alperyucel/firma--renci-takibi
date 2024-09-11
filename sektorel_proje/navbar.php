<header>
    <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
      <a href="anasayfa.php" class="fs-4 text-decoration-none text-dark">STAJ TAKİP</a>

      <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
        <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="ogrenciler.php">Öğrenciler</a>
        <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="firmalar.php">Firmalar</a>
        <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="ogretmenler.php">Öğretmenler</a>
        <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="hamiler.php">Hamiler</a>
        <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="eslesmeler.php">Eşleşmeler</a>
        <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="ziyaretler.php">Ziyaretler</a>
        <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="cikis.php">Çıkış Yap</a>
      </nav>
      
                 <?php
                 $kullanici_adi = isset($_SESSION["kullanici_adi"]) ? $_SESSION["kullanici_adi"] : "";
                 if (!empty($kullanici_adi)) {
                     echo  "<span class='me-3 py-2' style='color: blue;'>(Kullanıcı: $kullanici_adi)</span>";
                 }
                 ?>
    </div>
</header>