<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<?php
include "part/style.php";
?>

<body style="background-color: lightgrey;">
    <?php //NAV
    include "part/header.php";
    ?>
    <div class="container main">
        <div class="card" style="border-style: solid; border-color:grey;margin-top: 20px;">
            <div class="p-3 mb-2 bg-secondary text-white">
                <h3 style="text-align: center;">Daftar Periode</h3>
            </div>
            <div id="notifTambah"></div>
            <nav class="navbar navbar-expand-md navbar-light bg-light">
                <a class="navbar-brand">Cari Periode : </a>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <div class="col-xs-3">
                        <input class="form-control" name="keyword" id="keyword" type="text" placeholder="Search"></input>
                    </div>
                </div>
                <button class="btn btn-success" data-toggle="modal" data-target="#modalForm">
                    + Tambah Periode
                </button>
                <!-- Modal -->
                <div class="modal fade" id="modalForm" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title" id="tambah" style="text-align: center">TAMBAH PERIODE</h4>
                                <button type="button" id="btnClose" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">×</span>
                                    <span class="sr-only">Close</span>
                                </button>

                            </div>

                            <!-- Modal Body -->
                            <div class="modal-body">
                                <p class="statusMsg"></p>
                                <!-- <form> -->
                                <form method="post" id="insert_form">
                                    <div class="form-group">
                                        <label for="inputName">Nama Periode :</label>
                                        <input type="text" id="namaPeriode" class="form-control" placeholder="Contoh : Periode 2019/2020" name="namaPeriode">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail">Status :</label>
                                        <select id="statusPeriode" name="statusPeriode" class="form-control">
                                            <option selected>Pilih periode </option>
                                            <option value="1">AKTIF</option>
                                            <option value="0">NON-AKTIF</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputMessage">Tanggal Mulai :</label>
                                        <input type="date" id="tanggalAwal" class="form-control" name="tglMulaiPeriode">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputMessage">Tanggal Berakhir :</label>
                                        <input type="date" id="tanggalAkhir" class="form-control" name="tglAkhirPeriode">
                                    </div>

                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <button type="button" id="btnSimpan" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                                <!-- </form> -->
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

        <div class="container">
            <table class="table table-hover">
                <thead style="text-align: center;">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Nama Periode</th>
                        <th scope="col">Tanggal Awal Periode</th>
                        <th scope="col">Tanggal Akhir Periode</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>

                <tbody style="text-align: center;" id="data">
                    <?php
                    $link = mysqli_connect("localhost", "root", "", "pweb");

                    //*pagination
                    $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
                    // Jumlah data per halaman
                    $limit = 10;
                    $limitStart = ($page - 1) * $limit;
                    $SqlQuery = mysqli_query($link, "SELECT * FROM periode ORDER BY kode DESC LIMIT " . $limitStart . "," . $limit);
                    $no = $limitStart + 1;
                    while ($row = mysqli_fetch_array($SqlQuery)) {

                        echo "<tr>";
                        echo "<td>" . $row['kode'] . "</td>";
                        echo "<td>" . $row['nama'] . "</td>";
                        echo "<td>" . $row['tanggal_buka'] . "</td>";
                        echo "<td>" . $row['tanggal_akhir'] . "</td>";

                        if ($row['status'] == 1) {
                            $a = "aktif";
                        } else if ($row['status'] == 0) {
                            $a = "non-aktif";
                        }
                        echo "<td>" . $a . "</td>";

                        echo "<td> <a class='btn btn-info' href='frmUbahPeriode.php?kode= " . $row['kode'] . "'> Edit </a> ";
                        echo " <a class='btn btn-danger' onclick='hapusKode( " . $row['kode'] . ")'>Hapus</a></td>";
                        //echo " | <a <button type='button' onclick='hapusKode($row->kode)'>HAPUS</button></a> </td>";

                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <?php
                    // Jika page = 1, maka LinkPrev disable
                    if ($page == 1) {
                    ?>
                        <!-- link Previous Page disable -->
                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                    <?php
                    } else {
                        $LinkPrev = ($page > 1) ? $page - 1 : 1;
                    ?>
                        <!-- link Previous Page -->
                        <li class="page-item"><a class="page-link" href="frmMasterPeriode.php?page=<?php echo $LinkPrev; ?>">Previous</a></li>
                    <?php
                    }
                    ?>

                    <?php
                    $SqlQuery = mysqli_query($link, "SELECT * FROM periode");

                    //Hitung semua jumlah data yang berada pada tabel Sisawa
                    $JumlahData = mysqli_num_rows($SqlQuery);

                    // Hitung jumlah halaman yang tersedia
                    $jumlahPage = ceil($JumlahData / $limit);

                    // Jumlah link number 
                    $jumlahNumber = 1;

                    // Untuk awal link number
                    $startNumber = ($page > $jumlahNumber) ? $page - $jumlahNumber : 1;

                    // Untuk akhir link number
                    $endNumber = ($page < ($jumlahPage - $jumlahNumber)) ? $page + $jumlahNumber : $jumlahPage;

                    for ($i = $startNumber; $i <= $endNumber; $i++) {
                        $linkActive = ($page == $i) ? ' active ' : '';
                    ?>
                        <li class='page-item <?php echo $linkActive; ?>'> <a class="page-link" href="frmMasterPeriode.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php
                    }
                    ?>

                    <!-- link Next Page -->
                    <?php
                    if ($page == $jumlahPage) {
                    ?>
                        <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
                    <?php
                    } else {
                        $linkNext = ($page < $jumlahPage) ? $page + 1 : $jumlahPage;
                    ?>
                        <li class="page-item"><a class="page-link" href="frmMasterPeriode.php?page=<?php echo $linkNext; ?>">Next</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
    </div>
    </br>
    <?php //FOOTER
    include "part/footer.php";
    ?>
</body>





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js">
</script>

<script type="text/javascript">
    $('#modalForm').on('shown.bs.modal', function() {
        $('#myInput').trigger('focus')
    })

    function hapusKode(kodePer) {
        $.ajax({
            url: "process.php?act=delete",
            type: 'POST',
            data: {
                kode: kodePer
            },
            //dataType:'json',
            success: function(result) {
                alert("Data berhasil dihapus");
                window.location = 'frmMasterPeriode.php';
            },
            error: function(request, status, error) {
                alert(request.responseText);
                alert("Data gagal dihapus");
            }
        });
    }

    $(document).ready(function() {
        $('#keyword').keyup(function() {
            var key = $("#keyword").val();
            load_data(key);
            //console.log(keyword.value);
        });

        $('#btnSimpan').click(function() {
            var nama = $("#namaPeriode").val();
            var status = $("#statusPeriode").val();
            var tglAwal = $("#tanggalAwal").val();
            var tglAkhir = $("#tanggalAkhir").val();
            load_notifTambah(nama, status, tglAwal, tglAkhir);
            load_table()
            console.log('click jalan');
        });
    });

    function load_data(keyword) {
        $.ajax({
            type: 'POST',
            url: "process.php?act=cariDataPeriode",

            data: {
                keyword: keyword
            },
            success: function(tes) {
                $("#data").html(tes).show();
                //window.location = 'frmMasterPeriode.php';
                //$('#data').val();
                //console.log(load_data(keyword));
                //$('#data').val(res1);
            }
        });
        //console.log('ass');
    }

    function load_notifTambah(nama, status, tglAwal, tglAkhir) {
        $.ajax({
            type: 'POST',
            url: "process.php?act=tambahPeriode",
            data: {
                nama: nama,
                status: status,
                tglAwal: tglAwal,
                tglAkhir: tglAkhir
            },
            success: function(notifTambah) {
                $("#notifTambah").html(notifTambah).show();
                $('#insert_form')[0].reset();
                $('#btnClose').trigger("click");
                console.log('berhasil menambahkan data');
            }
        });
    }

    function load_table() {
        $.ajax({
            type: 'POST',
            url: "process.php?act=tabelPeriode",

            success: function(isiTable) {
                $('#data').html(isiTable).show();
                console.log('berhasil tampil table');
            }
        })
    }
</script>