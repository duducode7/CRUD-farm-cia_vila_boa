create DATABASE vila_boa_farm;

USE vila_boa_farm;

CREATE TABLE usuarios(
	id_usuario int not null AUTO_INCREMENT PRIMARY KEY,
    nome_usuario varchar(100) not null,
    email_usuario varchar(200) not null,
    senha_usuario varchar(100) not null
);

CREATE TABLE medicamentos(
	id_medicamento int NOT null AUTO_INCREMENT PRIMARY KEY,
    nome_medicamento varchar(100) NOT null,
    preço_medicamento decimal(10,2) NOT null,
    estoque_medicamento int NOT null
    tipo_medicamento varchar(50) not null
);