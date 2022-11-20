<?php

$conn = mysqli_connect('localhost','root','','shop');

function ambil($query){
    global $conn;
    $result = mysqli_query($conn,$query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result) ){
        $rows[] = $row;
    }
    return $rows;
} 

function tambah($tambah){
    global $conn;
    $produk = htmlspecialchars( $tambah["produk"] );
    $harga = htmlspecialchars( $tambah["harga"] );
    $tentang = htmlspecialchars( $tambah["tentang_produk"] );
    $kategori = $tambah["kategori"];
    $id_komen = $tambah["id_komen"];
    $gambar = upload();

    if(!$gambar){
        return false;
    }

    // menambahkan tabel komen
    $komen = "CREATE TABLE komentar_$id_komen(
        id INT PRIMARY KEY AUTO_INCREMENT,
        nama VARCHAR(50),
        komentar VARCHAR(150)
    );";

    mysqli_query($conn,$komen);
    
    // menambahkan isi dari tabel produk
    $data = "INSERT INTO produk VALUES ('$id_komen','$produk','$tentang','$harga','$gambar','$id_komen','$kategori')";
    mysqli_query($conn,$data);


    return mysqli_affected_rows($conn);
};


function upload(){
    $namefile = $_FILES["gambar"]["name"];
    $tmp_name = $_FILES["gambar"]["tmp_name"];
    $error = $_FILES["gambar"]["error"];
    $size = $_FILES["gambar"]["size"];

    // cek web error atau tidak
    if($error === 4){
        echo "<script>
                alert('Error om')
                </script>";
        return false;
    }

    // cek file
    $cek_valid = ["jpg","png","jpeg"];
    // buat misahin
    $cek_gambar = explode('.',$namefile);
    // buat milih nama paling belakang
    $cek_gambar = strtolower(end($cek_gambar) );

    // cek array 
    if(!in_array($cek_gambar,$cek_valid) ){
        echo "<script>
                alert('yehhh buka foto itu mah')
                </script>";
        return false;
    }

    // cek size
    if($size > 10000000){
        echo "<script>
        alert('badagg teuing file naa')
        </script>";
        return false;
    }

    // uniqid digunakan agar nama file tidak sama dengan yang lain
    $namabaru = uniqid();
    $namabaru .= ".";
    $namabaru = $cek_gambar;

    move_uploaded_file($tmp_name,"img/".$namefile);

    return $namefile;

}

function hapus($id){
    global $conn;
    mysqli_query($conn,"DROP TABLE komentar_$id");

    mysqli_query($conn,"DELETE FROM produk WHERE id = $id ");
    return mysqli_affected_rows($conn);
}

function ganti($data){
    global $conn;
    $id = $data["id"];
    $produk = htmlspecialchars( $data["nama"] );
    $harga = htmlspecialchars( $data["harga"] );
    $kategori = $data["kategori"];
    $keterangan = htmlspecialchars( $data["keterangan"] );
    $gambarlama = htmlspecialchars( $data["gambarlama"] );

    if($_FILES["gambar"]["error"] === 4){
        $gambar = $gambarlama;

    }else{
        $gambar = upload();
    }

    $isi = "UPDATE produk SET
            produk = '$produk',
            harga = '$harga',
            keterangan = '$keterangan',
            img = '$gambar',
            kategori = '$kategori'
            WHERE id = $id;
            ";

    mysqli_query($conn,$isi);


    return mysqli_affected_rows($conn);

}

function tambahKomentar($data){
    global $conn;
    $id = $_POST["id"];
    $nama = htmlspecialchars( $data["nama"] );
    $komen = htmlspecialchars( $data["komentar"] );

    $isi = "INSERT INTO komentar_$id VALUES ('','$nama','$komen');";

    mysqli_query($conn,$isi);

    return mysqli_affected_rows($conn);

}

function hapusKomentar($id,$id_komen){
    global $conn;
   
    $isi = "DELETE FROM komentar_$id WHERE id = $id_komen";
    mysqli_query($conn,$isi);

    return mysqli_affected_rows($conn);
}

function editKomentar($data){
    global $conn;
    $id = $data["id"];
    $idkomen = $data["id_komen"];
    $nama = $data["nama"];
    $komentar = $data["komentar"];

    $isi = "UPDATE komentar_$id SET
            nama = '$nama',
            komentar = '$komentar'
            WHERE id = $idkomen;
    ";

    mysqli_query($conn,$isi);

    return mysqli_affected_rows($conn);

}

?>