-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2019 at 06:05 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `controlic`
--
CREATE DATABASE IF NOT EXISTS `controlic` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `controlic`;

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_clientsupdate_save` (IN `pidclient` INT, IN `pdesrazsoc` VARCHAR(128), IN `pdesfantasia` VARCHAR(128), IN `pdescnpj` VARCHAR(128), IN `pdesnrphone` VARCHAR(128), IN `pdesemail` VARCHAR(128))  NO SQL
BEGIN
    
	UPDATE tb_clients SET 
    desrazsoc = pdesrazsoc,
    desfantasia = pdesfantasia,
    descnpj = pdescnpj,
    desnrphone = pdesnrphone,
    desemail = pdesemail
    WHERE pidclient = idclient;
    
    SELECT * FROM tb_clients a INNER JOIN tb_registers b USING(idclient) WHERE a.idclient = b.idclient;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_clients_delete` (IN `pidclient` INT)  NO SQL
BEGIN
	
    SET FOREIGN_KEY_CHECKS = 0;
    
    DELETE FROM tb_clients WHERE idclient = pidclient;
    
    SET FOREIGN_KEY_CHECKS = 1;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_clients_save` (IN `pdesrazsoc` VARCHAR(128), IN `pdesfantasia` VARCHAR(128), IN `pdescnpj` VARCHAR(128), IN `pdesnrphone` VARCHAR(128), IN `pdesemail` VARCHAR(128), IN `pdeslicexpires` TIMESTAMP, IN `piduser` INT)  NO SQL
BEGIN

	DECLARE vidclient INT;
    
	INSERT INTO tb_clients (desrazsoc, desfantasia, descnpj, desnrphone, desemail)
    VALUES(pdesrazsoc, pdesfantasia, pdescnpj, pdesnrphone, pdesemail);
    
    SET vidclient = LAST_INSERT_ID();
    
    INSERT INTO tb_registers (idclient, deslicexpires, iduser)
    VALUES(vidclient, pdeslicexpires, piduser);
    
        SELECT * FROM tb_clients a INNER JOIN tb_registers b USING(idclient) WHERE a.idclient = b.idclient;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_licenseupdate_save` (IN `pidclient` INT, IN `pdeslicexpires` TIMESTAMP)  NO SQL
BEGIN

UPDATE tb_registers SET
    deslicexpires = pdeslicexpires,
    deslicregister = CURRENT_TIMESTAMP()
	WHERE idclient = pidclient;

SELECT * FROM tb_clients a INNER JOIN tb_registers b USING(idclient) WHERE a.idclient = b.idclient;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_userspasswordsrecoveries_create` (`piduser` INT, `pdesip` VARCHAR(45))  BEGIN
	
	INSERT INTO tb_userspasswordsrecoveries (iduser, desip)
    VALUES(piduser, pdesip);
    
    SELECT * FROM tb_userspasswordsrecoveries
    WHERE idrecovery = LAST_INSERT_ID();
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usersupdate_save` (`piduser` INT, `pdesperson` VARCHAR(64), `pdeslogin` VARCHAR(64), `pdespassword` VARCHAR(256), `pdesemail` VARCHAR(128), `pnrphone` BIGINT, `pinadmin` TINYINT)  BEGIN
	
    DECLARE vidperson INT;
    
	SELECT idperson INTO vidperson
    FROM tb_users
    WHERE iduser = piduser;
    
    UPDATE tb_persons
    SET 
		desperson = pdesperson,
        desemail = pdesemail,
        nrphone = pnrphone
	WHERE idperson = vidperson;
    
    UPDATE tb_users
    SET
		deslogin = pdeslogin,
        despassword = pdespassword,
        inadmin = pinadmin
	WHERE iduser = piduser;
    
    SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) WHERE a.iduser = piduser;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_users_delete` (IN `piduser` INT)  BEGIN
    
    DECLARE vidperson INT;
    
    SET FOREIGN_KEY_CHECKS = 0;
	
	SELECT idperson INTO vidperson
    FROM tb_users
    WHERE iduser = piduser;
	
	DELETE FROM tb_persons WHERE idperson = vidperson;
    DELETE FROM tb_userslogs WHERE iduser = piduser;
    DELETE FROM tb_userspasswordsrecoveries WHERE iduser = piduser;
    DELETE FROM tb_users WHERE iduser = piduser;
    
    SET FOREIGN_KEY_CHECKS = 1;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_users_save` (`pdesperson` VARCHAR(64), `pdeslogin` VARCHAR(64), `pdespassword` VARCHAR(256), `pdesemail` VARCHAR(128), `pnrphone` BIGINT, `pinadmin` TINYINT)  BEGIN
	
    DECLARE vidperson INT;
    
	INSERT INTO tb_persons (desperson, desemail, nrphone)
    VALUES(pdesperson, pdesemail, pnrphone);
    
    SET vidperson = LAST_INSERT_ID();
    
    INSERT INTO tb_users (idperson, deslogin, despassword, inadmin)
    VALUES(vidperson, pdeslogin, pdespassword, pinadmin);
    
    SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) WHERE a.iduser = LAST_INSERT_ID();
    
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_clients`
--

CREATE TABLE `tb_clients` (
  `idclient` int(11) NOT NULL,
  `desrazsoc` varchar(50) DEFAULT NULL,
  `desfantasia` varchar(50) NOT NULL,
  `descnpj` varchar(14) DEFAULT NULL,
  `desnrphone` varchar(30) DEFAULT NULL,
  `desemail` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_orders`
