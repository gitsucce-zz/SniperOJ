CREATE DATABASE `software` /*!40100 DEFAULT CHARACTER SET utf8 */

CREATE TABLE `users` (
  `userID` int NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `score` int NOT NULL DEFAULT 0,
  `college` varchar (64) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `registe_time` int DEFAULT 0,
  `registe_ip` varchar(16) not null;
  `salt` varchar(16) DEFAULT NULL,
  `token` varchar(32) DEFAULT NULL,
  `token_alive_time` int DEFAULT 0,
  `verified` tinyint NOT NULL DEFAULT 0,
  `usertype` tinyint NOT NULL DEFAULT 0,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
    
CREATE TABLE `challenges` (
  `challengeID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(512) NOT NULL,
  `flag` varchar(64) NOT NULL,
  `score` int NOT NULL DEFAULT 0,
  `type` ENUM('web', 'pwn', 'stego', 'misc', 'crypto', 'forensics', 'others'),
  `online_time` int NOT NULL,
  `visit_times` int DEFAULT 0,
  `fixing` tinyint DEFAULT 0,
  `resource` varchar(512) DEFAULT NULL,
  `document` varchar(512) DEFAULT NULL,
  ``
  PRIMARY KEY (`challengeID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
    
CREATE TABLE `submit_log` (
  `submitID` int NOT NULL AUTO_INCREMENT,
  `challengeID`int NOT NULL,
  `userID`int NOT NULL,
  `flag` varchar(64) NOT NULL,
  `submit_time` int DEFAULT 0,
  `is_current` tinyint NOT NULL DEFAULT 0,
  PRIMARY KEY (`submitID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `news` (
  `newsID` int NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `content` varchar(512) NOT NULL,
  `authorID` int NOT NULL,
  `submit_time` int NOT NULL DEFAULT 0,
  `visit_times` int DEFAULT 0,
  PRIMARY KEY (`newsID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

    
CREATE TABLE `login_log` (
  `loginID` int NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `login_time` int DEFAULT 0,
  `login_ip` varchar(16) not null;
  PRIMARY KEY (`loginID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


CREATE TABLE captcha (
    captcha_id bigint(13) unsigned NOT NULL auto_increment,
    captcha_time int(10) unsigned NOT NULL,
    ip_address varchar(45) NOT NULL,
    word varchar(20) NOT NULL,
    PRIMARY KEY `captcha_id` (`captcha_id`),
    KEY `word` (`word`)
);
