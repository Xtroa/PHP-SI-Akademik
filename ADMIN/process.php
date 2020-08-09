<?php
session_start();
$link = mysqli_connect("localhost","root", "" , "pweb");
$act = $_GET['act'];

switch($act) {
    case "loginAdmin":
        $username=$_POST['uname'];
        $password=$_POST['upass'];
        
		$sql = "Select * from admin where username = '".$username."' AND password ='".$password."'";
		//echo "sql : ".$sql;
		$result = mysqli_query($link, $sql);
		
		$row = mysqli_fetch_object($result);
		$id = $row->id;
		echo "session idnya : " . $id;

		$cek = mysqli_num_rows($result);
		if($cek > 0){
			$_SESSION['username'] = $username;
			$_SESSION['status'] = "login";
			$_SESSION['id'] = $id;
			header("location:frmAdminHome.php");
		}else{
			$_SESSION['status'] = "belumLogin";
			header("location:home.php?pesan=gagal");
		}
        
		break;
		
	case "logout":
		session_start();
		session_destroy();
		header("location:home.php");
		break;

	
    case "tambahPeriode":
        // $mysql="select * from periode";
        // $hasil= mysqli_query($link, $mysql);
        // while($row=  mysqli_fetch_object($hasil)){
        //     if($row->status==1)
        //     {
        //         $a=$row->nama;
        //         $kueri="Update periode set status='0' where nama='". $a."'";
        //         $kekka=  mysqli_query($link, $kueri);
        //     }
        // }
        $namaPeriode = $_POST['nama'];
        $statusPeriode = $_POST['status'];
        $tanggalMulaiPeriode = $_POST['tglAwal'];
        $tanggalAkhirPeriode = $_POST['tglAkhir'];
        $sql = "insert into periode (nama,status,hapuskah,tanggal_buka,tanggal_akhir) VALUES ('".$namaPeriode."','".$statusPeriode."','0' ,'".$tanggalMulaiPeriode."','".$tanggalAkhirPeriode."')";
        //echo $namaperiode;
        $result = mysqli_query($link, $sql);
		
		if($result)
		{
			//echo "Data periode berhasil masuk"; 
			//header("location:frmMasterPeriode.php");
			echo "<div class='alert alert-success' role='alert'>Berhasil menambahkan periode !</div>";		
		}
		else
		{
			die("Error");
		}
		break;
        
	case "tambahMK":
		$kodeMk = $_POST['kodeMk'];
		$namaMK = $_POST['namaMk'];
		$deskripsi = $_POST['deskMk'];
		$sks = $_POST['jumlahMk'];
		
		$sql = "insert into mataKuliah (kode_mk,nama,jumlah_sks,deskripsi,hapuskah) VALUES 
		('".$kodeMk."','".$namaMK."','".$sks."' ,'".$deskripsi."','0')";
		//echo "sql : " . $sql;
		$result = mysqli_query($link, $sql);
		
		if($result)
		{
			//echo "Tambah MK berhasil";
			//header("location:frmMasterMK.php");
			echo "<div class='alert alert-success' role='alert'>Matakuliah berhasil ditambahkan. </div>";
		}
		else
		{
			die("Error");
		}
		break;
		
	case "tabelMK":
		//*pagination
		$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
		// Jumlah data per halaman
		$limit = 6;
		$limitStart = ($page - 1) * $limit;
					
		$output = '';  
		$query = "SELECT * FROM matakuliah ORDER BY kode_mk DESC LIMIT " . $limitStart . "," . $limit ;

		$result = mysqli_query($link, $query);  
		while($row = mysqli_fetch_array($result))  
		{  
			$output .= '  
				<tr>   
					<td>'.$row["kode_mk"].'</td>  
					<td>'.$row["nama"].'</td>  
					<td>'.$row["jumlah_sks"].'</td>  
					<td>'.$row["deskripsi"].'</td>
					<td> <a class="btn btn-info" href="frmUbahMK.php?kode='.$row["kode_mk"] .'"> Edit </a>
					<a class="btn btn-danger" onclick=hapusKode('. $row["kode_mk"] .')>Hapus </a> </td>
				</tr>
			';  
		}
		echo $output;  
		break;	

		case "tabelKelas":
			//*pagination
			$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
			// Jumlah data per halaman
			$limit = 6;
			$limitStart = ($page - 1) * $limit;
						
			$output = '';  
			$query = "SELECT k.kode_kelas, m.nama AS namamatkul, p.nama AS namaPeriode, k.nama_Kelas as namakls,  k.kapasitas as kap
			FROM kelas k
			INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk
			INNER JOIN periode p ON k.kode_periode  = p.kode 
			ORDER BY kode_kelas DESC LIMIT " . $limitStart . "," . $limit;
	
			$result = mysqli_query($link, $query);  
			while($row = mysqli_fetch_array($result))  
			{  
				$output .= '  
					<tr>   
						<td>'.$row["kode_kelas"].'</td>  
						<td>'.$row["namamatkul"].'</td>  
						<td>'.$row["namaPeriode"].'</td>  
						<td>'.$row["namakls"].'</td>
						<td>'.$row["kap"].'</td>
						<td> <a class="btn btn-primary" href="frmUbahKelas.php?kode_kelas='.$row["kode_kelas"] .'"> Edit </a>
						<a class="btn btn-danger" onclick=hapusKode('. $row["kode_kelas"] .')>Hapus </a> </td>
					</tr>
				';  
			}
			echo $output;  
			break;	
	
	case "tabelPeriode":
		
		//*pagination
		$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
		// Jumlah data per halaman
		$limit = 6;
		$limitStart = ($page - 1) * $limit;
					
		$output = '';  
		$query = "SELECT * FROM periode ORDER BY kode DESC LIMIT " . $limitStart . "," . $limit ;

		$result = mysqli_query($link, $query);  
		while($row = mysqli_fetch_array($result))  
		{  
			if($row["status"] == 1)
			{
				$nstatus = "Aktif";
			}
			else
			{
				$nstatus = "non-aktif";
			}
			$output .= '  
				<tr>   
					<td>'.$row["kode"].'</td>  
					<td>'.$row["nama"].'</td>  
					<td>'.$row["tanggal_buka"].'</td>
					<td>'.$row["tanggal_akhir"].'</td>
					<td>'.$nstatus.'</td>
					<td> <a class="btn btn-info" href="frmUbahPeriode.php?kode='.$row["kode"] .'"> Edit </a>
					<a class="btn btn-danger" onclick=hapusKode('. $row["kode"] .')>Hapus </a> </td>
				</tr>
			';  
		}
		echo $output;  
		break;	
		
	case "tambahMhs":
	//$foto = $_POST['upload'];

		//$namaFile = $_POST['file'];
		
		// ambil data file
		$namaFile = $_FILES['file']['name'];
		$namaSementara = $_FILES['file']['tmp_name'];

		echo "namafilenya : " . $namaFile . "</br>";

		// tentukan lokasi file akan dipindahkan
		$dirUpload = "foto/";

		

		// if ($terupload) {
		// 	echo "berhasil upload";
			
		// } else {
		// 	echo "Upload Gagal!";
		// }

		
		$nrp = $_POST['nrp'];
		$namaMhs = $_POST['nama'];
		$password = $_POST['password'];
		$ulangiPassword = $_POST['upassword'];
		$sks = $_POST['sks'];
		
		$sql = "insert into mahasiswa (nrp,nama,password,jatah_sks,foto_profil,hapuskah) VALUES ('".$nrp."','".$namaMhs."','".$password."' ,'".$sks."','".$namaFile."','0')";
		
		echo "sql : " . $sql;
		//echo "password" . $password . " ". $ulangiPassword;
		
		if($password == $ulangiPassword)
		{
			//echo "password sama";
			$result = mysqli_query($link, $sql);
			if($result)
			{
				// pindahkan file
				$terupload = move_uploaded_file($namaSementara, $dirUpload.$namaFile);
				echo "Tambah mahasiswa berhasil, nama file -> " . $namaFile;
				//header("location:frmMasterMahasiswa.php");
				echo "<div class='alert alert-success' role='alert'>Mahasiswa berhasil ditambahkan. </div>";
			}
			else
			{
				die("Error");
				echo "sql : " . $sql;
			}
		}
		else
		{
			echo "password ga sama";
		}
		
		break;

	// case "upload":
	// 	if ($_FILES)
	// 	{
	// 		$tmp = $_FILES['file']['tmp_name'];
	// 		$type = $_FILES['file']['type'];
	// 		$size = $_FILES['filet']['size'];
	// 		$filename = $_FILES['file']['name'];
	// 		$path = pathinfo($_SERVER['PHP_SELF']);
	// 		$destination = $path['dirname'] . '/' . $filename;
	// 		if (move_uploaded_file($tmp, $_SERVER['DOCUMENT_ROOT'] . $destination))
	// 			$status = 1;
	// 		else
	// 			$status = 2;
		
	// 		$hasil = array(
	// 			'status' => $status,
	// 			'filename' => $filename,
	// 			'type' => $type,
	// 			'size' => $size,
	// 		);
	// 		echo json_encode($hasil);
	// 	}

	// break;
		
		
	case "tambahKelas":
		$namaKelas = $_POST['namaKelas'];
		$pilihPeriode = $_POST['periode'];
		$pilihMk = $_POST['matkul'];
		$kapasitas = $_POST['kapasitas'];
		
		$sql = "insert into kelas (kode_mk,kode_periode,nama_kelas,kapasitas,hapuskah) VALUES ('".$pilihMk."','".$pilihPeriode."' ,'".$namaKelas."','".$kapasitas."','0')";
        
        $result = mysqli_query($link, $sql);
        
        if($result)
        {
			//echo "Tambah kelas berhasil";
			//header("location:frmMasterKelas.php");
			echo "<div class='alert alert-success' role='alert'>Berhasil menambahkan kelas. </div>";
        }
        else
        {
            die("Error");
        }
		break;

	case "tambahPengumuman":
		$judul = $_POST['judul'];
		$teks = $_POST['teks'];
		
		$namaFile = $_FILES['file']['name'];
		$namaSementara = $_FILES['file']['tmp_name'];

		echo "namafilenya : " . $namaFile . "</br>";

		// tentukan lokasi file akan dipindahkan
		$dirUpload = "image/berita/";
		
		$id=$_SESSION['id'];
		echo $id;
		
		$sql = "insert into pengumuman (judul,isi,gambar,waktu,id_admin) VALUES ('".$judul."','".$teks."','".$namaFile."','".date('Y-m-d h:i:s')."','".$_SESSION['id']."')";
        echo $sql;
        $result = mysqli_query($link, $sql);
        
        if($result)
        {
			move_uploaded_file($namaSementara, $dirUpload.$namaFile);
			//echo "Tambah kelas berhasil";
			//header("location:frmMasterKelas.php");
			echo "<div class='alert alert-success' role='alert'>Berhasil menambahkan kelas. </div>";
        }
        else
        {
            die("Error");
        }

	break;

        
	case "ubahPeriode":
		$kode = $_POST['kode'];
		$nama = $_POST['nama'];
		$status = $_POST['status'];
		$tanggalBuka = $_POST['tanggalBuka'];
		$tanggalAkhir = $_POST['tanggalAkhir'];
		
		if($_POST['status'] == "AKHIR")
		{
			$status = 1;
		}
		else if($_POST['status'] == "NON-AKTIF")
		{
			$status = 0;
		}
		
		//echo "status : ". $_POST['status'] . $status . " akhir ";
		//echo "kode : " . $kode; 
		//echo "status : " . $status;
		
		$sql = "UPDATE periode SET nama='$nama', status='$status', tanggal_buka='$tanggalBuka', tanggal_akhir='$tanggalAkhir' WHERE kode='$kode'";
		
		echo "sql : " . $sql;
		$result = mysqli_query($link, $sql);
        
        if($result)
        {
			//echo "Ubah periode berhasil";
			//header("location:frmUbahPeriode.php?kode=$kode");
			header("location:frmMasterPeriode.php");
        }
        else
        {
			die("Error");
			//header('location: ./loginadmin.php?error=' .urldecode('username atau password salah'));
        }
        break;
		
	case "ubahMK":
		$kode = $_POST['kode_mk'];
		$nama = $_POST['nama_mk'];
		//$status = $_POST['status'];
		$jumlahsks = $_POST['jumlah_sks'];
		$deskripsi = $_POST['deskripsi'];
		
		//echo "kode : ". $_POST['kode_mk'] . " akhir ";
		//echo "kode : ". $_POST['kode'] . " akhir ";
		//echo "kode : " . $kode; 
		//echo "status : " . $status;
		
		$sql = "UPDATE matakuliah SET nama='$nama', jumlah_sks='$jumlahsks', deskripsi='$deskripsi' WHERE kode_mk='$kode'";
		
		echo "sql : " . $sql;
		$result = mysqli_query($link, $sql);
        
        if($result)
        {
			//echo "Ubah periode berhasil";
			header("location:frmMasterMK.php");
        }
        else
        {
            die("Error");
        }
        break;
		
	case "ubahMHS":
		// ambil data file
		$namaFile = $_FILES['upload']['name'];
		$namaSementara = $_FILES['upload']['tmp_name'];

		if($namaFile=="")
		{
			echo "nama file ga ada";
			$kode = $_POST['nrp'];
			$nama = $_POST['nama'];
			$password = $_POST['password'];
			$jatah_sks = $_POST['jatahsks'];
			
			$sql = "UPDATE mahasiswa SET nama='$nama', password='password', jatah_sks='$jatah_sks' WHERE nrp='$kode'";
			
			echo "sql : " . $sql;
			$result = mysqli_query($link, $sql);
			
			if($result)
			{
				//echo "Ubah periode berhasil";
				header("location:frmMasterMahasiswa.php");
			}
			else
			{
				die("Error");
			}
			break;
		}
		else
		{
			echo "nama file ada";
			$dirUpload = "foto/";

			// pindahkan file
			$terupload = move_uploaded_file($namaSementara, $dirUpload.$namaFile);
	
			if ($terupload) {
				//header("location:frmMasterMahasiswa.php");
			} else {
				echo "Upload Gagal!";
			}
	
			$kode = $_POST['nrp'];
			$nama = $_POST['nama'];
			$password = $_POST['password'];
			$jatah_sks = $_POST['jatahsks'];
			
			$sql = "UPDATE mahasiswa SET nama='$nama', password='password', jatah_sks='$jatah_sks', foto_profil='$namaFile' WHERE nrp='$kode'";
			
			echo "sql : " . $sql;
			$result = mysqli_query($link, $sql);
			
			if($result)
			{
				//echo "Ubah periode berhasil";
				header("location:frmMasterMahasiswa.php");
			}
			else
			{
				die("Error");
			}
			break;
		}
		// tentukan lokasi file akan dipindahkan
		break;
		
	case "ubahKLS":
		$kode = $_POST['kode_kls'];
		$kodeMk = $_POST['pilihMK'];
		$kodePeriode = $_POST['pilihPeriode'];
		$namaKelas= $_POST['nama_kelas'];
		$kapasitas = $_POST['kapasitas_kelas'];
		
		echo "kode MK : " . $kodeMk ."</br>";
		echo "kode periode : " . $kodePeriode ."</br>";
		echo "nama kelas  : " . $namaKelas ."</br>";
		echo "kapasitas  : " . $kapasitas ."</br>";
		//echo "kode : ". $_POST['kode_MK'] . " akhir ";
		//echo "kode : ". $_POST['kode'] . " akhir ";
		//echo "kode : " . $kode; 
		//echo "status : " . $status;
		
		$sql = "UPDATE kelas SET kode_mk='$kodeMk', kode_periode='$kodePeriode', nama_kelas='$namaKelas', kapasitas='$kapasitas' WHERE kode_kelas='$kode'";
		
		echo "sql : " . $sql;
		$result = mysqli_query($link, $sql);
        
        if($result)
        {
			echo "Ubah periode berhasil";
			header("location:frmMasterKelas.php");
        }
        else
        {
            die("Error");
        }
        break;
			
	
	case "delete":
        
		$getKode = $_POST['kode'];
        $sql="DELETE from periode where kode=" . $getKode . "";
        $result=  mysqli_query($link, $sql);
		/*
        if($result)
        {
            echo "sukses";
			echo $sql;
        }
        else{
            echo "fail";
			echo $sql;
        }*/
        break;
		
		
	case "deleteMK":
        $getKode = $_POST['kode_mk'];
		//$getnama = $_POST['namaMK'];
        $sql="DELETE from matakuliah where kode_mk=" . $getKode . "";
        $result=  mysqli_query($link, $sql);
		/*
        if($result)
        {
            //echo "sukses";
			
        }
        else{
            //echo "fail";
			//echo $sql;
        }
		*/
        break;
	
	case "deleteMHS":
        $getKode = $_POST['nrp'];
		//$getnama = $_POST['namaMK'];
        $sql="DELETE from mahasiswa where nrp=" . $getKode . "";
        $result=  mysqli_query($link, $sql);
		
        if($result)
        {
            echo "sukses";
			echo $sql;
			break;
        }
        else{
            //echo "fail";
			echo $sql;
        }
		
        break;
	
	case "deleteKLS":
        $getKode = $_POST['kode_kelas'];
		//$getnama = $_POST['namaMK'];
        $sql="DELETE from kelas where kode_kelas=" . $getKode . "";
		echo "sql : " . $sql;
        $result=  mysqli_query($link, $sql);
		
        if($result)
        {
            echo "sukses";
			echo $sql;
			
        }
        else{
            //echo "fail";
			echo $sql;
        }
		
        break;
	
	
	case "getPeriode":
		echo "<option value=''>Pilih Periode</option>";
	
		$query = "SELECT * FROM periode ORDER BY nama ASC";
		$dewan1 = $link->prepare($query);
		$dewan1->execute();
		$res1 = $dewan1->get_result();
		while ($row = $res1->fetch_assoc()) {
			echo "<option value='" . $row['kode'] . "'>" . $row['nama'] . "</option>";
		}
		break;

	case "getMatakuliah":
		echo "<option value=''>Pilih Matakuliah</option>";
	
		$query = "SELECT * FROM matakuliah ORDER BY nama ASC";
		$dewan1 = $link->prepare($query);
		$dewan1->execute();
		$res1 = $dewan1->get_result();
		while ($row = $res1->fetch_assoc()) {
			echo "<option value='" . $row['kode_mk'] . "'>" . $row['nama'] . "</option>";
		}
		break;
	
	case "getKelas":
		$matakuliah = $_POST['pilihMatakuliah'];
	
		echo "<option value=''>Pilih Kelas</option>";
	
		$query = "SELECT * FROM kelas WHERE kode_mk=$matakuliah";
		$dewan1 = $link->prepare($query);
		//$dewan1->bind_param("i", $matakuliah);
		$dewan1->execute();
		$res1 = $dewan1->get_result();
		while ($row = $res1->fetch_assoc()) {
			echo "<option value='" . $row['kode_kelas'] . "'>" . $row['nama_kelas'] . "</option>";
		}
		break;

	case "createPdf":
		
		// memanggil library FPDF
		require('part/fpdf.php');
		// intance object dan memberikan pengaturan halaman PDF
		$pdf = new FPDF('l','mm','A5');
		// membuat halaman baru
		$pdf->AddPage();
		// setting jenis font yang akan digunakan
		$pdf->SetFont('Arial','B',16);
		// mencetak string 
		$pdf->Cell(190,7,'UNIVERSITAS SURABAYA',0,1,'C');
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(190,7,'DAFTAR MAHASISWA ',0,1,'C');

		$mahasiswa = mysqli_query($link, "SELECT mk.nrp AS nrp, m.nama AS nama, k.nama_kelas AS namakelas, mt.nama AS namamatkul
		FROM 
		mahasiswa_kelas mk
		INNER JOIN kelas k ON mk.kode_kelas = k.kode_kelas 
		INNER JOIN mahasiswa m ON m.nrp = mk.nrp
		INNER JOIN matakuliah mt ON k.kode_mk = mt.kode_mk
		");
		$no = 1;
		$pdf->Ln();
		$row = mysqli_fetch_array($mahasiswa);
		$pdf->SetFont('Arial','B',20);
		$pdf->Cell(190,7,$row['namamatkul'],0,1,'C');
		
		// Memberikan space kebawah agar tidak terlalu rapat
		$pdf->Cell(10,7,'',0,1);

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(15,6,'No',1,0,'C');
		$pdf->Cell(40,6,'NRP',1,0,'C');
		$pdf->Cell(85,6,'NAMA MAHASISWA',1,0,'C');
		$pdf->Cell(47,6,'TTD',1,0,'C');
		
		
		$mahasiswa = mysqli_query($link, "SELECT mk.nrp AS nrp, m.nama AS nama, k.nama_kelas AS namakelas, mt.nama AS namamatkul
		FROM 
		mahasiswa_kelas mk
		INNER JOIN kelas k ON mk.kode_kelas = k.kode_kelas 
		INNER JOIN mahasiswa m ON m.nrp = mk.nrp
		INNER JOIN matakuliah mt ON k.kode_mk = mt.kode_mk
		");
		$no = 1;
		$pdf->Ln();
		while ($row = mysqli_fetch_array($mahasiswa)){
			$pdf->SetFont('Arial','B',10);
			$pdf->SetFillColor(255,255,255);
    		$pdf->Cell(15,6,$no++,1,0,'C',true);
			$pdf->Cell(40,6,$row['nrp'],1,0,'C');
			$pdf->Cell(85,6,$row['nama'],1,0,'L');
			$pdf->Cell(47,6,"",1,0,'C');
			$pdf->Ln();
		}

		$pdf->Output();
		break;

	case "cariDataPeriode":
		$s_keyword = $_POST['keyword'];
		
		$search_keyword = "'%". $s_keyword ."%'";
		$query = "SELECT * FROM periode WHERE nama LIKE $search_keyword";
		//echo "query : " . $query;
		
		$result = $link->prepare($query);
		//$result->bind_param('s', $s_keyword);
		$result->execute();
		$res1 = $result->get_result();

		if ($res1->num_rows > 0) {
			while ($row = $res1->fetch_assoc()) {
				$kode = $row['kode'];
				$nama = $row['nama'];
				$tgl_buka = $row['tanggal_buka'];
				$tgl_akhir = $row['tanggal_akhir'];
				$status = $row['status'];
				
				if ($status == 1) {
					$a = "aktif";
				} else if ($status == 0) {
					$a = "non-aktif";
				}
			?>
			
			<tr>
                <td><?php echo $kode; ?></td>
                <td><?php echo $nama; ?></td>
                <td><?php echo $tgl_buka; ?></td>
                <td><?php echo $tgl_akhir; ?></td>
				<td><?php echo $a; ?></td>
				<td> <a class='btn btn-info' href='frmUbahPeriode.php?kode=<?php echo $kode ?>'> Edit </a>
                <a class='btn btn-danger' onclick="hapusKode(<?php echo $kode ?>)">Hapus</a></td>
			</tr>
			
			<?php } 
			} else { ?> 
            <tr>
                <td colspan='7'>Tidak ada data ditemukan</td>
            </tr>
        <?php } ?>
		<?php
		break;

	case "cariDataMatakuliah":
		$s_keyword = $_POST['keyword'];
		
		$search_keyword = "'%". $s_keyword ."%'";
		$query = "SELECT * FROM matakuliah WHERE nama LIKE $search_keyword";
		//echo "query : " . $query;
		
		$result = $link->prepare($query);
		//$result->bind_param('s', $s_keyword);
		$result->execute();
		$res1 = $result->get_result();

		if ($res1->num_rows > 0) {
			while ($row = $res1->fetch_assoc()) {
				$kode_mk = $row['kode_mk'];
				$nama = $row['nama'];
				$jumlah_sks = $row['jumlah_sks'];
				$deskripsi = $row['deskripsi'];
			?>
			
			<tr>
				<td><?php echo $kode_mk; ?></td>
				<td><?php echo $nama; ?></td>
				<td><?php echo $jumlah_sks; ?></td>
				<td><?php echo $deskripsi; ?></td>
				<td> <a class='btn btn-info' href='frmUbahMK.php?kode=<?php echo $kode_mk ?>'> Edit </a>
                <a class='btn btn-danger' onclick="hapusKode(<?php echo $kode_mk ?>)">Hapus</a></td>
			</tr>
			<?php } 
			} else { ?> 
			<tr>
				<td colspan='7'>Tidak ada data ditemukan</td>
			</tr>
		<?php } ?>
		<?php
		break;
		
		/*case "cariDataMahasiswa":
			$s_keyword = $_POST['keyword'];
			
			$search_keyword = "'%". $s_keyword ."%'";
			$query = "SELECT * FROM mahasiswa WHERE nama LIKE $search_keyword";
			//echo "query : " . $query;
			
			$result = $link->prepare($query);
			//$result->bind_param('s', $s_keyword);
			$result->execute();
			$res1 = $result->get_result();
	
			if ($res1->num_rows > 0) {
				while ($row = $res1->fetch_assoc()) {
					$nrp = $row['nrp'];
					$nama = $row['nama'];
					$password = $row['password'];
					$jatah_sks = $row['jatah_sks'];
					$foto = $row['foto_profil'];
				?>
				
				<tr>
					<td><?php echo $nrp; ?></td>
					<td><?php echo $nama; ?></td>
					<td><?php echo $password; ?></td>
					<td><?php echo $jatah_sks; ?></td>
					<td><img src="foto/<?php echo $foto ?>" height="100" width="100"/> </td>
					<td> <a class='btn btn-info' href='frmUbahMahasiswa.php?nrp=<?php echo $nrp ?>'> Edit </a>
					<a class='btn btn-danger' onclick="hapusKode(<?php echo $nrp ?>)">Hapus</a></td>
				</tr>
				<?php } 
				} else { ?> 
				<tr>
					<td colspan='7'>Tidak ada data ditemukan</td>
				</tr>
			<?php } ?>
			<?php
			break;*/	
		
	case "cariDataMahasiswa":
		$kategori = $_POST['kategori'];
		$keyword = $_POST['keyword'];

		echo "kategori nya ini: " . $kategori;
		echo "</br> ";
		echo "keyword nya ini: " . $keyword;
		echo "</br> ";
		$search_keyword = "'%". $keyword ."%'";
		
		if($kategori=="nrp")
		{
			$query = "SELECT * FROM mahasiswa WHERE nrp LIKE $search_keyword";
		}
		else if($kategori=="nama")
		{
			$query = "SELECT * FROM mahasiswa WHERE nama LIKE $search_keyword";
		}
		else if($kategori=="")
		{
			$query = "SELECT * FROM mahasiswa";
		}
		//$query = "SELECT * FROM mahasiswa WHERE nrp LIKE $search_keyword AND nama LIKE '%%' ";

		echo "query : " . $query;
		
		$result = $link->prepare($query);
		//$result->bind_param('s', $s_keyword);
		$result->execute();
		$res1 = $result->get_result();

		if ($res1->num_rows > 0) {
			while ($row = $res1->fetch_assoc()) {
				$nrp = $row['nrp'];
				$nama = $row['nama'];
				$password = $row['password'];
				$jatah_sks = $row['jatah_sks'];
				$foto = $row['foto_profil'];
			?>
			
			<tr>
				<td><?php echo $nrp; ?></td>
				<td><?php echo $nama; ?></td>
				<td><?php echo $password; ?></td>
				<td><?php echo $jatah_sks; ?></td>
				<td><img src="foto/<?php echo $foto ?>" height="100" width="100"/> </td>
				<td> <a class='btn btn-info' href='frmUbahMahasiswa.php?nrp=<?php echo $nrp ?>'> Edit </a>
				<a class='btn btn-danger' onclick="hapusKode(<?php echo $nrp ?>)">Hapus</a></td>
			</tr>
			<?php } 
			} else { ?> 
			<tr>
				<td colspan='7'>Tidak ada data ditemukan</td>
			</tr>
		<?php } ?>
		<?php
		break;

	case "cariDataKelas":
		$kategori = $_POST['kategori'];
		$keyword = $_POST['keyword'];

		/*echo "kategori nya ini: " . $kategori;
		echo "</br> ";
		echo "keyword nya ini: " . $keyword;
		echo "</br> ";*/
		$search_keyword = "'%". $keyword ."%'";
		
		if($kategori=="namamatkul")
		{
			$query = "SELECT k.kode_kelas, m.nama AS namamatkul, p.nama AS namaPeriode, k.nama_Kelas as namakls,  k.kapasitas as kap
			FROM kelas k
			INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk
			INNER JOIN periode p ON k.kode_periode  = p.kode
			WHERE m.nama LIKE $search_keyword";
		}
		else if($kategori=="periode")
		{
			$query = "SELECT k.kode_kelas, m.nama AS namamatkul, p.nama AS namaPeriode, k.nama_Kelas as namakls,  k.kapasitas as kap
			FROM kelas k
			INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk
			INNER JOIN periode p ON k.kode_periode  = p.kode
			WHERE p.nama LIKE $search_keyword";
		}
		else if($kategori=="namakelas")
		{
			$query = "SELECT k.kode_kelas, m.nama AS namamatkul, p.nama AS namaPeriode, k.nama_Kelas as namakls,  k.kapasitas as kap
			FROM kelas k
			INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk
			INNER JOIN periode p ON k.kode_periode  = p.kode
			WHERE k.nama_kelas LIKE $search_keyword";
		}
		else if($kategori=="")
		{
			$query = "SELECT k.kode_kelas, m.nama AS namamatkul, p.nama AS namaPeriode, k.nama_Kelas as namakls,  k.kapasitas as kap
			FROM kelas k
			INNER JOIN matakuliah m ON k.kode_mk = m.kode_mk
			INNER JOIN periode p ON k.kode_periode  = p.kode";
			//echo "masuk matkul";
		}
		//$query = "SELECT * FROM mahasiswa WHERE nrp LIKE $search_keyword AND nama LIKE '%%' ";

		//echo "query : " . $query;
		
		$result = $link->prepare($query);
		//$result->bind_param('s', $s_keyword);
		$result->execute();
		$res1 = $result->get_result();

		if ($res1->num_rows > 0) {
			while ($row = $res1->fetch_assoc()) {
				$kodekelas = $row['kode_kelas'];
				$namamatkul = $row['namamatkul'];
				$namaperiode = $row['namaPeriode'];
				$namakls = $row['namakls'];
				$kapasitas = $row['kap'];
			?>
			
			<tr>
				<td><?php echo $kodekelas; ?></td>
				<td><?php echo $namamatkul; ?></td>
				<td><?php echo $namaperiode; ?></td>
				<td><?php echo $namakls; ?></td>
				<td><?php echo $kapasitas; ?> </td>
				<td> <a class='btn btn-info' href='frmUbahKelas.php?kode_kelas=<?php echo $kodekelas ?>'> Edit </a>
				<a class='btn btn-danger' onclick="hapusKode(<?php echo $kodekelas ?>)">Hapus</a></td>
			</tr>
			<?php } 
			} else { ?> 
			<tr>
				<td colspan='7'>Tidak ada data ditemukan</td>
			</tr>
		<?php } ?>
		<?php
		break;
			
	case "notifTambah":
		
		
	break;
}
?>           
        
     