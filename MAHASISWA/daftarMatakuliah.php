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
	?>

	<div class="container main">
		<div class="row">
			<!-- Modal -->
			<div class="modal fade" id="modalForm" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content" id="modalDetail">

					</div>
				</div>
			</div>
			<div class="col-sm-9">

				</br>
				<H4 style="text-align: center;">Daftar Matakuliah </H4>
				</br>
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
						//*pagination
						$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
						// Jumlah data per halaman
						$limit = 10;
						$limitStart = ($page - 1) * $limit;
						$SqlQuery = mysqli_query($link, "SELECT DISTINCT (k.kode_mk),m.nama,m.jumlah_sks
                    FROM 
                    kelas k INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk
                        INNER JOIN periode p ON k.kode_periode = p.kode
                    WHERE p.status = 1 LIMIT " . $limitStart . "," . $limit);
						$no = $limitStart + 1;
						$urutan = 0;

						while ($row = mysqli_fetch_object($SqlQuery)) {
							echo "<tr>";
							$urutan++;
							echo "<td>" . $urutan . "</td>";
							echo "<td>" . $row->kode_mk . "</td>";
							echo "<td>" . $row->nama . "</td>";
							echo "<td style='text-align: center;'>" . $row->jumlah_sks . "</td>";
							echo " <td> <button class='btn btn-info deskmk' id='idk' data-toggle='modal' data-target='#modalForm' value='$row->kode_mk';>Informasi MK</button>";
							echo " <button class='btn btn-success kpmk' id='idk' data-toggle='modal' data-target='#modalForm' value='$row->kode_mk'; onclick='load_data()';>Daftar KP</button></td>";
							echo "</tr>";
						}
						?>
					</tbody>
				</table>
			</div>

			<div class="col-sm-2">
				<h3>Filter</h3>
				<p>Jumlah sks : </p>
				<p>Cari matakuliah : </p>
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
	// $(document).ready(function() {
	// 	$('#modalForm').on('modalForm', function(e) {

	// 		var getDetail = $(e.relatedTarget).data('kode_mk');
	// 		console.log("aaaa");
	// 		/* fungsi AJAX untuk melakukan fetch data */
	// 		$.ajax({
	// 			type: 'post',
	// 			url: 'process.php?act=detailmk',
	// 			/* detail per identifier ditampung pada berkas detail.php yang berada di folder application/view */
	// 			data: 'getDetail=' + getDetail,
	// 			/* memanggil fungsi getDetail dan mengirimkannya */
	// 			success: function(data) {
	// 				$('.modal-data').html(data);
	// 				/* menampilkan data dalam bentuk dokumen HTML */
	// 			}
	// 		});
	// 	});
	// });


	function load_data() {
		// var id = document.getElementById("idk").value;
		// console.log(id);


		// $.ajax({
		// 	method: "POST",
		// 	url: "process.php?act=cariDataKelas",
		// 	data: {
		// 		kategori: kategori,
		// 		keyword: keyword
		// 	},
		// 	success: function(hasil) {
		// 		$("#data").html(hasil).show();
		// 		//console.log('berhasil data');
		// 	}
		// });
	}

	// $("button").click(function() {
	// 		var id = $(this).val();
	// 		//alert(id);
	// 		console.log(id);
	// 	});

	$(document).ready(function() {
		$('.kpmk').click(function() {
			var idmk = $(this).attr("value");
			//console.log(idmk);
			$.ajax({
				url: "process.php?act=detailmk",
				method: "post",
				data: {
					idmk: idmk
				},
				success: function(data) {
					$('#modalDetail').html(data); //isi
					$('#modalForm').modal("show"); //atas
				}
			});
		});

		$('.deskmk').click(function() {
			var deskmk = $(this).attr("value");
			console.log(deskmk);
			$.ajax({
				url: "process.php?act=deskripsiMK",
				method: "post",
				data: {
					deskmk: deskmk
				},
				success: function(data) {
					$('#modalDetail').html(data); //isi
					$('#modalForm').modal("show"); //atas
				}
			});
		});
	});
</script>