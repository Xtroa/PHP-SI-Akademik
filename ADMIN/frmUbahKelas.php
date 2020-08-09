<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<style>
	.tablePeriode {
		margin-left: 5px;

	}

	div {
		margin-left: 0px;
		margin-top: 0px;
	}

	.tabletambah {
		margin-left: 0 px;
	}

	.tambahperiode {
		text-align: center;
	}

	.btnSimpan {
		margin-top: 19px;
	}
</style>
<?php //NAV
include "part/header.php";
?>

<body style="background-color: lightgrey;">
	<div class="container">
		<hr>
		<h3 style="text-align: center">EDIT KELAS</h3>
		<hr>
	</div>
	<div class="container">
		<div class="card" style="border-style: solid; border-color:grey;">

			<div class="card-header" style="text-align: left; background-color: lightgreen; ">
				<a class='btn btn-Danger' href="frmMasterKelas.php"> KEMBALI </a>
			</div>
			<?php
			$link = mysqli_connect("localhost", "root", "", "pweb");
			$kode = $_GET['kode_kelas'];
			//$periode = $_GET['']
			$sql = "SELECT k.kode_kelas, m.kode_mk, m.nama AS namamatkul, P.kode, p.nama AS namaPeriode, k.nama_Kelas as namakls,  k.kapasitas as kap 
			FROM kelas k 
			INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk 
			INNER JOIN periode p ON k.kode_periode  = p.kode 
			WHERE k.kode_kelas = $kode";
			$result = mysqli_query($link, $sql);
			while ($data = mysqli_fetch_object($result)) {
			?>

				<div class="container">
					<form method="post" action="process.php?act=ubahKLS">
						<div class="form-row" style="padding-top: 10px">
							<div class="form-group col-md-6">
								<label>Kode Kelas : </label>
								<input type="text" class="form-control" name="kode_kls" readonly value="<?php echo $data->kode_kelas ?>">
							</div>
						</div>
						<div class="form-row" style="padding-top: 10px">
							<div class="form-group col-md-6">
								<label>Nama Mata Kuliah : </label>
								<!--<input type="text" class="form-control" name="status" value="<?php echo $a ?>">-->
								<select name="pilihMK" class="form-control">
									<option></option>
									<?php
									$conn = mysqli_connect("localhost", "root", "", "pweb");
									$q = "SELECT * FROM matakuliah";
									$res = mysqli_query($conn, $q);
									while ($rowCmbBox = mysqli_fetch_assoc($res)) {
										$selected = "";
										if ($rowCmbBox["kode_mk"] == $data->kode_mk) {
											$selected = "selected";
										}
									?>
										<option <?php echo $selected; ?> value="<?php echo $rowCmbBox["kode_mk"]; ?>">
											<?php
											echo $rowCmbBox["nama"];
											?>
										</option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-row" style="padding-top: 10px">
							<div class="form-group col-md-6">
								<label>Periode : </label>
								<!--<input type="text" class="form-control" name="status" value="<?php echo $a ?>">-->
								<select name="pilihPeriode" class="form-control">
									<option></option>
									<?php
									$conn = mysqli_connect("localhost", "root", "", "pweb");
									$q = "SELECT * FROM periode";
									$res = mysqli_query($conn, $q);
									while ($rowCmbBox = mysqli_fetch_assoc($res)) {
										$selected = "";
										if ($rowCmbBox["kode"] == $data->kode) {
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
						</div>

						<div class="form-row" style="padding-top: 10px">
							<div class="form-group col-md-6">
								<label>Nama Kelas : </label>
								<input type="text" class="form-control" name="nama_kelas" value="<?php echo $data->namakls ?>">
							</div>
						</div>
						<div class="form-row" style="padding-top: 10px">
							<div class="form-group col-md-6">
								<label>Kapasitas : </label>
								<input type="text" class="form-control" name="kapasitas_kelas" value="<?php echo $data->kap ?>">
							</div>
						</div>
						<input type="submit" value="Simpan" class="btn btn-primary"></input>
					</form>
				</div>
		</div>
	</div>
	</br>
</body>


<?php //NAV
				include "part/footer.php";
?>

<?php
			}
?>