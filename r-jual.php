<?php

require "function02.php";
// require "laporan01.php";

$tgl1 = $_GET['tgl1'];
$tgl2 = $_GET['tgl2'];
$datajual = mysqli_query($conn, "SELECT penjualan.no_jual, 
penjualan.tgl_jual,
pelanggan.namapelanggan,
penjualan_detail.kode_barang,
barang.namaproduk,
penjualan_detail.hargajual,
penjualan_detail.qty,
penjualan.total
FROM penjualan_detail
INNER JOIN penjualan ON penjualan_detail.no_jual=penjualan.no_jual
INNER JOIN pelanggan ON penjualan.idpelanggan=pelanggan.idpelanggan
INNER JOIN barang ON penjualan_detail.kode_barang=barang.kode_barang
WHERE penjualan.tgl_jual BETWEEN '$tgl1' AND '$tgl2'
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Laporan Penjualan</title>
</head>

<body>
    <div style="text-align: center;">
        <h2 style="margin-bottom: -15px;">Rekap Laporan Pembelian</h2>
        <h2 style="margin-bottom: -15px;">Koperasi Cahaya Berkah Sejahtera</h2>
    </div><br><br>

    <table border="1" width="100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Nota</th>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($data = mysqli_fetch_array($datajual)) { ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $data['no_jual'] ?></td>
                    <td><?= $data['tgl_jual'] ?></td>
                    <td><?= $data['namapelanggan'] ?></td>
                    <td><?= $data['namaproduk'] ?></td>
                    <td><?= $data['hargajual'] ?></td>
                    <td><?= $data['qty'] ?></td>
                    <td><?= $data['total'] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <script>
        window.print();
    </script>
</body>

</html>