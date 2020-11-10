<?php

require_once('Config.php');

require_once('Conn.php');

class ParticipacoesController {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function get(){
        $retorno = $this->conn->query('SELECT * FROM participacao');

        if($retorno && $retorno->num_rows > 0){

            $arrayParticipacao = array();

            for($i = 0; $i < $retorno->num_rows; $i++){

                $arrayParticipacao[] = $retorno->fetch_object();

            }
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>$arrayParticipacao));

        }else{

            if($retorno && $retorno->num_rows == 0){
                $this->conn->close();
                return json_encode(array('status'=>'sucesso','dados'=>array()));

            }
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhuma participacao retornada!'));

        }

    }

    function insert($tempo = '', $aluno = '', $tipo = '', $aula = '', $turma = '', $disciplina = ''){ 
        if($aluno == '' || $tipo == '' || $aula == '' || $turma == '' || $disciplina == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $tempo = $tempo != "" ? "'{$this->conn->real_escape_string($tempo)}'" : "null";
        $retorno = $this->conn->query("INSERT INTO participacao (tempo, aluno_matricula, tipo_participacao_id, aula_numero, aula_turma_id, aula_turma_disciplina_codigo) VALUES (".$tempo.", '".$this->conn->real_escape_string($aluno)."', '".$this->conn->real_escape_string($tipo)."', '".$this->conn->real_escape_string($aula)."', '".$this->conn->real_escape_string($turma)."', '".$this->conn->real_escape_string($disciplina)."')");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Participacao inserida na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao inserir a participacao na tabela!'));
        }
    }

    function delete($id = ''){ 
        if($id == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("DELETE FROM participacao WHERE id = '".$this->conn->real_escape_string($id)."'");
        if($retorno && $this->conn->affected_rows > 0){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Participacao '.$id.' deletada da tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao deletar a participacao da tabela!'));
        }
    }
}