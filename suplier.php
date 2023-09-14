<?php

require 'function01.php';

//hitung jumlah barang
$h1 = mysqli_query($conn, "select * from suplier ");
$h2 = mysqli_num_rows($h1); //jumlah supplier

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Data Supplier</title>
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
        <a class="navbar-brand ps-3" href="suplier.php">Cahaya Berkah Sejahtera</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="index01.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Order
                        </a>
                        <a class="nav-link" href="stock01.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Data Barang
                        </a>
                        <a class="nav-link" href="masuk01.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link" href="suplier.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Supplier
                        </a>
                        <a class="nav-link" href="">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Kelola Pelanggan
                        </a>
                        <a class="nav-link" href="admin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Kelola Admin
                        </a>
                        <a class="nav-link" href="laporan01.php">
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
                    <h1 class="mt-4">Data Supplier</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Selamat Datang</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Jumlah Supplier: <?= $h2; ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Button to Open the Modal -->
                    <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Tambah Supplier
                    </button>
                    <a href="export-supplier.php" class="btn btn-info text-white mb-4">Export Data</a>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Data Supplier
                        </div>
                        <div class="card-body">
                            <div class="data-tables datatable-dark">
                                <table class="table table-bordered" id="dataTable" width="100%" collspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Supplier</th>
                                            <th>No. Telepon</th>
                                            <th>Deskripsi</th>
                                            <th>Alamat</th>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $get = mysqli_query($conn, "select * from suplier");
                                        $i = 1;

                                        while ($p = mysqli_fetch_array($get)) {
                                            $id_suplier     = $p['id_suplier'];
                                            $nama_suplier   = $p['nama_suplier'];
                                            $telpon         = $p['telpon'];
                                            $deskripsi      = $p['deskripsi'];
                                            $alamat         = $p['alamat'];

                                        ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?php echo $nama_suplier; ?></td>
                                                <td><?php echo $telpon; ?></td>
                                                <td><?php echo $deskripsi; ?></td>
                                                <td><?php echo $alamat; ?></td>
                                                <td><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?php echo $id_suplier; ?>">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?php echo $id_suplier; ?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?= $id_suplier; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!--Modal Header-->
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Supplier</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <form method="post">

                                                            <!--Modal Body-->
                                                            <form method="post" enctype="multipart/form-data">
                                                                <div class="modal-body">
                                                                    <input type="text" name="nama_suplier" class="form-control mb-4" placeholder="Nama Supplier" value="<?= $nama_suplier; ?>">
                                                                    <input type="text" name="telpon" class="form-control mb-4" placeholder="No. Telepon" value="<?= $telpon; ?>">
                                                                    <input type="text" name="deskripsi" class="form-control mb-4" placeholder="Deskripsi" value=" <?= $deskripsi; ?>">
                                                                    <input type="text" name="alamat" class="form-control mb-4" placeholder="Alamat" value=" <?= $alamat; ?>">
                                                                    <input type="hidden" name="id_suplier" value="<?= $id_suplier; ?>">
                                                                </div>

                                                                <!--Modal Footer-->
                                                                <div class=" modal-footer">
                                                                    <button type="submit" class="btn btn-success" name="editsuplier">Submit</button>
                                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Delete Modal -->
                                            <div class="modal fade" id="delete<?= $id_suplier; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!--Modal Header-->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title fs-5" id="exampleModalLabel">Hapus Supplier <?= $nama_suplier; ?></h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <!--Modal Body-->
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                Apakah anda yakin ingin menghapus barang ini?
                                                                <input type="hidden" name="ids" value="<?= $id_suplier; ?>">
                                                            </div>

                                                            <!--Modal Footer-->
                                                            <div class=" modal-footer">
                                                                <button type="submit" class="btn btn-success" name="hapussuplier">Submit</button>
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Supplier</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="post">

                <!--Modal Body-->
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="text" name="nama_suplier" class="form-control mb-4" placeholder="Nama Supplier">
                        <input type="text" name="telpon" class="form-control mb-4" placeholder="No. Telepon">
                        <input type="text" name="deskripsi" class="form-control mb-4" placeholder="Deskripsi">
                        <input type="text" name="alamat" class="form-control mb-4" placeholder="Alamat">
                    </div>

                    <!--Modal Footer-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="tambahsuplier">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
        </div>
    </div>
</div>


</html>