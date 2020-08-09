-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Agu 2020 pada 09.59
-- Versi server: 10.1.30-MariaDB
-- Versi PHP: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pweb`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(9) NOT NULL,
  `password` char(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart`
--

CREATE TABLE `cart` (
  `kode_kelas` int(11) NOT NULL,
  `nrp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `cart`
--

INSERT INTO `cart` (`kode_kelas`, `nrp`) VALUES
(16, 160414068),
(13, 160414068);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `kode_kelas` int(11) NOT NULL COMMENT 'Primary Key, Auto Increment',
  `kode_mk` varchar(8) NOT NULL COMMENT 'FK ke tabel Mata kuliah',
  `kode_periode` int(11) NOT NULL COMMENT 'FK ke tabel periode',
  `nama_kelas` varchar(8) NOT NULL COMMENT 'nama kelas, contoh: KP A, KP B',
  `kapasitas` smallint(6) NOT NULL COMMENT 'jumlah kapasitas kelas',
  `hapuskah` tinyint(1) NOT NULL COMMENT 'jika true maka kelas dianggap terhapus'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`kode_kelas`, `kode_mk`, `kode_periode`, `nama_kelas`, `kapasitas`, `hapuskah`) VALUES
(11, '4', 23, 'KP A', 50, 0),
(12, '4', 23, 'KP B', 50, 0),
(13, '4', 23, 'KP Z', 1, 0),
(14, '1', 23, 'KP A', 20, 0),
(15, '1', 23, 'KP B', 30, 0),
(16, '3', 23, 'kp C', 1, 0),
(17, '6', 26, 'tes moda', 10, 0),
(20, '', 0, 'KP G', 11, 0),
(21, '', 0, 'fdgdg', 33, 0),
(22, '7', 23, 'KP FIX', 22, 0),
(23, '8', 23, 'KP FIX 2', 22, 0),
(24, '1', 23, '24', 20, 0),
(26, '3', 23, 'header l', 22, 0),
(27, '3', 23, 'header l', 50, 0),
(28, '3', 23, 'notif', 11, 0),
(29, '1', 23, 'notif2', 22, 0),
(30, '14', 23, 'KP C', 44, 0),
(31, '6', 23, 'tessss', 22, 0),
(32, '5', 23, 'KP TES', 11, 0),
(33, '4', 23, 'KP TES 2', 22, 0),
(34, '3', 23, 'TESS FIX', 22, 0),
(35, '3', 23, 'FIX 2', 222, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nrp` int(9) NOT NULL COMMENT 'Primary Key',
  `nama` varchar(30) NOT NULL COMMENT 'Nama Mahasiswa',
  `jurusan` varchar(50) NOT NULL,
  `password` char(32) NOT NULL COMMENT 'Password md5',
  `jatah_sks` int(11) NOT NULL COMMENT 'Jumlah SKS yang boleh diambil',
  `foto_profil` varchar(100) NOT NULL COMMENT 'nama file foto profil mahasiswa (extension jpg)',
  `hapuskah` tinyint(1) NOT NULL COMMENT 'jika true maka data mhs dianggap terhapus'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`nrp`, `nama`, `jurusan`, `password`, `jatah_sks`, `foto_profil`, `hapuskah`) VALUES
