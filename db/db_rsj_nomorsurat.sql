-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 08, 2019 at 10:52 PM
-- Server version: 5.7.26-0ubuntu0.18.04.1
-- PHP Version: 7.2.19-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rsj_nomorsurat`
--

-- --------------------------------------------------------

--
-- Table structure for table `bagian_pengguna`
--

CREATE TABLE `bagian_pengguna` (
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `nama` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8_unicode_ci,
  `id_level_pengguna` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bagian_pengguna`
--

INSERT INTO `bagian_pengguna` (`id`, `created_at`, `modified_at`, `deleted_at`, `nama`, `keterangan`, `id_level_pengguna`) VALUES
(1, '2019-07-08 21:46:42', NULL, NULL, 'Kepegawaian', '', 2),
(2, '2019-07-08 21:46:53', '2019-07-08 21:47:15', NULL, 'Umum', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `bagian_surat`
--

CREATE TABLE `bagian_surat` (
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `kode` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `nama` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8_unicode_ci,
  `id_jenis_surat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bagian_surat`
--

INSERT INTO `bagian_surat` (`id`, `created_at`, `modified_at`, `deleted_at`, `kode`, `nama`, `keterangan`, `id_jenis_surat`) VALUES
(1, '2019-07-08 19:39:56', '2019-07-08 19:40:35', NULL, '001', 'Kepegawaian', '', 1),
(2, '2019-07-08 19:40:53', NULL, NULL, '002', 'Umum', '', 1),
(3, '2019-07-08 19:41:25', NULL, NULL, '001', 'Kepegawaian', '', 2),
(4, '2019-07-08 19:41:34', NULL, NULL, '002', 'Umum', '', 2),
(5, '2019-07-08 19:41:48', NULL, NULL, '001', 'Kepegawaian', '', 3),
(6, '2019-07-08 19:41:57', NULL, NULL, '002', 'Umum', '', 3);

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('ngj4vdlqeaigbs0c1r6sb1ieooff16sk', '::1', 1562575151, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323537353135313b),
('frj4f2vek6raiscp0aad53nmo9p0adoo', '::1', 1562576282, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323537363238323b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('cpejg7ai4bappn37i6jbmemqlljij92j', '::1', 1562578346, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323537383334363b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('temuflo58dppfdaltoel5ssmhlarcuhm', '::1', 1562580120, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323538303132303b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('8tp719spdspti6vrm6139m7af82s5qq3', '::1', 1562580482, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323538303438323b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('2uajfhas32srul678nghdqcs7ci35g1s', '::1', 1562582639, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323538323633393b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('931dlrv829m5qm66ps4dhh93qbjp83fl', '::1', 1562587849, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323538373834393b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('9nt4qr9lc9qs7b44jijl6r6r1poj43tr', '::1', 1562588307, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323538383330373b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('khr4lirnenle3h6cblejf0vc6ptrkl3m', '::1', 1562589477, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323538393437373b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('fk0v0q8ugem72km4fd6ug271mse8vckl', '::1', 1562589789, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323538393738393b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('2sria2344k431cgn88c8egvchk7lk7c2', '::1', 1562590094, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323539303039343b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('0dmvh3dfug5din4683j6rsbuaviuoc8a', '::1', 1562590435, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323539303433353b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('26qva6b8c9as008m5fm8a1417ktcaas1', '::1', 1562590739, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323539303733393b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('n410mler6a4j80pn37bcjcj16mecedg8', '::1', 1562591066, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323539313036363b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('n1dqtse4as18s9602srrehaajugevmve', '::1', 1562591429, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323539313432393b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('skkdtqrhikmgddsnvu8gv47tqpsdhom9', '::1', 1562591767, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323539313736373b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('6kfps17173h160lt1jjbsfppdqf24esi', '::1', 1562592218, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323539323231383b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('gqvlcvq6f4n49k9qiusjunkf9at5t76f', '::1', 1562592658, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323539323635383b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('865nt06po388n7h14t922vq0sd2rdtpi', '::1', 1562592991, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323539323939313b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('s6v3c0be3i570gprqi9m9ga6442mfbd1', '::1', 1562593481, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323539333438313b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('hp51k0kj6pf48el8fc76tdmnudt03lgj', '::1', 1562593809, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323539333830393b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('0ai0ocbmtglfd7agtmvh333mtjbvv0uh', '::1', 1562594233, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323539343233333b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('m9bnmv3491akf7n27uipo9mhl5ojhntj', '::1', 1562594568, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323539343536383b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('objbb5j8u8g5b5pgnla3v6g93pnbap1r', '::1', 1562594912, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323539343931323b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('narbi19dr0ls5jrbkcrau6jj5371kdc4', '::1', 1562595751, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323539353735313b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('g4eknv3v0dat3oacg5b0h9aasrqsh0a5', '::1', 1562596055, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323539363035353b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('roa88q2k72eft4o96catnkam8gcgfpv0', '::1', 1562596924, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323539363932343b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('6nsjepcrmog7ic1ab186pp8k3472b95d', '::1', 1562597239, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323539373233393b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('f97b9hhs7scocor53dap18msirtiojal', '::1', 1562597593, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323539373539333b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('5hu31d3j6ek2htttk2sktmhcjsoc3tci', '::1', 1562598105, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323539383130353b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('h3ek9bc7eql6ibvffefrf7osc19nc3kt', '::1', 1562598640, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323539383634303b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('3e695h2n0fkfco12oh9p5cu879mu657k', '::1', 1562599849, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323539393834393b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('0b1jcshcamosknn96mr6dt2mdiqu9sh6', '::1', 1562600163, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323630303136333b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2233656166666365383638393631303461666538363662383934303561653866653339313430396132223b7d),
('hhj55b243q2heqdbbdgt0sq29bne0ff6', '::1', 1562601018, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323630313031383b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2266373132663161623335323038333465383933343031363733333735663031646366343434363436223b7d),
('te4asr0cr60k94fcechptnid1lrlqbl1', '::1', 1562601113, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536323630313038393b7573657253657373696f6e7c613a393a7b733a323a226964223b733a313a2231223b733a333a226e6970223b733a31303a2231313337303130303534223b733a31313a22646973706c61794e616d65223b733a31333a2253616e6469204d756c79616469223b733a31343a22646973706c617950696374757265223b4e3b733a353a22656d61696c223b733a32323a2273616e64696d766c7961646940676d61696c2e636f6d223b733a363a226b6f6e74616b223b733a31323a22303837373230363134303030223b733a363a22616c616d6174223b4e3b733a353a226c6576656c223b733a353a2241444d494e223b733a353a22746f6b656e223b733a34303a2235313131656664386161393836326332386361373036663733376537383837363265363231336164223b7d);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_surat`
--

CREATE TABLE `jenis_surat` (
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `nama` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jenis_surat`
--

INSERT INTO `jenis_surat` (`id`, `created_at`, `modified_at`, `deleted_at`, `nama`, `keterangan`) VALUES
(1, '2019-07-08 19:11:07', '2019-07-08 19:13:03', NULL, 'Surat Keputusan (SK)', ''),
(2, '2019-07-08 19:13:37', '2019-07-08 19:39:30', NULL, 'Surat Perintah (SP)', ''),
(3, '2019-07-08 19:14:08', NULL, NULL, 'Nota Dinas', '');

-- --------------------------------------------------------

--
-- Table structure for table `level_pengguna`
--

CREATE TABLE `level_pengguna` (
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `nama` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `level_pengguna`
--

INSERT INTO `level_pengguna` (`id`, `created_at`, `modified_at`, `deleted_at`, `nama`, `keterangan`) VALUES
(1, NULL, '2019-07-08 21:47:31', NULL, 'ADMIN', ''),
(2, NULL, NULL, NULL, 'PEGAWAI', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nomor_surat`
--

CREATE TABLE `nomor_surat` (
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `id_jenis_surat` int(11) NOT NULL,
  `id_bagian_surat` int(11) NOT NULL,
  `id_ujung_surat` int(11) NOT NULL,
  `nomor` text COLLATE utf8_unicode_ci NOT NULL,
  `tujuan` text COLLATE utf8_unicode_ci NOT NULL,
  `perihal` text COLLATE utf8_unicode_ci,
  `tanggal` date NOT NULL,
  `id_pengguna` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `nip` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `display_picture` text COLLATE utf8_unicode_ci,
  `email` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kontak` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8_unicode_ci,
  `id_level_pengguna` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `created_at`, `modified_at`, `deleted_at`, `nip`, `password`, `display_name`, `display_picture`, `email`, `kontak`, `alamat`, `id_level_pengguna`) VALUES
(1, NULL, NULL, NULL, '1137010054', '6ace428f372dd08866196cf003e8b445', 'Sandi Mulyadi', NULL, 'sandimvlyadi@gmail.com', '087720614000', NULL, 1),
(2, '2019-07-08 22:44:43', NULL, NULL, '1137010011', '912ec803b2ce49e4a541068d495ab570', 'Toke Hiber', NULL, 'tokehiber@gmail.com', '', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `registrasi_pengguna`
--

CREATE TABLE `registrasi_pengguna` (
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `nip` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `session_log`
--

CREATE TABLE `session_log` (
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `id_pengguna` int(11) NOT NULL,
  `token` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `session_log`
--

INSERT INTO `session_log` (`id`, `created_at`, `modified_at`, `deleted_at`, `id_pengguna`, `token`) VALUES
(1, '2019-07-08 15:43:23', NULL, '2019-07-08 22:03:37', 1, '242d347dd8353baab66f56f6f9cd8549b331317a'),
(2, '2019-07-08 15:43:37', NULL, NULL, 1, '3eaffce86896104afe866b89405ae8fe391409a2'),
(3, '2019-07-08 22:36:09', NULL, NULL, 2, '4e866c06a1f26c9de8570139e822258709399d7f'),
(4, '2019-07-08 22:37:45', NULL, NULL, 2, '788eaa8bf165637d993d6b94e476e3884098e728'),
(5, '2019-07-08 22:38:07', NULL, NULL, 1, '2bc53f4e20729e222baa11a87958b2a54b09bf90'),
(6, '2019-07-08 22:41:28', NULL, NULL, 1, 'e1400167e8b88d8bc6e156caa77e0aab629d2f44'),
(7, '2019-07-08 22:42:04', NULL, NULL, 1, '9cd6660304466fee6b6512d6340f67e68a1eeda6'),
(8, '2019-07-08 22:43:16', NULL, NULL, 1, 'f712f1ab3520834e893401673375f01dcf444646'),
(9, '2019-07-08 22:50:53', NULL, NULL, 2, '1c409c72e50172d6965f1f95b8d23d53e18fa6c9'),
(10, '2019-07-08 22:51:27', NULL, NULL, 2, '6c7a0907a953a7eea27d78be4ee8fab9154f8386'),
(11, '2019-07-08 22:51:36', NULL, NULL, 1, '5111efd8aa9862c28ca706f737e788762e6213ad');

-- --------------------------------------------------------

--
-- Table structure for table `ujung_surat`
--

CREATE TABLE `ujung_surat` (
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `nama` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ujung_surat`
--

INSERT INTO `ujung_surat` (`id`, `created_at`, `modified_at`, `deleted_at`, `nama`, `keterangan`) VALUES
(1, '2019-07-08 19:18:34', '2019-07-08 19:18:44', NULL, 'RSJ', ''),
(2, '2019-07-08 19:18:53', NULL, NULL, 'UMUM', ''),
(3, '2019-07-08 19:18:59', NULL, NULL, 'KEPEG', ''),
(4, '2019-07-08 19:19:20', NULL, '2019-07-08 19:19:24', 'ASDF', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bagian_pengguna`
--
ALTER TABLE `bagian_pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bagian_surat`
--
ALTER TABLE `bagian_surat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `jenis_surat`
--
ALTER TABLE `jenis_surat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level_pengguna`
--
ALTER TABLE `level_pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nomor_surat`
--
ALTER TABLE `nomor_surat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrasi_pengguna`
--
ALTER TABLE `registrasi_pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session_log`
--
ALTER TABLE `session_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ujung_surat`
--
ALTER TABLE `ujung_surat`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bagian_pengguna`
--
ALTER TABLE `bagian_pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bagian_surat`
--
ALTER TABLE `bagian_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `jenis_surat`
--
ALTER TABLE `jenis_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `level_pengguna`
--
ALTER TABLE `level_pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `nomor_surat`
--
ALTER TABLE `nomor_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `registrasi_pengguna`
--
ALTER TABLE `registrasi_pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `session_log`
--
ALTER TABLE `session_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `ujung_surat`
--
ALTER TABLE `ujung_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
