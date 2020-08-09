<?php 
include 'koneksi.php';

// cek apakah user telah login, jika belum login maka di alihkan ke halaman login
if($_SESSION['status'] !="login"){
    header("location:mahasiswa/home.php");
}

$id = $_SESSION['id'];
//echo "id : " . $id;
?>

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <ul class="nav nav-pills">
            <li class="nav-item" style="transition: transform 0.15s linear;">
                <a class="nav-link active" style="color:white;" href="frmAdminHome.php">Beranda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color:white;" href="frmMasterPeriode.php">Master Periode</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color:white;" href="frmMasterMK.php">Master Matakuliah</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color:white;" href="frmMasterMahasiswa.php">Master Mahasiswa</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color:white;" href="frmMasterKelas.php">Master Kelas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color:white;" href="frmMasterPengumuman.php">Master Pengumuman</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color:white;" href="frmLaporan.php">Laporan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color:white;" href="frmMasterTest.php">Test</a>
            </li>
        </ul>
        
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link right" style="color:white;" href="process.php?act=logout">Log out</a>
            </li>
        </ul>
  </div>
</nav>