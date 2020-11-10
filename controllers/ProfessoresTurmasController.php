<?php

require_once('Config.php');

require_once('Conn.php');

class ProfessoresTurmasController {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function getProfessoresTurmas(){
        $retorno = $this->conn->query('SELECT * FROM professor_turma');

        if($retorno && $retorno->num_rows > 0){

            $arrayProfessorTurma = array();

            for($i = 0; $i < $retorno->num_rows; $i++){

                $arrayProfessorTurma[] = $retorno->fetch_object();

            }
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>$arrayProfessorTurma));

        }else{

            if($retorno && $retorno->num_rows == 0){
                $this->conn->close();
                return json_encode(array('status'=>'sucesso','dados'=>array()));

            }
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhuma relação de professores com turmas retornadas!'));

        }

    }

    function insertProfessorTurma($professor = '', $turma = '', $disciplina = '', $substituto = ''){ 
        if($professor == '' || $turma == '' || $disciplina == '' || $substituto == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("INSERT INTO professor_turma (professor_matricula, turma_id, turma_disciplina_codigo, e_substituto) VALUES ('".$this->conn->real_escape_string($professor)."', '".$this->conn->real_escape_string($turma)."', '".$this->conn->real_escape_string($disciplina)."', '".$this->conn->real_escape_string($substituto)."')");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Relação de professor '.$professor.' com a turma '.$turma.' inserida na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao inserir a relação do professor com a turma na tabela!'));
        }
    }

    function deleteProfessorTurma($professor = '', $turma = '', $disciplina = ''){ 
        if($professor == '' || $turma == '' || $disciplina == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("DELETE FROM professor_turma WHERE professor_matricula = '".$this->conn->real_escape_string($professor)."' AND turma_id = '".$this->conn->real_escape_string($turma)."' AND turma_disciplina_codigo = '".$this->conn->real_escape_string($disciplina)."'");
        if($retorno && $this->conn->affected_rows > 0){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Relação do professor '.$professor.' com a turma '.$turma.' deletada da tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao deletar a relação do professor com a turma da tabela!'));
        }
    }
}