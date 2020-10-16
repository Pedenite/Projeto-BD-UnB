create database opesso08_projetoDB;

create table aluno(
matricula nvarchar(9) not null,
nome nvarchar(50) null,
email nvarchar(50) null,
primary key (matricula)
);

create table departamento (
codigo varchar(3) not null,
nome varchar(20) not null,
primary key(codigo)
);

create table professor (
matricula varchar(9) not null,
nome varchar(20) not null,
email varchar(20) not null,
departamento_codigo varchar(3) not null,
primary key(matricula),
foreign key (departamento_codigo) references departamento(codigo)
);

create table disciplina (
codigo varchar(8) not null,
nome varchar(20) not null,
primary key(codigo)
);

create table turma (
id varchar(2) not null,
horario varchar(10) not null,
disciplina_codigo varchar(8) not null,
primary key (id, disciplina_codigo),
foreign key (disciplina_codigo) references disciplina(codigo)
);

create table professor_turma (
professor_matricula varchar(9) not null,
turma_id varchar(2) not null,
e_substituto bit,
primary key (professor_matricula, turma_id),
foreign key (professor_matricula) references professor(matricula),
foreign key (turma_id) references turma(id)
);

CREATE TABLE aluno_disponibilidade_recurso (
aluno_matricula varchar(9) NOT NULL,
disponibilidade_id int(11) NOT NULL,
recurso_id int(11) NOT NULL,
PRIMARY KEY (aluno_matricula,disponibilidade_id,recurso_id),
FOREIGN KEY (disponibilidade_id) REFERENCES disponibilidade(id),
FOREIGN KEY (aluno_matricula) REFERENCES aluno(matricula),
FOREIGN KEY (recurso_id) REFERENCES recurso(id)
);

CREATE TABLE disponibilidade (
id int(11) NOT NULL AUTO_INCREMENT,
disponibilidade varchar(45) NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE plataforma (
  id int(11) NOT NULL AUTO_INCREMENT,
  nome varchar(45) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE dispositivo (
  id int(11) NOT NULL AUTO_INCREMENT,
  descricao varchar(45) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE recurso (
  recurso varchar(45) not null,
  plataforma_id int(11) NOT NULL,
  PRIMARY KEY (recurso, plataforma_id),
  foreign key (plataforma_id) references plataforma(id)
);

create table aula(
numero int(3) not null,
data date not null,
duracao int(3) null,
e_sincrona bit,
turma_id varchar(2) not null,
plataforma_id int(11),
primary key(numero, turma_id),
foreign key (turma_id) references turma(id),
foreign key (plataforma_id) references plataforma(id)
);

CREATE TABLE tipo_participacao (
  id int(11) NOT NULL AUTO_INCREMENT,
  tipo varchar(45) NOT NULL,
  pontuacao float NOT NULL,
  PRIMARY KEY (id)
);


create table participacao (
id int(11) not null auto_increment,
tempo int(11) null, -- em minutos!
aluno_matricula varchar(9) not null,
tipo_participacao_id int(11) not null,
aula_numero int(3) not null,
aula_turma_id varchar(2) not null, 
primary key (id),
foreign key (aluno_matricula) references aluno(matricula),
foreign key (tipo_participacao_id) references tipo_participacao(id),
foreign key (aula_numero) references aula(numero),
foreign key (aula_turma_id) references turma(id)
);
