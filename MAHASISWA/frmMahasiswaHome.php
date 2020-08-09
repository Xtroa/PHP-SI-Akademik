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

    <?php
    $conn = mysqli_connect("localhost", "root", "", "pweb");
    $nrplogin = $_SESSION['nrp'];
    if (isset($_SESSION['nrp'])) {
        $query  = "SELECT * FROM mahasiswa WHERE nrp=$nrplogin";
        $hasil = mysqli_query($conn, $query);
        while ($row =  mysqli_fetch_assoc($hasil)) {
            $nama = $row['nama'];
        }
    }
    ?>


    <div class="container main" style="margin-top: 20px;">
        <h1 style="text-align: center;">Selamat Datang <?php echo $nama; ?></h1>
        <div class="row">
            <div class="col-sm-1.5" style="background-color: grey;">
                <?php
                $link = mysqli_connect("localhost", "root", "", "pweb");
                $SqlQuery = mysqli_query($link, "SELECT * FROM mahasiswa WHERE nrp=" . $nrplogin);
                while ($row = mysqli_fetch_object($SqlQuery)) {
                    echo "" . '<img style="" src="foto/' . $row->foto_profil . '" height="200" width="150"/>' . "<br></br>";
                }

                ?>


            </div>
            <div class="col-sm-7">
                <?php
                $link = mysqli_connect("localhost", "root", "", "pweb");
                $SqlQuery = mysqli_query($link, "SELECT * FROM mahasiswa WHERE nrp=" . $nrplogin);
                while ($row = mysqli_fetch_object($SqlQuery)) {
                    echo "Nrp : " . $row->nrp . "</br>";
                    echo "Nama : " . $row->nama . "</br>";
                    echo "Jurusan : " . $row->jurusan . "</br>";
                }
                ?>
                </br>
                <H4 style="text-align: center;">Matakuliah Yang Diambil </H4>
                </br>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Kelas</th>
                            <th scope="col">KP</th>
                            <th scope="col">SKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $link = mysqli_connect("localhost", "root", "", "pweb");

                        $SqlQuery = mysqli_query($link, "SELECT k.kode_kelas, m.nama AS namamatkul, p.nama AS namaPeriode, k.nama_Kelas as namakls,  k.kapasitas as kap, s.nrp, m.jumlah_sks as sks
                    FROM kelas k
                    INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk
                    INNER JOIN periode p ON k.kode_periode  = p.kode 
                    INNER JOIN mahasiswa_kelas s ON k.kode_kelas = s.kode_kelas WHERE s.nrp = $nrplogin");

                        $cek = mysqli_num_rows($SqlQuery);
                        if ($cek > 0) {
                            $no = 0;
                            while ($row =  mysqli_fetch_object($SqlQuery)) {
                                $no++;
                                echo "<tr>";
                                echo "<td>" . $no . "</td>";
                                echo "<td>" . $row->namamatkul . "</td>";
                                echo "<td>" . $row->namakls . "</td>";
                                echo "<td>" . $row->sks . "</td>";
                        ?>
                                <!--<td><img src="image/edit.png" widht="30 px" height="30 px"/> | <a href="process.php?act=deleteKLS"><img src="image/trash.jpg" width="30 px" height="30 px"/><?php  ?></a></td>-->
                            <?php
                                echo "</tr>";
                            }
                        } else {
                            ?>
                    </tbody>
                </table>
            <?php
                            echo "<tr>";
                            echo "<div class='alert alert-info' role='alert'>Anda belum mendaftar matakuliah ! </div>";
                            echo "</tr>";
                        }
            ?>
            </div>

            <div class="col-sm-3.5">

                <?php

                echo "Tanggal : " . date('l, d-M-Y ');
                echo "</br>";
                echo "<a><a>Jam Server : </a>" . " " . "<a id='timestamp'></a></a>";
                echo "</br>";
                echo "</br>";
                echo "<a>Cari matakuliah : </a>";
                echo "<a> <a class='btn btn-success btn-sm' href='daftarMatakuliah.php' target='_blank'>Daftar Matakuliah</a> </a>";

                ?>
                </br>
                <ul class="list-group mb-3" style="width: 320px;">
                    <div class="card-header" style="background-color: grey; margin-top: 20px;">
                        Pengumuman
                    </div>
                    <?php

                    $qpengumuman = "SELECT * FROM pengumuman";
                    $result = mysqli_query($conn, $qpengumuman);

                    while ($row = mysqli_fetch_array($result)) {
                        echo "<li class='list-group-item d-flex justify-content-between lh-condensed'>";
                        echo "<div>";
                        echo "<h6 class='my-0'>" . $row['judul'] . "</h6>";
                        $text = $row['isi'];
                        $ubat = (str_word_count($text) > 3 ? substr($text, 0, 100) . "..." : $text);
                        echo "<small class='text-muted'> $ubat </small>";
                        echo "</br>";
                        echo "<small>" . date('d-m-Y H:i', strtotime($row["waktu"])) . "</small>";

                        echo "</div>";

                        echo "</li>";
                    }


                    //echo "ubat : " . $ubat ;

                    ?>

                </ul>
            </div>
        </div>
    </div>

    <?php
    include "part/footer.php";
    ?>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js">
</script>

<script type="text/javascript">
    // Function ini dijalankan ketika Halaman ini dibuka pada browser
    $(function() {
        setInterval(timestamp, 1000); //fungsi yang dijalan setiap detik, 1000 = 1 detik
    });
    //Fungi ajax untuk Menampilkan Jam dengan mengakses e ajax_timestamp.php
    function timestamp() {
        $.ajax({
            url: 'process.php?act=ajax_timestamp.php',
            success: function(data) {
                $('#timestamp').html(data);
            },
        });
    }
</script>