<?php
session_start();
$link = mysqli_connect("localhost", "root", "", "pweb");
$act = $_GET['act'];
$nrplogin = $_SESSION['nrp'];

switch ($act) {
	case "loginMahasiswa":
		$nrp = $_POST['nrp'];
		$password = $_POST['upass'];

		$sql = "Select * from mahasiswa where nrp = '" . $nrp . "' AND password ='" . $password . "'";
		echo "sql : " . $sql;
		$result = mysqli_query($link, $sql);

		$cek = mysqli_num_rows($result);
		if ($cek > 0) {
			session_start();
			$_SESSION['nrp'] = $nrp;
			$_SESSION['status'] = "login";
			//echo "session : " . $nrp;
			header("location:frmMahasiswaHome.php");
		} else {
			header("location:home.php?pesan=gagal");
			//header("location:home.php");	
		}
		break;

	case "logout":
		session_start();
		session_destroy();
		header("location:home.php");
		break;

	case "detailmk":
		if (isset($_POST["idmk"])) {
			//$kode_mk = $_POST['idmk'];
			$sql = mysqli_query($link, "SELECT k.nama_kelas as nama, k.kapasitas as kapasitas
										FROM 
										kelas k INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk
										INNER JOIN periode p ON k.kode_periode = p.kode where m.kode_mk = '" . $_POST["idmk"] . "'");
?>
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel" style="text-align: center">DAFTAR KELAS YANG TERSEDIA</h4>
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">×</span>
					<span class="sr-only">Close</span>
				</button>
			</div>

			<!-- Modal Body -->
			<div class="container">
				<table class="table" style="margin-top: 20px; text-align: center;">
					<thead class="thead-light">
						<tr>
							<th scope="col">No</th>
							<th scope="col">KP</th>
							<th scope="col">Kapasitas</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						while ($row = mysqli_fetch_array($sql)) {
							echo "<tr>";
							echo "<td>" . $no++ . "</td>";
							echo "<td>" . $row["nama"] . "</td>";
							echo "<td>" . $row["kapasitas"] . "</td>";
							echo "</tr>";
						}
						?>
					</tbody>
				</table>
			</div>
			<!-- Modal -->

		<?php
		}
		break;

	case "deskripsiMK":
		if (isset($_POST["deskmk"])) {
			//$kode_mk = $_POST['idmk'];
			$sql = mysqli_query($link, "SELECT m.deskripsi as deskripsi FROM kelas k INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk 
					WHERE m.kode_mk = '" . $_POST["deskmk"] . "' LIMIT 1");
		?>
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel" style="text-align: center">Informasi Matakuliah</h4>
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">×</span>
					<span class="sr-only">Close</span>
				</button>
			</div>

			<!-- Modal Body -->
			<div class="container" style="margin-top: 20px; margin-bottom: 20px;">

				<?php
				$no = 1;
				while ($row = mysqli_fetch_array($sql)) {
					echo "<tr>";
					echo "<td>" . $row["deskripsi"] . "</td>";
					echo "</tr>";
				}
				?>
			</div>
			<!-- Modal -->
			<?php
		}
		break;

	case "tambahCart":
		$kodeMK = $_POST['kodeMK'];
		$namaKP = $_POST['namaKP'];

		// echo "KODE MK : " . $_POST['kodeMK'] . "</br>";
		// echo "KELAS KP : " . $_POST['namaKP'] . "</br>";

		//cek kapasitas
		// $sql = ("SELECT m.kode_mk, m.nama, k.nama_kelas, k.kapasitas, m.jumlah_sks AS sksM FROM kelas k INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk WHERE k.nama_kelas = $namaKP AND m.kode_mk = $kodeMK");
		// $res=mysqli_query($link,$sql);
		// //$sks=mysqli_fetch_array($res);

		// ambil kode kelas
		$q = "SELECT k.kode_kelas AS kodeKLS, m.jumlah_sks AS sksInput, m.kode_mk AS kodeMk
				FROM kelas k INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk 
				WHERE k.nama_kelas = '$namaKP' AND m.kode_mk = $kodeMK";
		$reskelas = mysqli_query($link, $q);
		$res1 = $reskelas->fetch_assoc();
		$kodemk = $res1["kodeMk"];
		//echo "KODE MK : " . $kodemk . "</br>";

		$query = "SELECT SUM(m.jumlah_sks) AS total, mh.jatah_sks AS jatah_sks, k.kode_mk AS kodeMk
				FROM kelas k 
				INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk 
				INNER JOIN cart c ON c.kode_kelas = k.kode_kelas
				INNER JOIN mahasiswa mh ON mh.nrp = c.nrp
				WHERE c.nrp = $nrplogin";
	
		$result = mysqli_query($link, $query);
		$row2 = $result->fetch_assoc();
		$kodemkCart = $row2["kodeMk"];
		//echo "KODE MK dari cart : " . $kodemkCart . "</br>";
		
		if ($kodemk != $kodemkCart)
		{
			$reskelas = mysqli_query($link, $q);
			$res1 = $reskelas->fetch_assoc();
			echo "lolos pengecekan kode mk </br>";
			$cek = mysqli_num_rows($reskelas);
			if($cek > 0)
			{
				echo "lolos pengecekan ada isinya </br>";
				while ($rowkelas =  mysqli_fetch_object($reskelas)) {
					echo "lolos pengecekan ada isinya bag 2</br>";
					$res = mysqli_query($link, $q);
					$row = mysqli_fetch_array($res);
					$sksInput = $row["sksInput"];
					
					$sksCart = $row2["total"];
					$jatah = $row2["jatah_sks"];
					
					echo "sks yang Input " . $sksInput . "</br>";
		
					$totalsks = 0;
					$totalsks = (int) $sksCart + (int) $sksInput;
					echo "total sks : " . $totalsks . "</br>";
		
					echo "SUM jumlahsks (total) : " . $sksCart . "</br>";
					echo "jatah sks : " . $jatah . "</br>";
					echo "sum + sks yang diinput = " . $sksCart . "+" . $sksInput . "=" . $totalsks . "</br>";
		
					if ($totalsks <= $jatah) {
						$sql2 = "insert into cart (kode_kelas, nrp) VALUES ('" . $rowkelas->kodeKLS . "','" . $nrplogin . "')";
						$result = mysqli_query($link, $sql2);
						if ($res) {
							echo "Tambah MK berhasil";
							header("location:test.php");
						} else {
							die("Error");
						}
						echo "masuk if masih bisa input " . "</br>";
					} else {
						header("location:Test.php?pesan=sksLebih");
						echo "udah maksimal " . "</br>";
					}
		
					echo "sks cart : " . $sksCart . "</br>";
					echo "jatah : " . $jatah . "</br>";
				}
			} else {
				echo "gagal lolos pengecekan ada isinya </br>";
				header("location:Test.php?pesan=tidakTersedia");
				//echo "salah satu input kelas tidak tersedia. ";
			}	
		} else {
			echo "gagal lolos pengecekan kode mk </br>";
			header("location:Test.php?pesan=mkSama");
			//echo "KODE MKNYA SAMA GA BISA. !!!";
		}
		break;

	case "deleteCart":
		$getId = $_POST['id'];
		$sql = "DELETE from cart where id=" . $getId . "";
		$result =  mysqli_query($link, $sql);

		if ($result) {
			echo "sukses";
			echo $sql;
		} else {
			echo "fail";
			echo $sql;
		}
		break;



}
?>