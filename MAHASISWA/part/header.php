<?php 
include 'koneksi.php';

// cek apakah user telah login, jika belum login maka di alihkan ke halaman login
if($_SESSION['status'] !="login"){
    header("location:home.php");
}

date_default_timezone_set('Asia/Jakarta');
$timestamp = strtotime("now");
$stringDate = date('d-m-Y H:i', $timestamp);

$timestamp2 = strtotime("20-07-2020 22:12");
$stringDate2 = date('20-07-2020 22:12', $timestamp2);

if($stringDate > $stringDate2)
{
?>
<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <ul class="nav nav-pills">
            <li class="nav-item" style="transition: transform 0.15s linear;">
                <a class="nav-link active" style="color:white;" href="frmMahasiswaHome.php">Beranda</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" style="color:white;" href="daftarMatakuliah.php">Daftar Matakuliah</a>
            </li>
            
        </ul>
        
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link right" style="color:white;" href="process.php?act=logout">Log out</a>
            </li>
        </ul>
    </div>
    
</nav>
<?php
// echo $stringDate . ">" . $stringDate2 . "</br>";
// echo $timestamp . ">" . $timestamp2 . "</br>";
}
else if($stringDate < $stringDate2)
{
?>
<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <ul class="nav nav-pills">
            <li class="nav-item" style="transition: transform 0.15s linear;">
                <a class="nav-link active" style="color:white;" href="frmMahasiswaHome.php">Beranda</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" style="color:white;" href="daftarMatakuliah.php">Daftar Matakuliah</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" style="color:white;" href="Test.php">Pendaftaran Matakuliah</a>
            </li>
        </ul>
        
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link right" style="color:white;" href="process.php?act=logout">Log out</a>
            </li>
        </ul>
    </div>
</nav>
<?php
// echo $stringDate . "<" . $stringDate2 . "</br>";
// echo $timestamp . "<" . $timestamp2 . "</br>";
}

?>