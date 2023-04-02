-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2022-12-04 21:54:47
-- 服务器版本: 5.6.50-log
-- PHP 版本: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `fuli`
--

-- --------------------------------------------------------

--
-- 表的结构 `qmn_admin`
--

CREATE TABLE IF NOT EXISTS `qmn_admin` (
  `id` int(30) NOT NULL COMMENT '管理员ID',
  `user` varchar(100) NOT NULL COMMENT '管理员账号',
  `pass` varchar(100) NOT NULL COMMENT '管理员密码',
  `qq` varchar(100) NOT NULL COMMENT '管理员QQ',
  `name` varchar(150) NOT NULL COMMENT '管理员昵称',
  `city` varchar(80) NOT NULL COMMENT '管理员来源',
  `ip` varchar(80) NOT NULL COMMENT '管理员IP',
  `time` datetime NOT NULL COMMENT '管理员登陆时间',
  `active` int(2) NOT NULL COMMENT '管理员状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `qmn_admin`
--

INSERT INTO `qmn_admin` (`id`, `user`, `pass`, `qq`, `name`, `city`, `ip`, `time`, `active`) VALUES
(1, 'admin', '123456', '123456', '青木倪', '中国.广西壮族自治区.来宾市', '223.104.93.161', '2022-12-04 21:43:38', 1);

-- --------------------------------------------------------

--
-- 表的结构 `qmn_card`
--

CREATE TABLE IF NOT EXISTS `qmn_card` (
  `cid` int(11) NOT NULL AUTO_INCREMENT COMMENT '卡密ID',
  `msg` varchar(200) NOT NULL COMMENT '卡密内容',
  `qq` varchar(200) DEFAULT NULL COMMENT '使用用户',
  `card_out` int(2) NOT NULL DEFAULT '0' COMMENT '导出状态',
  `time` datetime DEFAULT NULL COMMENT '使用时间',
  `active` int(2) NOT NULL DEFAULT '0' COMMENT '卡密状态',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qmn_config`
--

CREATE TABLE IF NOT EXISTS `qmn_config` (
  `k` varchar(200) NOT NULL COMMENT '站点配置',
  `v` text NOT NULL COMMENT '站点配置内容',
  `tis` varchar(200) NOT NULL COMMENT '配置提示',
  PRIMARY KEY (`k`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `qmn_config`
--

INSERT INTO `qmn_config` (`k`, `v`, `tis`) VALUES
('copyright', '随便打一句1', '站点版权'),
('description', '福利兑换网', '站点介绍'),
('icp', '随便打的', '站点ICP'),
('keywords', '福利兑换网', '站点关键词'),
('title', '福利兑换网', '站点名称');

-- --------------------------------------------------------

--
-- 表的结构 `qmn_log`
--

CREATE TABLE IF NOT EXISTS `qmn_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) NOT NULL,
  `type` varchar(200) NOT NULL,
  `data` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `time` datetime NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qmn_user`
--

CREATE TABLE IF NOT EXISTS `qmn_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `qq` varchar(100) NOT NULL COMMENT '用户QQ',
  `name` varchar(100) NOT NULL COMMENT '用户昵称',
  `pic` varchar(150) NOT NULL COMMENT '用户头像',
  `skey` varchar(100) NOT NULL COMMENT '用户skey',
  `pskey` varchar(150) NOT NULL COMMENT '用户pskey',
  `superkey` varchar(200) NOT NULL COMMENT '用户superkey',
  `city` varchar(50) NOT NULL COMMENT '用户来源',
  `ip` varchar(50) NOT NULL COMMENT '用户IP',
  `time` datetime NOT NULL COMMENT '注册时间',
  `active` int(2) NOT NULL COMMENT '用户状态',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qmn_user_log`
--

CREATE TABLE IF NOT EXISTS `qmn_user_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qq` varchar(150) NOT NULL COMMENT '领取QQ',
  `data` varchar(100) NOT NULL COMMENT '领取业务',
  `msg` varchar(200) NOT NULL COMMENT '领取状态',
  `card` varchar(200) NOT NULL COMMENT '使用卡密',
  `time` datetime NOT NULL COMMENT '领取时间',
  `active` int(2) NOT NULL COMMENT '领取状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