(1213, 'frmssss', '', '11', 22, '92216228_229261088443481_3356473657143590912_o.jpg', 0),
(160414067, 'Madara', 'Teknik Multimedia', 'password', 22, 'images.jfif', 0),
(160414068, 'Yudis', 'Teknik Informatika', 'yudis', 24, 'bob.jpg', 0),
(160414069, 'Narto', 'Teknik Informatika', 'narto', 20, 'narto.jpg', 0),
(160414070, 'jerry', 'Teknik Multimedia', 'jerry', 24, 'jerry.jpg', 0),
(160414089, 'Michael', 'Teknik Kimia', 'michael', 22, '1527242603530.jpg', 0),
(160414090, 'tex fix', '', 'fix', 31, '1.png', 0),
(160414091, 'TEX', '', 'tex', 10, 'Capture.PNG', 0),
(160414099, 'Tes hppppp', '', '11', 22, 'Screenshot_2020-07-24-11-20-22-321_org.zwanoo.android.speedtest.jpg', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa_kelas`
--

CREATE TABLE `mahasiswa_kelas` (
  `nrp` varchar(9) NOT NULL,
  `kode_kelas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mahasiswa_kelas`
--

INSERT INTO `mahasiswa_kelas` (`nrp`, `kode_kelas`) VALUES
('160414067', 13),
('160414080', 13),
('160414069', 16);

-- --------------------------------------------------------

--
-- Struktur dari tabel `matakuliah`
--

CREATE TABLE `matakuliah` (
  `kode_mk` int(8) NOT NULL COMMENT 'Primary Key',
  `nama` varchar(30) NOT NULL COMMENT 'nama mata kuliah',
  `jumlah_sks` smallint(6) NOT NULL COMMENT 'jumlah sks untuk mata kuliah ini',
  `deskripsi` text NOT NULL COMMENT 'deskripsi tentang mk',
  `hapuskah` tinyint(1) NOT NULL COMMENT 'jika true maka mata kuliah dianggap terhapus'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `matakuliah`
--

INSERT INTO `matakuliah` (`kode_mk`, `nama`, `jumlah_sks`, `deskripsi`, `hapuskah`) VALUES
(1, 'game UBAH', 23, 'ini belajar game UBAH', 0),
(2, 'kalkulus UBAH Lagi', 4, 'neraka ini guys', 0),
(3, 'kalkulus 2 UBAH', 5, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa aaaaaaaaaaaaaaaaaaa aaaaaaaaaaaaaaaaaaaaaa', 0),
(4, 'kalkulus 2', 5, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa aaaaaaaaaaaaaaaaaaa aaaaaaaaaaaaaaaaaaaaaa', 0),
(5, 'tes', 23, 'why', 0),
(6, 'TES MODAL', 3, 'TES INI MODAL', 0),
(7, 'TES MODAL 2', 2, 'modal2', 0),
(8, 'Modal Tes', 3, 'tes modal', 0),
(11, 'TES LOAD', 3, 'LOAD INI', 0),
(12, 'page2', 3, 'dfsfsfsfd', 0),
(13, 'tes fix', 2, 'wdadaswa', 0),
(14, 'fix udh bener', 2, 'bener ', 0),
(15, 'fix modal', 2, 'adadassdada', 0),
(16, 'ABC', 22, 'AAAAAA', 0),
(17, 'dsadasdas', 2, 'sdsadsasdadsa', 0),
(1113737373, 'Tess hp 2', 4, 'Tes hp 2', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `isi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `waktu` datetime NOT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `judul`, `isi`, `gambar`, `waktu`, `id_admin`) VALUES
(1, 'tes judul', 'aasdadassda asdada dsa asdasdadada asdad ad asdad as da da a daasdadassda asdada dsa asdasdadada asdad ad asdad as da da a daasdadassda asdada dsa asdasdadada asdad ad asdad as da da a daasdadassda asdada dsa asdasdadada asdad ad asdad as da da a d', 'tttsa.jpg', '2020-07-22 06:00:00', 0),
(2, 'Tes', 'Mungkin jadi 1 adalah perbuatan anda, tetapi tanggal ini adalah wkwkwk', '93510619_892509721197998_8101755389227302912_n.jpg', '2020-07-23 04:25:01', 0),
(4, 'tessssss', 'sadasdfasfdasfa', 'ebi.jpg', '2020-07-23 04:36:16', 0),
(5, 'sadadasdad', 'adasdsadsad', 'bob.jpg', '2020-07-23 05:48:24', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `periode`
--

CREATE TABLE `periode` (
  `kode` int(11) NOT NULL COMMENT 'Primary Key, Auto Increment',
  `nama` varchar(30) NOT NULL COMMENT 'Contoh: GASAL 2014/2015, GENAP 2014/2015',
  `status` tinyint(1) NOT NULL COMMENT 'jika true maka periode aktif, sebaliknya tidak aktif',
  `hapuskah` tinyint(1) NOT NULL COMMENT 'jika true maka periode dianggap terhapus',
  `tanggal_buka` date NOT NULL COMMENT 'tanggal awal periode perwalian ',
  `tanggal_akhir` date NOT NULL COMMENT 'tanggal akhir periode perwalian'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `periode`
--

INSERT INTO `periode` (`kode`, `nama`, `status`, `hapuskah`, `tanggal_buka`, `tanggal_akhir`) VALUES
(13, 'periode 6 ubah', 0, 0, '2020-04-22', '2020-05-02'),
(19, 'PERIODE 7 UBAH ', 0, 0, '2020-04-01', '2020-05-01'),
(20, 'peisadha', 0, 0, '2020-04-16', '2020-04-21'),
(23, 'Periode 2021/2022', 1, 0, '2020-04-01', '2020-05-01'),
(25, 'dfs', 0, 0, '0000-00-00', '0000-00-00'),
(26, 'GASAL 2020/2021', 0, 0, '2020-04-07', '2020-05-05'),
(29, 'Periode Modal', 0, 0, '2020-05-04', '2020-06-04'),
(30, 'fix ', 0, 0, '2020-05-12', '2020-06-06'),
(31, 'Periode Baru', 0, 0, '2020-07-08', '2020-07-15'),
(32, 'TES JS', 0, 0, '2020-07-08', '2020-07-09'),
(33, 'tesjs', 0, 0, '2020-07-07', '2020-07-08'),
(34, 'tes js btn', 0, 0, '2020-07-07', '2020-07-08'),
(35, '', 0, 0, '0000-00-00', '0000-00-00'),
(36, 'FIX js', 0, 0, '2020-07-07', '2020-07-25'),
(37, '', 0, 0, '0000-00-00', '0000-00-00'),
(38, 'sadasdasdsad', 0, 0, '2020-07-07', '2020-07-31'),
(39, '', 0, 0, '0000-00-00', '0000-00-00'),
(40, '', 0, 0, '0000-00-00', '0000-00-00'),
(41, '', 0, 0, '0000-00-00', '0000-00-00'),
(42, '', 0, 0, '0000-00-00', '0000-00-00'),
(43, 'gfhgfhfffhg', 0, 0, '2020-07-01', '2020-08-08'),
(44, '', 0, 0, '0000-00-00', '0000-00-00'),
(45, '', 0, 0, '0000-00-00', '0000-00-00'),
(46, '', 0, 0, '0000-00-00', '0000-00-00'),
(47, '', 0, 0, '0000-00-00', '0000-00-00'),
(48, '', 0, 0, '0000-00-00', '0000-00-00'),
(49, '', 0, 0, '0000-00-00', '0000-00-00'),
(50, 'WOW', 0, 0, '2020-07-07', '2020-07-21'),
(51, 'WOW', 0, 0, '2020-07-07', '2020-07-21'),
(52, '', 0, 0, '0000-00-00', '0000-00-00'),
(53, 'TES1234', 0, 0, '2020-07-08', '2020-07-31'),
(54, 'TES1234', 0, 0, '2020-07-08', '2020-07-31'),
(55, '', 0, 0, '0000-00-00', '0000-00-00'),
(56, '', 0, 0, '0000-00-00', '0000-00-00'),
(57, '', 0, 0, '0000-00-00', '0000-00-00'),
(58, 'sdadasdadadadassadasddas232132', 0, 0, '0000-00-00', '2020-07-24'),
(59, 'asdasdsa', 0, 0, '2020-07-15', '2020-07-10'),
(60, 'tgdfdgsgfgsdg', 0, 0, '2020-07-01', '2020-07-22'),
(61, 'adsdhasklfas', 0, 0, '2020-07-29', '2020-08-08'),
(62, 'dsadadasda', 0, 0, '2020-07-08', '2020-07-18'),
(63, 'asdadsada', 0, 0, '2020-07-02', '2020-07-31'),
(64, 'ssdfsdffsdg', 0, 0, '2020-06-29', '2020-07-15'),
(65, 'dasdasafasf', 0, 0, '2020-07-01', '2020-07-23'),
(66, 'dasdasasfasdf', 0, 0, '2020-07-08', '2020-07-17'),
(67, 'LAST', 0, 0, '2020-07-15', '2020-07-23'),
(68, 'ccvcvx', 0, 0, '2020-07-01', '2020-07-29'),
(69, 'aaaa', 0, 0, '2020-06-29', '2020-07-31'),
(70, 'bbb', 0, 0, '2020-07-04', '2020-07-25'),
(71, 'cc', 0, 0, '2020-07-18', '2020-07-29'),
(72, 'tes window', 0, 0, '2020-07-08', '2020-07-16'),
(73, 'TES tabel update', 0, 0, '2020-07-07', '2020-07-29'),
(74, 'tessss tiixx', 0, 0, '2020-07-14', '2020-08-07'),
(75, 'stop', 0, 0, '2020-07-09', '2020-07-22'),
(76, 'stop it', 0, 0, '2020-07-16', '2020-07-31'),
(77, 'ADUH', 0, 0, '2020-07-16', '2020-07-31'),
(78, 'ADUH1', 0, 0, '2020-07-16', '2020-07-30'),
(79, 'ADUH2', 0, 0, '2020-07-15', '2020-07-30'),
(80, 'ADUH 3', 0, 0, '2020-07-06', '2020-07-30'),
(81, 'ADUH 4', 0, 0, '2020-07-07', '2020-07-31');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD KEY `kode_kelas` (`kode_kelas`),
  ADD KEY `nrp` (`nrp`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`kode_kelas`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nrp`);

--
-- Indeks untuk tabel `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD PRIMARY KEY (`kode_mk`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `periode`
--
ALTER TABLE `periode`
  ADD PRIMARY KEY (`kode`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `kode_kelas` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key, Auto Increment', AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `matakuliah`
--
ALTER TABLE `matakuliah`
  MODIFY `kode_mk` int(8) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key', AUTO_INCREMENT=1113737374;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `periode`
--
ALTER TABLE `periode`
  MODIFY `kode` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key, Auto Increment', AUTO_INCREMENT=82;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`kode_kelas`) REFERENCES `kelas` (`kode_kelas`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`nrp`) REFERENCES `mahasiswa` (`nrp`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
