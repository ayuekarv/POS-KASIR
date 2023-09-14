<?php

function generateId()
{
    global $conn;

    $queryId    = mysqli_query($conn, "SELECT max(kode_barang) as maxid FROM barang");
    $data       = mysqli_fetch_array($queryId);
    $maxid      = $data['maxid'];

    $noUrut = (int) substr($maxid, 4, 3);
    $noUrut++;
    $maxid  = "BRG-" . sprintf("%03s", $noUrut);

    return $maxid;
}
