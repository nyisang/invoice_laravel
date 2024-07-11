-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 11, 2024 at 07:45 AM
-- Server version: 5.7.41
-- PHP Version: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nyisoftechco_invoice_assessment`
--

-- --------------------------------------------------------

--
-- Table structure for table `invoice_grandTotal`
--

CREATE TABLE `invoice_grandTotal` (
  `id` int(255) NOT NULL,
  `invoicename` varchar(255) NOT NULL,
  `invoiceamount` int(255) NOT NULL,
  `invoice_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_grandTotal`
--

INSERT INTO `invoice_grandTotal` (`id`, `invoicename`, `invoiceamount`, `invoice_status`) VALUES
(10, 'ggy', 555, 'PAID');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_payments`
--

CREATE TABLE `invoice_payments` (
  `id` int(255) NOT NULL,
  `date` date NOT NULL,
  `userid` int(255) NOT NULL,
  `TransAmount` int(255) NOT NULL,
  `InvoiceID` int(255) NOT NULL,
  `BusinessShortCode` int(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `TransactionType` varchar(255) NOT NULL,
  `PartyA` varchar(255) NOT NULL,
  `PartyB` varchar(255) NOT NULL,
  `MSISDN` int(255) NOT NULL,
  `response` int(255) NOT NULL,
  `BillRefNumber` int(255) NOT NULL,
  `TransactionDesc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_sale`
--

CREATE TABLE `invoice_sale` (
  `id` int(11) NOT NULL,
  `sellerinvoice_id` int(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `amount` int(255) NOT NULL,
  `status` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_sale`
--

INSERT INTO `invoice_sale` (`id`, `sellerinvoice_id`, `product`, `amount`, `status`) VALUES
(12, 1, 'tyy', 555, 2);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_users`
--

CREATE TABLE `invoice_users` (
  `id` int(255) NOT NULL,
  `date` date NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phonenumber` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_users`
--

INSERT INTO `invoice_users` (`id`, `date`, `first_name`, `last_name`, `phonenumber`, `password`) VALUES
(1, '2024-07-10', 'jared', 'nyisang', '0713536458', '1234'),
(1, '2024-07-10', 'jared', 'nyisang', '0706358388', '1234'),
(2, '2024-07-10', 'James', 'Kirwa', '0724464491', '1234'),
(3, '2024-07-10', 'James', 'kirwa3', '0724464493', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ICPMLRPBocMzdTaJS3BSNBsrMOjXsK4UpRrr97bI', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiOUcyVEJub2FMVWJOcTR3MnVPSm9KT0FnWWIxa1EwUWFLYzNTbWFhQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjI6ImlkIjtpOjE7czoxMToicGhvbmVudW1iZXIiO3M6MTA6IjA3MTM1MzY0NTgiO30=', 1720584683);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoice_grandTotal`
--
ALTER TABLE `invoice_grandTotal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_payments`
--
ALTER TABLE `invoice_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_sale`
--
ALTER TABLE `invoice_sale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoice_grandTotal`
--
ALTER TABLE `invoice_grandTotal`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `invoice_payments`
--
ALTER TABLE `invoice_payments`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_sale`
--
ALTER TABLE `invoice_sale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
