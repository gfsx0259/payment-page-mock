-- MySQL dump 10.13  Distrib 8.0.30, for Linux (x86_64)
--
-- Host: localhost    Database: app
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `route`
--

DROP TABLE IF EXISTS `route`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `route` (
  `id` int NOT NULL AUTO_INCREMENT,
  `route` varchar(128) NOT NULL,
  `title` varchar(191) NOT NULL,
  `logo` varchar(191) NOT NULL,
  `type` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `route`
--

LOCK TABLES `route` WRITE;
/*!40000 ALTER TABLE `route` DISABLE KEYS */;
INSERT INTO `route` VALUES (1,'card/sale','Card integration','card.svg',1),(2,'wallet/kakaopay/sale','QR code integration','kakaopay.svg',3),(22,'wallet/gcash/sale','Redirect integration','gcash.svg',2),(23,'pix/sale','QR code integration','pix.svg',3),(26,'banks/estonia/sale','Banks integration','neofinance.svg',2);
/*!40000 ALTER TABLE `route` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `callback`
--

DROP TABLE IF EXISTS `callback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `callback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `stub_id` int NOT NULL,
  `body` text NOT NULL,
  `order` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `callback_index_stub_id_6229ddc8962af` (`stub_id`),
  CONSTRAINT `callback_foreign_stub_id_6229ddc8962e9` FOREIGN KEY (`stub_id`) REFERENCES `stub` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `callback`
--

LOCK TABLES `callback` WRITE;
/*!40000 ALTER TABLE `callback` DISABLE KEYS */;
INSERT INTO `callback` VALUES (1,1,'{\"acs\":{\"pa_req\":\"112442583\",\"acs_url\":\"{{ACS_URL}}\",\"md\":\"eyJwdXJjaGFzZV9vcGVyYXRpb25faWQiOjUzLCJwcm9qZWN0X2lkIjo0MDIsInBheW1lbnRfaWQiOiJFUDU4ZjQtODdhNSIsInBsdXNfbWQiOiIifQ==\",\"term_url\":\"{{TERM_URL}}\"},\"sum_request\":{\"amount\":100056,\"currency\":\"RUB\"},\"request_id\":\"dbf1a3922c3d5565be5794d7d56a12e627e2b5ba-8c01825b9f349270e3dd91acd26976c6941b324a-00000001\",\"transaction\":{\"id\":35,\"date\":\"2022-03-13T17:07:48+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"card\",\"date\":\"2022-03-13T17:07:48+0000\",\"result_code\":\"0\",\"result_message\":\"Success\",\"status\":\"awaiting 3ds result\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EP9cc8-d305\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"actual_amount\":1000,\"remaining_refund\":1000,\"split_with_redirect\":false,\"provider_id\":3},\"sum_real\":{\"amount\":1000,\"currency\":\"RUB\"},\"account\":{\"number\":\"424242******4242\",\"type\":\"visa\",\"card_holder\":\"KO PO\",\"expiry_month\":\"10\",\"expiry_year\":\"2022\"},\"rrn\":\"000047769105\",\"AuthCode\":\"563253\",\"company\":{\"id\":1,\"title\":\"QA Company\"},\"general\":{\"project_id\":402,\"payment_id\":\"EP9cc8-d305\",\"signature\":\"bDSvqnpC5IXT5WH9UsaTPNSZk8oE1I8Ozfz5PR\\/Lg\\/EfloEpFf3l5QCKBpb5HcfOJBijzokvPhNlTjoeHD7TFw==\"},\"description\":\"\",\"operations\":[{\"id\":35,\"type\":\"sale\",\"status\":\"processing\",\"date\":\"2022-03-13T17:07:49+0000\",\"processing_time\":\"2022-03-13T17:07:48+0000\",\"request_id\":\"dbf1a3922c3d5565be5794d7d56a12e627e2b5ba-8c01825b9f349270e3dd91acd26976c6941b324a-00000001\",\"sum\":{\"amount\":1000,\"currency\":\"RUB\"},\"code\":\"0\",\"message\":\"Success\",\"provider\":{\"id\":3,\"payment_id\":\"16471912682712\"}}],\"return_url\":\"http:\\/\\/pp.terminal.test\\/process\\/complete-redirect\\/0ve40f96ssi35bvuln3irp5775\\/49fb2ae0c4d52bfb\"}',0),(2,1,'{\"sum_request\":{\"amount\":5000,\"currency\":\"RUB\"},\"request_id\":\"dbf1a3922c3d5565be5794d7d56a12e627e2b5ba-8c01825b9f349270e3dd91acd26976c6941b324a-00000001\",\"transaction\":{\"id\":35,\"date\":\"2022-03-13T17:07:48+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"card\",\"date\":\"2022-03-13T17:07:48+0000\",\"result_code\":\"0\",\"result_message\":\"Success\",\"status\":\"success\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EP9cc8-d305\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"actual_amount\":5000,\"remaining_refund\":5000,\"split_with_redirect\":false,\"provider_id\":3},\"sum_real\":{\"amount\":5000,\"currency\":\"RUB\"},\"account\":{\"number\":\"424242******4242\",\"type\":\"visa\",\"card_holder\":\"KO PO\",\"expiry_month\":\"10\",\"expiry_year\":\"2022\"},\"rrn\":\"000047769105\",\"AuthCode\":\"563253\",\"company\":{\"id\":1,\"title\":\"QA Company\"},\"general\":{\"project_id\":402,\"payment_id\":\"EP9cc8-d305\",\"signature\":\"bDSvqnpC5IXT5WH9UsaTPNSZk8oE1I8Ozfz5PR\\/Lg\\/EfloEpFf3l5QCKBpb5HcfOJBijzokvPhNlTjoeHD7TFw==\"},\"description\":\"\",\"operations\":[{\"id\":35,\"type\":\"sale\",\"status\":\"success\",\"date\":\"2022-03-13T17:07:49+0000\",\"processing_time\":\"2022-03-13T17:07:48+0000\",\"request_id\":\"dbf1a3922c3d5565be5794d7d56a12e627e2b5ba-8c01825b9f349270e3dd91acd26976c6941b324a-00000001\",\"sum\":{\"amount\":5000,\"currency\":\"RUB\"},\"code\":\"0\",\"message\":\"Success\",\"provider\":{\"id\":3,\"payment_id\":\"16471912682712\"}}],\"return_url\":\"http:\\/\\/pp.terminal.test\\/process\\/complete-redirect\\/0ve40f96ssi35bvuln3irp5775\\/49fb2ae0c4d52bfb\"}',0),(5,15,'{\"sum_request\":{\"amount\":1000,\"currency\":\"KRW\"},\"request_id\":\"{{REQUEST_ID}}\",\"transaction\":{\"id\":91,\"date\":\"2022-04-13T08:56:24+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"kakaopay\",\"date\":\"2022-04-13T08:56:24+0000\",\"result_code\":\"9999\",\"result_message\":\"Awaiting processing\",\"status\":\"awaiting customer action\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EP8adf-6913\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"split_with_redirect\":false,\"provider_id\":2780},\"sum_real\":{\"amount\":1000,\"currency\":\"KRW\"},\"rrn\":\"\",\"display_data\":[{\"type\":\"qr_img\",\"title\":\"QR code\",\"data\":\"{{QR_ACCEPT_IMAGE}}\"}],\"company\":{\"id\":1,\"title\":\"QA Company\"},\"general\":{\"project_id\":3899,\"payment_id\":\"EP8adf-6913\",\"signature\":\"ht8GuFN3NiCAZ1BgR9ZEQCI1B95dOhAz80xhn6T\\/Givv5qiTB1FVz6kHznwD9lZNSUw1LiZXL3E0YAeqSpSt8g==\"},\"description\":\"\",\"operations\":[{\"id\":91,\"type\":\"sale\",\"status\":\"awaiting customer action\",\"date\":\"2022-04-13T08:56:23+0000\",\"processing_time\":null,\"request_id\":\"2f5645b79dbe582cd524379654467cc7b034f3e3-495659ce9f36c71cd3740aca7cfce90f4eed88a3-00000001\",\"sum\":{\"amount\":1000,\"currency\":\"KRW\"},\"code\":\"9999\",\"message\":\"Awaiting processing\",\"provider\":{\"id\":2780}}]}',0),(7,15,'{\"sum_request\":{\"amount\":1000,\"currency\":\"KRW\"},\"request_id\":\"{{REQUEST_ID}}\",\"transaction\":{\"id\":91,\"date\":\"2022-04-13T08:56:24+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"kakaopay\",\"date\":\"2022-04-13T08:56:24+0000\",\"result_code\":\"9999\",\"result_message\":\"Success\",\"status\":\"success\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EP8adf-6913\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"split_with_redirect\":false,\"provider_id\":2780},\"sum_real\":{\"amount\":1000,\"currency\":\"KRW\"},\"rrn\":\"\",\"company\":{\"id\":1,\"title\":\"QA Company\"},\"general\":{\"project_id\":3899,\"payment_id\":\"EP8adf-6913\",\"signature\":\"ht8GuFN3NiCAZ1BgR9ZEQCI1B95dOhAz80xhn6T\\/Givv5qiTB1FVz6kHznwD9lZNSUw1LiZXL3E0YAeqSpSt8g==\"},\"description\":\"\",\"operations\":[{\"id\":91,\"type\":\"sale\",\"status\":\"sucess\",\"date\":\"2022-04-13T08:56:23+0000\",\"processing_time\":null,\"request_id\":\"2f5645b79dbe582cd524379654467cc7b034f3e3-495659ce9f36c71cd3740aca7cfce90f4eed88a3-00000001\",\"sum\":{\"amount\":1000,\"currency\":\"KRW\"},\"code\":\"9999\",\"message\":\"Success\",\"provider\":{\"id\":2780}}]}',0),(8,2,'{\"sum_request\":{\"amount\":3000,\"currency\":\"RUB\"},\"request_id\":\"dbf1a3922c3d5565be5794d7d56a12e627e2b5ba-8c01825b9f349270e3dd91acd26976c6941b324a-00000001\",\"transaction\":{\"id\":35,\"date\":\"2022-03-13T17:07:48+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"card\",\"date\":\"2022-03-13T17:07:48+0000\",\"result_code\":\"0\",\"result_message\":\"Decline\",\"status\":\"decline\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EP9cc8-d305\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"actual_amount\":3000,\"remaining_refund\":3000,\"split_with_redirect\":false,\"provider_id\":3},\"sum_real\":{\"amount\":3000,\"currency\":\"RUB\"},\"account\":{\"number\":\"424242******4242\",\"type\":\"visa\",\"card_holder\":\"KO PO\",\"expiry_month\":\"10\",\"expiry_year\":\"2022\"},\"rrn\":\"000047769105\",\"AuthCode\":\"563253\",\"company\":{\"id\":1,\"title\":\"QA Company\"},\"general\":{\"project_id\":402,\"payment_id\":\"EP9cc8-d305\",\"signature\":\"bDSvqnpC5IXT5WH9UsaTPNSZk8oE1I8Ozfz5PR\\/Lg\\/EfloEpFf3l5QCKBpb5HcfOJBijzokvPhNlTjoeHD7TFw==\"},\"description\":\"\",\"operations\":[{\"id\":35,\"type\":\"sale\",\"status\":\"decline\",\"date\":\"2022-03-13T17:07:49+0000\",\"processing_time\":\"2022-03-13T17:07:48+0000\",\"request_id\":\"dbf1a3922c3d5565be5794d7d56a12e627e2b5ba-8c01825b9f349270e3dd91acd26976c6941b324a-00000001\",\"sum\":{\"amount\":3000,\"currency\":\"RUB\"},\"code\":\"0\",\"message\":\"Decline\",\"provider\":{\"id\":3,\"payment_id\":\"16471912682712\"}}],\"return_url\":\"http:\\/\\/pp.terminal.test\\/process\\/complete-redirect\\/0ve40f96ssi35bvuln3irp5775\\/49fb2ae0c4d52bfb\"}',0),(9,11,'{\"sum_request\":{\"amount\":4000,\"currency\":\"RUB\"},\"request_id\":\"{{REQUEST_ID}}\",\"transaction\":{\"id\":35,\"date\":\"2022-03-13T17:07:48+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"card\",\"date\":\"2022-03-13T17:07:48+0000\",\"result_code\":\"0\",\"result_message\":\"Success\",\"status\":\"success\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EP9cc8-d305\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"actual_amount\":4000,\"remaining_refund\":4000,\"split_with_redirect\":false,\"provider_id\":3},\"sum_real\":{\"amount\":4000,\"currency\":\"RUB\"},\"account\":{\"number\":\"424242******4242\",\"type\":\"visa\",\"card_holder\":\"KO PO\",\"expiry_month\":\"10\",\"expiry_year\":\"2022\"},\"rrn\":\"000047769105\",\"AuthCode\":\"563253\",\"company\":{\"id\":1,\"title\":\"QA Company\"},\"general\":{\"project_id\":402,\"payment_id\":\"EP9cc8-d305\",\"signature\":\"bDSvqnpC5IXT5WH9UsaTPNSZk8oE1I8Ozfz5PR\\/Lg\\/EfloEpFf3l5QCKBpb5HcfOJBijzokvPhNlTjoeHD7TFw==\"},\"description\":\"\",\"operations\":[{\"id\":35,\"type\":\"sale\",\"status\":\"success\",\"date\":\"2022-03-13T17:07:49+0000\",\"processing_time\":\"2022-03-13T17:07:48+0000\",\"request_id\":\"{{REQUEST_ID}}\",\"sum\":{\"amount\":4000,\"currency\":\"RUB\"},\"code\":\"0\",\"message\":\"Success\",\"provider\":{\"id\":3,\"payment_id\":\"16471912682712\"}}],\"return_url\":\"http:\\/\\/pp.terminal.test\\/process\\/complete-redirect\\/0ve40f96ssi35bvuln3irp5775\\/49fb2ae0c4d52bfb\"}',0),(10,17,'{\"sum_request\":{\"amount\":1000,\"currency\":\"RUB\"},\"request_id\":\"{{REQUEST_ID}}\",\"transaction\":{\"id\":32,\"date\":\"2022-05-11T14:12:32+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"card\",\"date\":\"2022-05-11T14:12:32+0000\",\"result_code\":\"9999\",\"result_message\":\"Awaiting processing\",\"status\":\"awaiting clarification\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EPb727-dd9f\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"split_with_redirect\":false,\"provider_id\":3},\"sum_real\":{\"amount\":1000,\"currency\":\"RUB\"},\"account\":{\"number\":\"444444******3333\",\"type\":\"visa\",\"card_holder\":\"TEST TESTOV\",\"expiry_month\":\"05\",\"expiry_year\":\"2022\"},\"clarification_fields\":{\"avs_data\":[\"avs_post_code\",\"avs_street_address\"]},\"rrn\":\"\",\"company\":{\"id\":1,\"title\":\"QA Company\"},\"general\":{\"project_id\":2052,\"payment_id\":\"EPb727-dd9f\",\"signature\":\"oNJKxeYaFGOY4uodMYYMf3s2Ss37h1UKK0BOYA6BHBFx4yhAr4exGZVmjry4oysX+\\/mh\\/P5AxyAD\\/BGCLD0gtg==\"},\"description\":\"\",\"operations\":[{\"id\":32,\"type\":\"sale\",\"status\":\"awaiting clarification\",\"date\":\"2022-05-11T14:12:32+0000\",\"processing_time\":null,\"request_id\":\"a546aa84c3fbf12af8508da21caf9a1136a95037-7d8f34fcd173ef282745e02f13b872e69ed65766-00000001\",\"sum\":{\"amount\":1000,\"currency\":\"RUB\"},\"code\":\"9999\",\"message\":\"Awaiting processing\",\"provider\":{\"id\":3}}]}',0),(16,17,'{\"sum_request\":{\"amount\":1000,\"currency\":\"RUB\"},\"request_id\":\"{{REQUEST_ID}}\",\"transaction\":{\"id\":32,\"date\":\"2022-05-11T14:12:32+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"card\",\"date\":\"2022-05-11T14:12:32+0000\",\"result_code\":\"9999\",\"result_message\":\"Awaiting processing\",\"status\":\"awaiting clarification\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EPb727-dd9f\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"split_with_redirect\":false,\"provider_id\":3},\"sum_real\":{\"amount\":1000,\"currency\":\"RUB\"},\"account\":{\"number\":\"444444******3333\",\"type\":\"visa\",\"card_holder\":\"TEST TESTOV\",\"expiry_month\":\"05\",\"expiry_year\":\"2022\"},\"clarification_fields\":{\"avs_data\":{\"type\":\"array\",\"properties\":{\"avs_post_code\":{\"description\":\"some\"}}}},\"rrn\":\"\",\"company\":{\"id\":1,\"title\":\"QA Company\"},\"general\":{\"project_id\":2052,\"payment_id\":\"EPb727-dd9f\",\"signature\":\"oNJKxeYaFGOY4uodMYYMf3s2Ss37h1UKK0BOYA6BHBFx4yhAr4exGZVmjry4oysX+\\/mh\\/P5AxyAD\\/BGCLD0gtg==\"},\"description\":\"\",\"operations\":[{\"id\":32,\"type\":\"sale\",\"status\":\"awaiting clarification\",\"date\":\"2022-05-11T14:12:32+0000\",\"processing_time\":null,\"request_id\":\"a546aa84c3fbf12af8508da21caf9a1136a95037-7d8f34fcd173ef282745e02f13b872e69ed65766-00000001\",\"sum\":{\"amount\":1000,\"currency\":\"RUB\"},\"code\":\"9999\",\"message\":\"Awaiting processing\",\"provider\":{\"id\":3}}]}',0),(17,17,'{\"sum_request\":{\"amount\":4000,\"currency\":\"RUB\"},\"request_id\":\"{{REQUEST_ID}}\",\"transaction\":{\"id\":35,\"date\":\"2022-03-13T17:07:48+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"card\",\"date\":\"2022-03-13T17:07:48+0000\",\"result_code\":\"0\",\"result_message\":\"Success\",\"status\":\"success\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EP9cc8-d305\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"actual_amount\":4000,\"remaining_refund\":4000,\"split_with_redirect\":false,\"provider_id\":3},\"sum_real\":{\"amount\":4000,\"currency\":\"RUB\"},\"account\":{\"number\":\"424242******4242\",\"type\":\"visa\",\"card_holder\":\"KO PO\",\"expiry_month\":\"10\",\"expiry_year\":\"2022\"},\"rrn\":\"000047769105\",\"AuthCode\":\"563253\",\"company\":{\"id\":1,\"title\":\"QA Company\"},\"general\":{\"project_id\":2052,\"payment_id\":\"EPb727-dd9f\",\"signature\":\"oNJKxeYaFGOY4uodMYYMf3s2Ss37h1UKK0BOYA6BHBFx4yhAr4exGZVmjry4oysX+\\/mh\\/P5AxyAD\\/BGCLD0gtg==\"},\"description\":\"\",\"operations\":[{\"id\":35,\"type\":\"sale\",\"status\":\"success\",\"date\":\"2022-03-13T17:07:49+0000\",\"processing_time\":\"2022-03-13T17:07:48+0000\",\"request_id\":\"dbf1a3922c3d5565be5794d7d56a12e627e2b5ba-8c01825b9f349270e3dd91acd26976c6941b324a-00000001\",\"sum\":{\"amount\":4000,\"currency\":\"RUB\"},\"code\":\"0\",\"message\":\"Success\",\"provider\":{\"id\":3,\"payment_id\":\"16471912682712\"}}],\"return_url\":\"http:\\/\\/pp.terminal.test\\/process\\/complete-redirect\\/0ve40f96ssi35bvuln3irp5775\\/49fb2ae0c4d52bfb\"}',0),(19,18,'{\"request_id\":\"9e9e6bbe33624400589c10b8a229d17448e94cb4-ab7a0fa6ed133d08ac8b02624cdeec7c9fcab061-00000001\",\"transaction\":{\"id\":146,\"date\":\"2022-05-26T12:44:17+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"Gcash wallet\",\"date\":\"2022-05-26T12:44:17+0000\",\"result_code\":\"9999\",\"result_message\":\"Awaiting processing\",\"status\":\"awaiting redirect result\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EP8949-1fa2\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"split_with_redirect\":false,\"provider_id\":1794},\"sum_real\":{\"amount\":1000,\"currency\":\"PHP\"},\"rrn\":\"\",\"return_url\":{\"method\":\"GET\",\"body\":[],\"encrypted\":[],\"url\":\"{{APS_URL}}\"},\"sum_request\":{\"amount\":1000,\"currency\":\"PHP\"},\"company\":{\"id\":3,\"title\":\"Regress company 1\"},\"general\":{\"project_id\":445,\"payment_id\":\"EP8949-1fa2\",\"signature\":\"WYNggEzqIWNwncmkZ1GuEjWEuaBkS4prkirqL1gRZsxTaqqC1g5myk1OZw8\\/hsoVn+LDncCmDmAcHVcJ0O\\/LkQ==\"},\"description\":\"\",\"operations\":[{\"id\":146,\"type\":\"sale\",\"status\":\"awaiting redirect result\",\"date\":\"2022-05-26T12:44:17+0000\",\"processing_time\":null,\"request_id\":\"cd8a62bfd04885fcc917fdd9d9821a71373c7761-6e9dfb31133e8e1f5f0f7bc1c90c122418ba851c-00000001\",\"sum\":{\"amount\":1000,\"currency\":\"PHP\"},\"code\":\"9999\",\"message\":\"Awaiting processing\",\"provider\":{\"id\":1794}}]}',0),(20,18,'{\"request_id\":\"7925522ac728d4d7fee307b718b3a83a2d23cabb-08d00acecd833d7237fd9c1afe996db513d3bed6-00000001\",\"transaction\":{\"id\":146,\"date\":\"2022-05-26T12:44:35+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"Gcash wallet\",\"date\":\"2022-05-26T12:44:35+0000\",\"result_code\":\"0\",\"result_message\":\"Success\",\"status\":\"success\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EP8949-1fa2\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"actual_amount\":1000,\"split_with_redirect\":false,\"provider_id\":1794},\"sum_real\":{\"amount\":1000,\"currency\":\"PHP\"},\"account\":{\"number\":\"pp@pp.pp\"},\"rrn\":\"\",\"sum_request\":{\"amount\":1000,\"currency\":\"PHP\"},\"company\":{\"id\":3,\"title\":\"Regress company 1\"},\"general\":{\"project_id\":445,\"payment_id\":\"EP8949-1fa2\",\"signature\":\"\\/6Y7tZ4eN8magGoCP1Z9iT3+isf237gmOrSt3AYMSKsw+sxM1O1Xpxps3qtqBhF7FN7LTdmu3onf5NCV6U5MLw==\"},\"description\":\"\",\"operations\":[{\"id\":146,\"type\":\"sale\",\"status\":\"success\",\"date\":\"2022-05-26T12:44:35+0000\",\"processing_time\":\"2020-02-13T08:31:32+0000\",\"request_id\":\"cd8a62bfd04885fcc917fdd9d9821a71373c7761-6e9dfb31133e8e1f5f0f7bc1c90c122418ba851c-00000001\",\"sum\":{\"amount\":1000,\"currency\":\"PHP\"},\"code\":\"0\",\"message\":\"Success\",\"provider\":{\"id\":1794,\"payment_id\":\"PAC3WK06\"}}],\"return_url\":\"http:\\/\\/pp.terminal.test\\/process\\/complete-redirect\\/i4jceeap8v4g4s1ibba3taaq1f\\/c245134d8c0f0f4a\"}',0),(21,19,'{\"sum_request\":{\"amount\":1000,\"currency\":\"KRW\"},\"request_id\":\"2f5645b79dbe582cd524379654467cc7b034f3e3-495659ce9f36c71cd3740aca7cfce90f4eed88a3-00000001\",\"transaction\":{\"id\":91,\"date\":\"2022-04-13T08:56:24+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"pix\",\"date\":\"2022-04-13T08:56:24+0000\",\"result_code\":\"9999\",\"result_message\":\"Awaiting processing\",\"status\":\"awaiting clarification\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EP8adf-6913\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"split_with_redirect\":false,\"provider_id\":2780},\"sum_real\":{\"amount\":1000,\"currency\":\"KRW\"},\"clarification_fields\":{\"avs_data\":[\"avs_post_code\",\"avs_street_address\"]},\"rrn\":\"\",\"company\":{\"id\":1,\"title\":\"QA Company\"},\"general\":{\"project_id\":3899,\"payment_id\":\"EP8adf-6913\",\"signature\":\"ht8GuFN3NiCAZ1BgR9ZEQCI1B95dOhAz80xhn6T\\/Givv5qiTB1FVz6kHznwD9lZNSUw1LiZXL3E0YAeqSpSt8g==\"},\"description\":\"\",\"operations\":[{\"id\":91,\"type\":\"sale\",\"status\":\"awaiting clarification\",\"date\":\"2022-04-13T08:56:23+0000\",\"processing_time\":null,\"request_id\":\"2f5645b79dbe582cd524379654467cc7b034f3e3-495659ce9f36c71cd3740aca7cfce90f4eed88a3-00000001\",\"sum\":{\"amount\":1000,\"currency\":\"KRW\"},\"code\":\"9999\",\"message\":\"Awaiting processing\",\"provider\":{\"id\":2780}}]}',0),(22,19,'{\"sum_request\":{\"amount\":1000,\"currency\":\"KRW\"},\"request_id\":\"2f5645b79dbe582cd524379654467cc7b034f3e3-495659ce9f36c71cd3740aca7cfce90f4eed88a3-00000001\",\"transaction\":{\"id\":91,\"date\":\"2022-04-13T08:56:24+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"pix\",\"date\":\"2022-04-13T08:56:24+0000\",\"result_code\":\"9999\",\"result_message\":\"Awaiting processing\",\"status\":\"awaiting customer action\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EP8adf-6913\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"split_with_redirect\":false,\"provider_id\":2780},\"sum_real\":{\"amount\":1000,\"currency\":\"KRW\"},\"rrn\":\"\",\"display_data\":[{\"type\":\"qr_data\",\"title\":\"QR code\",\"data\":\"{{QR_ACCEPT_LINK}}\"}],\"company\":{\"id\":1,\"title\":\"QA Company\"},\"general\":{\"project_id\":3899,\"payment_id\":\"EP8adf-6913\",\"signature\":\"ht8GuFN3NiCAZ1BgR9ZEQCI1B95dOhAz80xhn6T\\/Givv5qiTB1FVz6kHznwD9lZNSUw1LiZXL3E0YAeqSpSt8g==\"},\"description\":\"\",\"operations\":[{\"id\":91,\"type\":\"sale\",\"status\":\"awaiting customer action\",\"date\":\"2022-04-13T08:56:23+0000\",\"processing_time\":null,\"request_id\":\"2f5645b79dbe582cd524379654467cc7b034f3e3-495659ce9f36c71cd3740aca7cfce90f4eed88a3-00000001\",\"sum\":{\"amount\":1000,\"currency\":\"KRW\"},\"code\":\"9999\",\"message\":\"Awaiting processing\",\"provider\":{\"id\":2780}}]}',0),(23,19,'{\"sum_request\":{\"amount\":1000,\"currency\":\"KRW\"},\"request_id\":\"2f5645b79dbe582cd524379654467cc7b034f3e3-495659ce9f36c71cd3740aca7cfce90f4eed88a3-00000001\",\"transaction\":{\"id\":91,\"date\":\"2022-04-13T08:56:24+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"pix\",\"date\":\"2022-04-13T08:56:24+0000\",\"result_code\":\"9999\",\"result_message\":\"success\",\"status\":\"success\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EP8adf-6913\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"split_with_redirect\":false,\"provider_id\":2780},\"sum_real\":{\"amount\":1000,\"currency\":\"KRW\"},\"rrn\":\"\",\"company\":{\"id\":1,\"title\":\"QA Company\"},\"general\":{\"project_id\":3899,\"payment_id\":\"EP8adf-6913\",\"signature\":\"ht8GuFN3NiCAZ1BgR9ZEQCI1B95dOhAz80xhn6T\\/Givv5qiTB1FVz6kHznwD9lZNSUw1LiZXL3E0YAeqSpSt8g==\"},\"description\":\"\",\"operations\":[{\"id\":91,\"type\":\"sale\",\"status\":\"success\",\"date\":\"2022-04-13T08:56:23+0000\",\"processing_time\":null,\"request_id\":\"2f5645b79dbe582cd524379654467cc7b034f3e3-495659ce9f36c71cd3740aca7cfce90f4eed88a3-00000001\",\"sum\":{\"amount\":1000,\"currency\":\"KRW\"},\"code\":\"9999\",\"message\":\"Awaiting processing\",\"provider\":{\"id\":2780}}]}',0),(24,20,'{\"request_id\":\"{{REQUEST_ID}}\",\"transaction\":{\"id\":5020745010150252,\"date\":\"2022-07-18T13:42:50+0000\",\"type\":\"purchase\"},\"payment\":{\"id\":\"TEST_PAYMENT_621498\",\"method\":\"Estonian Banks\",\"date\":\"2022-07-18T13:42:50+0000\",\"result_code\":\"29999\",\"result_message\":\"Awaiting processing\",\"status\":\"awaiting redirect result\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"cascading_with_redirect\":false,\"split_with_redirect\":false,\"need_confirm_retry\":false,\"method_id\":421,\"provider_id\":2301},\"sum_real\":{\"amount\":100,\"currency\":\"EUR\"},\"customer\":{\"id\":\"1\"},\"return_url\":{\"method\":\"POST\",\"body\":{\"widget_url\":\"{{NEOFINANCE_JS_RESOURCE}}\",\"widget_host\":\"http:\\/\\/localhost:8082\",\"token\":\"token\",\"other\":\"off\",\"callback_url\":\"{{APS_URL}}\",\"creditor\":\"LHVBEE22\",\"default_country\":\"EE\"},\"encrypted\":[],\"url\":\"{{APS_WIDGET_URL}}\",\"mode\":2},\"rrn\":\"\",\"sum_request\":{\"amount\":100,\"currency\":\"EUR\"},\"general\":{\"project_id\":51871,\"payment_id\":\"TEST_PAYMENT_621498\",\"signature\":\"x5N\\/oY0DduBswLh9z7MyWGddToV\\/m1qnIWwxGAfNKVTwvcySiSU7j0Z7BGYEVPhXeTbL6EXUjuqjCV+ODiJUkA==\"},\"description\":\"TEST_PAYMENT_621498\",\"operations\":[{\"id\":5020745010189782,\"type\":\"sale\",\"status\":\"awaiting redirect result\",\"date\":\"2022-07-18T13:42:50+0000\",\"processing_time\":null,\"request_id\":\"{{REQUEST_ID}}\",\"sum\":{\"amount\":100,\"currency\":\"EUR\"},\"code\":\"29999\",\"message\":\"Awaiting processing\",\"provider\":{\"id\":2301}}],\"status\":\"awaiting redirect result\",\"received_at\":1658151770.631434}',0),(35,20,'{\"sum_request\":{\"amount\":4000,\"currency\":\"RUB\"},\"request_id\":\"{{REQUEST_ID}}\",\"transaction\":{\"id\":35,\"date\":\"2022-03-13T17:07:48+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"card\",\"date\":\"2022-03-13T17:07:48+0000\",\"result_code\":\"0\",\"result_message\":\"Success\",\"status\":\"success\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EP9cc8-d305\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"actual_amount\":4000,\"remaining_refund\":4000,\"split_with_redirect\":false,\"provider_id\":3},\"sum_real\":{\"amount\":4000,\"currency\":\"RUB\"},\"account\":{\"number\":\"424242******4242\",\"type\":\"visa\",\"card_holder\":\"KO PO\",\"expiry_month\":\"10\",\"expiry_year\":\"2022\"},\"rrn\":\"000047769105\",\"AuthCode\":\"563253\",\"company\":{\"id\":1,\"title\":\"QA Company\"},\"general\":{\"project_id\":402,\"payment_id\":\"EP9cc8-d305\",\"signature\":\"bDSvqnpC5IXT5WH9UsaTPNSZk8oE1I8Ozfz5PR\\/Lg\\/EfloEpFf3l5QCKBpb5HcfOJBijzokvPhNlTjoeHD7TFw==\"},\"description\":\"\",\"operations\":[{\"id\":35,\"type\":\"sale\",\"status\":\"success\",\"date\":\"2022-03-13T17:07:49+0000\",\"processing_time\":\"2022-03-13T17:07:48+0000\",\"request_id\":\"{{REQUEST_ID}}\",\"sum\":{\"amount\":4000,\"currency\":\"RUB\"},\"code\":\"0\",\"message\":\"Success\",\"provider\":{\"id\":3,\"payment_id\":\"16471912682712\"}}],\"return_url\":\"http:\\/\\/pp.terminal.test\\/process\\/complete-redirect\\/0ve40f96ssi35bvuln3irp5775\\/49fb2ae0c4d52bfb\"}',1),(36,22,'{\"sum_request\":{\"amount\":11000,\"currency\":\"USD\"},\"request_id\":\"{{REQUEST_ID}}\",\"transaction\":{\"id\":100,\"date\":\"2022-07-27T08:28:15+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"card\",\"date\":\"2022-07-27T08:28:15+0000\",\"result_code\":\"9999\",\"result_message\":\"Awaiting processing\",\"status\":\"awaiting 3ds result\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EPf826-de8c\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"split_with_redirect\":false,\"provider_id\":402},\"sum_real\":{\"amount\":11000,\"currency\":\"USD\"},\"account\":{\"number\":\"424242******4242\",\"type\":\"visa\",\"card_holder\":\"TEST TESTOV\",\"expiry_month\":\"07\",\"expiry_year\":\"2024\"},\"rrn\":\"\",\"threeds2\":{\"iframe\":{\"url\":\"{{ACS_IFRAME_URL}}\",\"params\":{\"3DSMethodData\":\"16589104951172\",\"threeDSMethodData\":\"16589104951172\"}}},\"mpi_result\":{\"mpi_operation_id\":\"\",\"ds_operation_id\":\"\",\"acs_operation_id\":\"\",\"mpi_timestamp\":\"\",\"cardholder_info\":\"\",\"authentication_flow\":\"01\"},\"company\":{\"id\":1,\"title\":\"QA Company\"},\"general\":{\"project_id\":2401,\"payment_id\":\"EPf826-de8c\",\"signature\":\"8mAAabyQGOi+xRDcHSwyiB57tjSTq3Fko+PP3YelmXSYhRfEOSPkabvGBffPzyPWrmpZ6HcbVuGhFfp9LcUhlA==\"},\"description\":\"\",\"operations\":[{\"id\":106,\"type\":\"sale\",\"status\":\"awaiting 3ds result\",\"date\":\"2022-07-27T08:28:15+0000\",\"processing_time\":null,\"request_id\":\"{{REQUEST_ID}}\",\"sum\":{\"amount\":11000,\"currency\":\"USD\"},\"code\":\"9999\",\"message\":\"Awaiting processing\",\"provider\":{\"id\":402}}],\"status\":\"awaiting 3ds result\",\"received_at\":1658910497.512741}',0),(37,22,'{\"sum_request\":{\"amount\":11000,\"currency\":\"USD\"},\"request_id\":\"{{REQUEST_ID}}\",\"transaction\":{\"id\":100,\"date\":\"2022-07-27T08:28:15+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"card\",\"date\":\"2022-07-27T08:28:15+0000\",\"result_code\":\"9999\",\"result_message\":\"Awaiting processing\",\"status\":\"awaiting 3ds result\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EPf826-de8c\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"split_with_redirect\":false,\"provider_id\":402},\"sum_real\":{\"amount\":11000,\"currency\":\"USD\"},\"account\":{\"number\":\"424242******4242\",\"type\":\"visa\",\"card_holder\":\"TEST TESTOV\",\"expiry_month\":\"07\",\"expiry_year\":\"2024\"},\"rrn\":\"\",\"threeds2\":{\"redirect\":{\"url\":\"{{ACS_REDIRECT_URL}}\",\"params\":{\"creq\":\"ewogICAiYWNzVHJhbnNJRCIgOiAiMDAwMDAwMDAtMDAwNS01YTVhLTgwMDAtMDE2ZDg3YjVmNzllIiwKICAgImNoYWxsZW5nZVdpbmRvd1NpemUiIDogIjAzIiwKICAgIm1lc3NhZ2VUeXBlIiA6ICJDUmVxIiwKICAgIm1lc3NhZ2VWZXJzaW9uIiA6ICIyLjEuMCIsCiAgICJ0aHJlZURTU2VydmVyVHJhbnNJRCIgOiAiNGNiODhjNjEtNzZlNy01MThhLTgwMDAtMDAwMDAwMDAxMDE2Igp9\",\"threeDSSessionData\":\"106\"}}},\"mpi_result\":{\"mpi_operation_id\":\"4cb88c61-76e7-518a-8000-000000001016\",\"ds_operation_id\":\"30632cd6-4f97-5341-8000-00000007a990\",\"acs_operation_id\":\"00000000-0005-5a5a-8000-016d87b5f79e\",\"mpi_timestamp\":\"\",\"cardholder_info\":\"\",\"authentication_flow\":\"02\"},\"company\":{\"id\":1,\"title\":\"QA Company\"},\"general\":{\"project_id\":2401,\"payment_id\":\"EPf826-de8c\",\"signature\":\"dy3j1jspsYX4pQGXfEP0V6ZBItfZpApkacYYLYDcwt4ogqf0jlP74RwihkJQjMW\\/p562jGME8P\\/K5BSxZxSYqw==\"},\"description\":\"\",\"operations\":[{\"id\":106,\"type\":\"sale\",\"status\":\"awaiting 3ds result\",\"date\":\"2022-07-27T08:28:25+0000\",\"processing_time\":null,\"request_id\":\"{{REQUEST_ID}}\",\"sum\":{\"amount\":11000,\"currency\":\"USD\"},\"code\":\"9999\",\"message\":\"Awaiting processing\",\"provider\":{\"id\":402}}],\"status\":\"awaiting 3ds result\",\"received_at\":1658910506.620571,\"redirect\":{\"url\":\"{{ACS_REDIRECT_URL}}\",\"params\":{\"creq\":\"ewogICAiYWNzVHJhbnNJRCIgOiAiMDAwMDAwMDAtMDAwNS01YTVhLTgwMDAtMDE2ZDg3YjVmNzllIiwKICAgImNoYWxsZW5nZVdpbmRvd1NpemUiIDogIjAzIiwKICAgIm1lc3NhZ2VUeXBlIiA6ICJDUmVxIiwKICAgIm1lc3NhZ2VWZXJzaW9uIiA6ICIyLjEuMCIsCiAgICJ0aHJlZURTU2VydmVyVHJhbnNJRCIgOiAiNGNiODhjNjEtNzZlNy01MThhLTgwMDAtMDAwMDAwMDAxMDE2Igp9\",\"threeDSSessionData\":\"106\"},\"mode\":0}}',1),(38,22,'{\"sum_request\":{\"amount\":11000,\"currency\":\"USD\"},\"request_id\":\"{{REQUEST_ID}}\",\"transaction\":{\"id\":100,\"date\":\"2022-07-27T08:29:02+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"card\",\"date\":\"2022-07-27T08:29:02+0000\",\"result_code\":\"0\",\"result_message\":\"Success\",\"status\":\"success\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EPf826-de8c\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"actual_amount\":11000,\"remaining_refund\":11000,\"split_with_redirect\":false,\"provider_id\":402},\"sum_real\":{\"amount\":11000,\"currency\":\"USD\"},\"account\":{\"number\":\"424242******4242\",\"type\":\"visa\",\"card_holder\":\"TEST TESTOV\",\"expiry_month\":\"07\",\"expiry_year\":\"2024\"},\"avs_result\":\"X\",\"rrn\":\"002028454453\",\"AuthCode\":\"HOSTOK\",\"mpi_result\":{\"mpi_operation_id\":\"a27e7bd8-0761-5aef-8000-0000000009dc\",\"ds_operation_id\":\"a0dc40c1-72e1-571b-8000-000000077acf\",\"acs_operation_id\":\"a02aff79-8f50-40b4-88e9-38101c74c997\",\"mpi_timestamp\":202207270828,\"cardholder_info\":\"\",\"authentication_flow\":\"02\"},\"company\":{\"id\":1,\"title\":\"QA Company\"},\"general\":{\"project_id\":2401,\"payment_id\":\"EPf826-de8c\",\"signature\":\"FIcuqIg80GhXFqwFUzgO4vBfAcpQPLz6kCP1de2T69l1qis3qhSuuNw5Gwys7RGR\\/sK1ZrFfEb6u6uMCW5kO1w==\"},\"description\":\"\",\"operations\":[{\"id\":106,\"type\":\"sale\",\"status\":\"success\",\"date\":\"2022-07-27T08:29:02+0000\",\"processing_time\":\"2022-07-27T08:29:01+0000\",\"request_id\":\"{{REQUEST_ID}}\",\"sum\":{\"amount\":11000,\"currency\":\"USD\"},\"code\":\"0\",\"message\":\"Success\",\"provider\":{\"id\":402,\"payment_id\":\"16589105411179\"}}],\"return_url\":\"http:\\/\\/pp.terminal.test\\/process\\/complete-redirect\\/hrpirh4fsthkcf7e0dbdih2rcc\\/b7a7ba0a51755c1f\",\"status\":\"success\",\"received_at\":1658910546.686789}',2);
/*!40000 ALTER TABLE `callback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stub`
--

DROP TABLE IF EXISTS `stub`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stub` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(191) NOT NULL,
  `route_id` int NOT NULL,
  `description` text NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `stub_index_route_id_62f65cd9d6a67` (`route_id`),
  CONSTRAINT `stub_foreign_route_id_62f65cd9d6a9d` FOREIGN KEY (`route_id`) REFERENCES `route` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stub`
--

LOCK TABLES `stub` WRITE;
/*!40000 ALTER TABLE `stub` DISABLE KEYS */;
INSERT INTO `stub` VALUES (1,'3ds1.0 success',1,'',0),(2,'Base decline',1,'',0),(11,'Base success',1,'',1),(15,'Base success',2,'',1),(17,'Clarification success',1,'',0),(18,'Base success',22,'',1),(19,'Base success',23,'(without action complete at now)',1),(20,'Neofinance success',26,'',1),(22,'3ds2.0 Challenge success',1,'',0);
/*!40000 ALTER TABLE `stub` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resource`
--

DROP TABLE IF EXISTS `resource`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `resource` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content_type` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `path` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `resource_index_alias_62fb57edaaf24` (`alias`),
  UNIQUE KEY `resource_index_path_62fb57edaaf3a` (`path`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource`
--

LOCK TABLES `resource` WRITE;
/*!40000 ALTER TABLE `resource` DISABLE KEYS */;
INSERT INTO `resource` VALUES (1,'application/javascript','let NEOWidget={initialize:function(a,b,c){window.location.replace(c.callback_url)},serialize:function(a){let c=[];for(let b in a)a.hasOwnProperty(b)&&c.push(encodeURIComponent(b)+\"=\"+encodeURIComponent(a[b]));return c.join(\"&\")}}','/neofinance.js','NEOFINANCE_JS','Description'),(7,'application/json','[{\"id\":888,\"abbr\":\"SEB\",\"name\":\"SEB bank\",\"nativeName\":\"AS SEB Pank\",\"currencies\":[{\"id\":978,\"alpha_3_4217\":\"EUR\",\"number_3_4217\":\"978\",\"exponent\":2}]},{\"id\":889,\"abbr\":\"SWEDBANK\",\"name\":\"Swedbank\",\"nativeName\":\"Swedbank AS\",\"currencies\":[{\"id\":978,\"alpha_3_4217\":\"EUR\",\"number_3_4217\":\"978\",\"exponent\":2}]},{\"id\":890,\"abbr\":\"LHV\",\"name\":\"LHV bank\",\"nativeName\":\"LHV pank\",\"currencies\":[{\"id\":978,\"alpha_3_4217\":\"EUR\",\"number_3_4217\":\"978\",\"exponent\":2}]},{\"id\":1229,\"abbr\":\"LUMINOR\",\"name\":\"Luminor\",\"nativeName\":\"Luminor\",\"currencies\":[{\"id\":978,\"alpha_3_4217\":\"EUR\",\"number_3_4217\":\"978\",\"exponent\":2}]},{\"id\":1230,\"abbr\":\"CITADELE\",\"name\":\"Citadele\",\"nativeName\":\"Citadele\",\"currencies\":[{\"id\":978,\"alpha_3_4217\":\"EUR\",\"number_3_4217\":\"978\",\"exponent\":2}]},{\"id\":2867,\"abbr\":\"REVOLUT\",\"name\":\"Revolut\",\"nativeName\":\"Revolut\",\"currencies\":[{\"id\":978,\"alpha_3_4217\":\"EUR\",\"number_3_4217\":\"978\",\"exponent\":2}]},{\"id\":2913,\"abbr\":\"COOP\",\"name\":\"COOP\",\"nativeName\":\"COOP\",\"currencies\":[{\"id\":978,\"alpha_3_4217\":\"EUR\",\"number_3_4217\":\"978\",\"exponent\":2}]},{\"id\":35541,\"abbr\":\"PAYSERA\",\"name\":\"Paysera\",\"nativeName\":\"Paysera\",\"currencies\":[{\"id\":978,\"alpha_3_4217\":\"EUR\",\"number_3_4217\":\"978\",\"exponent\":2}]}]','/v2/info/banks/estonia/sale/list','ESTONIA_BANKS_LIST','Banks list for Estonia');
/*!40000 ALTER TABLE `resource` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-08-22  9:52:08
