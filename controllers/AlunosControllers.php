<?php

require_once('Config.php');

require_once('Conn.php');

class AlunosControllers {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function getAlunos(){
        $retorno = $this->conn->query('SELECT * FROM aluno');

        if($retorno && $retorno->num_rows > 0){

            $arratAluno = array();

            for($i = 0; $i < $retorno->num_rows; $i++){

                $arratAluno[] = $retorno->fetch_object();

            }

            return json_encode(array('status'=>'sucesso','dados'=>$arratAluno));

        }else{

            if($retorno && $retorno->num_rows == 0){

                return json_encode(array('status'=>'sucesso','dados'=>array()));

            }

            return json_encode(array('status'=>'erro','dados'=>'Nenhum aluno retornado!'));

        }

    }

    function insertAluno($matricula = '', $nome = '', $email = ''){ 
        if($matricula == ''|| $nome == ''|| $email == ''){
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("INSERT INTO `aluno` (`matricula`,`nome`,`email`) VALUES ('".$this->conn->real_escape_string($matricula)."','".$this->conn->real_escape_string($nome)."','".$this->conn->real_escape_string($email)."');");
        if($retorno){
            return json_encode(array('status'=>'sucesso','dados'=>'Aluno '.$nome.' inserido na tabela.'));
        }else{
            return json_encode(array('status'=>'erro','dados'=>'Erro ao inserir aluno na tabela!'));
        }
    }

    function deleteAluno($matricula = ''){ 
        if($matricula == ''){
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("DELETE FROM `aluno` WHERE `matricula` = '".$this->conn->real_escape_string($matricula)."';");
        if($retorno){
            return json_encode(array('status'=>'sucesso','dados'=>'Aluno '.$matricula.' deletado da tabela.'));
        }else{
            return json_encode(array('status'=>'erro','dados'=>'Erro ao deletar aluno da tabela!'));
        }
    }
}