--

CREATE TABLE `tb_orders` (
  `idorder` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `idclient` int(11) NOT NULL,
  `desorderdays` int(11) NOT NULL,
  `desdtorder` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_persons`
--

CREATE TABLE `tb_persons` (
  `idperson` int(11) NOT NULL,
  `desperson` varchar(64) NOT NULL,
  `desemail` varchar(128) DEFAULT NULL,
  `nrphone` bigint(20) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_registers`
--

CREATE TABLE `tb_registers` (
  `idregister` int(11) NOT NULL,
  `idclient` int(11) NOT NULL,
  `idorder` int(11) DEFAULT NULL,
  `iduser` int(11) NOT NULL,
  `deslicregister` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deslicexpires` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `iduser` int(11) NOT NULL,
  `idperson` int(11) NOT NULL,
  `deslogin` varchar(64) NOT NULL,
  `despassword` varchar(256) NOT NULL,
  `inadmin` tinyint(4) NOT NULL DEFAULT 0,
  `dtregister` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_clients`
--
ALTER TABLE `tb_clients`
  ADD PRIMARY KEY (`idclient`),
  ADD UNIQUE KEY `desfantasia` (`desfantasia`),
  ADD UNIQUE KEY `desfantasia_2` (`desfantasia`),
  ADD UNIQUE KEY `desfantasia_3` (`desfantasia`);

--
-- Indexes for table `tb_orders`
--
ALTER TABLE `tb_orders`
  ADD PRIMARY KEY (`idorder`),
  ADD KEY `FK_user_idx` (`iduser`) USING BTREE,
  ADD KEY `FK_client_idx` (`idclient`) USING BTREE;

--
-- Indexes for table `tb_persons`
--
ALTER TABLE `tb_persons`
  ADD PRIMARY KEY (`idperson`);

--
-- Indexes for table `tb_registers`
--
ALTER TABLE `tb_registers`
  ADD PRIMARY KEY (`idregister`),
  ADD UNIQUE KEY `fk_iduser_idx` (`idregister`),
  ADD KEY `FK_idorder_idx` (`idorder`),
  ADD KEY `FK_client_register_idx` (`idclient`),
  ADD KEY `fk_iduser` (`iduser`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`iduser`),
  ADD KEY `FK_users_persons_idx` (`idperson`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_clients`
--
ALTER TABLE `tb_clients`
  MODIFY `idclient` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_orders`
--
ALTER TABLE `tb_orders`
  MODIFY `idorder` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_persons`
--
ALTER TABLE `tb_persons`
  MODIFY `idperson` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_registers`
--
ALTER TABLE `tb_registers`
  MODIFY `idregister` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_orders`
--
ALTER TABLE `tb_orders`
  ADD CONSTRAINT `fk_clientorders` FOREIGN KEY (`idclient`) REFERENCES `tb_clients` (`idclient`),
  ADD CONSTRAINT `fk_userorders` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`);

--
-- Constraints for table `tb_registers`
--
ALTER TABLE `tb_registers`
  ADD CONSTRAINT `fk_idclient` FOREIGN KEY (`idclient`) REFERENCES `tb_clients` (`idclient`),
  ADD CONSTRAINT `fk_idorder` FOREIGN KEY (`idorder`) REFERENCES `tb_orders` (`idorder`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_iduser` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`) ON UPDATE CASCADE;

--
-- Constraints for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD CONSTRAINT `fk_users_persons` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
