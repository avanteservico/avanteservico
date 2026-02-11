DROP TABLE IF EXISTS `expense_types`;

CREATE TABLE `expense_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `expense_types` VALUES("1","Diversos","2026-02-09 22:10:02");
INSERT INTO `expense_types` VALUES("2","Combustível","2026-02-09 22:28:59");
INSERT INTO `expense_types` VALUES("3","Instalação de Rufos","2026-02-10 22:33:34");
INSERT INTO `expense_types` VALUES("4","Areia","2026-02-10 22:35:54");



DROP TABLE IF EXISTS `materials`;

CREATE TABLE `materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT 1,
  `name` varchar(255) NOT NULL,
  `expense_type_id` int(11) DEFAULT 1,
  `amount` decimal(10,2) NOT NULL,
  `purchase_date` date NOT NULL,
  `is_paid` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `work_id` (`work_id`),
  KEY `fk_materials_expense_type` (`expense_type_id`),
  KEY `fk_materials_supplier` (`supplier_id`),
  CONSTRAINT `fk_materials_expense_type` FOREIGN KEY (`expense_type_id`) REFERENCES `expense_types` (`id`),
  CONSTRAINT `fk_materials_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  CONSTRAINT `fk_materials_work` FOREIGN KEY (`work_id`) REFERENCES `works` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `materials` VALUES("5","1","1","Construtora silva","1","63.00","2026-01-12","1","2026-02-09 22:24:26");
INSERT INTO `materials` VALUES("6","1","1","Diversos Materiais pagos","1","1312.00","2026-01-30","1","2026-02-09 22:25:26");
INSERT INTO `materials` VALUES("7","1","1","Forro - Construtora Silva","1","970.00","2026-02-04","1","2026-02-09 22:26:02");
INSERT INTO `materials` VALUES("8","1","2","Diversos Jerri","2","100.00","2025-12-16","1","2026-02-09 22:28:59");
INSERT INTO `materials` VALUES("9","1","3","Diversos Nei","1","80.00","2025-12-08","1","2026-02-09 22:30:12");
INSERT INTO `materials` VALUES("10","1","4","Instalação de Rufos","3","1750.00","2025-12-17","1","2026-02-10 22:33:34");
INSERT INTO `materials` VALUES("11","1","5","Caçamba de Areia","4","450.00","2025-12-17","1","2026-02-10 22:35:54");



DROP TABLE IF EXISTS `people`;

CREATE TABLE `people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  `service_type` enum('daily','contract','production') DEFAULT 'daily',
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `people` VALUES("1","Jerrie Sales de Souza","Jerrie","","Coordenador","","Gestão da Obra","2026-02-07 20:13:23");
INSERT INTO `people` VALUES("2","Aneilton Manoel da Cruz","Nei","","Coordenador","","Gestão de Obra","2026-02-07 20:15:41");
INSERT INTO `people` VALUES("3","Maciel dos Santos Silva","Ciel","","Ajudante de Pedreiro","","","2026-02-09 06:27:28");
INSERT INTO `people` VALUES("4","Ruan Pablo Santos Machado","Ruan","","Ajudante de Pedreiro","","","2026-02-09 06:28:45");
INSERT INTO `people` VALUES("5","Gustavo Pereira dos Santos","Gustavo","","Ajudante de Pedreiro","","","2026-02-09 06:29:59");
INSERT INTO `people` VALUES("6","Reginaldo Camilo dos Santos","Nego Regi","","Ajudante de Pedreiro","","","2026-02-09 06:30:56");
INSERT INTO `people` VALUES("7","Valdson Jeanmonod Luz","Dison","","Ajudante de Pedreiro","","","2026-02-09 06:32:01");
INSERT INTO `people` VALUES("8","Fabio Silva dos Santos","Fabio","","Ajudante de Pedreiro","","","2026-02-09 06:33:39");
INSERT INTO `people` VALUES("9","Marcelo Coelho de Oliveira","Marcelo","","Ajudante de Pedreiro","","","2026-02-09 06:39:49");
INSERT INTO `people` VALUES("10","José Ramon Conceição","Ramon Eletricista","","Instalador de Forro","","Instalação de Forro e Reboco de sala","2026-02-09 07:14:32");
INSERT INTO `people` VALUES("11","Eugenio Pacelli","Topa Tudo","","Aluguel de Máquinas","","Aluguel de Máquinas diversas para obras","2026-02-09 07:19:23");
INSERT INTO `people` VALUES("12","Rodrigo Souza Araujo","Rodrigo","","Ajudante de Pedreiro","","Reboco de Sala","2026-02-09 07:22:28");
INSERT INTO `people` VALUES("13","Reidinel Medeiros dos Santos","Natival","","Pedreiro","","","2026-02-09 07:23:30");
INSERT INTO `people` VALUES("14","Raique Silva dos Santos","Raique","","Prestador de serviço","","Definir o tipo de serviço que foi","2026-02-09 07:27:23");
INSERT INTO `people` VALUES("15","Arisvaldo Lopes Martins","Ari","","Pedreiro","","","2026-02-09 07:28:09");
INSERT INTO `people` VALUES("16","Alexsandro Bispo de Jesus","Alexsandro","","Ajudante de Pedreiro","","","2026-02-09 07:29:50");
INSERT INTO `people` VALUES("17","Leandro Rocha Oliveira","Leandro","","Ajudante de Pedreiro","","","2026-02-09 07:39:35");
INSERT INTO `people` VALUES("18","Roberio Leandro Cerqueira Avila","Roberio","","Prestador de serviço","","","2026-02-09 07:40:57");
INSERT INTO `people` VALUES("19","Geovane Lucio dos Santos","Geovane","","Prestador de serviço","","","2026-02-09 07:42:51");
INSERT INTO `people` VALUES("20","Ronivaldo Jesus dos Santos","Ronivaldo","","Ajudante de Pedreiro","","","2026-02-09 09:09:33");
INSERT INTO `people` VALUES("21","Erivelton de Jesus Alves","Erivelton Caboco","","Pedreiro","","","2026-02-09 09:10:13");
INSERT INTO `people` VALUES("22","Ednaldo Alves","Caboco","","Pedreiro","","Assentamento de cerâmica","2026-02-09 09:16:58");
INSERT INTO `people` VALUES("23","Ajudante Jerrie","","","Ajudante de Pedreiro","","pago na conta de jerrie","2026-02-09 09:20:30");
INSERT INTO `people` VALUES("24","Givaldo de Jesus","","","Prestador de serviço","","","2026-02-09 09:25:53");
INSERT INTO `people` VALUES("25","Davi Porto Farias","Davi","","Prestador de serviço","","","2026-02-09 09:29:32");
INSERT INTO `people` VALUES("26","Gedson Antunes Souza","Gedson","","Prestador de serviço","","analisar","2026-02-09 09:39:18");
INSERT INTO `people` VALUES("27","Gabriel Ronaldy da Silva Santana","gabriel","","Ajudante de Pedreiro","","","2026-02-09 09:43:30");
INSERT INTO `people` VALUES("28","Ailton Silva Costa","Vira Bicho","","Pedreiro","","","2026-02-09 09:50:09");
INSERT INTO `people` VALUES("29","Jocimar Nascimento Brandão","Jocimar","","Prestador de serviço","","","2026-02-09 09:54:40");
INSERT INTO `people` VALUES("30","Silvio Reis Novais de Sousa","Silvio","","Pedreiro","","","2026-02-09 10:08:37");
INSERT INTO `people` VALUES("31","Vinicius Santos de Jesus","Vinicius","","Ajudante de Pedreiro","","","2026-02-09 10:09:25");
INSERT INTO `people` VALUES("32","Perimetral acabamento - Diversos","Perimetral Acabamentos","","Prestador de serviço","","Diversos","2026-02-09 10:11:37");
INSERT INTO `people` VALUES("33","Outlet das Tintas - Diversos","Outlet das Tintas","","Prestador de serviço","","","2026-02-09 10:17:17");
INSERT INTO `people` VALUES("34","Riquelmy Jesus da Silva","Riquelmy","","Ajudante de Pedreiro","","","2026-02-09 10:18:47");
INSERT INTO `people` VALUES("35","Elenildo Pereira","","","Ajudante de Pedreiro","","","2026-02-09 10:22:39");
INSERT INTO `people` VALUES("36","Zé Carlos Material de Const","Zé Carlos","","Prestador de serviço","","","2026-02-09 10:27:02");
INSERT INTO `people` VALUES("37","Genivaldo de Jesus dos Santos","Genivaldo","","Prestador de serviço","","","2026-02-09 10:33:32");
INSERT INTO `people` VALUES("38","Lidemberg Pintor","Berg","","Pintor","","R$ 12,00 o metro quadrado = R$ 12.836,64 referente a 1.069,72 metros quadrados de telhado","2026-02-09 11:10:17");
INSERT INTO `people` VALUES("39","Duda Vidros","Duda Vidros","","Vidraceiro","","Instalação de portas de alumínio, fornecimento de soleiras e troca de janela de vidro lateral","2026-02-09 11:22:58");
INSERT INTO `people` VALUES("40","Diversos Materiais pagos","","","Prestador de serviço","","Diversos materiais pagos","2026-02-09 11:46:18");
INSERT INTO `people` VALUES("41","Senhor da Poda","","","Podador","","","2026-02-10 22:36:51");



