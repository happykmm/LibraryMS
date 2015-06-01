-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015 年 04 月 26 日 08:18
-- 服务器版本: 5.5.20
-- PHP 版本: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `book_library`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `phone` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`, `phone`) VALUES
(0, 'zhangsan', '123456', 0);

-- --------------------------------------------------------

--
-- 表的结构 `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `isbn` varchar(20) NOT NULL,
  `category` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `press` varchar(20) NOT NULL,
  `year` int(4) unsigned NOT NULL,
  `author` varchar(20) NOT NULL,
  `price` decimal(8,2) unsigned NOT NULL,
  `amount` int(4) unsigned NOT NULL,
  PRIMARY KEY (`isbn`),
  KEY `name` (`name`),
  KEY `press` (`press`),
  KEY `year` (`year`),
  KEY `author` (`author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `books`
--

INSERT INTO `books` (`isbn`, `category`, `name`, `press`, `year`, `author`, `price`, `amount`) VALUES
('123', '0', '普通心理学', '北京师范大学出版社', 2010, '彭冉玲', '35.00', 1),
('321', '1', '01', '01', 1, '01', '0.00', 1),
('9787111375296', '0', '数据库系统概念', '机械工业出版社', 2013, '佚名', '99.00', 5),
('book_no_1', '0', 'Computer Architecture', '机械工业出版社', 2004, 'xxx', '90.00', 2),
('book_no_3', '0', 'Object-oriented prog', '影印出版社', 2006, 'xxx', '88.00', 6);

-- --------------------------------------------------------

--
-- 表的结构 `borrow`
--

CREATE TABLE IF NOT EXISTS `borrow` (
  `isbn` varchar(20) NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `borrow_time` datetime NOT NULL,
  `return_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`isbn`,`uid`),
  KEY `uid_fk` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `borrow`
--

INSERT INTO `borrow` (`isbn`, `uid`, `borrow_time`, `return_time`) VALUES
('321', 1, '2015-04-26 07:01:17', '2015-04-26 15:40:06'),
('9787111375296', 1, '2015-04-26 07:14:13', '2015-04-26 15:40:05'),
('9787111375296', 2, '2015-04-26 15:37:49', '2015-04-26 15:39:55'),
('9787111375296', 3, '2015-04-26 15:37:44', '2015-04-26 15:38:01'),
('9787111375296', 4, '2015-04-26 07:22:06', '2015-04-26 15:40:00'),
('9787111375296', 5, '2015-04-26 07:14:18', '2015-04-26 15:40:03'),
('book_no_1', 1, '0000-00-00 00:00:00', '2015-04-26 06:47:38'),
('book_no_1', 5, '0000-00-00 00:00:00', '2015-04-26 06:47:40');

-- --------------------------------------------------------

--
-- 表的结构 `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('0ff817e2405387bbbab1e4cf43c4f570', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36', 1429854911, 'a:3:{s:9:"user_data";s:0:"";s:2:"id";s:1:"0";s:4:"name";s:8:"zhangsan";}'),
('32bd39ea4a6ef5526647df4c81c9b205', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36', 1429958417, 'a:2:{s:2:"id";s:1:"0";s:4:"name";s:8:"zhangsan";}'),
('3354175aff31dedd1f9597e7c3f1fa20', '127.0.0.1', 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)', 1429591839, 'a:3:{s:9:"user_data";s:0:"";s:2:"id";s:1:"0";s:4:"name";s:8:"zhangsan";}'),
('3828c5a18cf2cc4f08485968b9587a49', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36', 1429976896, 'a:3:{s:9:"user_data";s:0:"";s:2:"id";s:1:"0";s:4:"name";s:8:"zhangsan";}'),
('513bc1f2f15351ad191ba517b629c5f0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36', 1429592108, 'a:3:{s:9:"user_data";s:0:"";s:2:"id";s:1:"0";s:4:"name";s:8:"zhangsan";}'),
('b5e01e3922eb84f29b80b326d55ae466', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36', 1429542887, ''),
('ba317b5635b27d3980e0ff44521a4a5b', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36', 1430034804, 'a:3:{s:9:"user_data";s:0:"";s:2:"id";s:1:"0";s:4:"name";s:8:"zhangsan";}'),
('c919bd12b1c4fb6a2103ff2350222caa', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36', 1429586633, ''),
('e1b45ae169dfdbaeddeb8c7175508fb1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36', 1429854993, 'a:3:{s:9:"user_data";s:0:"";s:2:"id";s:1:"0";s:4:"name";s:8:"zhangsan";}');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `department` varchar(20) NOT NULL,
  `position` varchar(20) NOT NULL,
  `is_del` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `name`, `department`, `position`, `is_del`) VALUES
(1, 'libai', 'cs', 'stu', 0),
(2, '李黑', '梁山', '好汉', 0),
(3, '老张', 'chinese', 'teacher', 0),
(4, '张三丰', 'math', 'stu', 0),
(5, 'dufu', 'cs', 'stu', 0);

--
-- 限制导出的表
--

--
-- 限制表 `borrow`
--
ALTER TABLE `borrow`
  ADD CONSTRAINT `isbn_fk` FOREIGN KEY (`isbn`) REFERENCES `books` (`isbn`) ON UPDATE CASCADE,
  ADD CONSTRAINT `uid_fk` FOREIGN KEY (`uid`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
