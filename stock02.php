<?php

require 'function02.php';
require 'mode-barang.php';

//hitung jumlah barang
$h1 = mysqli_query($conn, "select * from barang ");
$h2 = mysqli_num_rows($h1); //jumlah produk

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Data Barang</title>
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
        <a class="navbar-brand ps-3" href="stock02.php">Cahaya Berkah Sejahtera</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="index02.php">
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
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Data Barang</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Selamat Datang</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Jumlah Barang: <?= $h2; ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Button to Open the Modal -->
                    <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Tambah Barang Baru
                    </button>
                    <a href="export-stok02.php" class="btn btn-info text-white mb-4">Export Data</a>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Data Barang
                        </div>
                        <div class="card-body">
                            <div class="data-tables datatable-dark">
                                <table class="table table-bordered" id="dataTable" width="100%" collspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>ID Barang</th>
                                            <th>Supplier</th>
                                            <th>Nama Produk</th>
                                            <th>Stock</th>
                                            <th>Harga Awal</th>
                                            <th>Harga Jual</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $get = mysqli_query($conn, "select * from barang  b, suplier s where b.id_suplier=s.id_suplier");
                                        $i = 1;

                                        while ($p = mysqli_fetch_array($get)) {
                                            $nama_suplier   = $p['nama_suplier'];
                                            $namaproduk     = $p['namaproduk'];
                                            $stok           = $p['stok'];
                                            $hargaawal      = $p['hargaawal'];
                                            $hargajual      = $p['hargajual'];
                                            $kode_barang    = $p['kode_barang'];
                                            $idsuplier      = $p['id_suplier'];
                                            $barcode        = $p['barcode'];

                                        ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?php echo $kode_barang; ?></td>
                                                <td><?php echo $nama_suplier; ?></td>
                                                <td><?php echo $namaproduk; ?></td>
                                                <td><?php echo $stok; ?></td>
                                                <td>Rp <?php echo number_format($hargaawal); ?></td>
                                                <td>Rp <?php echo number_format($hargajual); ?></td>
                                                <td><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?php echo $kode_barang; ?>">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?php echo $kode_barang; ?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?= $kode_barang; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!--Modal Header-->
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Barang</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <form method="post">

                                                            <!--Modal Body-->
                                                            <div class="modal-body">
                                                                <input type="num" name="kode_barang" class="form-control mb-4" placeholder="ID Barang" value=" <?= $kode_barang; ?>" readonly>
                                                                <input type="text" name="nama_suplier" class="form-control mb-4" placeholder="Nama Supplier" value="<?= $nama_suplier; ?>" disabled>
                                                                <input type="text" name="namaproduk" class="form-control mb-4" placeholder="Nama Produk" value="<?= $namaproduk; ?>">
                                                                <input type="num" name="stok" class="form-control mb-4" placeholder="Stok" value=" <?= $stok; ?>">
                                                                <input type="num" name="hargaawal" class="form-control mb-4" placeholder="Harga Awal" value=" <?= $hargaawal; ?>">
                                                                <input type="num" name="hargajual" class="form-control mb-4" placeholder="Harga Jual" value=" <?= $hargajual; ?>">
                                                                <input type="hidden" name="idp" value="<?= $kode_barang; ?>">
                                                                <input type="hidden" name="ids" value="<?= $idsuplier; ?>">
                                                            </div>

                                                            <!--Modal Footer-->
                                                            <div class=" modal-footer">
                                                                <button type="submit" class="btn btn-success" name="editbarang">Submit</button>
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Delete Modal -->
                                            <div class="modal fade" id="delete<?= $kode_barang; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!--Modal Header-->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title fs-5" id="exampleModalLabel">Hapus Barang <?= $namaproduk; ?></h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <!--Modal Body-->
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                Apakah anda yakin ingin menghapus barang ini?
                                                                <input type="hidden" name="idp" value="<?= $kode_barang; ?>">
                                                            </div>

                                                            <!--Modal Footer-->
                                                            <div class=" modal-footer">
                                                                <button type="submit" class="btn btn-success" name="hapusbarang">Submit</button>
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }; //end of while
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Ayu Eka Marviyanti 2023</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!--Modal Header-->
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Barang Baru</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="post">

                <!--Modal Body-->
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="text" name="kode_barang" class="form-control" id="kode_barang" value="<?= generateId() ?>" readonly><br>
                        <input type="number" name="barcode" class="form-control" id="barcode" placeholder="Barcode" autocomplete="off" autofocus required><br>
                        Pilih Supplier
                        <select name="id_suplier" class="form-control">

                            <?php
                            $getsuplier = mysqli_query($conn, "select * from suplier");
                            while ($pl = mysqli_fetch_array($getsuplier)) {
                                $nama_suplier = $pl['nama_suplier'];
                                $idsuplier   = $pl['id_suplier'];

                            ?>
                                <option value="<?= $idsuplier; ?>"><?= $nama_suplier; ?></option>
                            <?php
                            };
                            ?>
                        </select><br>
                        <input type="text" name="namaproduk" class="form-control mb-4" placeholder="Nama Produk">
                        <input type="number" name="stok" class="form-control mb-4" placeholder="Stok">
                        <input type="number" name="hargaawal" class="form-control mb-4" placeholder="Harga Awal">
                        <input type="number" name="hargajual" class="form-control mb-4" placeholder="Harga Jual">
                    </div>

                    <!--Modal Footer-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="tambah">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
        </div>
    </div>
</div>


</html>