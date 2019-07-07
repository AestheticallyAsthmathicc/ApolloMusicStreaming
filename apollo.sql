-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 07, 2019 at 09:27 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apollo`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `id` int(11) NOT NULL,
  `title` varchar(250) COLLATE latin1_bin NOT NULL,
  `artist` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `artworkPath` varchar(500) COLLATE latin1_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `title`, `artist`, `genre`, `artworkPath`) VALUES
(1, 'Technicolor', 1, 8, 'assets/images/artwork/mansionair/technicolor.jpg'),
(2, 'i met you when i was 18', 2, 2, 'assets/images/artwork/lauv/imywiw18.jpg'),
(3, 'OK COMPUTER', 4, 8, 'assets/images/artwork/radiohead/okcomputer.jpg'),
(4, 'Bobby Tarantino II', 3, 4, 'assets/images/artwork/logic/bobbytarantino2.jpg'),
(5, 'Because the Internet', 5, 4, 'assets/images/artwork/childish-gambino/becausetheinternet.png'),
(6, 'Everbody', 3, 4, 'assets/images/artwork/logic/everybody.jpg'),
(7, 'Currents', 6, 8, 'assets/images/artwork/tame-impala/currents.jpg'),
(8, 'Stoney', 7, 5, 'assets/images/artwork/post-malone/stoney.jpg'),
(9, 'The Incredible True Story', 3, 4, 'assets/images/artwork/logic/theincredibletruestory.png');

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE latin1_bin NOT NULL,
  `artistPic` varchar(150) COLLATE latin1_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `name`, `artistPic`) VALUES
(1, 'Mansionair', 'music/mansionair/artist.jpg'),
(2, 'Lauv', 'music/lauv/artist.jpg'),
(3, 'Logic', 'music/logic/artist.jpg'),
(4, 'Radiohead', 'music/radiohead/artist.jpg'),
(5, 'Childish Gambino', 'music/childish-gambino/artist.jpg'),
(6, 'Tame Impala', 'music/tame-impala/artist.jpg'),
(7, 'Post Malone', 'music/post-malone/artist.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE latin1_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'Rock'),
(2, 'Pop'),
(3, 'Hip-hop'),
(4, 'Rap'),
(5, 'R&B'),
(6, 'Classical'),
(7, 'Electronic'),
(8, 'Alt Rock'),
(9, 'Country'),
(10, 'Folk'),
(11, 'Psychedelic Rock');

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

CREATE TABLE `playlists` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE latin1_bin NOT NULL,
  `owner` varchar(50) COLLATE latin1_bin NOT NULL,
  `dateCreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Dumping data for table `playlists`
--

INSERT INTO `playlists` (`id`, `name`, `owner`, `dateCreated`) VALUES
(5, 'Favs', 'moeed9daska', '2019-06-27 00:00:00'),
(6, 'safyan', 'normaluser', '2019-06-28 00:00:00'),
(7, 'waheed', 'normaluser', '2019-06-28 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `playlistSongs`
--

CREATE TABLE `playlistSongs` (
  `id` int(11) NOT NULL,
  `songId` int(11) NOT NULL,
  `playlistId` int(11) NOT NULL,
  `playlistOrder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Dumping data for table `playlistSongs`
--

INSERT INTO `playlistSongs` (`id`, `songId`, `playlistId`, `playlistOrder`) VALUES
(3, 13, 5, 0),
(4, 1, 5, 1),
(5, 7, 5, 2),
(7, 13, 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `title` varchar(250) COLLATE latin1_bin NOT NULL,
  `artist` int(11) NOT NULL,
  `album` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `duration` varchar(8) COLLATE latin1_bin NOT NULL,
  `path` varchar(500) COLLATE latin1_bin NOT NULL,
  `albumOrder` int(11) NOT NULL,
  `plays` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `title`, `artist`, `album`, `genre`, `duration`, `path`, `albumOrder`, `plays`) VALUES
(1, 'Technicolor', 1, 1, 8, '3:20', 'assets/music/mansionair/technicolour.mp3', 1, 17),
(2, 'Come Back Home', 2, 2, 2, '3:51', 'assets/music/lauv/come-back-home.mp3', 1, 37),
(3, 'Easy Love', 2, 2, 2, '3:44', 'assets/music/lauv/easy-love.mp3', 2, 17),
(4, '44 More', 3, 4, 4, '3:08', 'assets/music/logic/44-more.mp3', 1, 25),
(5, 'Everyday', 3, 4, 4, '3:24', 'assets/music/logic/everyday.mp3', 2, 21),
(6, 'Overnight', 3, 4, 4, '3:37', 'assets/music/logic/overnight.mp3', 3, 22),
(7, 'Crawl', 5, 5, 4, '3:29', 'assets/music/childish-gambino/crawl.mp3', 1, 25),
(8, 'Life the Biggest Troll', 5, 5, 4, '5:42', 'assets/music/childish-gambino/life-the-biggest-troll.mp3', 2, 29),
(9, 'WORLDSTAR', 5, 5, 4, '4:04', 'assets/music/childish-gambino/worldstar.mp3', 3, 26),
(10, 'Exit Music (for a film)', 4, 3, 8, '4:24', 'assets/music/radiohead/exit-music.mp3', 1, 13),
(11, 'Karma Police', 4, 3, 8, '4:21', 'assets/music/radiohead/karma-police.mp3', 2, 20),
(12, 'No Surprises', 4, 3, 8, '3:48', 'assets/music/radiohead/no-surprises.mp3', 3, 16),
(13, 'Killing Spree', 3, 6, 4, '3:26', 'assets/music/logic/killing-spree.mp3', 1, 5),
(14, 'Let It Happen', 6, 7, 11, '6:23', 'assets/music/tame-impala/let-it-happen.mp3', 2, 1),
(15, 'Nangs', 6, 7, 11, '5:23', 'assets/music/tame-impala/nangs.mp3', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(25) COLLATE latin1_bin NOT NULL,
  `firstName` varchar(25) COLLATE latin1_bin NOT NULL,
  `lastName` varchar(50) COLLATE latin1_bin NOT NULL,
  `email` varchar(50) COLLATE latin1_bin NOT NULL,
  `password` varchar(50) COLLATE latin1_bin NOT NULL,
  `date` datetime NOT NULL,
  `profilePic` varchar(100) COLLATE latin1_bin NOT NULL,
  `admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `firstName`, `lastName`, `email`, `password`, `date`, `profilePic`, `admin`) VALUES
(1, 'emiliaisbae', 'Emilia', 'Clarke', 'emilia@gmail.com', '51fd0ede15d2890b7cd1a28650c8be79', '2019-07-05 00:00:00', 'assets/images/profile-pics/default.png', 0),
(6, 'jonnyBoi', 'Jon', 'Snow', 'jonsnow@gmail.com', '1bbb2888eaa283545642d7470a712748', '2019-07-05 00:00:00', 'assets/images/profile-pics/default.png', 0),
(7, 'dracarysBish', 'Daenerys', 'Targaryen', 'dracarysBish@gmail.com', '050706f43c69942c7c2b80153ecaef59', '2019-07-05 00:00:00', 'assets/images/profile-pics/default.png', 0),
(10, 'OnionBoi', 'Davos', 'Seaworth', 'onionBoi@gmail.com', '63e71dd03809f3cc616c19feea0349e0', '2019-07-05 00:00:00', 'assets/images/profile-pics/default.png', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlistSongs`
--
ALTER TABLE `playlistSongs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `playlists`
--
ALTER TABLE `playlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `playlistSongs`
--
ALTER TABLE `playlistSongs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=668;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
