-- Last modified 2/7/2021

-- create the database
CREATE DATABASE IF NOT EXISTS `chatGroup` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `chatGroup`;


-- Table structure for table users
CREATE TABLE IF NOT EXISTS users (
	`id` int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`),
	`status` INT(11) DEFAULT 0,
	`email` TEXT,
	`pswd` TEXT,
	`handle` TEXT,
	`salt` TEXT,
	`first` TEXT,
	`last` TEXT,
	`phone` TEXT NULL,
	`profImg` TEXT
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
-- INSERT INTO user_id (id, status, username, password, handle, salt, first, last, phone, profileimg) VALUES (NULL, 1, '', '', '', '',  '', '', '', '');


-- Table structure for table messages
CREATE TABLE IF NOT EXISTS messages (
	`id` int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`),
	`sender` INT(11),
	`recip` TEXT,
	`msgType` INT(11) DEFAULT 0,
	`content` TEXT NULL,
	`time` INT(11) DEFAULT 0,
	`metadata` TEXT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
-- INSERT INTO messages (id, sender, recipient, msgType, content, time, metadata) VALUES (NULL, 0, '', 0, 'NULL', 0, NULL);
