<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">

<?php
include "part/style.php";
?>

<body>
    <?php
    include "part/header.php";
    ?>

    <h1 style="text-align: center; margin-top:30px;">SELAMAT DATANG <?php echo $_SESSION['username']; ?></h1>
    <div class="container main" style="margin-top: 30px;">
        <div class="card-deck">
            <div class="card mb-3">
                <a href="frmMasterPeriode.php"> <img class="card-img-top" style="border: 1px;" src="image/periode.png" alt="Card image cap"></a>
                <div class="card-body" style="background-color: Ivory;">
                    <h3 class="card-title" style="text-align: center;">Master Periode</h3>
                </div>
            </div>
            <div class="card mb-3">
                <a href="frmMasterMK.php"> <img class="card-img-top" style="border: 1px;" src="image/matakuliah.png" alt="Card image cap"></a>
                <div class="card-body" style="background-color: Ivory;">
                    <h3 class="card-title" style="text-align: center;">Master Matakuliah</h3>
                </div>
            </div>
            <div class="card mb-3">
                <a href="frmMasterMahasiswa.php"> <img class="card-img-top" style="border: 1px;" src="image/mahasiswa.png" alt="Card image cap"></a>
                <div class="card-body" style="background-color: Ivory;">
                    <h3 class="card-title" style="text-align: center;">Master Mahasiswa</h3>
                </div>
            </div>
        </div>

        <div class="card-deck">
            <div class="card mb-3">
                <a href="frmMasterKelas.php"> <img class="card-img-top" style="border: 1px;" src="image/kelas.png" alt="Card image cap"></a>
                <div class="card-body" style="background-color: Ivory;">
                    <h3 class="card-title" style="text-align: center;">Master Kelas</h3>
                </div>
            </div>
            <div class="card mb-3">
                <a href="frmMasterLaporan.php"> <img class="card-img-top" style="border: 1px;" src="image/laporan.png" alt="Card image cap"></a>
                <div class="card-body" style="background-color: Ivory;">
                    <h3 class="card-title" style="text-align: center;">Master Laporan</h3>
                </div>
            </div>
            <div class="card mb-3">
                <img class="card-img-top" src="image/kelas.png" alt="Card image cap">
                <div class="card-body" style="background-color: Ivory;">
                    <h3 class="card-title" style="text-align: center;">Logout</h3>
                </div>
            </div>
        </div>
    </div>
    </br>
    <?php
    include "part/footer.php";
    ?>
</body>