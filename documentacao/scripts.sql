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
