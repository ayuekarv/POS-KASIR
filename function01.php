<?php

session_start();


//Bikin Koneksi
$conn = mysqli_connect('localhost', 'root', '', 'pos-kasir');


if (isset($_POST['tambah'])) {
    $kode_barang    = $_POST['kode_barang'];
    $barcode        = $_POST['barcode'];
    $namaproduk     = $_POST['namaproduk'];
    $idsuplier      = $_POST['id_suplier'];
    $hargaawal      = $_POST['hargaawal'];
    $hargajual      = $_POST['hargajual'];
    $stok           = $_POST['stok'];

    $insert = mysqli_query($conn, "INSERT INTO barang (kode_barang,barcode,namaproduk,id_suplier,hargaawal,hargajual,stok) VALUES
    ('$kode_barang','$barcode','$namaproduk','$idsuplier','$hargaawal','$hargajual','$stok')");

    if ($insert) {
        header('location:stock01.php');
    } else {
        echo '
        <script>alert("Gagal menambah barang baru");
        window.location.href="stock01.php"
        </script>
        ';
    }
}

//Menambah barang masuk
if (isset($_POST['barangmasuk'])) {
    $kode_barang = $_POST['kode_barang'];
    $qty         = $_POST['qty'];

    //cari tau stok sekarang berapa
    $caristok = mysqli_query($conn, "SELECT * FROM barang WHERE kode_barang='$kode_barang'");
    $caristok2 = mysqli_fetch_array($caristok);
    $stoksekarang = $caristok2['stok'];

    //hitung
    $newstok = $stoksekarang + $qty;

    $insertmasuk = mysqli_query($conn, "INSERT INTO masuk (kode_barang,qty) VALUES ('$kode_barang','$qty')");
    $updatemasuk = mysqli_query($conn, "UPDATE barang SET stok='$newstok' WHERE kode_barang='$kode_barang'");

    if ($insertmasuk && $updatemasuk) {
        header('location:masuk01.php');
    } else {
        echo '
            <script>alert("Gagal");
            window.location.href="masuk01.php"
            </script>
            ';
    }
}

//Edit barang
if (isset($_POST['editbarang'])) {
    $nama_suplier = $_POST['nama_suplier'];
    $np = $_POST['namaproduk'];
    $stok = $_POST['stok'];
    $hargaawal = $_POST['hargaawal'];
    $hargajual = $_POST['hargajual'];
    $idp = $_POST['idp']; //id produk

    $query = mysqli_query($conn, "UPDATE barang SET namaproduk='$np', stok='$stok', hargaawal='$hargaawal', hargajual='$hargajual' WHERE kode_barang='$idp'");

    if ($query) {
        header('location:stock01.php');
    } else {
        echo '
        <script>alert("Gagal mengedit barang");
        window.location.href="stock01.php"
        </script>
        ';
    }
}

//Hapus Barang
if (isset($_POST['hapusbarang'])) {
    $idp = $_POST['idp'];

    $query = mysqli_query($conn, "DELETE FROM barang WHERE kode_barang='$idp'");

    if ($query) {
        header('location:stock01.php');
    } else {
        echo '
        <script>alert("Gagal mengapus barang");
        window.location.href="stock01.php"
        </script>
        ';
    }
}

//Edit barang masuk
if (isset($_POST['editmasuk'])) {
    $qty = $_POST['qty'];
    $idm = $_POST['idm']; //id masuk
    $idp = $_POST['idp']; //id produk

    //cari tau sekarang qty berapa
    $caritau = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    $caritau2 = mysqli_fetch_array($caritau);
    $qtysekarang = $caritau2['qty'];

    //cari tau stok sekarang berapa
    $caristok = mysqli_query($conn, "select * from barang where kode_barang='$idp'");
    $caristok2 = mysqli_fetch_array($caristok);
    $stoksekarang = $caristok2['stok'];

    if ($qty >= $qtysekarang) {
        //kalau inputan user lebih besar daripada qty yang tercatat sekarang
        //hitung selisih
        $selisih = $qty - $qtysekarang;
        $newstok = $stoksekarang + $selisih;


        $query1 = mysqli_query($conn, "update masuk set qty='$qty' where idmasuk='$idm'");
        $query2 = mysqli_query($conn, "update barang set stok='$newstok' where kode_barang='$idp'");

        if ($query1 && $query2) {
            header('location:masuk01.php');
        } else {
            echo '
            <script>alert("Gagal mengedit barang");
            window.location.href="masuk01.php"
            </script>
            ';
        }
    } else {
        //kalau lebih kecil
        //hitung selisih
        $selisih = $qtysekarang - $qty;
        $newstok = $stoksekarang - $selisih;

        $query1 = mysqli_query($conn, "update masuk set qty='$qty' where idmasuk='$idm'");
        $query2 = mysqli_query($conn, "update produk set stok='$newstok' where idproduk='$idp'");

        if ($query1 && $query2) {
            header('location:masuk01.php');
        } else {
            echo '
            <script>alert("Gagal mengedit barang");
            window.location.href="masuk01.php"
            </script>
            ';
        }
    }
}

//Hapus Barang Masuk
if (isset($_POST['hapusmasuk'])) {
    $idm = $_POST['idm'];
    $idp = $_POST['idp'];

    //cari tau sekarang qty berapa
    $caritau = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    $caritau2 = mysqli_fetch_array($caritau);
    $qtysekarang = $caritau2['qty'];

    //cari tau stok sekarang berapa
    $caristok = mysqli_query($conn, "select * from barang where kode_barang='$idp'");
    $caristok2 = mysqli_fetch_array($caristok);
    $stoksekarang = $caristok2['stok'];

    //hitung selisih
    $newstok = $stoksekarang - $qtysekarang;

    $query1 = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");
    $query2 = mysqli_query($conn, "update barang set stok='$newstok' where kode_barang='$idp'");

    if ($query1 && $query2) {
        header('location:masuk01.php');
    } else {
        echo '
            <script>alert("Gagal mengedit barang");
            window.location.href="masuk01.php"
            </script>
            ';
    }

    $query = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");

    if ($query) {
        header('location:masuk01.php');
    } else {
        echo '
        <script>alert("Gagal mengapus barang");
        window.location.href="masuk01.php"
        </script>
        ';
    }
}


//menambah admin baru
if (isset($_POST['tambahuser'])) {
    $namaadmin  = $_POST['namaadmin'];
    $email      = $_POST['email'];
    $username   = $_POST['username'];
    $password   = $_POST['password'];
    $notelp     = $_POST['notelp'];
    $level        = $_POST['level'];

    $queryinsert = mysqli_query($conn, "insert into  user(namaadmin, email, username, password, notelp, level) 
    values ('$namaadmin', '$email', '$username','$password', '$notelp', '$level')");

    if ($queryinsert) {
        //if berhasil
        header('location:admin.php');
    } else {
        //kalau gagal insert ke db
        header('location:admin.php');
    }
}

//edit data admin
if (isset($_POST['editadmin'])) {
    $namaadmin  = $_POST['namaadmin'];
    $email      = $_POST['email'];
    $username   = $_POST['username'];
    $password   = $_POST['password'];
    $notelp     = $_POST['notelp'];
    $iduser     = $_POST['iduser'];
    $level      = $_POST['level'];

    $queryupdate    = mysqli_query($conn, "update user set namaadmin='$namaadmin', email='$email', username='$username', password='$password', notelp='$notelp', level='$level' where iduser='$iduser'");

    if ($queryupdate) {
        //if berhasil
        header('location:admin.php');
    } else {
        //kalau gagal insert ke db
        header('location:admin.php');
    }
}

//hapus admin
if (isset($_POST['hapusadmin'])) {
    $iduser = $_POST['iduser'];

    $querydelete = mysqli_query($conn, "delete from user where iduser='$iduser'");

    if ($querydelete) {
        //if berhasil
        header('location:admin.php');
    } else {
        //kalau gagal insert ke db
        header('location:admin.php');
    }
}

//Tambah Suplier
if (isset($_POST['tambahsuplier'])) {
    $nama_suplier = $_POST['nama_suplier'];
    $telpon = $_POST['telpon'];
    $deskripsi = $_POST['deskripsi'];
    $alamat = $_POST['alamat'];

    $input_suplier = mysqli_query($conn, "insert into suplier (nama_suplier,telpon,deskripsi,alamat) values 
    ('$nama_suplier','$telpon','$deskripsi','$alamat')");

    if ($input_suplier) {
        header('location:suplier.php');
    } else {
        echo '
        <script>alert("Gagal menambah supplier");
        window.location.href="suplier.php"
        </script>
        ';
    }
}

//Edit Supplier

if (isset($_POST['editsuplier'])) {
    $ns = $_POST['nama_suplier'];
    $telp = $_POST['telpon'];
    $deskripsi = $_POST['deskripsi'];
    $id_s = $_POST['id_suplier']; //id supplier

    $query = mysqli_query($conn, "update suplier set nama_suplier='$ns', telpon='$telp', deskripsi='$deskripsi' where id_suplier='$id_s'");

    if ($query) {
        header('location:suplier.php');
    } else {
        echo '
        <script>alert("Gagal mengedit supplier");
        window.location.href="suplier.php"
        </script>
        ';
    }
}

//Hapus Supplier
if (isset($_POST['hapussuplier'])) {
    $idsup = $_POST['ids'];

    $query = mysqli_query($conn, "delete from suplier where id_suplier='$idsup'");

    if ($query) {
        header('location:suplier.php');
    } else {
        echo '
        <script>alert("Gagal mengapus supplier");
        window.location.href="suplier.php"
        </script>
        ';
    }
}
