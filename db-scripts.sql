CREATE DATABASE `qaworld`;

USE `qaworld`;

CREATE TABLE `user_details` ( 
    `username` varchar(40) NOT NULL, 
    `fullName` varchar(100) NOT NULL, 
    `password` varchar(350) NOT NULL ,
	PRIMARY KEY (`username`));

CREATE TABLE `question_details` (
	`questionID` INT(10) AUTO_INCREMENT NOT NULL,
    `questionTitle` VARCHAR(150) NOT NULL,
    `questionDescription` LONGTEXT NOT NULL,
    `createdTime` TIMESTAMP NOT NULL,
    `lastModified` TIMESTAMP NOT NULL,
    `upVotes` INT(255) NOT NULL DEFAULT 0,
    `downVotes` INT(255) NOT NULL DEFAULT 0,
    `username` VARCHAR(40) NOT NULL,
    `views` INT(255) NOT NULL DEFAULT 0,
    `tags` VARCHAR(65535) NOT NULL,
    PRIMARY KEY (`questionID`),
    FOREIGN KEY (`username`) REFERENCES `user_details`(`username`)
);

CREATE TABLE `answer_details` (
	`answerID` INT(10) AUTO_INCREMENT NOT NULL,
    `answerDescription` LONGTEXT NOT NULL,
    `createdTime` TIMESTAMP NOT NULL,
    `lastModified` TIMESTAMP NOT NULL,
    `upVotes` INT(255) NOT NULL DEFAULT 0,
    `downVotes` INT(255) NOT NULL DEFAULT 0,
    `username` VARCHAR(40) NOT NULL,
    `questionID` INT(10) NOT NULL,
    PRIMARY KEY (`answerID`),
    FOREIGN KEY (`username`) REFERENCES `user_details`(`username`),
    FOREIGN KEY (`questionID`) REFERENCES `question_details`(`questionID`)
);
