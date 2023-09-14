<?php

// session_start();


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
        header('location:stock02.php');
    } else {
        echo '
        <script>alert("Gagal menambah barang baru");
        window.location.href="stock02.php"
        </script>
        ';
    }
}

//Tambah Pelanggan
if (isset($_POST['tambahpelanggan'])) {
    $namapelanggan = $_POST['namapelanggan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];

    $insert = mysqli_query($conn, "insert into pelanggan (namapelanggan,notelp,alamat) values 
    ('$namapelanggan','$notelp','$alamat')");

    if ($insert) {
        header('location:pelanggan.php');
    } else {
        echo '
        <script>alert("Gagal menambah pelanggan baru");
        window.location.href="pelanggan.php"
        </script>
        ';
    }
}

//Tambah Pesanan
if (isset($_POST['tambahpesanan'])) {
    $idpelanggan = $_POST['idpelanggan'];

    $insert = mysqli_query($conn, "insert into pesanan (idpelanggan) values ('$idpelanggan')");

    if ($insert) {
        header('location:order.php');
    } else {
        echo '
        <script>alert("Gagal menambah pesanan baru");
        window.location.href="order.php"
        </script>
        ';
    }
}

//produk dipilih di pesanan
if (isset($_POST['addproduk'])) {
    $kode_barang = $_POST['kode_barang'];
    $idp = $_POST['idp'];   //idpesanan
    $qty = $_POST['qty'];   //jumlah

    //hitung stok sekarang ada berapa
    $hitung1 = mysqli_query($conn, "select * from barang where kode_barang='$kode_barang'");
    $hitung2 = mysqli_fetch_array($hitung1);
    $stoksekarang = $hitung2['stok']; //stok barang saat ini

    if ($stoksekarang >= $qty) {
        //kurangi stoknya dengan jumlah yang akan dikeluarkan
        $selisih = $stoksekarang - $qty;

        //stoknya cukup
        $insert = mysqli_query($conn, "insert into detailpesanan (idpesanan,kode_barang,qty) values ('$idp','$kode_barang','$qty')");
        $update = mysqli_query($conn, "update barang set stok='$selisih' where kode_barang='$kode_barang'");

        if ($insert && $update) {
            header('location:view.php?idp=' . $idp);
        } else {
            echo '
            <script>alert("Gagal menambah pesanan baru");
            window.location.href="view.php?idp=' . $idp . '"
            </script>
            ';
        }
    } else {
        //stok ga cukup
        echo '
        <script>alert("Stock barang tidak cukup");
        window.location.href="view.php?idp=' . $idp . '"
        </script>
        ';
    }
}

//Menambah barang masuk
if (isset($_POST['barangmasuk'])) {
    $kode_barang = $_POST['kode_barang'];
    $qty = $_POST['qty'];

    //cari tau stok sekarang berapa
    $caristok = mysqli_query($conn, "select * from barang where kode_barang='$kode_barang'");
    $caristok2 = mysqli_fetch_array($caristok);
    $stoksekarang = $caristok2['stok'];

    //hitung
    $newstok = $stoksekarang + $qty;

    $insertmasuk = mysqli_query($conn, "insert into masuk (kode_barang,qty) values ('$kode_barang','$qty')");
    $updatemasuk = mysqli_query($conn, "update barang set stok='$newstok' where kode_barang='$kode_barang'");

    if ($insertmasuk && $updatemasuk) {
        header('location:masuk02.php');
    } else {
        echo '
            <script>alert("Gagal");
            window.location.href="masuk02.php"
            </script>
            ';
    }
}

//Hapus produk pesanan
if (isset($_POST['hapusprodukpesanan'])) {
    $iddp = $_POST['iddp'];  //id detail pesanan
    $idpr = $_POST['idpr'];  //id produk
    $idps = $_POST['idpesanan'];  //id produk

    //cek qty sekarang
    $cek1 = mysqli_query($conn, "select * from detailpesanan where iddetailpesanan='$iddp'");
    $cek2 = mysqli_fetch_array($cek1);
    $qtysekarang = $cek2['qty'];

    //Cek stok sekarang
    $cek3 = mysqli_query($conn, "select * from produk where idproduk='$idpr'");
    $cek4 = mysqli_fetch_array($cek3);
    $stoksekarang = $cek4['stok'];

    $hitung = $stoksekarang + $qtysekarang;

    $update = mysqli_query($conn, "update produk set stok='$hitung' where idproduk='$idpr'"); //update stok
    $hapus = mysqli_query($conn, "delete from detailpesanan where idproduk='$idpr' and iddetailpesanan='$iddp'");

    if ($update && $hapus) {
        header('location:view.php?idp=' . $idps);
    } else {
        echo '
        <script>alert("Gagal menghapus barang");
        window.location.href="view.php?idp=' . $idps . '"
        </script>
        ';
    }
}

//Edit barang

if (isset($_POST['editbarang'])) {
    $kode_barang = ['kode_barang'];
    $np = $_POST['namaproduk'];
    $stok = $_POST['stok'];
    $hargaawal = $_POST['hargaawal'];
    $hargajual = $_POST['hargajual'];
    $idp = $_POST['idp']; //id produk

    $query = mysqli_query($conn, "update barang set kode_barang='$kode_barang', namaproduk='$np', stok='$stok', hargaawal='$hargaawal', hargajual='$hargajual' where kode_barang='$idp'");

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

    $query = mysqli_query($conn, "delete from barang where kode_barang='$idp'");

    if ($query) {
        header('location:stock02.php');
    } else {
        echo '
        <script>alert("Gagal mengapus barang");
        window.location.href="stock02.php"
        </script>
        ';
    }
}

//Edit Pelanggan

if (isset($_POST['editpelanggan'])) {
    $npl = $_POST['namapelanggan'];
    $no = $_POST['notelp'];
    $a = $_POST['alamat'];
    $idpl = $_POST['idpl'];

    $query = mysqli_query($conn, "update pelanggan set namapelanggan='$npl', 
    notelp='$no', alamat='$a' where idpelanggan='$idpl'");

    if ($query) {
        header('location:pelanggan.php');
    } else {
        echo '
        <script>alert("Gagal mengubah pelanggan");
        window.location.href="pelanggan.php"
        </script>
        ';
    }
}

//Hapus Pelanggan

if (isset($_POST['hapuspelanggan'])) {
    $idpl = $_POST['idpl'];

    $query = mysqli_query($conn, "delete from pelanggan where idpelanggan='$idpl'");

    if ($query) {
        header('location:pelanggan.php');
    } else {
        echo '
        <script>alert("Gagal mengapus pelanggan");
        window.location.href="pelanggan.php"
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
    $caristok = mysqli_query($conn, "select * from produk where idproduk='$idp'");
    $caristok2 = mysqli_fetch_array($caristok);
    $stoksekarang = $caristok2['stok'];

    if ($qty >= $qtysekarang) {
        //kalau inputan user lebih besar daripada qty yang tercatat sekarang
        //hitung selisih
        $selisih = $qty - $qtysekarang;
        $newstok = $stoksekarang + $selisih;


        $query1 = mysqli_query($conn, "update masuk set qty='$qty' where idmasuk='$idm'");
        $query2 = mysqli_query($conn, "update produk set stok='$newstok' where idproduk='$idp'");

        if ($query1 && $query2) {
            header('location:masuk02.php');
        } else {
            echo '
            <script>alert("Gagal mengedit barang");
            window.location.href="masuk02.php"
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
            header('location:masuk02.php');
        } else {
            echo '
            <script>alert("Gagal mengedit barang");
            window.location.href="masuk02.php"
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
    $caristok = mysqli_query($conn, "select * from produk where idproduk='$idp'");
    $caristok2 = mysqli_fetch_array($caristok);
    $stoksekarang = $caristok2['stok'];

    //hitung selisih
    $newstok = $stoksekarang - $qtysekarang;

    $query1 = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");
    $query2 = mysqli_query($conn, "update produk set stok='$newstok' where idproduk='$idp'");

    if ($query1 && $query2) {
        header('location:masuk02.php');
    } else {
        echo '
            <script>alert("Gagal mengedit barang");
            window.location.href="masuk02.php"
            </script>
            ';
    }

    $query = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");

    if ($query) {
        header('location:masuk02.php');
    } else {
        echo '
        <script>alert("Gagal mengapus barang");
        window.location.href="masuk02.php"
        </script>
        ';
    }
}

//Hapus Order
if (isset($_POST['hapusorder'])) {
    $idps = $_POST['idps']; //id pesanan

    $cekdata = mysqli_query($conn, "select * from detailpesanan dp where idpesanan='$idps'");

    while ($ok = mysqli_fetch_array($cekdata)) {
        //balikin stok
        $qty = $ok['qty'];
        $idproduk = $ok['idproduk'];
        $iddp = $_ok['iddetailpesanan'];  //id detail pesanan

        //cari tau stok sekarang berapa
        $caristok = mysqli_query($conn, "select * from produk where idproduk='$idproduk'");
        $caristok2 = mysqli_fetch_array($caristok);
        $stoksekarang = $caristok2['stok'];

        $newstok = $stoksekarang + $qty;

        $queryupdate = mysqli_query($conn, "update produk set stok='$newstok' where idproduk='$idproduk'");

        //hapuss data
        $queryhapus = mysqli_query($conn, "delete from detailpesanan where iddetailpesanan='$iddp'");
    }

    $query = mysqli_query($conn, "delete from pesanan where idpesanan='$idps'");

    if ($queryupdate && $queryhapus && $query) {
        header('location:order.php');
    } else {
        echo '
        <script>alert("Gagal mengapus pesanan);
        window.location.href="order.php"
        </script>
        ';
    }
}

//Mengubah data detail pesanan
if (isset($_POST['editdetail'])) {
    $idpr = $_POST['idpr']; //id produk
    $iddp = $_POST['iddp']; //id detail pesanan
    $idp = $_POST['idp']; //id pesanan
    $qty = $_POST['qty'];

    //cari tau sekarang qty berapa
    $caritau = mysqli_query($conn, "select * from detailpesanan where iddetailpesanan='$iddp'");
    $caritau2 = mysqli_fetch_array($caritau);
    $qtysekarang = $caritau2['qty'];

    //cari tau stok sekarang berapa
    $caristok = mysqli_query($conn, "select * from produk where idproduk='$idpr'");
    $caristok2 = mysqli_fetch_array($caristok);
    $stoksekarang = $caristok2['stok'];

    if ($qty >= $qtysekarang) {
        //kalau inputan user lebih besar daripada qty yang tercatat sekarang
        //hitung selisih
        $selisih = $qty - $qtysekarang;
        $newstok = $stoksekarang - $selisih;


        $query1 = mysqli_query($conn, "update detailpesanan set qty='$qty' where iddetailpesanan='$iddp'");
        $query2 = mysqli_query($conn, "update produk set stok='$newstok' where idproduk='$idpr'");

        if ($query1 && $query2) {
            header('location:view.php?idp=' . $idp);
        } else {
            echo '
            <script>alert("Gagal mengedit data pesanan");
            window.location.href="view.php?idp=' . $idp . '"
            </script>
            ';
        }
    } else {
        //kalau lebih kecil
        //hitung selisih
        $selisih = $qtysekarang - $qty;
        $newstok = $stoksekarang + $selisih;

        $query1 = mysqli_query($conn, "update detailpesanan set qty='$qty' where iddetailpesanan='$iddp'");
        $query2 = mysqli_query($conn, "update produk set stok='$newstok' where idproduk='$idpr'");

        if ($query1 && $query2) {
            header('location:view.php?idp=' . $idp);
        } else {
            echo '
            <script>alert("Gagal mengedit data pesanan");
            window.location.href="view.php?idp=' . $idp . '"
            </script>
            ';
        }
    }
}
