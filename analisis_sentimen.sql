-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2017 at 01:27 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `analisis_sentimen`
--

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `id_kata` int(11) NOT NULL,
  `kata` varchar(20) NOT NULL,
  `bobot_positif` float NOT NULL,
  `bobot_negatif` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id_kata`, `kata`, `bobot_positif`, `bobot_negatif`) VALUES
(1, 'suka', 0.0245902, 0.02),
(2, 'dunia', 0.0163934, 0.00666667),
(3, 'informatika', 0.0532787, 0.0666667),
(4, 'bau', 0.00819672, 0.00666667),
(5, 'komputer', 0.0204918, 0.00666667),
(6, 'niat', 0.00819672, 0.00666667),
(7, 'masuk', 0.0163934, 0.04),
(8, 'jurus', 0.0122951, 0.0733333),
(9, 'ilmu', 0.0122951, 0.00666667),
(10, 'ajar', 0.0245902, 0.02),
(11, 'logika', 0.0204918, 0.0133333),
(12, 'algoritma', 0.00819672, 0.00666667),
(13, 'matematika', 0.0163934, 0.00666667),
(14, 'it', 0.0327869, 0.00666667),
(15, 'struktur', 0.00819672, 0.00666667),
(16, 'data', 0.0122951, 0.00666667),
(17, 'olah', 0.00819672, 0.00666667),
(18, 'dll', 0.00819672, 0.00666667),
(19, 'kerja', 0.0122951, 0.0133333),
(20, 'desain', 0.0122951, 0.00666667),
(21, 'video', 0.00819672, 0.00666667),
(22, 'paksa', 0.00819672, 0.00666667),
(23, 'teknik', 0.0491803, 0.0333333),
(24, 'nyesel', 0.00819672, 0.00666667),
(25, 'nggak', 0.00819672, 0.00666667),
(26, 'materi', 0.00819672, 0.00666667),
(27, 'multimedia', 0.00819672, 0.00666667),
(28, 'modal', 0.00819672, 0.00666667),
(29, 'laptop', 0.00819672, 0.00666667),
(30, 'dkv', 0.0122951, 0.00666667),
(31, 'tugas', 0.00819672, 0.00666667),
(32, 'aneh', 0.00819672, 0.00666667),
(33, 'pilih', 0.00819672, 0.00666667),
(34, 'bidang', 0.0122951, 0.0333333),
(35, 'minat', 0.0163934, 0.0133333),
(36, 'hubung', 0.00819672, 0.00666667),
(37, 'fotografi', 0.00819672, 0.00666667),
(38, 'biaya', 0.0122951, 0.00666667),
(39, 'uras', 0.00819672, 0.00666667),
(40, 'orang', 0.00819672, 0.00666667),
(41, 'ti', 0.00819672, 0.00666667),
(42, 'males', 0.00819672, 0.00666667),
(43, 'mikir', 0.0163934, 0.00666667),
(44, 'tahan', 0.00819672, 0.00666667),
(45, 'bosan', 0.00819672, 0.00666667),
(46, 'cocok', 0.0204918, 0.02),
(47, 'saran', 0.00819672, 0.00666667),
(48, 'ambil', 0.00819672, 0.00666667),
(49, 'silah', 0.00819672, 0.00666667),
(50, 'ahli', 0.0122951, 0.02),
(51, 'handal', 0.0163934, 0.00666667),
(52, 'jenis', 0.00819672, 0.00666667),
(53, 'akademis', 0.00819672, 0.00666667),
(54, 'ukur', 0.00819672, 0.00666667),
(55, 'kuasa', 0.00819672, 0.0133333),
(56, 'penuh', 0.00819672, 0.00666667),
(57, 'istilah', 0.00819672, 0.00666667),
(58, 'multitafsir', 0.00819672, 0.00666667),
(59, 'spesialisasi', 0.00819672, 0.00666667),
(60, 'networking', 0.00819672, 0.00666667),
(61, 'ai', 0.00819672, 0.00666667),
(62, 'rpl', 0.00819672, 0.00666667),
(63, 'database', 0.00819672, 0.00666667),
(64, 'os', 0.00819672, 0.00666667),
(65, 'dlbs', 0.00819672, 0.00666667),
(66, 'fokus', 0.00819672, 0.00666667),
(67, 'proses', 0.00819672, 0.00666667),
(68, 'pikir', 0.0122951, 0.00666667),
(69, 'selesai', 0.0122951, 0.00666667),
(70, 'teknologi', 0.00819672, 0.00666667),
(71, 'informasi', 0.00819672, 0.00666667),
(72, 'lulus', 0.00819672, 0.02),
(73, 'harap', 0.00819672, 0.00666667),
(74, 'bangun', 0.00819672, 0.00666667),
(75, 'sistem', 0.00819672, 0.00666667),
(76, 'sih', 0.0122951, 0.00666667),
(77, 'mudahnyanya', 0.00819672, 0.00666667),
(78, 'pemrograman', 0.0122951, 0.00666667),
(79, 'kuat', 0.00819672, 0.00666667),
(80, 'lumayan', 0.00819672, 0.00666667),
(81, 'jago', 0.00819672, 0.00666667),
(82, 'betah', 0.00819672, 0.00666667),
(83, 'kuliah', 0.0163934, 0.0266667),
(84, 'jaring', 0.0122951, 0.00666667),
(85, 'bikin', 0.0204918, 0.00666667),
(86, 'aplikasi', 0.0163934, 0.00666667),
(87, 'smartphone', 0.00819672, 0.00666667),
(88, 'game', 0.00819672, 0.00666667),
(89, 'web', 0.00819672, 0.00666667),
(90, 'dasar', 0.00819672, 0.00666667),
(91, 'sederhana', 0.00819672, 0.00666667),
(92, 'programming', 0.00819672, 0.00666667),
(93, 'pecah', 0.00819672, 0.00666667),
(94, 'bahasa', 0.00819672, 0.00666667),
(95, 'media', 0.00819672, 0.00666667),
(96, 'aja', 0.00819672, 0.00666667),
(97, 'pakai', 0.00819672, 0.00666667),
(98, 'software', 0.0163934, 0.00666667),
(99, 'buka', 0.00819672, 0.00666667),
(100, 'ide', 0.00819672, 0.00666667),
(101, 'compiler', 0.00819672, 0.00666667),
(102, 'text-editor', 0.00819672, 0.00666667),
(103, 'kayak', 0.00819672, 0.00666667),
(104, 'netbeans', 0.00819672, 0.00666667),
(105, 'visual', 0.00819672, 0.00666667),
(106, 'studio', 0.00819672, 0.00666667),
(107, 'laku', 0.00819672, 0.00666667),
(108, 'kerjaanya', 0.00819672, 0.00666667),
(109, 'program', 0.0122951, 0.00666667),
(110, 'analisa', 0.00819672, 0.00666667),
(111, 'ngurusin', 0.00819672, 0.00666667),
(112, 'pokok', 0.00819672, 0.00666667),
(113, 'coba', 0.00819672, 0.00666667),
(114, 'mikit', 0.00819672, 0.00666667),
(115, 'keren', 0.00819672, 0.00666667),
(116, 'sesuai', 0.00819672, 0.0133333),
(117, 'senang', 0.00819672, 0.00666667),
(118, 'dokter', 0.00819672, 0.00666667),
(119, 'sesal', 0.00409836, 0.0133333),
(120, 'lemah', 0.00409836, 0.0133333),
(121, 'salah', 0.00409836, 0.0133333),
(122, 'sulit', 0.00409836, 0.02),
(123, 'logik', 0.00409836, 0.0133333),
(124, 'lanjur', 0.00409836, 0.0133333),
(125, 'jebak', 0.00409836, 0.0133333),
(126, 'pindah', 0.00409836, 0.0133333);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`) VALUES
('user', '827ccb0eea8a706c4c34a16891f84e7b');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id_kata`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `id_kata` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
