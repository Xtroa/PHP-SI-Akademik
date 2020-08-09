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
		<h3 style="text-align: center">EDIT MAHASISWA</h3>
		<hr>
	</div>

	<div class="container">
		<div class="card" style="border-style: solid; border-color:grey;">
			<div class="card-header" style="text-align: left; background-color: lightgreen; ">
				<a class='btn btn-Danger' href="frmMasterMahasiswa.php"> KEMBALI </a>
			</div>
			<?php
			$link = mysqli_connect("localhost", "root", "", "pweb");
			$kode = $_GET['nrp'];
			$sql = " SELECT * FROM mahasiswa WHERE nrp='$kode'";
			$result = mysqli_query($link, $sql);
			while ($data = mysqli_fetch_object($result)) {
			?>
				<div class="container">
					<form method="post" action="process.php?act=ubahMHS" enctype="multipart/form-data">
						<div class="form-row" style="padding-top: 10px">
							<div class="form-group col-md-6">
								<label>NRP : </label>
								<input type="text" class="form-control" name="nrp" value="<?php echo $data->nrp ?>">
							</div>
						</div>
						<div class="form-row" style="padding-top: 10px">
							<div class="form-group col-md-6">
								<label>Nama : </label>
								<input type="text" class="form-control" name="nama" value="<?php echo $data->nama ?>">
							</div>
						</div>
						<div class="form-row" style="padding-top: 10px">
							<div class="form-group col-md-6">
								<label>Jatah sks : </label>
								<input type="text" class="form-control" name="jatahsks" value="<?php echo $data->jatah_sks ?>">
							</div>
						</div>
						<div class="form-row" style="padding-top: 10px">
							<div class="form-group col-md-6">
								<label>Password : </label>
								<input type="text" class="form-control" name="password" value="<?php echo $data->password ?>">
							</div>
						</div>

						<label>Foto : </label></br>
						<div class="form-row">
							<div class="form-group col-md-6">
								<input type="file" class="custom-file-input" name="upload" id="file" accept="image/*" onchange="previewImage();" aria-describedby="inputGroupFileAddon01">
								<label class="custom-file-label" for="inputGroupFile01">Choose file</label>
							</div>
						</div>

						<div class="form-row">
							<div class="col">
								<label>Foto lama : </label>
								</br>
								<img src="foto/<?php echo $data->foto_profil ?>" height="100" width="100" />
								<br style="text-align: center"><?php echo $data->foto_profil ?></br>
							</div>
							<div class="col">
								<label>Foto Baru : </label>
								</br>
								<img id="preview" height="100" width="100">
								</br>
								<label id="showText"></label>
							</div>
						</div>
						</br>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js">
</script>

<script>
	function previewImage() {
		var file = document.getElementById("file").files;
		if (file.length > 0) {
			var fileReader = new FileReader();

			fileReader.onload = function(event) {
				document.getElementById("preview").setAttribute("src", event.target.result);
				document.getElementById("showText").innerHTML = file[0].name;
				console.log(file);
			};
			fileReader.readAsDataURL(file[0]);
		}
	}
</script>