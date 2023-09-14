<?php

require 'function02.php';
require 'mode-jual.php';

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
} else {
    $msg = '';
}

//jika barang dihapus
if ($msg == 'deleted') {
    $barcode = $_GET['barcode'];
    $idjual   = $_GET['idjual'];
    $qty      = $_GET['qty'];
    $tgl      = $_GET['tgl'];
    delete($barcode, $idjual, $qty);
    echo "<script>
            alert('barang telah dihapus...');
                document.location = '?tgl=$tgl';
         </script>";
}

//jika ada barcode yang dikirim
$kode = @$_GET['barcode'] ? @$_GET['barcode'] : '';
if ($kode) {
    $tgl = $_GET['tgl'];
    $databrg = mysqli_query($conn, "SELECT * FROM barang WHERE barcode = '$kode'");
    $selectbrg = mysqli_fetch_assoc($databrg);
    if (!mysqli_num_rows($databrg)) {
        echo "<script>
                alert('barang dengan barcode tersebut tidak ada..');
                document.location = '?tgl=$tgl';
                </script>";
    }
}

//jika tombol tambah barang ditekan
if (isset($_POST['addbrg'])) {
    $tgl = $_POST['tglnota'];
    if (insert($_POST)) {
        echo "<script>
                document.location = '?tgl=$tgl';
                </script>";
    }
}

