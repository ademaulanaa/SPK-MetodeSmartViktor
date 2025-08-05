-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2025 at 05:19 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_smart_vikor`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `nama`) VALUES
(37, 'ANASUI DREAM'),
(38, 'ANASUI DREAM'),
(39, 'CREED AVENTUS'),
(40, 'ANGEL HEART'),
(41, 'ANGEL M'),
(42, 'ANGEL W'),
(43, 'ANGEL NOVA'),
(44, 'AGNES MONICA MANAGEMENT'),
(45, 'JOO MALONE WOOD SAGE'),
(46, 'ADIDAS SPORT'),
(47, 'ADIDAS'),
(48, 'COOL WATER M'),
(49, 'CK ONE'),
(50, 'CK MEN'),
(51, 'CK BEE'),
(52, 'COFFE'),
(53, 'CUDDLE'),
(54, 'D&G IMPERIALISTIS'),
(55, 'D&G'),
(56, 'DUNHILL LONDON'),
(57, 'KENZO BATANG'),
(58, 'DUNHILL BLUE'),
(59, 'DUNHILL '),
(60, 'DUNHILL BLUE'),
(61, 'DIOR SAUVAGE'),
(62, 'DIOR TOBACOLOR'),
(63, 'DAISY MARC JACO'),
(64, 'EMPERIO ARMANI'),
(65, 'DIOR POISON'),
(66, 'POLINA JEMMAN'),
(67, 'DALAL ABRAHA'),
(68, 'KENZO AMOUR'),
(69, 'KENZO BALI'),
(70, 'DELINA THE MARLEY'),
(71, 'KIRKE TIZIANA'),
(72, 'LACOSTE SPORT'),
(73, 'LALABO SANTAL'),
(74, 'LANCOME TRESOR'),
(75, 'LANCOME L'),
(76, 'ONE MILLION LUCKY'),
(77, 'LV OMBRE NOMADE'),
(78, 'MISS DIOR'),
(79, 'ONE DIRECTION'),
(80, 'MAHAIR ZEIN'),
(81, 'MADINAH ZEIN'),
(82, 'ARMANI MY WAY'),
(83, 'CHANNEL ALUR SPORT'),
(84, 'LOVELY AL REHAB'),
(85, 'LUX'),
(86, 'DIOR OUD ROSE'),
(87, 'ROSES ARE WHITE');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_smart`
--

