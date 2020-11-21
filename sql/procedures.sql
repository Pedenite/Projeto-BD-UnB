DROP PROCEDURE IF EXISTS professorLegal;
DELIMITER //

CREATE PROCEDURE professorLegal(IN Turma VARCHAR(2), IN Diciplina VARCHAR(8))
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE aluno VARCHAR(9);
    DECLARE nota FLOAT;
    DECLARE mediaTurma FLOAT;
    DECLARE curs1 CURSOR FOR 
    (
        SELECT par.aluno_matricula, SUM(tip_par.pontuacao * par.tempo) FROM participacao AS par 
        INNER JOIN tipo_participacao AS tip_par ON par.tipo_participacao_id = tip_par.id
        WHERE par.aula_turma_id = Turma AND par.aula_turma_disciplina_codigo = Diciplina
        GROUP BY par.aluno_matricula
    );
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    SET mediaTurma = (
        SELECT AVG(tip_par.pontuacao * par.tempo) 
        FROM participacao AS par 
        INNER JOIN tipo_participacao AS tip_par ON par.tipo_participacao_id = tip_par.id
        WHERE par.aula_turma_id = Turma AND par.aula_turma_disciplina_codigo = Diciplina
        GROUP BY par.aula_turma_id
    );
    OPEN curs1;
        read_loop: LOOP
            FETCH curs1 INTO aluno, nota;
            IF done THEN
                LEAVE read_loop;
            END IF;
            IF nota > mediaTurma THEN
                INSERT INTO participacao (aluno_matricula, tipo_participacao_id, aula_numero, aula_turma_id, aula_turma_disciplina_codigo) SELECT aluno,"1",A.numero, A.turma_id, A.turma_disciplina_codigo from aula as A WHERE A.turma_id = Turma AND A.turma_disciplina_codigo = Diciplina LIMIT 1;
            END IF;

        END LOOP;
    CLOSE curs1;


END //

DELIMITER ;

-- CALL professorLegal('A','CIC0124');
