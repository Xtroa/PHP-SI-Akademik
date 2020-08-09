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
                <h3 style="text-align: center;">Daftar Pengumuman</h3>
            </div>
            <div id="notifTambah"></div>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand">Cari Pengumuman : </a>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    
                    <div class="col-xs-3" style="margin-left: 20px;">
                        <input class="form-control" name="keyword" id="keyword" type="text" placeholder="Search"></input>
                    </div>
                </div>

                <button class="btn btn-success" data-toggle="modal" data-target="#modalForm">
                    + Tambah Pengumuman
                </button>
                <!-- Modal -->
                <div class="modal fade" id="modalForm" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel" style="text-align: center">TAMBAH PENGUMUMAN</h4>
                                <button type="button" id="btnClose" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">×</span>
                                    <span class="sr-only">Close</span>
                                </button>

                            </div>

                            <!-- Modal Body -->
                            <div class="modal-body">
                                <p class="statusMsg"></p>
                                <form method="post" id="insert_form" enctype="multipart/form-data" action="">
                                    <div class="form-group">
                                        <label for="inputName">Judul :</label>
                                        <input type="text" id="judul" class="form-control" placeholder="" name="judul">
                                    </div>
                                    <div class="form-group">
                                        <label>Teks : </label>
                                        <input type="text" id="teks" class="form-control" placeholder="" name="teks">
                                    </div>
                                    <label>Upload Foto :</label>
                                    <div class="form-group">
                                        <!-- <input type="file" class="form-control-file" name="file" id="file" accept="image/*" onchange="previewImage();" aria-describedby="inputGroupFileAddon01"> -->
                                        <input type="file" class="form-control-file" name="file" id="file" onchange="previewImage();" aria-describedby="inputGroupFileAddon01">
                                    </div>
                                    <div class="form-group">
                                        <img style="border-radius: 4px; padding: 5px; width: 150px;" id="preview">
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
                <table style="text-align: center;" class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">judul</th>
                            <th scope="col">waktu</th>
                            <th scope="col">gambar</th>
                            <th scope="col">isi</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="data" style="text-align: center;">
                        <?php

                        $link = mysqli_connect("localhost", "root", "", "pweb");
                        //*pagination
                        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
                        // Jumlah data per halaman
                        $limit = 3;
                        $limitStart = ($page - 1) * $limit;
                        $SqlQuery = mysqli_query($link, "SELECT * FROM pengumuman ORDER BY id DESC LIMIT " . $limitStart . "," . $limit);
                        $no = $limitStart + 1;

                        while ($row = mysqli_fetch_object($SqlQuery)) {
                            echo "<tr>";
                            echo "<td>" . $row->id . "</td>";
                            echo "<td>" . $row->judul . "</td>";
                            echo "<td>" . $row->waktu . "</td>";
                            echo "<td>" . '<img src="foto/' . $row->gambar . '" height="100" width="100"/>' . "</td>";
                            echo " <td> <button class='btn btn-info deskmk' id='idk' data-toggle='modal' data-target='#modalForm' value='$row->id';>Isi Berita</button>";
                            echo "<td> <a class='btn btn-info' href='frmUbahPengumuman.php?id=$row->id'> Edit </a>";
                            echo " <a class='btn btn-danger' onclick='hapusKode($row->id)'>HAPUS</button></a> </td>";


                        ?>
                            <!--<td><img src="image/edit.png" widht="30 px" height="30 px"/> | <a href="process.php?act=tambahMhs"><img src="image/trash.jpg" width="30 px" height="30 px"/><?php  ?></a></td>-->
                        <?php

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
                            <li class="page-item"><a class="page-link" href="frmMasterPengumuman.php?page=<?php echo $LinkPrev; ?>">Previous</a></li>
                        <?php
                        }
                        ?>

                        <?php
                        $SqlQuery = mysqli_query($link, "SELECT * FROM pengumuman");

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
                            <li class='page-item <?php echo $linkActive; ?>'> <a class="page-link" href="frmMasterPengumuman.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
                            <li class="page-item"><a class="page-link" href="frmMasterPengumuman.php?page=<?php echo $linkNext; ?>">Next</a></li>
                        <?php
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
        </br>
    </div>
    <?php //FOOTER
    include "part/footer.php";
    ?>
</body>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js">
</script>

<script>
    function hapusKode(id) {
        $.ajax({
            url: "process.php?act=deletePengumuman",
            type: 'POST',
            data: {
                id: id
            },
            //dataType:'JSON',
            success: function(data) {
                alert("Data berhasil dihapus");
                window.location='frmMasterPengumuman.php';
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });
    }

    function previewImage() {
        var file = document.getElementById("file").files;
        if (file.length > 0) {
            var fileReader = new FileReader();

            fileReader.onload = function(event) {
                document.getElementById("preview").setAttribute("src", event.target.result);
            };
            fileReader.readAsDataURL(file[0]);
        }
    }

    function load_data(kategori, keyword) {
        $.ajax({
            method: "POST",
            url: "process.php?act=cariDataPengumuman",
            data: {
                kategori: kategori,
                keyword: keyword
            },
            success: function(hasil) {
                $("#data").html(hasil).show();
                console.log('berhasil data');
            }
        });
    }
    $(document).ready(function() {

        $('#keyword').keyup(function() {
            var kategori = $("#kategori").val();
            var keyword = $("#keyword").val();
            load_data(kategori, keyword);
            console.log('berhasil key');
        });

        $('#btnSimpan').click(function() {
            var nrp = $("#nrp").val();
            var nama = $("#nama").val();
            var password = $("#password").val();
            var upassword = $("#upassword").val();
            var sks = $("#sks").val();
            var id = $id;
                $.ajax({
                url: "process.php?act=tambahPengumuman",
                type: 'post',
                processData: false,
                contentType: false,
                data: new FormData($('#insert_form')[0]), id,
                success: function(notifTambah) {
                    $("#notifTambah").html(notifTambah).show();
                    $('#insert_form')[0].reset();
                    $('#btnClose').trigger("click");
                    console.log('berhasil menambahkan data');
                },
                error: function (hasil)
                {
                    console.log('gagal menambahkan data');
                }
            });
            console.log('berhasil key');
        });
    });
</script>