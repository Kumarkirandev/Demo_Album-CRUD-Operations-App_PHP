SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `db_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_music_album`
--

CREATE TABLE `tbl_music_album` (
  `album_id` bigint(20) NOT NULL,
  `album_key` varchar(255) NOT NULL,
  `album_title` varchar(255) DEFAULT NULL,
  `album_artist` varchar(255) DEFAULT NULL,
  `album_music_director` varchar(255) DEFAULT NULL,
  `album_lyrist` varchar(255) DEFAULT NULL,
  `album_year` char(4) DEFAULT NULL,
  `album_label` varchar(255) DEFAULT NULL,
  `album_genres` varchar(255) DEFAULT NULL,
  `album_cover` varchar(255) DEFAULT NULL,
  `album_description` text,
  `update_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_music_album`
--

INSERT INTO `tbl_music_album` (`album_id`, `album_key`, `album_title`, `album_artist`, `album_music_director`, `album_lyrist`, `album_year`, `album_label`, `album_genres`, `album_cover`, `album_description`, `update_date`) VALUES
(1, 'Jenny', 'Lover', 'Taylor Swift', 'Frank Dukes,', 'Louis Bell', '2019', '2019', 'Electropop', 'upload/albumCover/lover.jpg', 'Lover is the seventh studio album by American singer-songwriter Taylor Swift. It was released on August 23, 2019, by Republic Records. ', '2019-10-07 19:12:07');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_preferences`
--

CREATE TABLE `tbl_preferences` (
  `id` int(2) NOT NULL,
  `record_per_page` int(4) NOT NULL,
  `site_base_url` varchar(255) NOT NULL,
  `website_keywords` text NOT NULL,
  `website_title` text NOT NULL,
  `website_des` text NOT NULL,
  `name_owner` varchar(50) CHARACTER SET latin1 NOT NULL,
  `email_of_owner` varchar(80) CHARACTER SET latin1 NOT NULL,
  `name_email_sender` varchar(255) CHARACTER SET latin1 NOT NULL,
  `email_add_sent_out` varchar(255) CHARACTER SET latin1 NOT NULL,
  `notify_newuser` int(1) NOT NULL,
  `notify_send_email` varchar(80) CHARACTER SET latin1 NOT NULL,
  `upload_image_size` int(6) NOT NULL,
  `admin_title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `contactus_address` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_preferences`
--

INSERT INTO `tbl_preferences` (`id`, `record_per_page`, `site_base_url`, `website_keywords`, `website_title`, `website_des`, `name_owner`, `email_of_owner`, `name_email_sender`, `email_add_sent_out`, `notify_newuser`, `notify_send_email`, `upload_image_size`, `admin_title`, `contactus_address`) VALUES
(1, 25, 'http://localhost/demo/', 'demo data', 'Demo', 'this is for demo', 'demo', 'demo@gmail.com', 'demo@example.com', '', 0, '', 0, 'DEMO', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_music_album`
--
ALTER TABLE `tbl_music_album`
  ADD PRIMARY KEY (`album_id`),
  ADD UNIQUE KEY `album_key` (`album_key`);

--
-- Indexes for table `tbl_preferences`
--
ALTER TABLE `tbl_preferences`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_music_album`
--
ALTER TABLE `tbl_music_album`
  MODIFY `album_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_preferences`
--
ALTER TABLE `tbl_preferences`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