DROP TABLE IF EXISTS `person_payments`;

CREATE TABLE `person_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `work_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_paid` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`),
  KEY `work_id` (`work_id`),
  CONSTRAINT `fk_person_payments_person` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_person_payments_work` FOREIGN KEY (`work_id`) REFERENCES `works` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `person_payments` VALUES("2","3","1","300.00","2025-12-05","pagamento","1","2026-02-09 06:28:18");
INSERT INTO `person_payments` VALUES("3","4","1","270.00","2025-12-05","pagamento","1","2026-02-09 06:29:21");
INSERT INTO `person_payments` VALUES("4","5","1","270.00","2025-12-05","pagamento","1","2026-02-09 06:30:25");
INSERT INTO `person_payments` VALUES("5","6","1","270.00","2025-12-05","pagamento","1","2026-02-09 06:31:19");
INSERT INTO `person_payments` VALUES("6","7","1","300.00","2025-12-05","pagamento","1","2026-02-09 06:32:18");
INSERT INTO `person_payments` VALUES("7","2","1","400.00","2025-12-06","pagamento","1","2026-02-09 06:32:51");
INSERT INTO `person_payments` VALUES("8","8","1","550.00","2025-12-07","pagamento","1","2026-02-09 06:34:01");
INSERT INTO `person_payments` VALUES("9","3","1","400.00","2025-12-12","pagamento","1","2026-02-09 06:36:19");
INSERT INTO `person_payments` VALUES("10","6","1","360.00","2025-12-12","pagamento","1","2026-02-09 06:36:55");
INSERT INTO `person_payments` VALUES("11","4","1","360.00","2025-12-12","pagamento","1","2026-02-09 06:37:18");
INSERT INTO `person_payments` VALUES("12","5","1","360.00","2025-12-12","pagamento","1","2026-02-09 06:37:51");
INSERT INTO `person_payments` VALUES("13","2","1","400.00","2025-12-12","pagamento","1","2026-02-09 06:38:18");
INSERT INTO `person_payments` VALUES("14","1","1","800.00","2025-12-12","pagamento 02 semanas","1","2026-02-09 06:38:58");
INSERT INTO `person_payments` VALUES("15","7","1","400.00","2025-12-12","pagamento","1","2026-02-09 06:39:21");
INSERT INTO `person_payments` VALUES("16","9","1","360.00","2025-12-13","pagamento","1","2026-02-09 06:40:16");
INSERT INTO `person_payments` VALUES("17","2","1","400.00","2025-12-19","pagamento","1","2026-02-09 07:07:32");
INSERT INTO `person_payments` VALUES("18","1","1","400.00","2025-12-19","pagamento","1","2026-02-09 07:07:56");
INSERT INTO `person_payments` VALUES("19","9","1","360.00","2025-12-19","pagamento","1","2026-02-09 07:08:20");
INSERT INTO `person_payments` VALUES("20","6","1","450.00","2025-12-19","pagamento","1","2026-02-09 07:08:46");
INSERT INTO `person_payments` VALUES("21","4","1","360.00","2025-12-19","pagamento","1","2026-02-09 07:09:19");
INSERT INTO `person_payments` VALUES("22","5","1","360.00","2025-12-19","pagamento","1","2026-02-09 07:09:41");
INSERT INTO `person_payments` VALUES("23","3","1","650.00","2025-12-19","pagamento","1","2026-02-09 07:10:06");
INSERT INTO `person_payments` VALUES("24","7","1","500.00","2025-12-19","pagamento","1","2026-02-09 07:11:57");
INSERT INTO `person_payments` VALUES("25","10","1","1400.00","2025-12-20","Revisão do forro na escola","1","2026-02-09 07:14:56");
INSERT INTO `person_payments` VALUES("26","10","1","300.00","2025-12-21","Reboco de 01 sala","1","2026-02-09 07:15:33");
INSERT INTO `person_payments` VALUES("27","11","1","1880.85","2025-12-23","Aluguel de andaimes e Martelete","1","2026-02-09 07:20:02");
INSERT INTO `person_payments` VALUES("28","3","1","200.00","2025-12-24","pagamento","1","2026-02-09 07:21:44");
INSERT INTO `person_payments` VALUES("29","12","1","1500.00","2025-12-24","Reboco de 05 salas","1","2026-02-09 07:22:53");
INSERT INTO `person_payments` VALUES("30","13","1","300.00","2025-12-24","Reboco de 01 sala","1","2026-02-09 07:23:55");
INSERT INTO `person_payments` VALUES("31","6","1","180.00","2025-12-24","pagamento","1","2026-02-09 07:24:21");
INSERT INTO `person_payments` VALUES("32","9","1","180.00","2025-12-24","pagamento","1","2026-02-09 07:24:46");
INSERT INTO `person_payments` VALUES("33","14","1","392.00","2025-12-26","pagamento","1","2026-02-09 07:27:47");
INSERT INTO `person_payments` VALUES("34","15","1","250.00","2025-12-26","pagamento","1","2026-02-09 07:28:37");
INSERT INTO `person_payments` VALUES("35","15","1","500.00","2025-12-26","pagamento","1","2026-02-09 07:29:11");
INSERT INTO `person_payments` VALUES("36","16","1","600.00","2025-12-26","Reboco de 02 sala","1","2026-02-09 07:30:21");
INSERT INTO `person_payments` VALUES("37","2","1","400.00","2025-12-26","pagamento","1","2026-02-09 07:36:08");
INSERT INTO `person_payments` VALUES("38","1","1","400.00","2025-12-26","pagamento","1","2026-02-09 07:36:40");
INSERT INTO `person_payments` VALUES("39","10","1","300.00","2025-12-26","Reboco de 01 sala","1","2026-02-09 07:37:59");
INSERT INTO `person_payments` VALUES("40","7","1","200.00","2025-12-26","pagamento","1","2026-02-09 07:38:42");
INSERT INTO `person_payments` VALUES("41","17","1","920.00","2025-12-27","pagamento","1","2026-02-09 07:39:57");
INSERT INTO `person_payments` VALUES("42","18","1","250.00","2025-12-29","pagamento","1","2026-02-09 07:41:18");
INSERT INTO `person_payments` VALUES("43","19","1","250.00","2025-12-29","pagamento","1","2026-02-09 07:43:14");
INSERT INTO `person_payments` VALUES("44","16","1","600.00","2025-12-29","pagamento","1","2026-02-09 07:44:31");
INSERT INTO `person_payments` VALUES("45","16","1","70.00","2025-12-29","pagamento","1","2026-02-09 07:44:47");
INSERT INTO `person_payments` VALUES("46","19","1","80.00","2025-12-29","pagamento","1","2026-02-09 07:45:10");
INSERT INTO `person_payments` VALUES("47","19","1","280.00","2025-12-29","pagamento","1","2026-02-09 09:05:57");
INSERT INTO `person_payments` VALUES("48","16","1","600.00","2025-12-29","pagamento","1","2026-02-09 09:06:28");
INSERT INTO `person_payments` VALUES("49","16","1","70.00","2025-12-29","pagamento","1","2026-02-09 09:07:21");
INSERT INTO `person_payments` VALUES("50","19","1","70.00","2025-12-29","pagamento","1","2026-02-09 09:08:23");
INSERT INTO `person_payments` VALUES("51","20","1","480.00","2025-12-29","pagamento","1","2026-02-09 09:09:52");
INSERT INTO `person_payments` VALUES("52","21","1","2289.60","2025-12-29","Assentamento de cerâmica","1","2026-02-09 09:10:46");
INSERT INTO `person_payments` VALUES("53","20","1","648.00","2025-12-30","pagamento","1","2026-02-09 09:12:03");
INSERT INTO `person_payments` VALUES("54","22","1","2289.60","2025-12-31","Assentamento de cerâmica","1","2026-02-09 09:17:28");
INSERT INTO `person_payments` VALUES("55","20","1","312.00","2025-12-31","pagamento","1","2026-02-09 09:18:05");
INSERT INTO `person_payments` VALUES("56","20","1","100.00","2025-12-31","pagamento","1","2026-02-09 09:18:24");
INSERT INTO `person_payments` VALUES("57","7","1","400.00","2025-12-31","pagamento","1","2026-02-09 09:18:56");
INSERT INTO `person_payments` VALUES("58","6","1","450.00","2025-12-31","pagamento","1","2026-02-09 09:19:21");
INSERT INTO `person_payments` VALUES("59","9","1","720.00","2025-12-31","pagamento","1","2026-02-09 09:19:44");
INSERT INTO `person_payments` VALUES("60","23","1","360.00","2025-12-31","pagamento","1","2026-02-09 09:20:49");
INSERT INTO `person_payments` VALUES("61","9","1","90.00","2025-12-31","pagamento","1","2026-02-09 09:21:18");
INSERT INTO `person_payments` VALUES("62","22","1","2289.60","2026-01-02","Assentamento de cerâmica","1","2026-02-09 09:24:11");
INSERT INTO `person_payments` VALUES("63","21","1","2289.60","2026-01-02","Assentamento de cerâmica","1","2026-02-09 09:24:40");
INSERT INTO `person_payments` VALUES("64","24","1","3000.00","2026-01-03","pagamento","1","2026-02-09 09:26:18");
INSERT INTO `person_payments` VALUES("65","2","1","400.00","2026-01-03","pagamento","1","2026-02-09 09:26:42");
INSERT INTO `person_payments` VALUES("66","1","1","400.00","2026-01-03","pagamento","1","2026-02-09 09:27:01");
INSERT INTO `person_payments` VALUES("67","13","1","1200.00","2026-01-06","pagamento","1","2026-02-09 09:27:33");
INSERT INTO `person_payments` VALUES("68","25","1","500.00","2026-01-07","pagamento","1","2026-02-09 09:29:50");
INSERT INTO `person_payments` VALUES("69","24","1","300.00","2026-01-07","pagamento","1","2026-02-09 09:30:11");
INSERT INTO `person_payments` VALUES("70","22","1","2289.60","2026-01-08","Assentamento de cerâmica - Eliana de jesus Alves","1","2026-02-09 09:32:15");
INSERT INTO `person_payments` VALUES("71","21","1","2289.60","2026-01-09","Assentamento de cerâmica - Ludmila de Oliveira","1","2026-02-09 09:34:23");
INSERT INTO `person_payments` VALUES("72","21","1","2289.60","2026-01-09","Assentamento de cerâmica","1","2026-02-09 09:35:09");
INSERT INTO `person_payments` VALUES("73","25","1","800.00","2026-01-09","pagamento","1","2026-02-09 09:36:41");
INSERT INTO `person_payments` VALUES("74","2","1","400.00","2026-01-09","pagamento","1","2026-02-09 09:37:05");
INSERT INTO `person_payments` VALUES("75","1","1","400.00","2026-01-09","pagamento","1","2026-02-09 09:38:00");
INSERT INTO `person_payments` VALUES("76","26","1","430.00","2026-01-10","pagamento","1","2026-02-09 09:39:58");
INSERT INTO `person_payments` VALUES("77","7","1","500.00","2026-01-10","pagamento","1","2026-02-09 09:41:59");
INSERT INTO `person_payments` VALUES("78","6","1","450.00","2026-01-10","pagamento","1","2026-02-09 09:42:26");
INSERT INTO `person_payments` VALUES("79","4","1","450.00","2026-01-10","pagamento","1","2026-02-09 09:43:02");
INSERT INTO `person_payments` VALUES("80","27","1","250.00","2026-01-10","pagamento","1","2026-02-09 09:43:52");
INSERT INTO `person_payments` VALUES("81","3","1","550.00","2026-01-10","pagamento","1","2026-02-09 09:44:23");
INSERT INTO `person_payments` VALUES("82","22","1","2289.60","2026-01-13","Assentamento de cerâmica - Eliana de jesus Alves","1","2026-02-09 09:47:18");
INSERT INTO `person_payments` VALUES("83","25","1","520.00","2026-01-13","pagamento","1","2026-02-09 09:47:43");
INSERT INTO `person_payments` VALUES("84","28","1","2759.70","2026-01-16","Assentamento de cerâmica","1","2026-02-09 09:50:34");
INSERT INTO `person_payments` VALUES("85","21","1","1809.70","2026-01-15","pagamento","1","2026-02-09 09:51:06");
INSERT INTO `person_payments` VALUES("86","1","1","500.00","2026-01-16","pagamento","1","2026-02-09 09:53:01");
INSERT INTO `person_payments` VALUES("87","2","1","400.00","2026-01-16","pagamento","1","2026-02-09 09:53:27");
INSERT INTO `person_payments` VALUES("88","29","1","2000.00","2026-01-16","pagamento","1","2026-02-09 09:55:05");
INSERT INTO `person_payments` VALUES("89","25","1","900.00","2026-01-16","pagamento","1","2026-02-09 09:56:29");
INSERT INTO `person_payments` VALUES("90","25","1","920.00","2026-01-16","pagamento","1","2026-02-09 09:56:40");
INSERT INTO `person_payments` VALUES("91","13","1","1999.75","2026-01-17","pagamento","1","2026-02-09 09:57:15");
INSERT INTO `person_payments` VALUES("92","3","1","400.00","2026-01-17","pagamento","1","2026-02-09 09:57:37");
INSERT INTO `person_payments` VALUES("93","7","1","400.00","2026-01-17","pagamento","1","2026-02-09 09:58:00");
INSERT INTO `person_payments` VALUES("94","6","1","360.00","2026-01-17","pagamento","1","2026-02-09 09:58:35");
INSERT INTO `person_payments` VALUES("95","30","1","2613.00","2026-01-17","pagamento","1","2026-02-09 10:09:01");
INSERT INTO `person_payments` VALUES("96","31","1","450.00","2026-01-18","pagamento","1","2026-02-09 10:09:45");
INSERT INTO `person_payments` VALUES("97","32","1","17200.00","2026-01-19","pagamento","1","2026-02-09 10:12:03");
INSERT INTO `person_payments` VALUES("98","7","1","110.00","2026-01-19","pagamento","1","2026-02-09 10:13:32");
INSERT INTO `person_payments` VALUES("99","25","1","500.00","2026-01-20","pagamento","1","2026-02-09 10:14:24");
INSERT INTO `person_payments` VALUES("100","26","1","960.00","2026-01-22","pagamento","1","2026-02-09 10:16:31");
INSERT INTO `person_payments` VALUES("101","33","1","470.00","2026-01-22","pagamento","1","2026-02-09 10:17:39");
INSERT INTO `person_payments` VALUES("102","28","1","4312.50","2026-01-22","Assentamento de cerâmica","1","2026-02-09 10:18:12");
INSERT INTO `person_payments` VALUES("103","34","1","250.00","2026-01-22","pagamento","1","2026-02-09 10:19:09");
INSERT INTO `person_payments` VALUES("104","2","1","400.00","2026-01-23","pagamento","1","2026-02-09 10:19:58");
INSERT INTO `person_payments` VALUES("105","1","1","500.00","2026-01-23","pagamento","1","2026-02-09 10:20:20");
INSERT INTO `person_payments` VALUES("106","33","1","129.00","2026-01-24","pagamento","1","2026-02-09 10:20:44");
INSERT INTO `person_payments` VALUES("107","31","1","337.00","2026-01-24","pagamento","1","2026-02-09 10:21:10");
INSERT INTO `person_payments` VALUES("108","27","1","450.00","2026-01-24","pagamento","1","2026-02-09 10:22:11");
INSERT INTO `person_payments` VALUES("109","35","1","150.00","2026-01-24","pagamento","1","2026-02-09 10:22:53");
INSERT INTO `person_payments` VALUES("110","13","1","1000.00","2026-01-24","pagamento","1","2026-02-09 10:23:18");
INSERT INTO `person_payments` VALUES("111","21","1","2781.00","2026-01-26","Assentamento de cerâmica","1","2026-02-09 10:23:52");
INSERT INTO `person_payments` VALUES("112","11","1","243.00","2026-01-26","Aluguel de andaimes","1","2026-02-09 10:25:52");
INSERT INTO `person_payments` VALUES("113","21","1","810.00","2026-01-27","pagamento","1","2026-02-09 10:26:19");
INSERT INTO `person_payments` VALUES("114","36","1","1988.00","2026-01-27","pagamento","1","2026-02-09 10:27:26");
INSERT INTO `person_payments` VALUES("115","28","1","300.00","2026-01-29","pagamento","1","2026-02-09 10:28:54");
INSERT INTO `person_payments` VALUES("116","7","1","700.00","2026-01-30","pagamento","1","2026-02-09 10:30:36");
INSERT INTO `person_payments` VALUES("117","33","1","90.00","2026-01-31","pagamento","1","2026-02-09 10:31:22");
INSERT INTO `person_payments` VALUES("118","1","1","500.00","2026-01-31","pagamento","1","2026-02-09 10:31:45");
INSERT INTO `person_payments` VALUES("119","2","1","400.00","2026-01-31","pagamento","1","2026-02-09 10:32:31");
INSERT INTO `person_payments` VALUES("120","30","1","2500.00","2026-01-31","pagamento","1","2026-02-09 10:33:03");
INSERT INTO `person_payments` VALUES("121","37","1","1000.00","2026-01-31","pagamento","1","2026-02-09 10:34:09");
INSERT INTO `person_payments` VALUES("122","29","1","2000.00","2026-02-03","Elétrica","1","2026-02-09 11:07:55");
INSERT INTO `person_payments` VALUES("123","38","1","1500.00","2025-12-29","Pagamento em dinheiro","1","2026-02-09 11:10:46");
INSERT INTO `person_payments` VALUES("124","38","1","3500.00","2026-02-03","Pagamento - Geniele da Silva S","1","2026-02-09 11:11:32");
INSERT INTO `person_payments` VALUES("125","38","1","3500.00","2026-02-03","Pagamento - Marcelo da Silva S","1","2026-02-09 11:11:58");
INSERT INTO `person_payments` VALUES("126","37","1","1250.00","2026-02-03","Instalação de forro","1","2026-02-09 11:16:59");
INSERT INTO `person_payments` VALUES("127","28","1","300.00","2026-02-05","pagamento","1","2026-02-09 11:20:33");
INSERT INTO `person_payments` VALUES("128","39","1","4095.00","2026-02-06","pagamento","1","2026-02-09 11:23:26");
INSERT INTO `person_payments` VALUES("129","39","1","4095.00","2026-02-12","pagamento","0","2026-02-09 11:23:44");
INSERT INTO `person_payments` VALUES("130","30","1","2000.00","2026-02-09","pagamento","1","2026-02-09 11:24:23");
INSERT INTO `person_payments` VALUES("131","1","1","500.00","2026-02-09","pagamento","1","2026-02-09 11:24:52");
INSERT INTO `person_payments` VALUES("132","2","1","400.00","2026-02-09","pagamento","1","2026-02-09 11:25:10");
INSERT INTO `person_payments` VALUES("133","27","1","400.00","2026-02-09","pagamento","1","2026-02-09 11:26:29");
INSERT INTO `person_payments` VALUES("134","38","1","4336.34","2026-02-13","R$ 12.836,64 (R$ 8.500,00 PG)","0","2026-02-09 11:32:28");
INSERT INTO `person_payments` VALUES("135","40","1","23876.01","2026-02-09","pagamento","1","2026-02-09 11:46:46");
INSERT INTO `person_payments` VALUES("136","41","1","150.00","2025-12-18","Corte de Árvore","1","2026-02-10 22:37:24");



DROP TABLE IF EXISTS `revenues`;

CREATE TABLE `revenues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_id` int(11) NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `received_date` date NOT NULL,
  `status` enum('received','to_receive') DEFAULT 'to_receive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `work_id` (`work_id`),
  KEY `service_id` (`service_id`),
  CONSTRAINT `fk_revenues_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_revenues_work` FOREIGN KEY (`work_id`) REFERENCES `works` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `revenues` VALUES("2","1","1","Recebimento: Revestimento","40000.00","2026-02-08","received","2026-02-08 07:36:30");
INSERT INTO `revenues` VALUES("3","1","2","Recebimento: Telhado","40000.00","2026-02-08","received","2026-02-08 07:37:10");



DROP TABLE IF EXISTS `services`;

CREATE TABLE `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `percentage_work` decimal(5,2) DEFAULT 0.00,
  `value` decimal(10,2) DEFAULT 0.00,
  `executed_percentage` decimal(5,2) DEFAULT 0.00,
  `paid_value` decimal(10,2) DEFAULT 0.00,
  `status` enum('pendente','finalizado') DEFAULT 'pendente',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `work_id` (`work_id`),
  CONSTRAINT `fk_services_work` FOREIGN KEY (`work_id`) REFERENCES `works` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `services` VALUES("1","1","Revestimento","20.00","40836.26","100.00","40000.00","finalizado","2026-02-07 18:56:54");
