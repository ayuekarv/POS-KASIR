<?php

require 'function02.php';
// require 'mode-jual.php';
// require 'transaksi.php';
// require 'r-jual.php';

//hitung jumlah barang
$h1 = mysqli_query($conn, "select * from penjualan");
$h2 = mysqli_num_rows($h1); //jumlah pesanan


$penjualan = mysqli_query($conn, "SELECT penjualan.no_jual, 
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
INNER JOIN barang ON penjualan_detail.kode_barang=barang.kode_barang");

function in_date($tgl)
{
    $tg    = substr($tgl, 8, 2);
    $bln    = substr($tgl, 5, 2);
    $thn    = substr($tgl, 0, 4);
    return $tg . "-" . $bln . "-" . $thn;
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Data Penjualan</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link href="css/styles.css" rel="stylesheet" />
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src=""></script>
    <style>
        .zoomable {
            width: 100px;
        }

        .zoomable:hover {
            transform: scale(2.5);
            transition: 0.3s ease;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="laporan01.php">Cahaya Berkah Sejahtera</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="laporan02.php.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="transaksi.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Order
                        </a>
                        <a class="nav-link" href="stock02.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Data Barang
                        </a>
                        <a class="nav-link" href="masuk02.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link" href="">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Supplier
                        </a>
                        <a class="nav-link" href="pelanggan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Kelola Pelanggan
                        </a>
                        <a class="nav-link" href="">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Kelola Admin
                        </a>
                        <a class="nav-link" href="laporan02.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Laporan Penjualan
                        </a>
                        <a class="nav-link" href="logout.php">
                            Logout
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <div class="content-wrapper">
                <main>
                    <!-- Content Header (Page Header) -->
                    <div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <br>
                                    <h1 class="m-0">DATA PENJUALAN</h1><br>
                                    <ol class="breadcrumb mb-2">
                                        <li class="breadcrumb-item active"> Selamat Datang</li>
                                    </ol>
                                    <div class="row">
                                        <div class="col-xl-4 col-md-6">
                                            <div class="card bg-primary text-white mb-4">
                                                <div class="card-body">Jumlah Pesanan: <?= $h2; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- /.col -->
                            </div> <!-- /.row -->
                        </div> <!-- /.container-fluid-->
                    </div>

                    <section class="content">
                        <div class="container-fluid">
                            <div class="card">
                                <div class="card-header">
                                    <div class="col-lg-4 py-2 px-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary float-right" data-bs-toggle="modal" data-bs-target="#mdlJual">
                                            <i class="fas fa-print"></i> Cetak </button>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-3">
                                    <table class="table table-hover text-nowrap" id="dataTable">
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
                                            while ($jual = mysqli_fetch_array($penjualan)) { ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= $jual['no_jual'] ?></td>
                                                    <td><?= in_date($jual['tgl_jual']) ?></td>
                                                    <td><?= $jual['namapelanggan'] ?></td>
                                                    <td><?= $jual['namaproduk'] ?></td>
                                                    <td><?= $jual['hargajual'] ?></td>
                                                    <td><?= $jual['qty'] ?></td>
                                                    <td class="text-center"><?= number_format($jual['total']) ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="modal fade" id="mdlJual">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="r-jual.php" method="get">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Periode Pesanan</h4>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <label for="tgl1" class="col-sm-3 col-form-label">Tanggal Awal</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" name="tgl1" id="tgl1">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tgl2" class="col-sm-3 col-form-label">Tanggal Akhir</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" name="tgl2" id="tgl2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-print"></i> Cetak</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /. modal-content -->
                        </div>
                        <!-- /. modal-dialog -->
                    </div>
                    <script>
                        let tgl1 = document.getElementById('tgl1');
                        let tgl2 = document.getElementById('tgl2');

                        function printDoc() {
                            if (tgl1.value != "" && tgl2.value != "") {
                                window.open("r-jual.php?tgl1=" + tgl1.value + "&tgl2=" +
                                    tgl2.value, "", "width=900, height=600, left=100");
                            }
                        }
                    </script>
                </main>
            </div>
        </div>
    </div>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>