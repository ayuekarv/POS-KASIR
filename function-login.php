<?php

session_start();


//Bikin Koneksi
$conn = mysqli_connect('localhost', 'root', '', 'pos-kasir');

$username = $_POST['username'];
$password = $_POST['password'];

$check = mysqli_query($conn, "SELECT * FROM user WHERE username='$username' and password='$password'");
$hitung = mysqli_num_rows($check);

//Login
if ($hitung > 0) {
    //Jika datanya ditemukan
    //Maka berhasil login

    $ambillevel = mysqli_fetch_assoc($check);
    $level = $ambillevel['level'];


    if ($ambillevel['level'] == "admin") {
        //kalau dia admin
        $_SESSION['log'] = "Logged";
        $_SESION['level'] = 'admin';
        header('location:index01.php');
    } else if ($ambillevel['level']  == "user") {
        //kalau bukan admin
        $_SESSION['log'] = "Logged";
        $_SESION['level'] = 'user';
        header('location:index02.php');
    }
} else {
    //Data tidak ditemukan
    //Gagal login
    echo '
        <script>alert("Username atau Password salah");
        window.location.href="login.php"
        </script>
        ';
}
