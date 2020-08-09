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
                <h3 style="text-align: center;">Daftar Mahasiswa</h3>
            </div>
            <div id="notifTambah"></div>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand">Cari Mahasiswa : </a>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <div class="col-xs-3">
                        <select name="kategori" id="kategori" class="form-control">
                            <option value=""></option>
                            <option value="nrp">NRP</option>
                            <option value="nama">Nama</option>
                        </select>
                    </div>
                    <div class="col-xs-3" style="margin-left: 20px;">
                        <input class="form-control" name="keyword" id="keyword" type="text" placeholder="Search"></input>
                    </div>
                </div>

                <button class="btn btn-success" data-toggle="modal" data-target="#modalForm">
                    + Tambah Mahasiswa
                </button>
                <!-- Modal -->
                <div class="modal fade" id="modalForm" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel" style="text-align: center">TAMBAH MAHASISWA</h4>
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
                                        <label for="inputName">NRP :</label>
                                        <input type="text" id="nrp" class="form-control" placeholder="Contoh : 160414068" name="nrp">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Mahasiswa : </label>
                                        <input type="text" id="nama" class="form-control" placeholder="Contoh : Yudis" name="nama">
                                    </div>
                                    <div class="form-group">
                                        <label>Password : </label>
                                        <input type="password" id="password" class="form-control" name="password">
                                    </div>
                                    <div class="form-group">
                                        <label>Ulangi Password : </label>
                                        <input type="password" id="upassword" class="form-control" name="upassword">
                                    </div>
                                    <div class="form-group">
                                        <label>Jatah SKS : </label>
                                        <input type="text" id="sks" class="form-control" placeholder="Contoh : 3" name="sks">
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
                            <th scope="col">NRP</th>
                            <th scope="col">Nama</th>
                            <th scope="col">PASSWORD</th>
                            <th scope="col">JATAH SKS</th>
                            <th scope="col">FOTO</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="data" style="text-align: center;">
                        <?php

                        $link = mysqli_connect("localhost", "root", "", "pweb");
                        //$sql = " select * from mahasiswa";
                        //$result = mysqli_query($link, $sql);

                        // if (!$result) {
                        //    die("SQL Error");
                        // }

                        //*pagination
                        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
                        // Jumlah data per halaman
                        $limit = 3;
                        $limitStart = ($page - 1) * $limit;
                        $SqlQuery = mysqli_query($link, "SELECT * FROM mahasiswa ORDER BY nrp DESC LIMIT " . $limitStart . "," . $limit);
                        $no = $limitStart + 1;

                        while ($row = mysqli_fetch_object($SqlQuery)) {
                            echo "<tr>";
                            echo "<td>" . $row->nrp . "</td>";
                            echo "<td>" . $row->nama . "</td>";
                            echo "<td>" . $row->password . "</td>";
                            echo "<td>" . $row->jatah_sks . "</td>";
                            //echo "<td>" .$row->foto_profil. "</td>";
                            echo "<td>" . '<img src="foto/' . $row->foto_profil . '" height="100" width="100"/>' . "</td>";
                            echo "<td> <a class='btn btn-info' href='frmUbahMahasiswa.php?nrp=$row->nrp'> Edit </a>";
                            echo " <a class='btn btn-danger' onclick='hapusKode($row->nrp)'>HAPUS</button></a> </td>";


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
                            <li class="page-item"><a class="page-link" href="frmMasterMahasiswa.php?page=<?php echo $LinkPrev; ?>">Previous</a></li>
                        <?php
                        }
                        ?>

                        <?php
                        $SqlQuery = mysqli_query($link, "SELECT * FROM mahasiswa");

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
                            <li class='page-item <?php echo $linkActive; ?>'> <a class="page-link" href="frmMasterMahasiswa.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
                            <li class="page-item"><a class="page-link" href="frmMasterMahasiswa.php?page=<?php echo $linkNext; ?>">Next</a></li>
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
    function hapusKode(nrpP) {
        $.ajax({
            url: "process.php?act=deleteMHS",
            type: 'POST',
            data: {
                nrp: nrpP
            },
            //dataType:'JSON',
            success: function(data) {
                alert("Data berhasil dihapus");
                window.location='frmMasterMahasiswa.php';
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
            url: "process.php?act=cariDataMahasiswa",
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


    // function load_notifTambah(nrp, nama, password, upassword, sks, fd) {
    //     $.ajax({
    //         url: "process.php?act=tambahMhs",
    //         type: 'post',
    //         processData: false,
    //         contentType: false,
    //         data: {
    //             nrp: nrp, nama: nama, password: password, upassword: upassword, sks: sks, fd: fd
    //         },
    //         success: function(notifTambah) {
    //             $("#notifTambah").html(notifTambah).show();
    //             $('#insert_form')[0].reset();
    //             $('#btnClose').trigger("click");

                
                

    //             console.log('berhasil menambahkan data');
    //         },
    //         error: function (hasil)
    //         {
    //             console.log('gagal menambahkan data');
    //         }
    //     });
    // }


    

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
            //var upload = $("#file").val();

            

            // var file = document.getElementById('file').value;
            // var upload = file.replace("C:\\fakepath\\","");


            // var fd = new FormData();
            // var files = $('#file')[0].files[0];
            // fd.append('file',files);
            //console.log(fd);

                $.ajax({
                url: "process.php?act=tambahMhs",
                type: 'post',
                processData: false,
                contentType: false,
                data: new FormData($('#insert_form')[0]),
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
            //var formData = new FormData($("#form")[0]);

            //printObject(image_file);
            //alert (JSON.stringify(image_file));  
            //print_r ($image_file);

            // if(image_file <= 0){
            //     alert("No file selected.");
            // }

            // var upload;
            // upload = new FormData();
            // upload.append( 'file', $( '#file' )[0].files[0] );

            //var upload = document.getElementById("file").files[0];
            // $destination = './foto/aaaaa';
            // move_uploaded_file($_FILES['file']['tmp_name'], $destination);

            // var file = upload.replace("C:\\fakepath\\","C:\\xampp\\htdocs\\PWEB_ADMIN\\foto\\");
            // alert(file);
            // console.log(file);

            // alert(upload);
            // console.log(upload);

            //load_notifTambah(nrp, nama, password, upassword, sks, fd);
            console.log('berhasil key');
        });

        // $("#btnSimpan").click(function(){
        //     $("#pesan").ajaxStart(function(){
        //         $(this).show();
        //     }).ajaxComplete(function(){
        //         $(this).hide();
        //     });
        //     $.ajaxFileUpload({
        //         url: "process.php?act=upload.php",
        //         secureuri: false,
        //         fileElementId: "file",
        //         dataType: "json",
        //         success: function (json, status){
        //             if(json.status==1){
        //                 alert('berhasil')
        //             }else{
        //                 alert('Upload GAGAL!');
        //             }
        //         }
        //     });
        //     return false;
        // });

        
    });
</script>