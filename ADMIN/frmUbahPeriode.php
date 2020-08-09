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
		<h3 style="text-align: center">EDIT PERIODE</h3>
		<hr>
	</div>

	<div class="container">
		<div class="card" style="border-style: solid; border-color:grey;">

			<div class="card-header" style="text-align: left; background-color: lightgreen; ">
				<a class='btn btn-Danger' href="frmMasterPeriode.php"> KEMBALI </a>
			</div>

			<?php
			$link = mysqli_connect("localhost", "root", "", "pweb");
			$kode = $_GET['kode'];
			$sql = " SELECT * FROM periode WHERE kode='$kode'";
			$result = mysqli_query($link, $sql);

			while ($data = mysqli_fetch_object($result)) {
				if ($data->status == 1) {
					$a = "aktif";
				} else if ($data->status == 0) {
					$a = "non-aktif";
				}
			?>

				<div class="container">
					<form method="post" action="process.php?act=ubahPeriode">
						<div class="form-row" style="padding-top: 10px">
							<div class="form-group col-md-6">
								<label>Id : </label>
								<input type="text" class="form-control" name="kode" readonly value="<?php echo $data->kode ?>">
							</div>
						</div>
						<div class="form-row" style="padding-top: 10px">
							<div class="form-group col-md-6">
								<label>Nama Periode : </label>
								<input type="text" class="form-control" name="nama" value="<?php echo $data->nama ?>">
							</div>
						</div>
						<div class="form-row" style="padding-top: 10px">
							<div class="form-group col-md-6">
								<label>Status : </label>
								<!--<input type="text" class="form-control" name="status" value="<?php echo $a ?>">-->
								<select name="status" class="form-control">
									<?php
									$conn = mysqli_connect("localhost", "root", "", "pweb");
									$q = "SELECT DISTINCT(status) FROM periode";
									$res = mysqli_query($conn, $q);
									while ($rowCmbBox = mysqli_fetch_assoc($res)) {
										$selected = "";
										if ($rowCmbBox["status"] == $data->status) {
											$selected = "selected";
										}
									?>
										<option <?php echo $selected; ?> value="<?php echo $rowCmbBox["status"] ?>">
											<?php
											//echo "sas" . $rowCmbBox["status"];
											if ($rowCmbBox["status"] == 0) {
												echo "NON-AKTIF";
											} else if ($rowCmbBox["status"] == 1) {
												echo "AKTIF";
											}
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
								<label>Tanggal Awal : </label>
								<input type="date" class="form-control" name="tanggalBuka" value="<?php echo $data->tanggal_buka ?>">
							</div>
						</div>
						<div class="form-row" style="padding-top: 10px">
							<div class="form-group col-md-6">
								<label>Tanggal Akhir : </label>
								<input type="date" class="form-control" name="tanggalAkhir" value="<?php echo $data->tanggal_akhir ?>">
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