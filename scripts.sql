CREATE DATABASE opesso08_projetoDB;

CREATE TABLE aluno(
matricula nvarchar(9) NOT NULL,
nome nvarchar(50) NULL,
email nvarchar(50) NULL,
PRIMARY KEY (matricula)
);