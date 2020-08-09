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

<?php //header
include "part/header.php";
?>

<body style="background-color: lightgrey;">
	<div class="container">
		<hr>
		<h3 style="text-align: center">EDIT MATAKULIAH</h3>
		<hr>
	</div>

	<div class="container">
		<div class="card" style="border-style: solid; border-color:grey;">

			<div class="card-header" style="text-align: left; background-color: lightgreen; ">
				<a class='btn btn-Danger' href="frmMasterMK.php"> KEMBALI </a>
			</div>
			<?php
			$link = mysqli_connect("localhost", "root", "", "pweb");
			$kode = $_GET['kode'];
			//$namaPeriode = $_GET['kode_mk'];
			//$namaMatkul = $_GET['kode_mk'];
			$sql = " SELECT * FROM matakuliah WHERE kode_mk='$kode'";
			$result = mysqli_query($link, $sql);
			while ($data = mysqli_fetch_object($result)) {
			?>
				<div class="container">
					<form method="post" action="process.php?act=ubahMK">
						<div class="form-row" style="padding-top: 10px">
							<div class="form-group col-md-6">
								<label>Kode Matakuliah : </label>
								<input type="text" class="form-control" name="kode_mk" readonly value="<?php echo $data->kode_mk ?>">
							</div>
						</div>
						<div class="form-row" style="padding-top: 10px">
							<div class="form-group col-md-6">
								<label>Nama Matakuliah : </label>
								<input type="text" class="form-control" name="nama_mk" value="<?php echo $data->nama ?>">
							</div>
						</div>
						<div class="form-row" style="padding-top: 10px">
							<div class="form-group col-md-6">
								<label>Jumlah SKS : </label>
								<input type="text" class="form-control" name="jumlah_sks" value="<?php echo $data->jumlah_sks ?>">
							</div>
						</div>

						<div class="form-group">
							<label for="exampleFormControlTextarea1">Deskripsi</label>
							<textarea class="form-control" placeholder="Contoh : Matakuliah ini mengajarkan" name="deskripsi" rows="3"><?php echo $data->deskripsi ?></textarea>
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