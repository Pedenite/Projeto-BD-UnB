use opesso08_ProjetoDB;

create view participacao_info as
select distinct al.nome as aluno, tp.tipo as participacao, au.numero as aula, tu.id as turma, d.nome as disciplina
from participacao p
inner join aluno al on p.aluno_matricula = al.matricula
inner join tipo_participacao tp on p.tipo_participacao_id = tp.id
inner join aula au on p.aula_numero = au.numero
inner join turma tu on p.aula_turma_id = tu.id
inner join disciplina d on p.aula_turma_disciplina_codigo = d.codigo
order by al.nome;

create view pessoas as
select 'aluno' as cadastro, nome, email from aluno
union all
select 'professor', nome, email from professor
order by nome;

create view disciplinas_sem_aulas as
select * from disciplina where codigo not in 
(select turma_disciplina_codigo from aula);
