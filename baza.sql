-- Adminer 4.6.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `GA`;
CREATE TABLE `GA` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `steamid` varchar(26) CHARACTER SET utf8 NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `GAHist`;
CREATE TABLE `GAHist` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `avatar` text CHARACTER SET utf8 NOT NULL,
  `amount` int(5) NOT NULL,
  `time` bigint(20) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `inventory`;
CREATE TABLE `inventory` (
  `id` varchar(255) NOT NULL,
  `market_hash_name` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `classid` varchar(255) NOT NULL,
  `bot_id` varchar(64) NOT NULL,
  `in_trade` varchar(1) NOT NULL,
  `deposit_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `rake`;
CREATE TABLE `rake` (
  `coinflip` varchar(255) NOT NULL,
  `jackpot` varchar(255) NOT NULL,
  `roulette` varchar(255) NOT NULL,
  UNIQUE KEY `jackpot` (`jackpot`),
  UNIQUE KEY `roulette` (`roulette`),
  UNIQUE KEY `coinflip_2` (`coinflip`,`jackpot`,`roulette`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `roll_history`;
CREATE TABLE `roll_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `roll` int(11) NOT NULL,
  `time` varchar(64) NOT NULL,
  `hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `trade_history`;
CREATE TABLE `trade_history` (
  `offer_id` bigint(20) unsigned NOT NULL,
  `offer_partner` varchar(255) NOT NULL,
  `offer_state` varchar(255) NOT NULL,
  `worth` bigint(20) unsigned NOT NULL,
  `action` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `offer_id` (`offer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `ref_code` varchar(256) CHARACTER SET utf8 NOT NULL,
  `deposit` int(11) NOT NULL DEFAULT '0',
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `steamid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `wallet` int(10) unsigned NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tradeurl` text COLLATE utf8_unicode_ci NOT NULL,
  `inviter` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rank` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `is_admin` int(11) NOT NULL,
  `is_yt` int(11) NOT NULL,
  `muted` int(11) NOT NULL,
  `banned` int(11) NOT NULL,
  `transfer_banned` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `csgo` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'true',
  `token_time` bigint(20) NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logged_in` int(11) NOT NULL,
  `wager` int(11) NOT NULL,
  `total_bet` bigint(20) unsigned NOT NULL,
  `total_won` bigint(20) unsigned NOT NULL,
  `total_lose` bigint(20) NOT NULL,
  `deposit_sum` bigint(20) NOT NULL,
  `collected` int(10) unsigned NOT NULL,
  `last_free_use` int(11) NOT NULL,
  `last_group_use` int(11) NOT NULL,
  `group_used` int(11) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_steamid_unique` (`steamid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`ref_code`, `deposit`, `id`, `avatar`, `steamid`, `wallet`, `username`, `tradeurl`, `inviter`, `rank`, `is_admin`, `is_yt`, `muted`, `banned`, `transfer_banned`, `code`, `csgo`, `token_time`, `token`, `logged_in`, `wager`, `total_bet`, `total_won`, `total_lose`, `deposit_sum`, `collected`, `last_free_use`, `last_group_use`, `group_used`, `remember_token`, `created_at`, `updated_at`) VALUES
('',	5,	416,	'https://pp.userapi.com/c841423/v841423768/60685/x0RWprue9Y8.jpg?ava=1',	'446465959',	4915,	'Уллубий Зайнутдинов',	'',	'',	'user',	1,	0,	0,	0,	0,	'',	'true',	1532267929,	'c5b0c7cac3904a6f7bfc683f4479485c4b343feb911b4fed7ddb72cc836f8ca6',	0,	0,	200,	110,	0,	0,	0,	0,	0,	0,	'ZwJ6GJZ0vMrul5PL3lQ71bheheRzH65oPDS86CFzXWjrtViU2IMytAhqHQKb',	'2018-07-18 09:52:03',	'2018-07-20 10:39:30');

DROP TABLE IF EXISTS `wallet_change`;
CREATE TABLE `wallet_change` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `change` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `withdraw`;
CREATE TABLE `withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `system` varchar(256) CHARACTER SET utf8 NOT NULL,
  `wallet` varchar(15) CHARACTER SET utf8 NOT NULL,
  `amount` int(11) NOT NULL,
  `date` varchar(256) CHARACTER SET utf8 NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2018-07-22 14:04:50
