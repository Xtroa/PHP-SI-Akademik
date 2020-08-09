<?
include "koneksi.php";
?>

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
				<h3 style="text-align: center;">Daftar Kelas</h3>
			</div>
			<div id="notifTambah"></div>
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<a class="navbar-brand">Cari Kelas : </a>
				<div class="collapse navbar-collapse" id="navbarTogglerDemo02">
					<div class="col-xs-3">
						<select name="kategori" id="kategori" class="form-control">
							<option value=""></option>
							<option value="namamatkul">Nama MK</option>
							<option value="periode">Periode</option>
							<option value="namakelas">Nama Kelas</option>
						</select>
					</div>
					<div class="col-xs-3" style="margin-left: 20px;">
						<input class="form-control" name="keyword" id="keyword" type="text" placeholder="Search"></input>
					</div>
				</div>

				<button class="btn btn-success" data-toggle="modal" data-target="#modalForm">
					+ Tambah Kelas
				</button>
				<!-- Modal -->
				<div class="modal fade" id="modalForm" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<!-- Modal Header -->
							<div class="modal-header">
								<h4 class="modal-title" id="myModalLabel" style="text-align: center">TAMBAH KELAS</h4>
								<button type="button" id="btnClose" class="close" data-dismiss="modal">
									<span aria-hidden="true">×</span>
									<span class="sr-only">Close</span>
								</button>

							</div>

							<!-- Modal Body -->
							<div class="modal-body">
								<p class="statusMsg"></p>
								<form method="post" id="insert_form" enctype="multipart/form-data">
									<div class="form-group">
										<label>Nama Kelas : </label>
										<input type="text" id="namaKelas" class="form-control" name="namaKelas" placeholder="Contoh : KP A">
									</div>
									<div class="form-group">
										<label>Periode : </label>
										<select name="pilihPeriode" id="periode" class="form-control">
											<option></option>
											<?php
											$conn = mysqli_connect("localhost", "root", "", "pweb");
											$q = "SELECT * FROM periode WHERE status = 1";
											$res = mysqli_query($conn, $q);
											while ($rowCmbBox = mysqli_fetch_assoc($res)) {
												$selected = "";
												if ($rowCmbBox["kode"]) {
													$selected = "selected";
												}
											?>
												<option <?php echo $selected; ?> value="<?php echo $rowCmbBox["kode"]; ?>">
													<?php
													echo $rowCmbBox["nama"];
													?>
												</option>
											<?php
											}
											?>
										</select>
									</div>
									<div class="form-group">
										<label>Pilih Matakuliah : </label>
										<select name="pilihMK" id="matkul" class="form-control">
											<option></option>
											<?php
											$conn = mysqli_connect("localhost", "root", "", "pweb");
											$q = "SELECT * FROM matakuliah";
											$res = mysqli_query($conn, $q);
											while ($rowCmbBox = mysqli_fetch_assoc($res)) {
											?>
												<option value="<?php echo $rowCmbBox["kode_mk"]; ?>">
													<?php
													echo $rowCmbBox["nama"];
													?>
												</option>
											<?php
											}
											?>
										</select>
									</div>
									<div class="form-group">
										<label>Kapasitas Kelas : </label>
										<input type="text" id="kapasitas" class="form-control" placeholder="Contoh : 50" name="kapasitas">
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
				<table class="table table-hover">
					<thead style="text-align: center;">
						<tr>
							<th scope="col">Kode Kelas</th>
							<th scope="col">Nama MK</th>
							<th scope="col">PERIODE</th>
							<th scope="col">NAMA KELAS</th>
							<th scope="col">KAPASITAS</th>
							<th scope="col">Aksi</th>
						</tr>
					</thead>
					<tbody style="text-align: center;" id="data">
						<?php


						$link = mysqli_connect("localhost", "root", "", "pweb");
						//$sql = "SELECT k.kode_kelas, m.nama AS namamatkul, p.nama AS namaPeriode, k.nama_Kelas as namakls,  k.kapasitas as kap
						//		FROM kelas k
						//		INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk
						//		INNER JOIN periode p ON k.kode_periode  = p.kode
						//		";
						//$result = mysqli_query($link, $sql);

						//if (!$result) {
						//	die("SQL Error");
						//}

						//*pagination
						$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
						// Jumlah data per halaman
						$limit = 10;
						$limitStart = ($page - 1) * $limit;
						$SqlQuery = mysqli_query($link, "SELECT k.kode_kelas, m.nama AS namamatkul, p.nama AS namaPeriode, k.nama_Kelas as namakls,  k.kapasitas as kap
						FROM kelas k
						INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk
						INNER JOIN periode p ON k.kode_periode  = p.kode 
						ORDER BY kode_kelas DESC LIMIT " . $limitStart . "," . $limit);
						$no = $limitStart + 1;

						while ($row =  mysqli_fetch_object($SqlQuery)) {
							echo "<tr>";
							echo "<td>" . $row->kode_kelas . "</td>";

							echo "<td>" . $row->namamatkul . "</td>";
							echo "<td>" . $row->namaPeriode . "</td>";
							echo "<td>" . $row->namakls . "</td>";
							echo "<td>" . $row->kap . "</td>";
							echo "<td> <a class='btn btn-primary' href='frmUbahKelas.php?kode_kelas=$row->kode_kelas&namaPeriode=$row->namaPeriode&namamatkul=$row->namamatkul'> Edit </a>";
							echo " <a class='btn btn-danger' onclick='hapusKode($row->kode_kelas)'>Hapus</a></td>";

						?>
							<!--<td><img src="image/edit.png" widht="30 px" height="30 px"/> | <a href="process.php?act=deleteKLS"><img src="image/trash.jpg" width="30 px" height="30 px"/><?php  ?></a></td>-->
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
							<li class="page-item"><a class="page-link" href="frmMasterKelas.php?page=<?php echo $LinkPrev; ?>">Previous</a></li>
						<?php
						}
						?>

						<?php
						$SqlQuery = mysqli_query($link, "SELECT k.kode_kelas, m.nama AS namamatkul, p.nama AS namaPeriode, k.nama_Kelas as namakls,  k.kapasitas as kap
						FROM kelas k
						INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk
						INNER JOIN periode p ON k.kode_periode  = p.kode");

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
							<li class='page-item <?php echo $linkActive; ?>'> <a class="page-link" href="frmMasterKelas.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
							<li class="page-item"><a class="page-link" href="frmMasterKelas.php?page=<?php echo $linkNext; ?>">Next</a></li>
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
	function hapusKode(kodeKLS) {
		$.ajax({
			url: "process.php?act=deleteKLS",
			type: 'POST',
			data: {
				kode_kelas: kodeKLS
			},
			//dataType:'JSON',
			success: function(data) {
				alert("Data berhasil dihapus");
				window.location = 'frmMasterKelas.php';
			},
			error: function(request, status, error) {
				alert(request.responseText);
			}
		});
	}

	function load_data(kategori, keyword) {
		$.ajax({
			method: "POST",
			url: "process.php?act=cariDataKelas",
			data: {
				kategori: kategori,
				keyword: keyword
			},
			success: function(hasil) {
				$("#data").html(hasil).show();
				//console.log('berhasil data');
			}
		});
	}

	function load_notifTambah(namaKelas, periode, matkul, kapasitas) {
        $.ajax({
			type: 'POST',
            url: "process.php?act=tambahKelas",
            data: {
                namaKelas: namaKelas, periode: periode, matkul: matkul, kapasitas: kapasitas
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
            url: "process.php?act=tabelKelas",

            success: function(isiTable) {
                $('#data').html(isiTable).show();
                console.log('berhasil tampil table');
            }
        })
    }

	$(document).ready(function() {
		
		$('#keyword').keyup(function() {
			var kategori = $("#kategori").val();
			var keyword = $("#keyword").val();
			load_data(kategori, keyword);
			//console.log('berhasil key');
		});

		$('#btnSimpan').click(function() {
			var namakelas = $("#namaKelas").val();
			var periode = $("#periode").val();
			var matkul = $("#matkul").val();
			var kapasitas = $("#kapasitas").val();
			load_notifTambah(namakelas, periode, matkul, kapasitas);
			load_table();
			// alert(periode);
			// alert(matkul);
			//console.log('berhasil key');
		});
	});
</script>