-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: localhost    Database: political_compass
-- ------------------------------------------------------
-- Server version	5.7.23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(150) NOT NULL,
  `axis` varchar(1) NOT NULL,
  `units` float NOT NULL,
  `agree` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (1,'If economic globalisation is inevitable, it should primarily serve humanity rather than the interests of trans-national corporations.','x',1.12,'-'),(2,'Id always support my country, whether it was right or wrong.','y',0.5,'+'),(3,'No one chooses his or her country of birth, so its foolish to be proud of it.','y',0.5,'-'),(4,'Our race has many superior qualities, compared with other races.','y',0.5,'+'),(5,'The enemy of my enemy is my friend.','y',0.5,'+'),(6,'Military action that defies international law is sometimes justified.','y',0.5,'+'),(7,'There is now a worrying fusion of information and entertainment.','y',0.5,'-'),(8,'People are ultimately divided more by class than by nationality.','x',1.13,'-'),(9,'Controlling inflation is more important than controlling unemployment.','x',1.13,'+'),(10,'Because corporations cannot be trusted to voluntarily protect the environment, they require regulation.','x',1,'-'),(11,'\'From each according to his ability, to each according to his need\' is a fundamentally good idea.','x',1,'-'),(12,'Its a sad reflection on our society that something as basic as drinking water is now a bottled, branded consumer product.','x',1.25,'-'),(13,'Land shouldnt be a commodity to be bought and sold.','x',1.13,'-'),(14,'It is regrettable that many personal fortunes are made by people who simply manipulate money and contribute nothing to their society.','x',1.12,'-'),(15,'Protectionism is sometimes necessary in trade.','x',1.13,'-'),(16,'The only social responsibility of a company should be to deliver a profit to its shareholders.','x',1.13,'+'),(17,'The rich are too highly taxed.','x',1,'+'),(18,'Those with the ability to pay should have access to higher standards of medical care.','x',1,'+'),(19,'Governments should penalise businesses that mislead the public.','x',1,'-'),(20,'A genuine free market requires restrictions on the ability of predator multinationals to create monopolies.','y',0.1,'-'),(21,'The freer the market, the freer the people.','x',1.25,'+'),(22,'Abortion, when the womans life is not threatened, should always be illegal.','y',0.5,'+'),(23,'All authority should be questioned.','y',0.5,'-'),(24,'An eye for an eye and a tooth for a tooth.','y',0.4,'+'),(25,'Taxpayers should not be expected to prop up any theatres or museums that cannot survive on a commercial basis.','x',1.13,'+'),(26,'Schools should not make classroom attendance compulsory.','y',0.5,'-'),(27,'All people have their rights, but it is better for all of us that different sorts of people should keep to their own kind.','y',0.5,'+'),(28,'Good parents sometimes have to spank their children.','y',0.5,'+'),(29,'Its natural for children to keep some secrets from their parents.','y',0.5,'-'),(30,'Possessing marijuana for personal use should not be a criminal offence.','y',0.4,'-'),(31,'The prime function of schooling should be to equip the future generation to find jobs.','y',0.4,'+'),(32,'People with serious inheritable disabilities should not be allowed to reproduce.','y',0.5,'+'),(33,'The most important thing for children to learn is to accept discipline.','y',0.5,'+'),(34,'There are no savage and civilised peoples; there are only different cultures.','y',0.5,'-'),(35,'Those who are able to work, and refuse the opportunity, should not expect societys support.','y',0.5,'+'),(36,'When you are troubled, its better not to think about it, but to keep busy with more cheerful things.','y',0.5,'+'),(37,'First-generation immigrants can never be fully integrated within their new country.','y',0.5,'-'),(38,'Whats good for the most successful corporations is always, ultimately, good for all of us.','x',1.4,'+'),(39,'No broadcasting institution, however independent its content, should receive public funding.','x',0.75,'+'),(40,'Our civil liberties are being excessively curbed in the name of counter-terrorism.','y',0.5,'+'),(41,'A significant advantage of a one-party state is that it avoids all the arguments that delay progress in a democratic political system.','y',0.5,'+'),(42,'Although the electronic age makes official surveillance easier, only wrongdoers need to be worried.','y',0.5,'+'),(43,'The death penalty should be an option for the most serious crimes.','y',0.5,'+'),(44,'In a civilised society, one must always have people above to be obeyed and people below to be commanded.','y',0.4,'+'),(45,'Abstract art that doesnt represent anything shouldnt be considered art at all.','y',0.5,'+'),(46,'In criminal justice, punishment should be more important than rehabilitation.','y',0.5,'-'),(47,'It is a waste of time to try to rehabilitate some criminals.','y',0.5,'-'),(48,'The businessperson and the manufacturer are more important than the writer and the artist.','y',0.4,'-'),(49,'Mothers may have careers, but their first duty is to be homemakers.','y',0.4,'+'),(50,'Multinational companies are unethically exploiting the plant genetic resources of developing countries.','y',0.5,'-'),(51,'Making peace with the establishment is an important aspect of maturity.','y',0.4,'+'),(52,'Astrology accurately explains many things.','y',0.4,'+'),(53,'You cannot be moral without being religious.','y',0.4,'+'),(54,'Charity is better than social security as a means of helping the genuinely disadvantaged.','x',1.25,'+'),(55,'Some people are naturally unlucky.','y',0.4,'+'),(56,'It is important that my childs school instills religious values.','y',0.4,'+'),(57,'Sex outside marriage is usually immoral.','y',0.46,'+'),(58,'A same sex couple in a stable, loving relationship should not be excluded from the possibility of child adoption.','y',0.4,'-'),(59,'Pornography, depicting consenting adults, should be legal for the adult population.','y',0.4,'-'),(60,'What goes on in a private bedroom between consenting adults is no business of the state.','y',0.4,'-'),(61,'No one can feel naturally homosexual.','y',0.4,'+'),(62,'These days openness about sex has gone too far.','y',0.44,'+');
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-08-18  4:56:53

