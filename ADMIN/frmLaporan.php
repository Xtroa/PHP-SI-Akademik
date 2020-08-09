<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">

<?php
include "part/style.php";
?>

<body style="background-color: lightgrey;">
    <?php
    include "part/header.php";
    ?>

    <div class="container main">
        <div class="card" style="border-style: solid; border-color:grey;margin-top: 20px;">
            <div class="p-3 mb-0 bg-secondary text-white">
                <h3 style="text-align: center;">Daftar Mahasiswa</h3>
            </div>

            <div class="card-header" style="text-align: center; background-color: lightgreen; ">FILTER LAPORAN MAHASISWA DI KELAS</div>
            <div class="container">
                <form method="post" action="process.php?act=createPdf" enctype="multipart/form-data">
                    <div class="form-group col-md-3" style="margin-top: 10px;">
                        <label>Pilih Periode : </label>
                        <select class="form-control" name="pilihPeriode" id="periode">
                            <option value="">Pilih Periode</option>

                        </select>
                    </div>
                    <div class="form-group col-md-3" style="margin-top: 10px;">
                        <label>Pilih Matakuliah : </label>
                        <select class="form-control" name="pilihMatakuliah" id="matakuliah">
                            <option></option>

                        </select>
                    </div>
                    <div class="form-group col-md-3" style="margin-top: 10px;">
                        <label>Pilih Kelas : </label>
                        <select class="form-control" name="pilihKelas" id="kelas">
                            <option></option>

                        </select>
                    </div>
                    <div class="form-group col-md-3" style="margin-top: 10px;">
                        <input type="submit" value="CETAK LAPORAN" class="btn btn-primary"></input>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <?php
    include "part/footer.php";
    ?>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js">
</script>

<script>
    $(document).ready(function() {
        $.ajax({
            type: 'POST',
            url: "process.php?act=getPeriode",
            cache: false,
            success: function(msg) {
                $("#periode").html(msg);
            }
        });

        $("#periode").change(function() {
            var periode = $("#periode").val();
            $.ajax({
                type: 'POST',
                url: "process.php?act=getMatakuliah",
                data: {
                    pilihMatakuliah: periode
                },
                cache: false,
                success: function(msg) {
                    $("#matakuliah").html(msg);
                    //console.log();
                }
            });
        });

        $("#matakuliah").change(function() {
            var matakuliah = $("#matakuliah").val();
            $.ajax({
                type: 'POST',
                url: "process.php?act=getKelas",
                data: {
                    pilihMatakuliah: matakuliah
                },
                cache: false,

                success: function(msg) {
                    $("#kelas").html(msg);
                    //console.log();
                }
            });
        });

    });
</script>