drop database if exists opesso08_ProjetoDB;
create database opesso08_ProjetoDB;
use opesso08_ProjetoDB;

create table aluno(
	matricula varchar(9) not null,
	nome varchar(50) null,
	email varchar(50) null,
	primary key (matricula)
);

create table departamento (
	codigo varchar(3) not null,
	nome varchar(50) not null,
	primary key(codigo)
);

create table professor (
	matricula varchar(9) not null,
	nome varchar(50) not null,
	email varchar(50) not null,
	departamento_codigo varchar(3) not null,
	primary key(matricula),
	foreign key (departamento_codigo) references departamento(codigo)
);

create table disciplina (
	codigo varchar(8) not null,
	nome varchar(100) not null,
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
	turma_disciplina_codigo varchar(8) not null,
	e_substituto bit,
	primary key (professor_matricula, turma_id, turma_disciplina_codigo),
	foreign key (professor_matricula) references professor(matricula),
	foreign key (turma_id, turma_disciplina_codigo) references turma(id, disciplina_codigo)
);

create table plataforma (
	id int(11) not null auto_increment,
	nome varchar(45) not null,
	primary key (id)
);

create table recurso (
	recurso varchar(45) not null,
	plataforma_id int(11) not null,
	primary key (recurso, plataforma_id),
	foreign key (plataforma_id) references plataforma(id)
);

create table dispositivo (
	id int(11) not null auto_increment,
	descricao varchar(45) not null,
	primary key (id)
);

create table aluno_dispositivo (
	aluno_matricula varchar(9) not null,
	dispositivo_id int(11) not null,
	disponibilidade varchar(10) not null check (disponibilidade in ('sempre', 'as vezes', 'raramente', 'pela manha', 'pela tarde', 'pela noite')),
	primary key (aluno_matricula,dispositivo_id),
	foreign key (aluno_matricula) references aluno(matricula),
	foreign key (dispositivo_id) references dispositivo(id)
);

create table aula(
	numero int(3) not null,
	data date not null,
	duracao int(3) null, -- em minutos!
	e_sincrona bit,
	turma_id varchar(2) not null,
	turma_disciplina_codigo varchar(8) not null,
	plataforma_id int(11),
	primary key(numero, turma_id, turma_disciplina_codigo),
	foreign key (turma_id, turma_disciplina_codigo) references turma(id, disciplina_codigo),
	foreign key (plataforma_id) references plataforma(id)
);

create table tipo_participacao (
	id int(11) not null auto_increment,
	tipo varchar(45) not null,
	pontuacao float not null,
	primary key (id)
);

create table participacao (
	id int(11) not null auto_increment,
	tempo int(11) not null default 1, -- em minutos!
	aluno_matricula varchar(9) not null,
	tipo_participacao_id int(11) not null,
	aula_numero int(3) not null,
	aula_turma_id varchar(2) not null,
	aula_turma_disciplina_codigo varchar(8) not null,
	primary key (id),
	foreign key (aluno_matricula) references aluno(matricula),
	foreign key (tipo_participacao_id) references tipo_participacao(id),
	foreign key (aula_numero, aula_turma_id, aula_turma_disciplina_codigo) references aula(numero, turma_id, turma_disciplina_codigo)
);
