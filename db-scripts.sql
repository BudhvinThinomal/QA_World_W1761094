CREATE DATABASE `qaworld`;

USE `qaworld`;

CREATE TABLE `user_details` ( 
    `username` varchar(40) NOT NULL, 
    `fullName` varchar(100) NOT NULL, 
    `password` varchar(350) NOT NULL ,
	PRIMARY KEY (`username`));

CREATE TABLE `answer_details` (
	`answerID` INT(10) AUTO_INCREMENT NOT NULL,
    `answerDescription` LONGTEXT NOT NULL,
    `createdTime` TIMESTAMP NOT NULL,
    `lastModified` TIMESTAMP NOT NULL,
    `likes` INT(255) NOT NULL DEFAULT 0,
    `dislikes` INT(255) NOT NULL DEFAULT 0,
    `username` VARCHAR(40) NOT NULL,
    `questionID` INT(10) NOT NULL,
    PRIMARY KEY (`answerID`),
    FOREIGN KEY (`username`) REFERENCES `user_details`(`username`),
    FOREIGN KEY (`questionID`) REFERENCES `question_details`(`questionID`)
);

CREATE TABLE `question_details` (
	`questionID` INT(10) AUTO_INCREMENT NOT NULL,
    `questionTitle` VARCHAR(150) NOT NULL,
    `questionDescription` LONGTEXT NOT NULL,
    `createdTime` TIMESTAMP NOT NULL,
    `lastModified` TIMESTAMP NOT NULL,
    `username` VARCHAR(40) NOT NULL,
    PRIMARY KEY (`questionID`),
    FOREIGN KEY (`username`) REFERENCES `user_details`(`username`)
);

CREATE TABLE `answer_votes` (
	`voteID` INT(10) AUTO_INCREMENT NOT NULL,
    `like` INT(10) NOT NULL,
    `dislike` INT(10) NOT NULL,
    `username` VARCHAR(40) NOT NULL,
    `answerID` INT(10) NOT NULL,
    `questionID` INT(10) NOT NULL,
    PRIMARY KEY (`voteID`),
    FOREIGN KEY (`username`) REFERENCES `user_details`(`username`),
    FOREIGN KEY (`answerID`) REFERENCES `answer_details`(`answerID`),
    FOREIGN KEY (`questionID`) REFERENCES `question_details`(`questionID`)
);

CREATE TABLE `ci_sessions` (
	`id` varchar(128) NOT NULL,
	`ip_address` varchar(45) NOT NULL,
	`timestamp` int(10) UNSIGNED DEFAULT 0 NOT NULL,
	`data` blob NOT NULL,
	KEY `ci_sessions_timestamp` (`timestamp`)
);