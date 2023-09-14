<?php

function generateNo()
{
    global $conn;

    $queryNo = mysqli_query($conn, "SELECT max(no_jual) as maxno FROM penjualan");
    $row = mysqli_fetch_assoc($queryNo);
    $maxno = $row["maxno"];

    $noUrut = (int) substr($maxno, 2, 4);
    $noUrut++;
    $maxno = 'PJ' . sprintf("%04s", $noUrut);

    return $maxno;
}

function totaljual($no_jual)
{
    global $conn;

    $totaljual = mysqli_query($conn, "SELECT sum(jml_hrg) AS total FROM penjualan_detail 
    WHERE no_jual='$no_jual'");
    $data = mysqli_fetch_assoc($totaljual);
    $total = $data["total"];

    return $total;
}

function insert($data)
{
    global $conn;


    $no         = mysqli_real_escape_string($conn, $data['no_jual']);
    $tgl        = mysqli_real_escape_string($conn, $data['tglnota']);
    $kode       = mysqli_real_escape_string($conn, $data['barcode']);
    $kode_barang = mysqli_real_escape_string($conn, $data['kode_barang']);
    $namaproduk = mysqli_real_escape_string($conn, $data['namaproduk']);
    $qty        = mysqli_real_escape_string($conn, $data['qty']);
    $harga      = mysqli_real_escape_string($conn, $data['harga']);
    $jml_hrg     = mysqli_real_escape_string($conn, $data['jml_hrg']);
    $stok       = mysqli_real_escape_string($conn, $data['stok']);

    // cek barang sudah diinput atau belum
    $cekbrg = mysqli_query($conn, "SELECT * FROM penjualan_detail 
    WHERE no_jual = '$no' AND barcode = '$kode'");
    if (mysqli_num_rows($cekbrg)) {
        echo "<script>
                alert('barang sudah ada, anda harus menghapusnya dulu jika ingin mengubah qty nya..');
            </script>";
        return false;
    }

    // qty barang tidak boleh kosong
    if (empty($qty)) {
        echo "<script>
                alert('Qty barang tidak boleh kosong');
            </script>";
        return false;
    } else if ($qty > $stok) {
        echo "<script>
                alert('Stok barang tidak mencukupi');
            </script>";
        return false;
    } else {
        // $sqljual = "INSERT INTO penjualan_detail VALUES ('', '$no', '$tgl', '$kode', '$namaproduk', 
        // '$qty', '$harga', '$jml_hrg')";

        $sqljual = "INSERT INTO penjualan_detail(no_jual, tgl_jual, namaproduk, barcode, kode_barang, qty, hargajual, jml_hrg)
        VALUES ('$no','$tgl','$namaproduk','$kode','$kode_barang','$qty','$harga','$jml_hrg')";
        mysqli_query($conn, $sqljual);
    }

    mysqli_query($conn, "UPDATE barang SET stok = stok - $qty WHERE barcode = '$kode'");

    return mysqli_affected_rows($conn);
}

function delete($barcode, $idjual, $qty)
{
    global $conn;
    $sqlDel = "DELETE FROM penjualan_detail WHERE barcode = '$barcode' AND no_jual = '$idjual'";
    mysqli_query($conn, $sqlDel);

    mysqli_query($conn, "UPDATE barang SET stok = stok + $qty WHERE barcode = '$barcode'");

    return mysqli_affected_rows($conn);
}

function simpan($data)
{
    global $conn;

    $no_jual        = mysqli_real_escape_string($conn, $data['no_jual']);
    $tgl            = mysqli_real_escape_string($conn, $data['tglnota']);
    $idpelanggan    = mysqli_real_escape_string($conn, $data['idpelanggan']);
    $total          = mysqli_real_escape_string($conn, $data['total']);
    $keterangan     = mysqli_real_escape_string($conn, $data['ket']);
    $bayar          = mysqli_real_escape_string($conn, $data['bayar']);
    $kembalian      = mysqli_real_escape_string($conn, $data['kembalian']);

    $sqljual = "INSERT INTO penjualan  VALUES ('$no_jual', '$tgl', '$idpelanggan', '$total', '$keterangan','$bayar','$kembalian')";
    mysqli_query($conn, $sqljual);

    return mysqli_affected_rows($conn);
}