//jika tombol simpan ditekan
if (isset($_POST['simpan'])) {
    $nota = $_POST['no_jual'];
    if (simpan($_POST)) {
        echo "<script>
                alert('data penjualan berhasil disimpan');
                window.onload = function(){
                    let win = window.open('../report/struk.php?nota=$nota', 'Struk Belanja',
                    'width=260, height=400, left=10, top=10', '_blank');
                    if(win){
                        win.focus();
                        window.location = 'transaksi.php';
                }
                </script>";
    }
}

$no_jual = generateNo();

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
        <a class="navbar-brand ps-3" href="stock01.php">Cahaya Berkah Sejahtera</a>
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
                            Transaksi
                        </a>
                        <a class="nav-link" href="order.php">
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
                        <a class="nav-link" href="suplier.php">
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
                                    <h1 class="m-0">Penjualan Barang</h1><br>
                                </div> <!-- /.col -->
                            </div> <!-- /.row -->
                        </div> <!-- /.container-fluid-->
                    </div>
                    <section>
                        <div class="container-fluid">
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card card-outline card-warning p-3">
                                            <div class="form-group row mb-2">
                                                <label for="nonota" class="col-sm-2 col-form-label"><b>No Nota</b></label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="no_jual" class="form-control" id="nonota" value="<?= $no_jual ?>">
                                                </div>
                                                <label for="tglnota" class="col-sm-2 col-form-label"><b>Tgl Nota</b></label>
                                                <div class="col-sm-4">
                                                    <input type="date" name="tglnota" class="form-control" id="tglnota" value="<?= @$_GET['tgl'] ? $_GET['tgl'] : date('Y-M-D') ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group row sm-2">
                                                <label for="barcode" class="col-sm-2 col-form-label"><b>Barcode</b></label>
                                                <div class="col-sm-10 input-group">
                                                    <input type="text" name="barcode" id="barcode" value="<?= @$_GET['barcode'] ? $_GET['barcode'] : '' ?>" class="form-control" placeholder="Masukan barcode barang">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="icon-barcode"><i class="fas fa-barcode form-control"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card card-outline card-danger pt-3 px-3 pb-2">
                                            <h6 class="font-weight-bold text-right">Total Penjualan</h6>
                                            <h1 class="font-weight-bold text-right" style="font-size:40pt;">
                                                <input type="hidden" name="total" id="total" value="<?= totaljual($no_jual) ?>">
                                                <?= number_format(totaljual($no_jual), 0, ',', '.') ?>
                                            </h1>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="card pt-1 pb-2 px-3">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="namaproduk"><b>Nama Barang</b></label><br>
                                                <input type="text" name="namaproduk" class="form-control form-control-sm" id="namaproduk" value="<? @$_GET['barcode'] ? $selectbrg['namaproduk'] : '' ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label for="stok"><b>Stock</b></label><br>
                                                <input type="number" name="stok" class="form-control form-control-sm" id="stok" value="<? @$_GET['barcode'] ? $selectbrg['stok'] : '' ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="harga"><b>Harga</b></label><br>
                                                <input type="number" name="harga" class="form-control form-control-sm" id="harga" value="<? @$_GET['barcode'] ? $selectbrg['hargajual'] : '' ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="qty"><b>Qty</b></label><br>
                                                <input type="number" name="qty" class="form-control form-control-sm" id="qty" value="<? @$_GET['barcode'] ? 1 : '' ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="jml_hrg"><b>Jumlah Harga</b></label><br>
                                                <input type="number" name="jml_hrg" class="form-control form-control-sm" id="jml_hrg" value="<? @$_GET['barcode'] ? $selectbrg['harga_jual'] : '' ?>" readonly>
                                            </div>
                                        </div>
                                    </div><br>
                                    <button type="submit" class="btn btn-sm btn-primary btn-block" name="addbrg"><i class="fas fa-cart-plus fa-sm"></i> Tambah Barang</button>
                                </div><br>
                                <div class="card card-outline card-success table-responsive px-2">
                                    <table class="table table-sm table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Barcode</th>
                                                <th>Nama Barang</th>
                                                <th class="text-right">Harga</th>
                                                <th class="text-right">Qty</th>
                                                <th class="text-right">Jumlah Harga</th>
                                                <th class="text-right" width="10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            $brgDetail = mysqli_query($conn, "SELECT * FROM penjualan_detail WHERE no_jual = '$no_jual'");
                                            foreach ($brgDetail as $detail) { ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $detail['barcode'] ?></td>
                                                    <td><?= $detail['namaproduk'] ?></td>
                                                    <td class="text-right"><?= number_format($detail['hargajual'], 0, ',') ?></td>
                                                    <td class="text-right"><?= $detail['qty'] ?></td>
                                                    <td class="text-right"><?= number_format($detail['jmlhrg'], 0, ',') ?></td>
                                                    <td class="text-center">
                                                        <a href="?barcode=<?= $detail['barcode'] ?> &idjual=<?= $detail['no_jual'] ?>
                                                            &qty=<? $detail['qty'] ?>&tgl=<? $detail['tgl_beli'] ?>&msg=deleted" class="btn btn-sm btn-danger" title="hapus barang" onclick="return confirm('Anda yakin ajan menghapus barang ini?')"><i class="fas fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            <?php
                                            };
                                            ?>
                                        </tbody>
                                    </table>
                                </div><br>
                                <div class="row">
                                    <div class="col-lg-4 p-2">
                                        <div class="form-group row mb-2">
                                            <label for="namapelanggan" class="col-sm-3 col-form-label col-form-label-sm"><b>Customer</b></label>
                                            <div class="col-sm-9">
                                                <select name="idpelanggan" class="form-control">
                                                    <?php
                                                    $getpelanggan = mysqli_query($conn, "select * from pelanggan");

                                                    while ($pl = mysqli_fetch_array($getpelanggan)) {
                                                        $namapelanggan = $pl['namapelanggan'];
                                                        $idpelanggan = $pl['idpelanggan'];
                                                        $alamat = $pl['alamat'];
                                                    ?>
                                                        <option value="<?= $idpelanggan; ?>"><?= $namapelanggan ?></option>
                                                    <?php
                                                    };
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-2">
                                            <label for="ket" class="col-sm-3 col-form-label"><b>Keterangan</b></label>
                                            <div class="col-sm-9">
                                                <textarea name="ket" id="ket" class="form-control form-control-sm"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 py-2 px-3">
                                        <div class="form-group row mb-2">
                                            <label for="bayar" class="col-sm-3 col-form-label"><b>Bayar</b></label>
                                            <div class="col-sm-9">
                                                <input type="number" name="bayar" class="form-control form-control-sm text-right" id="bayar">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-2">
                                            <label for="kembalian" class="col-sm-3 col-form-label"><b>Kembalian</b></label>
                                            <div class="col-sm-9">
                                                <input type="number" name="kembalian" class="form-control form-control-sm text-right" id="kembalian">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 p-2">
                                        <button type="submit" name="simpan" id="simpan" class="form-control btn btn-warning btn-sm btn-block"><i class="fa fa-save"></i> Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                    <script>
                        let barcode = document.getElementById('barcode');
                        let tgl = document.getElementById('tglnota');
                        let namaproduk = document.getElementById('namaproduk');
                        let qty = document.getElementById('qty');
                        let harga = document.getElementById('harga');
                        let jmlhrg = document.getElementById('jml_hrg');
                        let bayar = document.getElementById('bayar');
                        let kembalian = document.getElementById('kembalian');
                        let total = document.getElementById('total');

                        barcode.addEventListener('change', function() {
                            document.location.href = '?barcode=' + barcode.value + '&tgl=' + tgl.value;
                        })

                        qty.addEventListener('input', function() {
                            jml_hrg.value = qty.value * harga.value;
                        })
                        bayar.addEventListener('input', function() {
                            kembalian.value = bayar.value - total.value;
                        })
                    </script>
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
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>