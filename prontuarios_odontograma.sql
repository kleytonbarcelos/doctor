# Host: localhost  (Version: 5.5.5-10.1.16-MariaDB)
# Date: 2017-09-01 16:57:03
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "prontuarios_odontograma"
#

CREATE TABLE `prontuarios_odontograma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prontuario_id` int(11) DEFAULT NULL,
  `local` varchar(255) DEFAULT NULL,
  `procedimento` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

#
# Data for table "prontuarios_odontograma"
#

INSERT INTO `prontuarios_odontograma` VALUES (9,4476,'25','83000046 - Coroa de aço em dente decíduo'),(10,4477,'21','82000050 - Amputação radicular com obturação retrógrada'),(11,4477,'Outro procedimento','30204038 - Exérese de rânula ou mucocele'),(12,4477,'Outro procedimento','85100056 - Curativo de demora em endodontia');
