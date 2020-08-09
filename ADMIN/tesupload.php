<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<body>
	<div>
	<form method="post" action="" enctype="multipart/form-data" id="myform">
			<label>a2st2aga1</label>
				<input type="file" class="form-control-file" name="file" id="file">
				<button type="button" id="btnSimpan" class="btn btn-primary">Simpan</button>
		</form>
	</div>
</body>

<?php



?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js">
</script>

<script>
	function load_notifTambah(fd) {
		$.ajax({
			enctype: "multipart/form-data",
			method: "POST",
			url: "upload.php",
			data: {
				fd: fd
			},
			success: function(notifTambah) {
				console.log('berhasil menambahkan data');
			},
			error: function(hasil) {
				console.log('gagal menambahkan data');
			}
		});
	}




	$(document).ready(function() {
		$('#btnSimpan').click(function() {
			var fd = new FormData();
			var files = $('#file').get(0).files[0];
			fd.append('#file',files);

			console.log(files);

			// var image_file = $('#file').files[0];
            // var formData = new FormData();
			// formData.append("file", image_file);
			


			load_notifTambah(fd);
		});

	});
</script>