<?php


require 'fungsi.php';

session_start();

if( !isset($_SESSION["login"]) ){
    $_SESSION["login"] = false;
    $_SESSION["user"] = null;
}



$produk = ambil("SELECT * FROM produk");

$kategori = ambil("SELECT * FROM kategori");

if(isset($_POST["keyword"]) ){
    $keyword = $_POST["keyword"];
    echo "<script>
    document.location.href = 'cari.php?keyword=$keyword';
    </script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>ShopMan</title>
</head>
<body>
    <!-- navbar -->

    <div class="navbar">
        <h1>ShopMan</h1>
        <form action="" method="post">
            <input type="search" name="keyword" id="keyword" placeholder="Cari Barang..." autofocus autocomplete="off">
        </form>
        <ul>
            <?php if($_SESSION["login"] === false) : ?>    
                <li class="login"><a href="login.php">Login</a></li>
            <?php endif ; ?>
            <?php if($_SESSION["login"] === true) : ?>    
                <li class="profil">
                <a href="profil.php?user=<?= $_SESSION["user"] ?>">🙍‍♂️</a>
                <a href="toko.php">🏢</a>
                <a href="keranjang.php">🛒 </a>
                </li>
            <?php endif ; ?>
        </ul>
    </div>

    <!-- main -->

    <div class="kelompok">
        <h1>REKOMENDASI</h1>
        <ul class="produk">
            <?php foreach($produk as $produknya) : ?>
            <li>
                <div class="isi">
                    <a href="produk.php?id=<?= $produknya["id"] ?>">
                        <img src="img/<?= $produknya["img"] ?>">
                        <h4 ><?= $produknya["produk"] ?></h4>
                        <h3>💰 <?= $produknya["harga"] ?></h3>
                    </a>
                </div>
            </li>
            <?php endforeach ; ?>
        </ul>
    </div>

    <!-- kategori -->
    <div class="container">
        <h1>KATEGORI</h1>
        <ul class="isikategori">
            <?php foreach($kategori as $kategorinya) : ?>
            <li><a href="kategori.php?kategori=<?= $kategorinya["kategori"] ?>">
                <div class="tipe">
                    <img src="img_kategori/<?= $kategorinya["img"] ?>.jpg" alt="foto" class="ketegori">
                    <h5><?= $kategorinya["kategori"] ?></h5>
                </div>
                </a>
            </li>
            <?php endforeach ; ?>
        </ul>
    </div>

</body>
</html>