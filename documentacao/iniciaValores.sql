-- script para popular as tabelas com valores padrão.
-- Tenha certeza de não ter dados nas tabelas com auto-increment
use opesso08_ProjetoDB;

insert into aluno (
    matricula,
    nome,
    email
) values
(180021231, 'Kesley Kenny Guimarães Vasques', 'kesley.kenny@aluno.unb.br'),
(180021320, 'Keydson Estrela da Silva', 'keydson.silva@aluno.unb.br'),
(180022059, 'Letícia Dias Soares Alves', 'dias.soares@aluno.unb.br'),
(180026305, 'Pedro Henrique de Brito Agnes', 'pedro.agnes@aluno.unb.br'),
(180026488, 'Pedro Pessoa Ramos', 'ramos.pedro@aluno.unb.br');

insert into departamento (
	codigo,
    nome
) values
('CIC', 'Departamento de Ciência da Computação'),
('FE', 'Faculdade de Educação'),
('MAT', 'Departamento de Matemática'),
('FT', 'Faculdade de Tecnologia'),
('FAU', 'Faculdade de Arquitetura e urbanismo');

insert into professor (
	matricula,
    nome,
    email,
    departamento_codigo
) values
(000000001, 'Maristela Terto de Holanda', 'mholanda@unb.br', 'CIC'),
(000000002, 'Flávia Zapata', 'fzapata@unb.br', 'MAT'),
(000000003, 'Aletéia Patrícia Favacho de Araújo', 'aleteia@unb.br', 'CIC'),
(000000004, 'Marcos Fagundes Caetano', 'mfcaetano@unb.br', 'CIC'),
(000000005, 'Leticia Lopes Leite', 'llleite@unb.br', 'CIC'),
(000000006, 'Harley Vera Oliveira', 'harley.vera@aluno.unb.br', 'CIC');

insert into disciplina (
	codigo,
    nome
) values
('CIC0207', 'Projeto Interdisciplinar de licenciatura em computação'),
('CIC0097', 'Banco de Dados'),
('CIC0124', 'Redes de Computadores'),
('CIC0225', 'Introdução a Sistemas Operacionais'),
('MAT0053', 'Cáculo Numérico');

insert into turma (
	id,
    horario,
    disciplina_codigo
) values
('A', '7M12 6N123', 'CIC0207'),
('B', '35N12', 'CIC0097'),
('A', '3N34 5N34', 'CIC0124'),
('A', '2N12 4N12', 'CIC0225'),
('A', '35T12', 'MAT0053'),
('B', '35T34', 'MAT0053');

insert into professor_turma (
	professor_matricula,
    turma_id,
    turma_disciplina_codigo,
    e_substituto
) values
(000000005, 'A', 'CIC0207', 0),
(000000001, 'B', 'CIC0097', 0),
(000000006, 'B', 'CIC0097', 1),
(000000004, 'A', 'CIC0124', 0),
(000000003, 'A', 'CIC0225', 0),
(000000002, 'A', 'MAT0053', 0),
(000000002, 'B', 'MAT0053', 0);

alter table plataforma auto_increment = 1;
insert into plataforma (
	nome
) values
('Microsoft Teams'), -- 1
('Zoom'), -- 2
('Moodle'), -- 3
('Youtube'), -- 4
('Meets'); -- 5

insert into recurso (
	recurso,
    plataforma_id
) values
('videochamada', 1),
('chat', 1),
('videochamada', 2),
('chat', 2),
('chamada por telefone', 2),
('questionário', 3),
('fórum', 3),
('videos', 3),
('videos', 4),
('videochamada', 5),
('chat', 5);

alter table dispositivo auto_increment = 1;
insert into dispositivo (
	descricao
) values
('Celular'), -- 1
('Desktop'), -- 2
('Notebook'), -- 3
('Internet Residencial'), -- 4
('Telefone'), -- 5
('5G'), -- 6
('4G'); -- 7

insert into aluno_dispositivo (
	aluno_matricula,
    dispositivo_id,
    disponibilidade
) values
(180021231, 1, 'sempre'),
(180021231, 2, 'as vezes'),
(180021231, 3, 'sempre'),
(180021231, 4, 'sempre'),
(180021320, 1, 'raramente'),
(180021320, 3, 'sempre'),
(180021320, 4, 'as vezes'),
(180022059, 1, 'sempre'),
(180022059, 2, 'sempre'),
(180022059, 4, 'sempre'),
(180026305, 1, 'sempre'),
(180026305, 2, 'sempre'),
(180026305, 4, 'sempre'),
(180026305, 5, 'pela noite'),
(180026488, 1, 'pela manha'),
(180026488, 2, 'sempre'),
(180026488, 4, 'sempre');

insert into aula (
	numero,
    data,
    duracao,
    e_sincrona,
    turma_id,
    turma_disciplina_codigo,
    plataforma_id
) values
(1, '2020-08-18', 90, 1, 'B', 'CIC0097', 1),
(2, '2020-08-20', 90, 1, 'B', 'CIC0097', 1),
(3, '2020-08-25', null, 0, 'B', 'CIC0097', 3),
(1, '2020-08-18', 90, 1, 'A', 'CIC0124', 1),
(2, '2020-08-20', null, 0, 'A', 'CIC0124', 3);

alter table tipo_participacao auto_increment = 1;
insert into tipo_participacao (
	tipo,
    pontuacao,
    pontuacao_por_tempo
) values
('comentário', 1.0, 0), -- 1
('envio de tarefa', 10.0, 0), -- 2
('diálogo com professor', 2.5, 1), -- 3
('presença em aula', 0.5, 1), -- 4
('chamada', 0.1, 0); -- 5

insert into participacao (
	tempo,
    aluno_matricula,
    tipo_participacao_id,
    aula_numero,
    aula_turma_id,
    aula_turma_disciplina_codigo
) values
(null, 180021231, 2, 2, 'A', 'CIC0124'),
(null, 180021320, 2, 2, 'A', 'CIC0124'),
(null, 180022059, 2, 2, 'A', 'CIC0124'),
(null, 180026305, 2, 2, 'A', 'CIC0124'),
(null, 180026488, 2, 2, 'A', 'CIC0124');
