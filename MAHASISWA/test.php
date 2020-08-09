<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<?php
include "part/style.php";
?>

<body>
	<?php

	include "part/header.php";
	$nrplogin = $_SESSION['nrp'];
	//$SesionKdKelas = $_SESSION['kdKelas'];




	// echo "SESION KELAS KODENYA : " . $SesionKdKelas . "</br>";
	// $link = mysqli_connect("localhost", "root", "", "pweb");
	// $SqlPenuh = mysqli_query($link, "SELECT mk.nama AS namaMK
	// 	FROM kelas k INNER JOIN matakuliah mk ON k.kode_mk = mk.kode_mk 
	// 	WHERE k.kode_kelas = $SesionKdKelas");
	// $querycekpenuh = "SELECT mk.nama AS namaMK
	// FROM kelas k INNER JOIN matakuliah mk ON k.kode_mk = mk.kode_mk 
	// WHERE k.kode_kelas = $SesionKdKelas";
	// echo "query cek penuh : " . $querycekpenuh;



	?>
	<div class="container main">
		<div class="row">
			<div class="col-12 col-md-8 border border-dark" style="margin-top: 20px;">
				</br>
				<H4 style="text-align: center;">Pendafaran ditutup pada jam 16:00 WIB</H4>
				</br>
				<?php
				//notifikasi gagal login
				if (isset($_GET['pesan'])) {
					if ($_GET['pesan'] == "tidakTersedia") {
						echo "<div class='alert alert-danger' role='alert'> Salah satu input kelas tidak tersedia. </div>";
					} else if ($_GET['pesan'] == "sksLebih") {
						echo "<div class='alert alert-danger' role='alert'> sks melebihi jumlah jatah sks. </div>";
					} else if ($_GET['pesan'] == "mkSama") {
						echo "<div class='alert alert-danger' role='alert'> Matakuliah sudah diambil. </div>";
					} else if ($_GET['pesan'] == "kelasPenuh") {


						//echo <div id="dataPenuh" class="alert alert-danger" role="alert"> Kelas matakuliah sudah ada yang penuh : 
						//echo 
						// $no = 0;
						// while ($row = mysqli_fetch_object($SqlPenuh)) {
						// 	//echo "namamknya". $row->namaMK . "</br>";
						// 	$no++;
						// 	echo "<div class='alert alert-danger' role='alert'> Kelas matakuliah sudah ada yang penuh : </br> ";
						// 	echo "session nrp while : " . $_SESSION['kdKelas'];
						// 	echo "<p>" . $no . ". Matakuliah : " . $row->namaMK . "</p>";
						// 	echo "<p>" . $no . ". Matakuliah : " . $row->namaMK . "</p>";
						// 	echo "</div>";
						// }
					}
				}
				?>
				<div id="dataPenuh"> </div>
				<form method="post" action="process.php?act=tambahCart">
					<div class="form-inline">
						<div class="form-group">
							<label>Masukan Kode MK & KP kelas : </label>
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control col-md-12" placeholder="Kode MK" name="kodeMK" required>
						</div>
						<div class="col-md-2">
							<input type="text" class="form-control col-md-9" placeholder="KP" name="namaKP" required>
						</div>
						<button type="submit" class="btn btn-primary mb-2">Tambahkan</button>
						<br>
					</div>
					<?php
					$link = mysqli_connect("localhost", "root", "", "pweb");
					$SqlQuery = mysqli_query($link, "SELECT SUM(m.jumlah_sks) AS total, jatah_sks AS jatah_sks
						FROM 
						kelas k 
						INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk 
						INNER JOIN cart c ON c.kode_kelas = k.kode_kelas
						INNER JOIN mahasiswa mh ON mh.nrp = c.nrp
						WHERE c.nrp = $nrplogin");

					while ($row = mysqli_fetch_object($SqlQuery)) {
						echo "</br>";
						echo "<p style='text-align: right;'>Sisa SKS = " . $row->total . " / " . $row->jatah_sks . "</p>";
					}
					?>

				</form>

				<table class="table table-hover">
					<thead style="text-align: center;">
						<tr>
							<th scope="col">No</th>
							<th scope="col">Kode</th>
							<th scope="col">Nama Matakuliah</th>
							<th scope="col">Sks</th>
							<th scope="col">Aksi</th>
						</tr>
					</thead>
					<tbody style="text-align: center;" id="data">
						<?php
						$link = mysqli_connect("localhost", "root", "", "pweb");
						$SqlQuery2 = mysqli_query($link, "SELECT c.kode_kelas AS kodeKls, c.nrp AS nrp, mk.kode_mk AS kodemk ,mk.nama AS namamk, k.nama_kelas AS kp
						FROM cart c 
						INNER JOIN kelas k ON c.kode_kelas = k.kode_kelas
						INNER JOIN mahasiswa m ON c.nrp = m.nrp
                        INNER JOIN matakuliah mk ON mk.kode_mk = k.kode_mk
						WHERE c.nrp = $nrplogin");


						$urutan = 0;
						while ($row2 = mysqli_fetch_object($SqlQuery2)) {
							echo "<tr>";
							$urutan++;
							echo "<td>" . $urutan . "</td>";
							echo "<td>" . $row2->kodemk . "</td>";
							echo "<td>" . $row2->namamk . "</td>";
							echo "<td>" . $row2->kp . "</td>";
							echo "<td> <button type='button' class='btn btn-outline-danger' onclick='hapusKode($row2->kodeKls,$row2->nrp)'>X</button> </td>";
							//echo "<td style='text-align: center;'>" . $row->jumlah_sks . "</td>";
							//echo " <td> <button class='btn btn-info deskmk' id='idk' data-toggle='modal' data-target='#modalForm' value='$row->kode_mk';>Informasi MK</button>";
							//echo " <button class='btn btn-success kpmk' id='idk' data-toggle='modal' data-target='#modalForm' value='$row->kode_mk'; onclick='load_data()';>Daftar KP</button></td>";
							echo "</tr>";
						}
						?>
					</tbody>
				</table>
				</br>
				<!--<form method="post" action="process.php?act=konfirmasiCart">
				<button class='btn btn-primary float-right konfiirmasi'; id="konfirmasi"; style="margin-bottom: 20px;">Konfirmasi Matakuliah</button>	
				</form>-->
				<button class='btn btn-primary float-right konfiirmasi' ; id="konfirmasi" ; style="margin-bottom: 20px;">Konfirmasi Matakuliah</button>
			</div>
			<div class="col-6 col-md-3 border border-dark" style="margin-top: 20px; margin-left: 20px;">
				<?php

				echo "Tanggal : " . date('l, d-M-Y ');
				echo "</br>";
				echo "<a><a>Jam Server : </a>" . " " . "<a id='timestamp'></a></a>";
				echo "</br>";
				echo "</br>";
				echo "<a>Cari matakuliah : </a>";
				echo "<a> <a class='btn btn-success btn-sm' href='daftarMatakuliah.php' target='_blank'>Daftar Matakuliah</a> </a>";

				?>

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
	function hapusKode(kodeKls, nrp) {
		$.ajax({
			url: "process.php?act=deleteCart",
			type: 'POST',
			data: {
				kodeKls: kodeKls,
				nrp: nrp
			},
			//dataType:'JSON',
			success: function(data) {
				alert("Data berhasil dihapus");
				window.location = 'Test.php';
			},
			error: function(request, status, error) {
				alert(request.responseText);
			}
		});
	}


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

	function load_data() {
		$.ajax({
			url: "process.php?act=konfirmasiCart",
			success: function(hasil) {
				$("#dataPenuh").html(hasil).show();
				console.log('berhasil nampilin data');
			}
		});
	}

	$(document).ready(function() {
		$('#konfirmasi').click(function() {
			load_data();
			console.log('berhasil key');
		});
	});

	
</script>