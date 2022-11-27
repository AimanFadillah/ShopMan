<?php

require 'fungsi.php';
session_start();

if( !isset($_SESSION["login"]) ){
    $_SESSION["login"] = false;
}



$nama = $_GET["nama"];

// KEAMANAN JIKA ADA YANG NGUTAK ATIK ID
if($_SESSION["login"] === true){
    $nama = $_GET["nama"];
    $user = ambil("SELECT * FROM user WHERE id = $nama ");
    if(empty($user) ){
        echo "<script>
        document.location.href = 'logout.php';
        </script>";
    }
}


$kategori = $_GET["kategori"];

$produk = ambil("SELECT * FROM produk WHERE kategori like '%$kategori%' ");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/kategori.css">
    <title>Kategori</title>
</head>
<body>

<!-- navbar -->
<div class="navbar">
        <a href="index.php?nama=<?= $nama ?>"><h1>Kembali</h1></a>
        
        <ul>
            <?php if($_SESSION["login"] === false) : ?>    
                <li class="login"><a href="login.php">Login</a></li>
            <?php endif ; ?>
            <?php if($_SESSION["login"] === true) : ?>    
                <li class="tambah"><a href="tambah.php">Tambah</a></li>
            <?php endif ; ?>
           
        </ul>
    </div>

<!--  -->
<div class="kelompok">
    <h1><?= $kategori ?></h1>
    <?php if(empty($produk) ) : ?>
        <h2>Barang Tidak Ada :( </h2>
    <?php endif ; ?>
    <ul class="produk">
            <?php foreach($produk as $produknya) : ?>
            <li>
                <div class="isi">
                    <a href="produk.php?id=<?= $produknya["id"] ?>&nama=<?= $nama ?>">
                        <img src="img/<?= $produknya["img"] ?>">
                        <h4 ><?= $produknya["produk"] ?></h4>
                        <h3>Rp.<?= $produknya["harga"] ?></h3>
                    </a>
                </div>
            </li>
            <?php endforeach ; ?>
        </ul>
</div>
    
</body>
</html>