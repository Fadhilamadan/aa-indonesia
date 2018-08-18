-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2017 at 04:56 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aaindonesia`
--

-- --------------------------------------------------------

--
-- Table structure for table `b_office`
--

CREATE TABLE `b_office` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `kota` varchar(50) NOT NULL,
  `kodepos` int(7) NOT NULL,
  `no_telp` varchar(50) NOT NULL,
  `aktif` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `b_office`
--

INSERT INTO `b_office` (`id`, `nama`, `alamat`, `kota`, `kodepos`, `no_telp`, `aktif`) VALUES
(1, 'KaliRungkut', 'Kali Rungkut Gg 2,  12-G', 'Surabaya', 60292, '031-321312', 1),
(2, 'Ubud', 'Jalan Kuta Lot VII 12 ', 'Denpasar', 34029, '0352-339172', 1),
(4, 'Pusat', 'Jalan Ayani 17', 'Jakarta', 600770, '021-223341', 0),
(6, 'RW001', 'Jl Manado Gg 17', 'Makassar', 34021, '0351-335870', 0),
(7, 'Manyar', 'Jl Manyar 1', 'Surabaya', 60291, '03123213', 0);

-- --------------------------------------------------------

--
-- Table structure for table `closing`
--

CREATE TABLE `closing` (
  `id` int(11) NOT NULL,
  `komisi` double NOT NULL,
  `tanggal` date DEFAULT NULL,
  `tipe` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `closing`
--

INSERT INTO `closing` (`id`, `komisi`, `tanggal`, `tipe`) VALUES
(72, 500000000, '2017-06-01', 'Closing'),
(73, 125000000, '2017-06-02', 'Closing'),
(74, 450000000, '2017-06-03', 'Closing'),
(75, 600000000, '2017-06-04', 'Closing');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `position_id` int(11) NOT NULL,
  `b_office_id` int(11) NOT NULL,
  `upline_id` int(11) DEFAULT NULL,
  `aktif` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `nama`, `jenis_kelamin`, `no_telp`, `tgl_lahir`, `position_id`, `b_office_id`, `upline_id`, `aktif`) VALUES
(1, 'Admin', 'Laki-Laki', '012345678', '2017-06-01', 2, 1, NULL, 1),
(50, 'Faishal Hendaryawan', 'Laki-Laki', '085752928290', '2000-12-31', 4, 1, NULL, 1),
(51, 'Rama Adhiguna', 'Laki-Laki', '312312', '2000-12-31', 4, 2, NULL, 1),
(52, 'Putu Aditya', 'Laki-Laki', '312312', '2000-12-11', 3, 1, NULL, 1),
(53, 'Suherman', 'Laki-Laki', '123123', '2000-12-31', 3, 2, 51, 1),
(54, 'Lucas Leonard', 'Laki-Laki', '12323', '2000-12-31', 1, 1, 50, 1),
(55, 'Kukuh', 'Laki-Laki', '123123', '2000-12-03', 1, 1, 51, 1),
(56, 'Fadhil Amadan', 'Laki-Laki', '4123123', '2000-12-31', 1, 1, 52, 1),
(57, 'Yaya', 'Perempuan', '123123', '2000-12-31', 1, 1, 56, 1),
(58, 'Guntoro', 'Laki-Laki', '132123', '2000-11-26', 1, 2, 53, 1),
(59, 'Sulistyo', 'Laki-Laki', '123123141', '2000-12-31', 1, 1, 57, 1),
(60, 'Sulistyo A', 'Laki-Laki', '123123141', '2000-12-31', 1, 1, 57, 1),
(61, 'Kurkur', 'Laki-Laki', '141234', '2000-12-31', 1, 2, 60, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hub_branch_employee`
--