INSERT INTO `services` VALUES("2","1","Telhado","20.00","40836.26","100.00","40000.00","finalizado","2026-02-07 19:14:31");
INSERT INTO `services` VALUES("3","1","Elétrica","20.00","40836.26","100.00","0.00","finalizado","2026-02-07 19:19:31");
INSERT INTO `services` VALUES("4","1","Pintura","20.00","40836.26","60.00","0.00","pendente","2026-02-07 19:19:54");
INSERT INTO `services` VALUES("5","1","Instalações Hidrosanitárias","10.00","20418.13","75.00","0.00","pendente","2026-02-07 19:20:12");
INSERT INTO `services` VALUES("6","1","Serviços Diversos","10.00","20418.13","58.00","0.00","pendente","2026-02-07 19:20:29");



DROP TABLE IF EXISTS `sub_services`;

CREATE TABLE `sub_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `percentage_service` decimal(5,2) DEFAULT 0.00,
  `value` decimal(10,2) DEFAULT 0.00,
  `executed_percentage` decimal(5,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `service_id` (`service_id`),
  CONSTRAINT `fk_sub_services_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `sub_services` VALUES("1","5","Instalação de Pia Cozinha","20.00","4083.63","100.00","2026-02-07 19:36:22");
INSERT INTO `sub_services` VALUES("2","5","Instalação de Pia - Lava Pano","15.00","3062.72","0.00","2026-02-07 19:36:39");
INSERT INTO `sub_services` VALUES("3","5","Revisão de banheiro Masculino e Femino","40.00","8167.25","100.00","2026-02-07 19:37:03");
INSERT INTO `sub_services` VALUES("4","5","Revisão Banheiro Administrativo","15.00","3062.72","100.00","2026-02-07 19:37:20");
INSERT INTO `sub_services` VALUES("5","5","Instalação de Caixa de Gordura Cozinha","10.00","2041.81","0.00","2026-02-07 19:41:09");
INSERT INTO `sub_services` VALUES("6","6","Calçada frente escola","30.00","6125.44","55.00","2026-02-07 19:49:36");
INSERT INTO `sub_services` VALUES("7","6","Calçada fundo Escola","30.00","6125.44","60.00","2026-02-07 19:49:52");
INSERT INTO `sub_services` VALUES("8","6","Instalação de Grelha Pátio","20.00","4083.63","100.00","2026-02-07 19:50:29");
INSERT INTO `sub_services` VALUES("9","6","Instalação de serviços diversos","20.00","4083.63","17.50","2026-02-07 19:51:13");



