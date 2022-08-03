-- Run this script to setup database

--
-- Database: mvusers
--
CREATE DATABASE IF NOT EXISTS `mvusers` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `mvusers`;


-- Table structure for table user_id

CREATE TABLE IF NOT EXISTS user_id (
	id int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`),
	username text NOT NULL,
	password text NOT NULL,
	name text NOT NULL,
	phone text NULL DEFAULT NULL,
	profileimg text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

-- last text NOT NULL,
-- first text NOT NULL, 

-- INSERT INTO user_id (ID, username, password, name, phone, profileimg) VALUES (NULL, '$value7', '$value5', '$value6',  $number, '$filepath');

-- Table structure for table messages

CREATE TABLE IF NOT EXISTS messages (
	id int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`),
	name text NOT NULL,
	recipient text NOT NULL,
	`text` text NOT NULL,
	`time` int NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
-- change name column to sender
-- INSERT INTO messages (ID, name, recipient, text, time) VALUES (NULL, '$value1', '$value2', '$value3', '$x_values');