CREATE TABLE `hasil_smart` (
  `id_hasil_smart` int(11) NOT NULL,
  `id_alternatif` int(11) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hasil_smart`
--

INSERT INTO `hasil_smart` (`id_hasil_smart`, `id_alternatif`, `nilai`) VALUES
(1, 47, 0.4),
(2, 46, 0.275),
(3, 44, 0.525),
(4, 37, 0.3),
(5, 38, 0.225),
(6, 40, 0.275),
(7, 41, 0.35),
(8, 43, 0.65),
(9, 42, 0.625),
(10, 82, 0.8),
(11, 83, 0.675),
(12, 51, 0.7),
(13, 50, 0.425),
(14, 49, 0.175),
(15, 52, 0.55),
(16, 48, 0.675),
(17, 39, 0.425),
(18, 53, 0.35),
(19, 55, 0.725),
(20, 54, 0.525),
(21, 63, 0.425),
(22, 67, 0.625),
(23, 70, 0.7),
(24, 86, 0.325),
(25, 65, 0.5),
(26, 61, 0.925),
(27, 62, 0.4),
(28, 59, 0.175),
(29, 58, 0.55),
(30, 60, 0.65),
(31, 56, 0.3),
(32, 64, 0.725),
(33, 45, 0.675),
(34, 68, 0.275),
(35, 69, 0.675),
(36, 57, 0.4),
(37, 71, 0.4),
(38, 72, 0.7),
(39, 73, 0.7),
(40, 75, 0.8),
(41, 74, 0.55),
(42, 84, 0.2),
(43, 85, 0.7),
(44, 77, 0.475),
(45, 81, 0.525),
(46, 80, 0.725),
(47, 78, 0.85),
(48, 79, 0.475),
(49, 76, 0.35),
(50, 66, 0.4),
(51, 87, 0.325);

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `kode_kriteria` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `type` enum('Benefit','Cost') NOT NULL,
  `bobot` float NOT NULL,
  `ada_pilihan` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `kode_kriteria`, `nama`, `type`, `bobot`, `ada_pilihan`) VALUES
(12, 'C1', 'Aroma', 'Benefit', 30, 1),
(13, 'C2', 'Ketahanan', 'Benefit', 30, 1),
(14, 'C3', 'Harga', 'Cost', 20, 1),
(18, 'C4', 'Kualitas Kemiripan', 'Benefit', 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `id_penilaian` int(11) NOT NULL,
  `id_alternatif` int(10) NOT NULL,
  `id_kriteria` int(10) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`id_penilaian`, `id_alternatif`, `id_kriteria`, `nilai`) VALUES
(307, 37, 12, 2),
(309, 37, 12, 2),
(310, 37, 13, 2),
(311, 37, 14, 4),
(313, 38, 12, 1),
(314, 38, 13, 2),
(315, 38, 14, 5),
(317, 39, 12, 3),
(318, 39, 13, 2),
(319, 39, 14, 2),
(321, 40, 12, 1),
(322, 40, 13, 2),
(323, 40, 14, 5),
(325, 41, 12, 1),
(326, 41, 13, 1),
(327, 41, 14, 2),
(329, 42, 12, 4),
(330, 42, 13, 3),
(331, 42, 14, 4),
(333, 43, 12, 3),
(334, 43, 13, 5),
(335, 43, 14, 5),
(337, 44, 12, 3),
(338, 44, 13, 2),
(339, 44, 14, 1),
(341, 45, 12, 3),
(342, 45, 13, 4),
(343, 45, 14, 3),
(345, 46, 12, 1),
(346, 46, 13, 2),
(347, 46, 14, 2),
(349, 47, 12, 2),
(350, 47, 13, 4),
(351, 47, 14, 3),
(353, 48, 12, 3),
(354, 48, 13, 4),
(355, 48, 14, 3),
(357, 49, 12, 1),
(358, 49, 13, 2),
(359, 49, 14, 5),
(360, 37, 12, 2),
(361, 37, 13, 2),
(362, 37, 14, 4),
(363, 37, 18, 3),
(364, 38, 12, 1),
(365, 38, 13, 2),
(366, 38, 14, 5),
(367, 38, 18, 4),
(368, 39, 12, 3),
(369, 39, 13, 2),
(370, 39, 14, 2),
(371, 39, 18, 2),
(372, 40, 12, 1),
(373, 40, 13, 2),
(374, 40, 14, 5),
(375, 40, 18, 5),
(376, 41, 12, 1),
(377, 41, 13, 1),
(378, 41, 14, 2),
(379, 41, 18, 5),
(380, 42, 12, 4),
(381, 42, 13, 3),
(382, 42, 14, 4),
(383, 42, 18, 5),
(384, 43, 12, 3),
(385, 43, 13, 5),
(386, 43, 14, 5),
(387, 43, 18, 5),
(388, 44, 12, 3),
(389, 44, 13, 2),
(390, 44, 14, 1),
(391, 44, 18, 3),
(392, 45, 12, 3),
(393, 45, 13, 4),
(394, 45, 14, 3),
(395, 45, 18, 5),
(396, 46, 12, 1),
(397, 46, 13, 2),
(398, 46, 14, 2),
(399, 46, 18, 2),
(400, 47, 12, 2),
(401, 47, 13, 4),
(402, 47, 14, 3),
(403, 47, 18, 1),
(404, 48, 12, 3),
(405, 48, 13, 4),
(406, 48, 14, 3),
(407, 48, 18, 5),
(408, 49, 12, 1),
(409, 49, 13, 2),
(410, 49, 14, 5),
(411, 49, 18, 3),
(412, 50, 12, 4),
(413, 50, 13, 1),
(414, 50, 14, 3),
(415, 50, 18, 3),
(416, 51, 12, 2),
(417, 51, 13, 4),
(418, 51, 14, 1),
(419, 51, 18, 5),
(420, 52, 12, 4),
(421, 52, 13, 4),
(422, 52, 14, 3),
(423, 52, 18, 1),
(424, 53, 12, 2),
(425, 53, 13, 2),
(426, 53, 14, 5),
(427, 53, 18, 5),
(428, 54, 12, 1),
(429, 54, 13, 4),
(430, 54, 14, 1),
(431, 54, 18, 3),
(432, 55, 12, 5),
(433, 55, 13, 4),
(434, 55, 14, 4),
(435, 55, 18, 4),
(436, 56, 12, 2),
(437, 56, 13, 2),
(438, 56, 14, 3),
(439, 56, 18, 2),
(440, 57, 12, 4),
(441, 57, 13, 2),
(442, 57, 14, 5),
(443, 57, 18, 3),
(444, 58, 12, 1),
(445, 58, 13, 5),
(446, 58, 14, 4),
(447, 58, 18, 5),
(448, 59, 12, 2),
(449, 59, 13, 1),
(450, 59, 14, 4),
(451, 59, 18, 2),
(452, 60, 12, 5),
(453, 60, 13, 1),
(454, 60, 14, 2),
(455, 60, 18, 5),
(456, 61, 12, 5),
(457, 61, 13, 4),
(458, 61, 14, 1),
(459, 61, 18, 5),
(460, 62, 12, 3),
(461, 62, 13, 1),
(462, 62, 14, 3),
(463, 62, 18, 4),
(464, 63, 12, 3),
(465, 63, 13, 4),
(466, 63, 14, 5),
(467, 63, 18, 2),
(468, 64, 12, 4),
(469, 64, 13, 5),
(470, 64, 14, 2),
(471, 64, 18, 2),
(472, 65, 12, 2),
(473, 65, 13, 2),
(474, 65, 14, 1),
(475, 65, 18, 4),
(476, 66, 12, 2),
(477, 66, 13, 2),
(478, 66, 14, 2),
(479, 66, 18, 3),
(480, 67, 12, 3),
(481, 67, 13, 2),
(482, 67, 14, 1),
(483, 67, 18, 5),
(484, 68, 12, 2),
(485, 68, 13, 1),
(486, 68, 14, 1),
(487, 68, 18, 1),
(488, 69, 12, 2),
(489, 69, 13, 5),
(490, 69, 14, 3),
(491, 69, 18, 5),
(492, 70, 12, 5),
(493, 70, 13, 1),
(494, 70, 14, 1),
(495, 70, 18, 5),
(496, 71, 12, 3),
(497, 71, 13, 1),
(498, 71, 14, 2),
(499, 71, 18, 3),
(500, 72, 12, 1),
(501, 72, 13, 5),
(502, 72, 14, 1),
(503, 72, 18, 5),
(504, 73, 12, 3),
(505, 73, 13, 5),
(506, 73, 14, 3),
(507, 73, 18, 4),
(508, 74, 12, 1),
(509, 74, 13, 5),
(510, 74, 14, 3),
(511, 74, 18, 4),
(512, 75, 12, 5),
(513, 75, 13, 5),
(514, 75, 14, 2),
(515, 75, 18, 2),
(516, 76, 12, 4),
(517, 76, 13, 2),
(518, 76, 14, 4),
(519, 76, 18, 1),
(520, 77, 12, 2),
(521, 77, 13, 3),
(522, 77, 14, 4),
(523, 77, 18, 5),
(524, 78, 12, 5),
(525, 78, 13, 3),
(526, 78, 14, 1),
(527, 78, 18, 5),
(528, 79, 12, 2),
(529, 79, 13, 5),
(530, 79, 14, 5),
(531, 79, 18, 3),
(532, 80, 12, 4),
(533, 80, 13, 3),
(534, 80, 14, 1),
(535, 80, 18, 4),
(536, 81, 12, 4),
(537, 81, 13, 3),
(538, 81, 14, 2),
(539, 81, 18, 1),
(540, 82, 12, 5),
(541, 82, 13, 5),
(542, 82, 14, 2),
(543, 82, 18, 2),
(544, 83, 12, 4),
(545, 83, 13, 3),
(546, 83, 14, 2),
(547, 83, 18, 4),
(548, 84, 12, 1),
(549, 84, 13, 1),
(550, 84, 14, 2),
(551, 84, 18, 2),
(552, 85, 12, 4),
(553, 85, 13, 4),
(554, 85, 14, 2),
(555, 85, 18, 3),
(556, 86, 12, 2),
(557, 86, 13, 3),
(558, 86, 14, 5),
(559, 86, 18, 3),
(560, 87, 12, 2),
(561, 87, 13, 3),
(562, 87, 14, 5),
(563, 87, 18, 3);

-- --------------------------------------------------------

--
-- Table structure for table `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_sub_kriteria` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_sub_kriteria`, `id_kriteria`, `nama`, `nilai`) VALUES
(15, 14, '5000', 4),
(16, 14, '3500', 3),
(19, 12, 'Woody', 4),
(20, 12, 'Fruty', 3),
(21, 12, 'Floral', 2),
(22, 12, 'Oriental', 1),
(23, 13, 'Sangat tahan', 5),
(24, 13, 'Tahan', 4),
(25, 13, 'Cukup ', 3),
(26, 13, 'Kurang', 2),
(27, 13, 'Sangat kurang', 1),
(28, 14, '6000', 5),
(29, 14, '2500', 2),
(30, 14, '2000', 1),
(39, 12, 'Fresh', 5),
(40, 18, 'Sangat Mirip', 5),
(41, 18, 'Mirip', 4),
(42, 18, 'Cukup', 3),
(43, 18, 'Kurang Mirip', 2),
(44, 18, 'Tidak mirip', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(5) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(70) NOT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `email`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Admin', 'admin@gmail.com'),
(11, 'aditya', '5d1852d43efe8f6e393448a3b4d1cd98a4cfd56f', 'Yoga Aditya', 'Yogaaditya@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indexes for table `hasil_smart`
--
ALTER TABLE `hasil_smart`
  ADD PRIMARY KEY (`id_hasil_smart`),
  ADD KEY `fk_hasilsmart_alternatif` (`id_alternatif`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `fk_penilaian_alternatif` (`id_alternatif`),
  ADD KEY `fk_penilaian_kriteria` (`id_kriteria`);

--
-- Indexes for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id_sub_kriteria`),
  ADD KEY `fk_subkriteria_kriteria` (`id_kriteria`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `hasil_smart`
--
ALTER TABLE `hasil_smart`
  MODIFY `id_hasil_smart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=564;

--
-- AUTO_INCREMENT for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_sub_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hasil_smart`
--
ALTER TABLE `hasil_smart`
  ADD CONSTRAINT `fk_hasilsmart_alternatif` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `fk_penilaian_alternatif` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_penilaian_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `fk_subkriteria_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