CREATE TABLE `hub_branch_employee` (
  `id` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `branch_id` int(4) NOT NULL,
  `employee_id` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hub_branch_employee`
--

INSERT INTO `hub_branch_employee` (`id`, `tanggal`, `branch_id`, `employee_id`) VALUES
(3, '2017-06-01 14:41:05', 1, 50),
(4, '2017-06-01 14:41:54', 2, 51),
(5, '2017-06-01 14:42:20', 1, 52),
(6, '2017-06-01 14:43:42', 2, 53),
(7, '2017-06-02 14:45:11', 1, 54),
(8, '2017-06-02 14:45:27', 1, 55),
(9, '2017-06-02 14:47:07', 1, 56),
(10, '2017-06-03 14:49:12', 1, 57),
(11, '2017-06-03 14:49:35', 2, 58),
(12, '2017-06-03 14:50:05', 1, 59),
(13, '2017-06-03 14:50:05', 1, 60),
(14, '2017-06-03 14:51:31', 2, 61);

-- --------------------------------------------------------

--
-- Table structure for table `hub_closing_employee`
--

CREATE TABLE `hub_closing_employee` (
  `komisi` decimal(12,2) NOT NULL,
  `jml_unit` decimal(4,3) NOT NULL,
  `kerja_sama` int(1) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `closing_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hub_closing_employee`
--

INSERT INTO `hub_closing_employee` (`komisi`, `jml_unit`, `kerja_sama`, `employee_id`, `closing_id`) VALUES
('500000000.00', '1.000', 1, 53, 72),
('62500000.00', '0.500', 1, 56, 73),
('62500000.00', '0.500', 2, 54, 73),
('225000000.00', '0.500', 1, 61, 74),
('225000000.00', '0.500', 2, 60, 74),
('600000000.00', '1.000', 1, 58, 75);

-- --------------------------------------------------------

--
-- Table structure for table `hub_komisi`
--

CREATE TABLE `hub_komisi` (
  `pajak` decimal(12,2) NOT NULL,
  `nominal` decimal(12,2) NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `kerja_sama` int(1) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `closing_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hub_komisi`
--

INSERT INTO `hub_komisi` (`pajak`, `nominal`, `jenis`, `kerja_sama`, `employee_id`, `closing_id`) VALUES
('5000000.00', '34650000.00', 'pasif - principal', 1, 51, 72),
('625000.00', '1856250.00', 'pasif - vice principal', 1, 52, 73),
('625000.00', '4331250.00', 'pasif - principal', 1, 50, 73),
('625000.00', '1856250.00', 'pasif - vice principal', 2, 52, 73),
('625000.00', '4331250.00', 'pasif - principal', 2, 50, 73),
('2250000.00', '15592500.00', 'pasif - upline1', 1, 60, 74),
('2250000.00', '4455000.00', 'pasif - upline2', 1, 57, 74),
('2250000.00', '2227500.00', 'pasif - upline3', 1, 56, 74),
('2250000.00', '6682500.00', 'pasif - vice principal', 1, 53, 74),
('2250000.00', '15592500.00', 'pasif - principal', 1, 51, 74),
('2250000.00', '15592500.00', 'pasif - upline1', 2, 57, 74),
('2250000.00', '4455000.00', 'pasif - upline2', 2, 56, 74),
('2250000.00', '6682500.00', 'pasif - vice principal', 2, 52, 74),
('2250000.00', '15592500.00', 'pasif - principal', 2, 50, 74),
('6000000.00', '17820000.00', 'pasif - vice principal', 1, 53, 75),
('6000000.00', '41580000.00', 'pasif - principal', 1, 51, 75);

-- --------------------------------------------------------

--
-- Table structure for table `hub_positions_employee`
--

CREATE TABLE `hub_positions_employee` (
  `id` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `position_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hub_positions_employee`
--

INSERT INTO `hub_positions_employee` (`id`, `tanggal`, `position_id`, `employee_id`) VALUES
(53, '2017-06-01 14:41:05', 1, 50),
(54, '2017-06-01 14:41:19', 4, 50),
(55, '2017-06-01 14:41:54', 4, 51),
(56, '2017-06-01 14:42:20', 3, 52),
(57, '2017-06-01 14:43:42', 3, 53),
(58, '2017-06-02 14:45:11', 1, 54),
(59, '2017-06-02 14:45:27', 1, 55),
(60, '2017-06-02 14:47:07', 1, 56),
(61, '2017-06-03 14:49:12', 1, 57),
(62, '2017-06-03 14:49:35', 1, 58),
(63, '2017-06-03 14:50:05', 1, 59),
(64, '2017-06-03 14:50:05', 1, 60),
(65, '2017-06-03 14:51:31', 1, 61);

-- --------------------------------------------------------

--
-- Table structure for table `percents`
--

CREATE TABLE `percents` (
  `id` int(11) NOT NULL,
  `upline1` int(11) NOT NULL,
  `upline2` int(11) NOT NULL,
  `upline3` int(11) NOT NULL,
  `principal` int(11) NOT NULL,
  `vice_principal` int(11) NOT NULL,
  `pajak` double NOT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `percents`
--

INSERT INTO `percents` (`id`, `upline1`, `upline2`, `upline3`, `principal`, `vice_principal`, `pajak`, `tanggal`) VALUES
(1, 7, 2, 1, 7, 3, 1, '2017-04-02'),
(2, 5, 2, 1, 7, 3, 1, '2017-05-01');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `nama`) VALUES
(1, 'Agent'),
(2, 'Operator'),
(3, 'Vice_Principal'),
(4, 'Principal'),
(5, 'resign');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `employee_id`) VALUES
('admin', '81dc9bdb52d04dc20036dbd8313ed055', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `b_office`
--
ALTER TABLE `b_office`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `closing`
--
ALTER TABLE `closing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `position_id` (`position_id`),
  ADD KEY `b_office_id` (`b_office_id`),
  ADD KEY `upline_id` (`upline_id`);

--
-- Indexes for table `hub_branch_employee`
--
ALTER TABLE `hub_branch_employee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `hub_closing_employee`
--
ALTER TABLE `hub_closing_employee`
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `closing_id` (`closing_id`);

--
-- Indexes for table `hub_komisi`
--
ALTER TABLE `hub_komisi`
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `closing_id` (`closing_id`);

--
-- Indexes for table `hub_positions_employee`
--
ALTER TABLE `hub_positions_employee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `position_id` (`position_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `percents`
--
ALTER TABLE `percents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD KEY `employee_id` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `b_office`
--
ALTER TABLE `b_office`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `closing`
--
ALTER TABLE `closing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `hub_branch_employee`
--
ALTER TABLE `hub_branch_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `hub_positions_employee`
--
ALTER TABLE `hub_positions_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `percents`
--
ALTER TABLE `percents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`),
  ADD CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`b_office_id`) REFERENCES `b_office` (`id`),
  ADD CONSTRAINT `employees_ibfk_3` FOREIGN KEY (`upline_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `hub_branch_employee`
--
ALTER TABLE `hub_branch_employee`
  ADD CONSTRAINT `hub_branch_employee_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `b_office` (`id`),
  ADD CONSTRAINT `hub_branch_employee_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `hub_closing_employee`
--
ALTER TABLE `hub_closing_employee`
  ADD CONSTRAINT `hub_closing_employee_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `hub_closing_employee_ibfk_2` FOREIGN KEY (`closing_id`) REFERENCES `closing` (`id`);

--
-- Constraints for table `hub_komisi`
--
ALTER TABLE `hub_komisi`
  ADD CONSTRAINT `hub_komisi_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `hub_komisi_ibfk_2` FOREIGN KEY (`closing_id`) REFERENCES `closing` (`id`);

--
-- Constraints for table `hub_positions_employee`
--
ALTER TABLE `hub_positions_employee`
  ADD CONSTRAINT `hub_positions_employee_ibfk_1` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`),
  ADD CONSTRAINT `hub_positions_employee_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
