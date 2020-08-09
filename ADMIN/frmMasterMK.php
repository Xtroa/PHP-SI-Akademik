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
                <h3 style="text-align: center;">Daftar Matakuliah</h3>
            </div>
            <div id="notifTambah"></div>
            <nav class="navbar navbar-expand-md navbar-light bg-light">
                <a class="navbar-brand">Cari Matakuliah : </a>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <div class="col-xs-3">
                        <input class="form-control" name="keyword" id="keyword" type="text" placeholder="Search"></input>
                    </div>
                </div>
                <button class="btn btn-success" data-toggle="modal" data-target="#modalForm">
                    + Tambah Matakuliah
                </button>
                <!-- Modal -->
                <div class="modal fade" id="modalForm" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel" style="text-align: center">TAMBAH MATAKULIAH</h4>
                                <button type="button" id="btnClose" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">×</span>
                                    <span class="sr-only">Close</span>
                                </button>

                            </div>

                            <!-- Modal Body -->
                            <div class="modal-body">
                                <p class="statusMsg"></p>
                                <!-- <form method="post" action="process.php?act=tambahMK"> -->
                                <form method="post" id="insert_form">
                                    <div class="form-group">
                                        <label for="inputName">Kode Matakuliah :</label>
                                        <input type="text" id="kodeMk" class="form-control" placeholder="Contoh : 16D132" name="kodeMK">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail">Nama Matakuliah :</label>
                                        <input type="text" id="namaMk" class="form-control" placeholder="Contoh : Kalkulus" name="namaMK">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputMessage">Deskripsi :</label>
                                        <textarea class="form-control" id="deskMk" placeholder="Contoh : Matakuliah ini mengajarkan" name="deskripsiMK" rows="3"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputMessage">Jumlah SKS :</label>
                                        <input type="text" id="jumlahMk" class="form-control" placeholder="Contoh : 3" name="jumlahSKS">
                                    </div>
                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <button type="button" id="btnSimpan" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            
            <div class="container">
                <table id="tableMK" class="table table-hover">
                    <thead style="text-align: center;">
                        <tr>
                            <th scope="col" style="text-align: center;">ID</th>
                            <th scope="col" style="text-align: center;">Nama Matkul</th>
                            <th scope="col" style="text-align: center;">Jumlah SKS</th>
                            <th scope="col" style="text-align: center; width: 500px;">Deskripsi</th>
                            <th scope="col" style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;" id="data">
                        <?php
                        $link = mysqli_connect("localhost", "root", "", "pweb");

                        //*pagination
                        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
                        // Jumlah data per halaman
                        $limit = 6;
                        $limitStart = ($page - 1) * $limit;
                        $SqlQuery = mysqli_query($link, "SELECT * FROM matakuliah ORDER BY kode_mk DESC LIMIT " . $limitStart . "," . $limit);
                        $no = $limitStart + 1;

                        while ($row = mysqli_fetch_object($SqlQuery)) {
                            echo "<tr>";
                            echo "<td>" . $row->kode_mk . "</td>";
                            echo "<td>" . $row->nama . "</td>";
                            echo "<td style='text-align: center;'>" . $row->jumlah_sks . "</td>";
                            echo "<td style='width: 500px;'>" . $row->deskripsi . "</td>";

                            echo "<td> <a class='btn btn-info' href='frmUbahMK.php?kode=$row->kode_mk'> Edit </a>";
                            echo " <a class='btn btn-danger' onclick='hapusKode($row->kode_mk)'>Hapus</a></td>";
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
                            <li class="page-item"><a class="page-link" href="frmMasterMK.php?page=<?php echo $LinkPrev; ?>">Previous</a></li>
                        <?php
                        }
                        ?>

                        <?php
                        $SqlQuery = mysqli_query($link, "SELECT * FROM matakuliah");

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
                            <li class='page-item <?php echo $linkActive; ?>'> <a class="page-link" href="frmMasterMK.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
                            <li class="page-item"><a class="page-link" href="frmMasterMK.php?page=<?php echo $linkNext; ?>">Next</a></li>
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

<script>
    function hapusKode(kodeMK) {
        $.ajax({
            url: "process.php?act=deleteMK",
            type: 'POST',
            data: {
                kode_mk: kodeMK
            },
            //dataType:'',
            success: function(data) {
                alert("Data berhasil dihapus");
                window.location = 'frmMasterMK.php';
            },
            error: function(request, status, error) {
                alert(request.responseText);
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
            var kodeMk = $("#kodeMk").val();
            var namaMk = $("#namaMk").val();
            var deskMk = $("#deskMk").val();
            var jumlahMk = $("#jumlahMk").val();
            load_notifTambah(kodeMk, namaMk, deskMk, jumlahMk);
            load_table();
            console.log(kodeMk);
            //alert(kodeMk);
        });
    });

    function load_data(keyword) {
        $.ajax({
            type: 'POST',
            url: "process.php?act=cariDataMatakuliah",
            data: {
                keyword: keyword
            },
            success: function(tes) {
                $("#data").html(tes).show();
                //$('#data').val();
                console.log("sukses");
                //$('#data').val(res1);
            }
        });
        //console.log('aaaa');
    }

    function load_notifTambah(kodeMk, namaMk, deskMk, jumlahMk) {
        $.ajax({
            type: 'POST',
            url: "process.php?act=tambahMK",
            data: {
                kodeMk: kodeMk, namaMk: namaMk, deskMk: deskMk, jumlahMk: jumlahMk
            },
            success: function(notifTambah) {
                $("#notifTambah").html(notifTambah).show();
                $('#insert_form')[0].reset(); 
                $('#btnClose').trigger("click");
                console.log('berhasil menambahkan data');
            }
        })
    }

    function load_table() {
        $.ajax({
            type: 'POST',
            url: "process.php?act=tabelMK",
            
            success: function(isiTable) {
                $('#data').html(isiTable).show();
                console.log('berhasil tampil table');
            }
        })
    }

</script>