DROP TABLE IF EXISTS `suppliers`;

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `suppliers` VALUES("1","Construtora silva","","","","Loja de Material de Construção","2026-02-09 21:49:25");
INSERT INTO `suppliers` VALUES("2","Diversos Jerri","","Jerrie","","","2026-02-09 22:28:04");
INSERT INTO `suppliers` VALUES("3","Diversos Nei","","Nei","","","2026-02-09 22:29:35");
INSERT INTO `suppliers` VALUES("4","Alan Calhas","","Alan","","","2026-02-10 22:32:52");
INSERT INTO `suppliers` VALUES("5","Rouge Areia","","Rouge","","","2026-02-10 22:35:01");



DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('todo','in_progress','done') DEFAULT 'todo',
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `deadline` date DEFAULT NULL,
  `responsible_id` int(11) DEFAULT NULL,
  `column_index` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `work_id` (`work_id`),
  KEY `responsible_id` (`responsible_id`),
  CONSTRAINT `fk_tasks_responsible` FOREIGN KEY (`responsible_id`) REFERENCES `people` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_tasks_work` FOREIGN KEY (`work_id`) REFERENCES `works` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tasks` VALUES("1","1","Instalação de Caixa de Gordura","Instalar caixa de gordura na cozinha","todo","medium","2026-02-13","1","0","2026-02-07 20:14:47");
