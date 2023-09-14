<?php
//require 'ceklogin.php';

require 'function01.php';
?>
<html>

<head>
    <title>Data Supplier</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>

<body>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Data Supplier</h1>
        <ol class="breadcrumb mb-4">
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
                                </tr>
                            <?php
                            }; //end of while
                            ?>
                        </tbody>
                    </table>

                    <script>
                        $(document).ready(function() {
                            $('#dataTable').DataTable({
                                dom: 'Bfrtip',
                                buttons: [
                                    'copy', 'csv', 'excel', 'pdf', 'print'
                                ]
                            });
                        });
                    </script>

                    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
                    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>



</body>

</html>