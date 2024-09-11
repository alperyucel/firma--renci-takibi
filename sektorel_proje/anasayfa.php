<?php
  session_start();
  if(isset($_SESSION["kullanici_adi"]) == false) {
    header("Location: giris.php");
    die();
  }                    
?>

<?php
  require_once("header.php");
?>
<body>
<div class="container py-3">
  <?php
    require_once("navbar.php");
  ?>

  <main>
    <!-- <h1>İçerik buraya gelecek</h1> -->

  </main>
</div>
</body>      
<?php
require_once("scripts.php");
?>