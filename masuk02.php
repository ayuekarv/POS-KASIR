<?php

require 'function02.php';

//hitung jumlah barang
$h1 = mysqli_query($conn, "select * from masuk ");
$h2 = mysqli_num_rows($h1); //jumlah barang masuk

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Data Barang Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="masuk02.php">Cahaya Berkah Sejahtera</a>
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
                    <h1 class="mt-4">Data Barang Masuk</h1>
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
                        Tambah Barang Masuk
                    </button>
                    <a href="export-masuk01.php" class="btn btn-info text-white mb-4">Export Data</a>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Barang
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" collspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>ID Barang</th>
                                            <th>Supplier</th>
                                            <th>Nama Produk</th>
                                            <th>Jumlah</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $get = mysqli_query($conn, "SELECT * FROM masuk INNER JOIN barang ON masuk.kode_barang = barang.kode_barang
                                        INNER JOIN suplier ON barang.id_suplier = suplier.id_suplier");
                                        $i = 1;
                                        while ($p = mysqli_fetch_array($get)) {
                                            $idm        = $p['idmasuk'];
                                            $namaproduk = $p['namaproduk'];
                                            $qty        = $p['qty'];
                                            $tanggal    = $p['tanggal'];
                                            $idm        = $p['idmasuk'];
                                            $idp        = $p['kode_barang'];
                                            $id_suplier = $p['id_suplier'];
                                            $nama_suplier = $p['nama_suplier'];

                                        ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $idp; ?></td>
                                                <td><?= $nama_suplier; ?></td>
                                                <td><?= $namaproduk; ?></td>
                                                <td><?= $qty; ?></td>
                                                <td><?= $tanggal; ?></td>
                                                <td><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $idm; ?>">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $idm; ?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?= $idm; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!--Modal Header-->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title fs-5" id="exampleModalLabel">Edit Barang Masuk</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <!--Modal Body-->
                                                        <form method="post" enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                <input type="text" name="kode_barang" class="form-control mb-4" placeholder="ID Barang" value=" <?= $idp; ?>" readonly>
                                                                <input type="num" name="id_suplier" class="form-control mb-4" placeholder="Supplier" value=" <?= $id_suplier; ?>" readonly>
                                                                <input type="text" name="namaproduk" class="form-control mb-4" placeholder="Nama Produk" value="<?= $namaproduk; ?>" disabled>
                                                                <input type="num" name="qty" class="form-control mb-4" placeholder="Jumlah" value=" <?= $qty; ?>">
                                                                <input type="hidden" name="idm" value="<?= $idm; ?>">
                                                                <input type="hidden" name="idp" value="<?= $idp; ?>">
                                                            </div>

                                                            <!--Modal Footer-->
                                                            <div class=" modal-footer">
                                                                <button type="submit" class="btn btn-success" name="editmasuk">Submit</button>
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Delete Modal -->
                                            <div class="modal fade" id="delete<?= $idm; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!--Modal Header-->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title fs-5" id="exampleModalLabel">Hapus Barang <?= $namaproduk; ?></h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <form method="post">

                                                            <!--Modal Body-->
                                                            <div class="modal-body">
                                                                Apakah anda yakin ingin menghapus data ini?
                                                                <input type="hidden" name="idm" value="<?= $idm; ?>">
                                                                <input type="hidden" name="idp" value="<?= $idp; ?>">
                                                            </div>

                                                            <!--Modal Footer-->
                                                            <div class=" modal-footer">
                                                                <button type="submit" class="btn btn-success" name="hapusmasuk">Submit</button>
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Barang</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="post">

                <!--Modal Body-->
                <div class="modal-body">
                    Pilih Barang
                    <select name="kode_barang" class="form-control">

                        <?php
                        $getproduk = mysqli_query($conn, "SELECT * FROM suplier s, barang b where s.id_suplier=b.id_suplier");
                        while ($pl = mysqli_fetch_array($getproduk)) {
                            $namaproduk = $pl['namaproduk'];
                            $stok       = $pl['stok'];
                            $hargajual  = $pl['hargajual'];
                            $kode_barang = $pl['kode_barang'];
                            $id_suplier = $pl['id_suplier'];

                        ?>
                            <option value="<?= $kode_barang; ?>"><?= $kode_barang; ?> - <?= $namaproduk; ?> - <?= $hargajual; ?> (Stock: <?= $stok; ?>)(Supplier:<?= $id_suplier; ?>)</option>
                        <?php
                        };
                        ?>

                        <input type="number" name="qty" class="form-control mt-4" placeholder="Jumlah" min="1" required>
                </div>

                <!--Modal Footer-->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="barangmasuk">Submit</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


</html>