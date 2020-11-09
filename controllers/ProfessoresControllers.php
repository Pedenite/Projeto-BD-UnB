<?php

require_once('Config.php');

require_once('Conn.php');

class ProfessoresControllers {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function getProfessores(){
        $retorno = $this->conn->query('SELECT * FROM professor');

        if($retorno && $retorno->num_rows > 0){

            $arrayProfessor = array();

            for($i = 0; $i < $retorno->num_rows; $i++){

                $arrayProfessor[] = $retorno->fetch_object();

            }
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>$arrayProfessor));

        }else{

            if($retorno && $retorno->num_rows == 0){
                $this->conn->close();
                return json_encode(array('status'=>'sucesso','dados'=>array()));

            }
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhum professor retornado!'));

        }

    }
    
    function insertProfessor($matricula = '', $nome = '', $email = '', $departamento = ''){ 
        if($matricula == '' || $nome == '' || $email == '' || $departamento == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("INSERT INTO `professor` (`matricula`, `nome`, `email`, `departamento_codigo`) VALUES ('".$this->conn->real_escape_string($matricula)."', '".$this->conn->real_escape_string($nome)."', '".$this->conn->real_escape_string($email)."', '".$this->conn->real_escape_string($departamento)."')");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Professor '.$matricula.' inserido na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao inserir o professor na tabela!'));
        }
    }

    function deleteProfessor($matricula = ''){ 
        if($matricula == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("DELETE FROM professor WHERE matricula = '".$this->conn->real_escape_string($matricula)."'");
        if($retorno && $this->conn->affected_rows > 0){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Professor '.$matricula.' deletado da tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao deletar o professor da tabela!'));
        }
    }
}