INSERT INTO `tasks` VALUES("2","1","Instalação de Janela de Vidro no AEE","","todo","medium","2026-02-19","2","0","2026-02-07 20:15:13");



DROP TABLE IF EXISTS `user_permissions`;

CREATE TABLE `user_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `resource` varchar(50) NOT NULL,
  `can_list` tinyint(1) DEFAULT 0,
  `can_create` tinyint(1) DEFAULT 0,
  `can_read` tinyint(1) DEFAULT 0,
  `can_update` tinyint(1) DEFAULT 0,
  `can_delete` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_user_permissions` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','manager','user') DEFAULT 'user',
  `must_change_password` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` VALUES("1","Administrador","avanteservico@gmail.com","$2y$10$gXQcJI1rBayWKLr5g9.dd.bOeWTwaXFLPxOIeXcWv/eVamYdrQqyi","admin","0","2026-02-07 17:34:54");
INSERT INTO `users` VALUES("2","Neris Farias","nerisfarias@gmail.com","$2y$10$Btasy3bFD6yAhgBNjT.dEOZ6rOCeonlH5df3ISIjAXTcUt4lnq0NW","user","0","2026-02-07 22:19:59");
INSERT INTO `users` VALUES("3","Ingrid Docilio","dociliofarias@gmail.com","$2y$10$f3325LYdfnb5ujhq43szh.oeei4W0oEicZvJjRXB44G4SPAcD9Kaa","user","1","2026-02-08 15:52:58");



DROP TABLE IF EXISTS `work_suppliers`;

CREATE TABLE `work_suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_work_supplier` (`work_id`,`supplier_id`),
  KEY `fk_work_suppliers_supplier` (`supplier_id`),
  CONSTRAINT `fk_work_suppliers_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_work_suppliers_work` FOREIGN KEY (`work_id`) REFERENCES `works` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `work_suppliers` VALUES("1","1","1","2026-02-09 22:06:17");
INSERT INTO `work_suppliers` VALUES("2","1","4","2026-02-10 22:48:59");



DROP TABLE IF EXISTS `works`;

CREATE TABLE `works` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `reference_point` text DEFAULT NULL,
  `total_value` decimal(10,2) DEFAULT 0.00,
  `start_date` date DEFAULT NULL,
  `end_date_prediction` date DEFAULT NULL,
  `status` enum('active','completed','paused','canceled') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `works` VALUES("1","Reforma Escola José de Anchieta","Bairro Várzea Alegre","Várzea Alegre","204181.32","2025-12-04","2026-02-14","active","2026-02-07 18:55:46");



