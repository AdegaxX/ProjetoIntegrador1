create database usuarios2;

use usuarios2;

create table Alunos(
ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Nome VARCHAR(255) NOT NULL,
Matricula VARCHAR(20) NOT NULL,
Interesse TINYINT(1) DEFAULT 0,
RecebeuQuentinha TINYINT(1) DEFAULT 0);

show tables;

select * from alunos;

update alunos
set interesse = 1
where nome = "Isabela Gabrielly Pereira";

SET SQL_SAFE_UPDATES = 0;

describe alunos;

insert into alunos values
(1, "Rian Albano Sousa Ribeiro", "557389", 1, 0),
(2, "Madson Luan Dias Nascimento", "558611", 1, 0),
(3, "Leandro Nascimento Adegas", "557297", 1, 0),
(4, "Lincoln Alyson Melo Lembi", "557460", 1, 0),
(5, "Isabela Gabrielly Pereira", "189433", 0, 0),
(6, "Lorenzo Vinicius Márcio Novaes", "360023", 0, 0),
(7, "Silvana Betina Castro", "822334", 0, 0),
(8, "Elisa Esther Fernanda Oliveira", "119550", 0, 0),
(9, "Carlos Eduardo José Leonardo Sales", "166822", 0, 0),
(10, "Jaqueline Cláudia Cardoso", "987747", 0, 0),
(11, "Carlos Eduardo Nelson Murilo Rocha", "514734", 1, 0),
(12, "Arthur Carlos Oliver Nunes", "539071", 1, 0),
(13, "Otávio Leonardo Henry Brito", "149686", 1, 0),
(14, "Isaac Benedito Bruno Galvão", "687610", 1, 0),
(15, "Kauê Danilo Sérgio Carvalho", "927558", 1, 0),
(16, "Stella Sophie Assunção", "124524", 1, 0),
(17, "Vanessa Lúcia Viana", "883646", 1, 0),
(18, "Rita Raquel Cláudia da Rosa", "423360", 1, 0),
(19, "Gabrielly Mariana Melo", "814080", 1, 0),
(20, "Roberto Bernardo Nascimento", "316695", 1, 0),
(21, "Nelson Fábio Hugo de Paula", "013539", 1, 0),
(22, "Cláudia Emilly Helena Ferreira", "466239", 1, 0),
(23, "Esther Aurora Gomes", "456213", 1, 0),
(24, "Marli Luana Carolina Ferreira", "697593", 1, 0),
(25, "Manuel Bruno da Luz", "935827", 1, 0),
(26, "Nelson Renan Teixeira", "988471", 1, 0),
(27, "Heloise Alana Louise Farias", "418852", 1, 0),
(28, "Aparecida Carolina Vera Costa", "099363", 1, 0),
(29, "Débora Clarice Hadassa Nogueira", "914182", 1, 0),
(30, "Osvaldo Thiago Caio da Conceição", "442295", 1, 0),
(31, "Diogo Igor Joaquim Silva", "728600", 1, 0),
(32, "Levi Samuel Renan Assunção", "310661", 1, 0),
(33, "Catarina Letícia da Paz", "291891", 1, 0),
(34, "Arthur Márcio Bernardes", "416948", 1, 0);