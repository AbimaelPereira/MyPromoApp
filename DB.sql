CREATE TABLE `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `user` varchar(40) NOT NULL,
  `pass` varchar(256) NOT NULL,
  `logo` varchar(20) NOT NULL,
  `nome_mercado` varchar(80) NOT NULL,
  `topicApp` varchar(256) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;