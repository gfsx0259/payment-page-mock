-- MySQL dump 10.13  Distrib 8.0.28, for Linux (x86_64)
--
-- Host: localhost    Database: app
-- ------------------------------------------------------
-- Server version	8.0.28

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `route`
--

LOCK TABLES `route` WRITE;
/*!40000 ALTER TABLE `route` DISABLE KEYS */;
INSERT INTO `route` VALUES (1,'card/sale','Card integration','card.svg'),(2,'wallet/kakaopay/sale','QR code integration','kakaopay.svg');
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
  PRIMARY KEY (`id`),
  KEY `callback_index_stub_id_6229ddc8962af` (`stub_id`),
  CONSTRAINT `callback_foreign_stub_id_6229ddc8962e9` FOREIGN KEY (`stub_id`) REFERENCES `stub` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `callback`
--

LOCK TABLES `callback` WRITE;
/*!40000 ALTER TABLE `callback` DISABLE KEYS */;
INSERT INTO `callback` VALUES (1,1,'{\"acs\":{\"pa_req\":\"112442583\",\"acs_url\":\"{{ACS_URL}}\",\"md\":\"eyJwdXJjaGFzZV9vcGVyYXRpb25faWQiOjUzLCJwcm9qZWN0X2lkIjo0MDIsInBheW1lbnRfaWQiOiJFUDU4ZjQtODdhNSIsInBsdXNfbWQiOiIifQ==\",\"term_url\":\"{{TERM_URL}}\"},\"sum_request\":{\"amount\":100056,\"currency\":\"RUB\"},\"request_id\":\"dbf1a3922c3d5565be5794d7d56a12e627e2b5ba-8c01825b9f349270e3dd91acd26976c6941b324a-00000001\",\"transaction\":{\"id\":35,\"date\":\"2022-03-13T17:07:48+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"card\",\"date\":\"2022-03-13T17:07:48+0000\",\"result_code\":\"0\",\"result_message\":\"Success\",\"status\":\"awaiting 3ds result\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EP9cc8-d305\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"actual_amount\":1000,\"remaining_refund\":1000,\"split_with_redirect\":false,\"provider_id\":3},\"sum_real\":{\"amount\":1000,\"currency\":\"RUB\"},\"account\":{\"number\":\"424242******4242\",\"type\":\"visa\",\"card_holder\":\"KO PO\",\"expiry_month\":\"10\",\"expiry_year\":\"2022\"},\"rrn\":\"000047769105\",\"AuthCode\":\"563253\",\"company\":{\"id\":1,\"title\":\"QA Company\"},\"general\":{\"project_id\":402,\"payment_id\":\"EP9cc8-d305\",\"signature\":\"bDSvqnpC5IXT5WH9UsaTPNSZk8oE1I8Ozfz5PR\\/Lg\\/EfloEpFf3l5QCKBpb5HcfOJBijzokvPhNlTjoeHD7TFw==\"},\"description\":\"\",\"operations\":[{\"id\":35,\"type\":\"sale\",\"status\":\"processing\",\"date\":\"2022-03-13T17:07:49+0000\",\"processing_time\":\"2022-03-13T17:07:48+0000\",\"request_id\":\"dbf1a3922c3d5565be5794d7d56a12e627e2b5ba-8c01825b9f349270e3dd91acd26976c6941b324a-00000001\",\"sum\":{\"amount\":1000,\"currency\":\"RUB\"},\"code\":\"0\",\"message\":\"Success\",\"provider\":{\"id\":3,\"payment_id\":\"16471912682712\"}}],\"return_url\":\"http:\\/\\/pp.terminal.test\\/process\\/complete-redirect\\/0ve40f96ssi35bvuln3irp5775\\/49fb2ae0c4d52bfb\"}'),(2,1,'{\"sum_request\":{\"amount\":5000,\"currency\":\"RUB\"},\"request_id\":\"dbf1a3922c3d5565be5794d7d56a12e627e2b5ba-8c01825b9f349270e3dd91acd26976c6941b324a-00000001\",\"transaction\":{\"id\":35,\"date\":\"2022-03-13T17:07:48+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"card\",\"date\":\"2022-03-13T17:07:48+0000\",\"result_code\":\"0\",\"result_message\":\"Success\",\"status\":\"success\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EP9cc8-d305\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"actual_amount\":5000,\"remaining_refund\":5000,\"split_with_redirect\":false,\"provider_id\":3},\"sum_real\":{\"amount\":5000,\"currency\":\"RUB\"},\"account\":{\"number\":\"424242******4242\",\"type\":\"visa\",\"card_holder\":\"KO PO\",\"expiry_month\":\"10\",\"expiry_year\":\"2022\"},\"rrn\":\"000047769105\",\"AuthCode\":\"563253\",\"company\":{\"id\":1,\"title\":\"QA Company\"},\"general\":{\"project_id\":402,\"payment_id\":\"EP9cc8-d305\",\"signature\":\"bDSvqnpC5IXT5WH9UsaTPNSZk8oE1I8Ozfz5PR\\/Lg\\/EfloEpFf3l5QCKBpb5HcfOJBijzokvPhNlTjoeHD7TFw==\"},\"description\":\"\",\"operations\":[{\"id\":35,\"type\":\"sale\",\"status\":\"success\",\"date\":\"2022-03-13T17:07:49+0000\",\"processing_time\":\"2022-03-13T17:07:48+0000\",\"request_id\":\"dbf1a3922c3d5565be5794d7d56a12e627e2b5ba-8c01825b9f349270e3dd91acd26976c6941b324a-00000001\",\"sum\":{\"amount\":5000,\"currency\":\"RUB\"},\"code\":\"0\",\"message\":\"Success\",\"provider\":{\"id\":3,\"payment_id\":\"16471912682712\"}}],\"return_url\":\"http:\\/\\/pp.terminal.test\\/process\\/complete-redirect\\/0ve40f96ssi35bvuln3irp5775\\/49fb2ae0c4d52bfb\"}'),(5,15,'{\"sum_request\":{\"amount\":1000,\"currency\":\"KRW\"},\"request_id\":\"2f5645b79dbe582cd524379654467cc7b034f3e3-495659ce9f36c71cd3740aca7cfce90f4eed88a3-00000001\",\"transaction\":{\"id\":91,\"date\":\"2022-04-13T08:56:24+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"kakaopay\",\"date\":\"2022-04-13T08:56:24+0000\",\"result_code\":\"9999\",\"result_message\":\"Awaiting processing\",\"status\":\"awaiting customer action\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EP8adf-6913\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"split_with_redirect\":false,\"provider_id\":2780},\"sum_real\":{\"amount\":1000,\"currency\":\"KRW\"},\"rrn\":\"\",\"display_data\":[{\"type\":\"qr_img\",\"title\":\"QR code\",\"data\":\"data:image\\/png;base64,iVBORw0KGgoAAAANSUhEUgAAAW0AAAFtCAIAAABDY6x1AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAMoElEQVR4nO3dQW4cOwwE0Pgj979y\\/l4LAUKRlNp4b+uZ7p6xUxAYivr59+\\/fH4DAf7cfAPg8OQKk5AiQkiNASo4AKTkCpOQIkJIjQEqOACk5AqTkCJCSI0BKjgApOQKk5AiQkiNASo4AKTkCpOQIkPqbvPnn56fqOfb2Q2SXx1hevH\\/Ioxcn7z36CMl9+26USB6y8He0d\\/SQib5fWSL5vNYjQEqOACk5AqTkCJCK6qyLvrLc0U8XhU91dKnfV+5NCn6F30ZSOt3fqO+3cHSj\\/Qcc+1d2xHoESMkRICVHgJQcAVKVddZFXzV0rNSUFN72l0oc1fCSSxU2oe4d3bevffmRb\\/LIrf9zWFiPACk5AqTkCJCSI0Cqsc7ap7Bls+\\/FSQGsr+u0sLFyf+XkdzQ2KGAx9vHHBhSMsR4BUnIESMkRICVHgNQn66yFO8cTY4NC95fq21Z\\/q8CZKCwzF1ZD+1qBH2E9AqTkCJCSI0BKjgCpn1v9f8mVCyuLY+XPvVtfXfIYt\\/bCF44R2Os7b+zN79k5WMBNcgRIyREgJUeAVGU\\/69jB6HtjVdi+qaK3frro+yY\\/8T0fGfueH\\/lXtrAeAVJyBEjJESAlR4BU1M\\/6C\\/QV7QqfalHYovpIJXV\\/5cXYHvxbxe8vsh4BUnIESMkRICVHgFTl3IBEYWfh0ZWTol1fNfRWsbDPI3vwj668V\\/jMfXMSxuq71iNASo4AKTkCpOQIkIrmBvQduXSreNa3v7uvoLt39E2O1aQLn2r\\/GPtLHRkbMpA8xq2yq\\/UIkJIjQEqOACk5AqSunYPV10n5SIvq0VMtPnHAWPLxv3g81ViVvdDYRALrESAlR4CUHAFScgRIzc0NGDv4PnmMW99GcuWxauitbtdbIxeOFH6E\\/ZWP3jvGegRIyREgJUeAlBwBUnP9rI9sQt\\/faPFIAezNY7H66sqFN7pVwb01U7bvfzP2rEeAlBwBUnIESMkRIBXVWc\\/uNNVoeGvW6dju77FW4FsF7KMrjx0SNtZjnVz51ngK6xEgJUeAlBwBUnIESL3Szzp2PvvRiwsHsj7S\\/Hp037FvY+y7erPZd0zff25YjwApOQKk5AiQkiNAqrKf9YuFt8WtqbF7j\\/RZFt53rEhZWDrduzVFoW+k7hHrESAlR4CUHAFScgRI\\/U3e\\/InCauFD3qr\\/Hdl\\/sWP3XTwyRHb\\/bfTNlNjr+zb2VzY3AHiIHAFScgRIyREgNTefdb3xpb3h+xvdGiJbqO\\/wqrF+1v17925Nfh2r0Y59G0esR4CUHAFScgRIyREg1VhnvTXrNLlUYe2wb3ht4Un3t6586yyrPn1\\/OX2PUch6BEjJESAlR4CUHAFSlXMDjmo8fWesj+2VHmu6TS7VV3csLKwmzc1HPx3rok7qyreqzuYGADfJESAlR4CUHAFSjedg9VXa+i61N9axur\\/vkcKHvHXfwp3yt3b39zUKH+nrdrUeAVJyBEjJESAlR4DUXJ11\\/+LF2Dbz\\/X33771VKt77xFSBvUeGyCY36puiOjZC+Ij1CJCSI0BKjgApOQKkojprYc3yyNgo0L6i7CMKOyk\\/0XY5Vjl+5NyvsT9C6xEgJUeAlBwBUnIESEXzWW\\/t0S5sJUxqh30zVvvaeffGOnQLv9hb31Xfn9n+p8n44b4vx3oESMkRICVHgJQcAVLX5gbs37t4ZALrkcJS8SNzUvcvPvKJv7ojhd\\/V2KUKWY8AKTkCpOQIkJIjQCrqZ90rLCWOdUMe\\/XRv\\/8y3xrX2VRaTj3DrsK4jj9TgE33HrVmPACk5AqTkCJCSI0Cqss7a13V6VAFK2gELS1xHZci+Dft9xnb3F04kGKt233qqW38b1iNASo4AKTkCpOQIkIrqrH3nYI1VYfuKWH2Vtr7iWV+lvO\\/bKDRWWC30SNnVegRIyREgJUeAlBwBUo3nYC2Svf9jJz8d\\/XTRV0tL9J1lldx3\\/xhHL\\/7EaWRje\\/+TS5kbANwkR4CUHAFScgRINfazHr23r2TbtyV\\/bKrAkbEt+X0K\\/66OXlw43ODIUbG\\/7xC4hPUIkJIjQEqOACk5AqR+Ckt6e2MHMi3GZp32dY72lV0f2YPf9+X0jacYq8Imxkrj1iNASo4AKTkCpOQIkKqcG9DX0rfYDxk40jdVdG+s7No36bbw131rL\\/ytNuKx6v7Ri80NAG6SI0BKjgApOQKkojrrorB49mbV6tZRT4WdlIWHVy2S3\\/5YifroUkePcfTiwuEGRzfqK29bjwApOQKk5AiQkiNAqrLOWtgdOLbfea\\/wMfrOlHqklFh4qVvzd\\/cvTtxq9R4bE2E9AqTkCJCSI0BKjgCpufmst\\/S1e45N99x7ZFBoX0H3zWm1hc98a1ZxYSHZegRIyREgJUeAlBwBUpXzWW9JNr\\/fOsy9sPA29lsYa47smzl6tOn+6EaFExiO9I2nOGI9AqTkCJCSI0BKjgCpqJ91vVbbdu\\/FWJGysEV1rNv1kbbavb5PdPTeI2M9x8mlxgYULKxHgJQcAVJyBEjJESBVOTegr7Hy1njL\\/aVuVRYLb7S\\/79hQ1aMr7\\/UVvxNjEzbMDQC+So4AKTkCpOQIkGqcz3rr6PPkvn2dsoU3Kix\\/Ht336DH6yq5HN9q\\/eHGrSPnItIqE9QiQkiNASo4AKTkCpCrnBqyX\\/v6m+76S7dFjLAqbMvu+qyOfuNTi1mTfoyuPVY6tR4CUHAFScgRIyREg1TifdfFmzTLxiVLxXmEd7oungo3VO\\/cvXvR1MyeX2rMeAVJyBEjJESAlR4DUXJ110VdYLfTI5vexQuMjRffCFyduTZxYjNXC9bMCN8kRICVHgJQcAVKNcwOO3DoX\\/latdGyI7CfOsnpkMGphkbLv\\/K03\\/0fCegRIyREgJUeAlBwBUn\\/7Lj1WakoeI3nv\\/jGO7ps0sPaVPwvLrn1PtTdWOE+euXB6q\\/mswFfJESAlR4CUHAFSjXXWvqbMR85J2kuu3LdVvLDcO3a205hb8xn66tnmswKfIUeAlBwBUnIESEV11r7tz7dqh0fv7Tu96da80rGCX9IZfHSj\\/Yv7SsWFxob1JqxHgJQcAVJyBEjJESBV2c86Vizsm6OZGBsysOibR9tXdyz8vLd2yhf+xe6vnNSGx7q3rUeAlBwBUnIESMkRINV4DlbhGetjh6ontdJE4Y3GjgErPBfq6MqFNyr0yDTioysXsh4BUnIESMkRICVHgFRlP2vhrvM3j5g6MrbpfjE2RuCLZ5XdGiKxv9SisEPXfFbgM+QIkJIjQEqOAKnK+axjTZn7o95vlZoWY62xyQcsPJDp1uiDQrdK8mP\\/jo7+4RyxHgFScgRIyREgJUeAVDQ34JEd+m9uUe\\/bVp8YO2HrVivwXl\\/z660BBbceY2E9AqTkCJCSI0BKjgCpR8\\/ButXgWLihe2xbfeEB9H0DCsamRhQ+VWE\\/65sFXf2swEPkCJCSI0BKjgCpynOwxtof+4566uvCPHrxrSbjoyvfGhNbeKlHKtZ7hS3I+\\/cmrEeAlBwBUnIESMkRIFVZZx3Tt\\/m9r622r5Nyf6O9vhre3punVY19G2\\/+54Z+VuAmOQKk5AiQkiNAqnJuwGKsD2\\/svYux3d9jW8X7OpLHjtTaG\\/uAR49x6+PrZwUeIkeAlBwBUnIESFWegzXWPLd3q1iYvPjovX1tpkfGNuyPDTe9da7b2CyLPtYjQEqOACk5AqTkCJC6Np91bKt44tZm\\/7HpnmP6ipT7G42VP8dq8Im+sqv1CJCSI0BKjgApOQKkzGd98fCqsfOZjt6bXKqw9XnsUn2PsTd2zJu5AcBD5AiQkiNASo4AqWg+65t9eI+MTT2qaSUVr+SZ999G8hGO\\/jbeLKzur7xXWDgv\\/Pj6WYF3yREgJUeAlBwBUpXnYH1iBMHYLMxbnYWFVy58762ZEn0nTi3vTSrWhbX\\/vb4bWY8AKTkCpOQIkJIjQKrxHKxHxmreOrx+cauS+on5rEfGzpT6fUNz9bMC75IjQEqOACk5AqQq+1kfMdbv+Eilra9JcWz2Z9+3sf+V9TWhJvoass1nBd4lR4CUHAFScgRI\\/YY661gf7aJwT\\/rY4VWFV\\/7EEVNJ2bVvHu1Yc\\/NY46z1CJCSI0BKjgApOQKkGuusfZuUj3yiSrdXWDz7RGF17xPTWwsbZ5Ny71jZ1XoESMkRICVHgJQcAVKV81n73OrS6zN2SlZfn+WbZzuNNSgv+k7Y2t\\/oEdYjQEqOACk5AqTkCJCK6qwAf6xHgJwcAVJyBEjJESAlR4CUHAFScgRIyREgJUeAlBwBUnIESMkRICVHgJQcAVJyBEjJESAlR4CUHAFScgRI\\/Q+edJ8Ttp4C7gAAAABJRU5ErkJggg==\"}],\"company\":{\"id\":1,\"title\":\"QA Company\"},\"general\":{\"project_id\":3899,\"payment_id\":\"EP8adf-6913\",\"signature\":\"ht8GuFN3NiCAZ1BgR9ZEQCI1B95dOhAz80xhn6T\\/Givv5qiTB1FVz6kHznwD9lZNSUw1LiZXL3E0YAeqSpSt8g==\"},\"description\":\"\",\"operations\":[{\"id\":91,\"type\":\"sale\",\"status\":\"awaiting customer action\",\"date\":\"2022-04-13T08:56:23+0000\",\"processing_time\":null,\"request_id\":\"2f5645b79dbe582cd524379654467cc7b034f3e3-495659ce9f36c71cd3740aca7cfce90f4eed88a3-00000001\",\"sum\":{\"amount\":1000,\"currency\":\"KRW\"},\"code\":\"9999\",\"message\":\"Awaiting processing\",\"provider\":{\"id\":2780}}]}'),(7,15,'{\"sum_request\":{\"amount\":1000,\"currency\":\"KRW\"},\"request_id\":\"2f5645b79dbe582cd524379654467cc7b034f3e3-495659ce9f36c71cd3740aca7cfce90f4eed88a3-00000001\",\"transaction\":{\"id\":91,\"date\":\"2022-04-13T08:56:24+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"kakaopay\",\"date\":\"2022-04-13T08:56:24+0000\",\"result_code\":\"9999\",\"result_message\":\"Success\",\"status\":\"success\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EP8adf-6913\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"split_with_redirect\":false,\"provider_id\":2780},\"sum_real\":{\"amount\":1000,\"currency\":\"KRW\"},\"rrn\":\"\",\"company\":{\"id\":1,\"title\":\"QA Company\"},\"general\":{\"project_id\":3899,\"payment_id\":\"EP8adf-6913\",\"signature\":\"ht8GuFN3NiCAZ1BgR9ZEQCI1B95dOhAz80xhn6T\\/Givv5qiTB1FVz6kHznwD9lZNSUw1LiZXL3E0YAeqSpSt8g==\"},\"description\":\"\",\"operations\":[{\"id\":91,\"type\":\"sale\",\"status\":\"sucess\",\"date\":\"2022-04-13T08:56:23+0000\",\"processing_time\":null,\"request_id\":\"2f5645b79dbe582cd524379654467cc7b034f3e3-495659ce9f36c71cd3740aca7cfce90f4eed88a3-00000001\",\"sum\":{\"amount\":1000,\"currency\":\"KRW\"},\"code\":\"9999\",\"message\":\"Success\",\"provider\":{\"id\":2780}}]}'),(8,2,'{\"sum_request\":{\"amount\":3000,\"currency\":\"RUB\"},\"request_id\":\"dbf1a3922c3d5565be5794d7d56a12e627e2b5ba-8c01825b9f349270e3dd91acd26976c6941b324a-00000001\",\"transaction\":{\"id\":35,\"date\":\"2022-03-13T17:07:48+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"card\",\"date\":\"2022-03-13T17:07:48+0000\",\"result_code\":\"0\",\"result_message\":\"Decline\",\"status\":\"decline\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EP9cc8-d305\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"actual_amount\":3000,\"remaining_refund\":3000,\"split_with_redirect\":false,\"provider_id\":3},\"sum_real\":{\"amount\":3000,\"currency\":\"RUB\"},\"account\":{\"number\":\"424242******4242\",\"type\":\"visa\",\"card_holder\":\"KO PO\",\"expiry_month\":\"10\",\"expiry_year\":\"2022\"},\"rrn\":\"000047769105\",\"AuthCode\":\"563253\",\"company\":{\"id\":1,\"title\":\"QA Company\"},\"general\":{\"project_id\":402,\"payment_id\":\"EP9cc8-d305\",\"signature\":\"bDSvqnpC5IXT5WH9UsaTPNSZk8oE1I8Ozfz5PR\\/Lg\\/EfloEpFf3l5QCKBpb5HcfOJBijzokvPhNlTjoeHD7TFw==\"},\"description\":\"\",\"operations\":[{\"id\":35,\"type\":\"sale\",\"status\":\"decline\",\"date\":\"2022-03-13T17:07:49+0000\",\"processing_time\":\"2022-03-13T17:07:48+0000\",\"request_id\":\"dbf1a3922c3d5565be5794d7d56a12e627e2b5ba-8c01825b9f349270e3dd91acd26976c6941b324a-00000001\",\"sum\":{\"amount\":3000,\"currency\":\"RUB\"},\"code\":\"0\",\"message\":\"Decline\",\"provider\":{\"id\":3,\"payment_id\":\"16471912682712\"}}],\"return_url\":\"http:\\/\\/pp.terminal.test\\/process\\/complete-redirect\\/0ve40f96ssi35bvuln3irp5775\\/49fb2ae0c4d52bfb\"}'),(9,11,'{\"sum_request\":{\"amount\":4000,\"currency\":\"RUB\"},\"request_id\":\"dbf1a3922c3d5565be5794d7d56a12e627e2b5ba-8c01825b9f349270e3dd91acd26976c6941b324a-00000001\",\"transaction\":{\"id\":35,\"date\":\"2022-03-13T17:07:48+0000\",\"type\":\"purchase\"},\"payment\":{\"method\":\"card\",\"date\":\"2022-03-13T17:07:48+0000\",\"result_code\":\"0\",\"result_message\":\"Success\",\"status\":\"success\",\"is_new_attempts_available\":false,\"attempts_timeout\":0,\"id\":\"EP9cc8-d305\",\"cascading_with_redirect\":false,\"is_cascading\":false,\"actual_amount\":4000,\"remaining_refund\":4000,\"split_with_redirect\":false,\"provider_id\":3},\"sum_real\":{\"amount\":4000,\"currency\":\"RUB\"},\"account\":{\"number\":\"424242******4242\",\"type\":\"visa\",\"card_holder\":\"KO PO\",\"expiry_month\":\"10\",\"expiry_year\":\"2022\"},\"rrn\":\"000047769105\",\"AuthCode\":\"563253\",\"company\":{\"id\":1,\"title\":\"QA Company\"},\"general\":{\"project_id\":402,\"payment_id\":\"EP9cc8-d305\",\"signature\":\"bDSvqnpC5IXT5WH9UsaTPNSZk8oE1I8Ozfz5PR\\/Lg\\/EfloEpFf3l5QCKBpb5HcfOJBijzokvPhNlTjoeHD7TFw==\"},\"description\":\"\",\"operations\":[{\"id\":35,\"type\":\"sale\",\"status\":\"success\",\"date\":\"2022-03-13T17:07:49+0000\",\"processing_time\":\"2022-03-13T17:07:48+0000\",\"request_id\":\"dbf1a3922c3d5565be5794d7d56a12e627e2b5ba-8c01825b9f349270e3dd91acd26976c6941b324a-00000001\",\"sum\":{\"amount\":4000,\"currency\":\"RUB\"},\"code\":\"0\",\"message\":\"Success\",\"provider\":{\"id\":3,\"payment_id\":\"16471912682712\"}}],\"return_url\":\"http:\\/\\/pp.terminal.test\\/process\\/complete-redirect\\/0ve40f96ssi35bvuln3irp5775\\/49fb2ae0c4d52bfb\"}');
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stub`
--

LOCK TABLES `stub` WRITE;
/*!40000 ALTER TABLE `stub` DISABLE KEYS */;
INSERT INTO `stub` VALUES (1,'Redirect success',1,'3ds 1.0 flow'),(2,'Base decline',1,''),(11,'Base success',1,''),(15,'Base success',2,'');
/*!40000 ALTER TABLE `stub` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-04-23 12:31:59
