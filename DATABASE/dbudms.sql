-- Create database and use it
CREATE DATABASE IF NOT EXISTS dbudms;
USE dbudms;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Table: users
CREATE TABLE IF NOT EXISTS users (
  FNAME varchar(30) DEFAULT NULL,
  mNAME varchar(30) DEFAULT NULL,
  lname varchar(30) DEFAULT NULL,
  user_id varchar(15) NOT NULL,
  sex varchar(8) DEFAULT NULL,
  level varchar(10) DEFAULT NULL,
  phone_no varchar(25) DEFAULT NULL,
  username varchar(20) DEFAULT NULL,
  password varchar(20) DEFAULT NULL,
  confirmpassword varchar(15) NOT NULL,
  status varchar(5) NOT NULL,
  PRIMARY KEY (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table: block
CREATE TABLE IF NOT EXISTS block (
  block_no varchar(3) NOT NULL,
  norooms varchar(4) DEFAULT NULL,
  faculty varchar(30) DEFAULT NULL,
  batch varchar(20) NOT NULL,
  sexcategory varchar(8) DEFAULT NULL,
  user_id varchar(15) DEFAULT NULL,
  phone varchar(13) DEFAULT NULL,
  PRIMARY KEY (block_no),
  KEY user_id (user_id),
  CONSTRAINT block_ibfk_1 FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table: room
CREATE TABLE IF NOT EXISTS room (
  block_no varchar(3) NOT NULL,
  room_no varchar(3) NOT NULL,
  nobed int(2) DEFAULT NULL,
  PRIMARY KEY (block_no, room_no),
  KEY block_no_fk (block_no),
  CONSTRAINT room_ibfk_1 FOREIGN KEY (block_no) REFERENCES block(block_no) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table: registrar
CREATE TABLE IF NOT EXISTS registrar (
  no INT(11) NOT NULL AUTO_INCREMENT,
  fname VARCHAR(50) NOT NULL,
  mname VARCHAR(50) NOT NULL,
  lname VARCHAR(50) NOT NULL,
  stud_id VARCHAR(20) NOT NULL UNIQUE,
  sex VARCHAR(10) NOT NULL,
  batch VARCHAR(10) NOT NULL,
  faculty VARCHAR(30) NOT NULL,
  department VARCHAR(30) NOT NULL,
  PRIMARY KEY (no),
  INDEX idx_batch (batch),
  INDEX idx_faculty (faculty),
  INDEX idx_department (department)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=11;

-- Table: students
CREATE TABLE IF NOT EXISTS students (
  fname varchar(30) DEFAULT NULL,
  mname varchar(30) DEFAULT NULL,
  lname varchar(30) DEFAULT NULL,
  stud_id varchar(15) NOT NULL,
  sex varchar(8) DEFAULT NULL,
  batch varchar(10) DEFAULT NULL,
  faculty varchar(25) DEFAULT NULL,
  block_no varchar(3) DEFAULT NULL,
  room_no varchar(3) DEFAULT NULL,
  PRIMARY KEY (stud_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table: comment
CREATE TABLE IF NOT EXISTS comment (
  id int(11) NOT NULL AUTO_INCREMENT,
  fname varchar(25) NOT NULL,
  email varchar(25) NOT NULL,
  message varchar(250) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2;

-- Sample Data

-- Users
INSERT INTO users (FNAME, mNAME, lname, user_id, sex, level, phone_no, username, password, confirmpassword, status) VALUES
('John', 'gede', 'deme', '069', 'female', '3', '+251918529252', 'mkt', '069', '069', '1'),
('seleshi', 'zelalem', 'bayleyegn', '082', 'male', '2', '+251920737328', 'sele', '1234', '1234', '1'),
('Temesegan', 'Walelign', 'Kebede', '089', 'male', '1', '0922553395', 'admin', '789', '789', '1'),
('John', 'Gkiros', 'haile', '117', 'male', '3', '+251927456841', 'john', '117', '117', '1'),
('sintayehu', 'yimam', 'ahmed', '134', 'female', '3', '+251912633107', 'judi', '1046', '1046', '1'),
('henok', 'Gmariam', 'feseha', '139', 'male', '3', '+251912929283', 'henok', '139', '139', '1');

-- Registrar
INSERT INTO registrar (fname, mname, lname, stud_id, sex, batch, faculty, department) 
VALUES
('abebe', 'kshf', 'djhfgdj', '100', 'male', '3rdyear', 'computing', 'information technology'),
('djfhgdj', 'sjdhfgj', 'jfdk', '101', 'male', '4thyear', 'computing', 'information technology'),
('temesegan', 'djfh', 'jdfhg', '102', 'male', '4thyear', 'computing', 'information technology'),
('jfhdghj', 'g', 'jfhjfh', '103', 'male', '4thyear', 'computing', 'information technology'),
('hjf', 'jsdhb', 'fdjgbd', '104', 'male', '4thyear', 'computing', 'information technology'),
('abebech', 'alemu', 'djhgfjh', '023', 'female', '4thyear', 'computing', 'computer science'),
('dfhjh', 'jhdsgsj', 'fhgj', '152', 'female', '4thyear', 'computing', 'information technology'),
('sintayehu', 'yimam', 'fhgj', '132', 'male', '4thyear', 'ACCOUNTING AND FINANCE', 'information technology'),
('jfkdgsj', 'jksdghjk', 'dfjhg', '58', 'male', '4thyear', 'ACCOUNTING AND FINANCE', 'cs'),
('dsfdfbl', 'dfjbh', 'jhfvdfjhdf', '109', 'male', '4thyear', 'computing', 'is'),
('sintayehu1', 'yimam1', 'fhgj', '133', 'male', '4thyear', 'ACCOUNTING AND FINANCE', 'information technology');

-- Students
INSERT INTO students (fname, mname, lname, stud_id, sex, batch, faculty, block_no, room_no) VALUES
('djfhgdj', 'sjdhfgj', 'jfdk', '101', 'male', '4thyear', 'computing', '30', '1'),
('temesegan', 'djfh', 'jdfhg', '102', 'male', '4thyear', 'computing', '30', '1'),
('jfhdghj', 'g', 'jfhjfh', '103', 'male', '4thyear', 'computing', '30', '1'),
('hjf', 'jsdhb', 'fdjgbd', '104', 'male', '4thyear', 'computing', '30', '1'),
('dsfdfbl', 'dfjbh', 'jhfvdfjhdf', '109', 'male', '4thyear', 'computing', '30', '1'),
('jfkdgsj', 'jksdghjk', 'dfjhg', '58', 'male', '4thyear', 'computing', '30', '1');
