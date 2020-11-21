<?php

require_once('Config.php');

require_once('Conn.php');

class ProceduresController {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function pontosExtras($turma = '', $disciplina = ''){
        if($turma == '' || $disciplina == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }

        $retorno = $this->conn->query("CALL professorLegal('".$this->conn->real_escape_string($turma)."','".$this->conn->real_escape_string($disciplina)."')");

        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Pontos extras computados.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao computar pontos extras!'));
        }
    }
}