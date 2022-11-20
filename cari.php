<?php

require 'fungsi.php';

$keyword = $_GET["keyword"];

$produk = cari($keyword);

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
        <a href="index.php"><h1>Kembali</h1></a>
        
        <ul>
            <li><a href="tambah.php">Tambah</a></li>
        </ul>
    </div>

<!--  -->
<div class="kelompok">
    <h1>Pencarian "<?= $keyword ?>"</h1>
    <?php if(empty($produk) ) : ?>
        <h2>Barang Tidak Ditemukan :( </h2>
    <?php endif ; ?>
    <ul class="produk">
            <?php foreach($produk as $produknya) : ?>
            <li>
                <div class="isi">
                    <a href="produk.php?id=<?= $produknya["id"] ?>">
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