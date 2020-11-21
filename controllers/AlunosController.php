<?php

require_once('Config.php');

require_once('Conn.php');

class AlunosController {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function get(){
        $retorno = $this->conn->query('SELECT * FROM aluno');

        if($retorno && $retorno->num_rows > 0){

            $arrayAluno = array();

            for($i = 0; $i < $retorno->num_rows; $i++){

                $arrayAluno[] = $retorno->fetch_object();

            }
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>$arrayAluno));

        }else{

            if($retorno && $retorno->num_rows == 0){
                $this->conn->close();
                return json_encode(array('status'=>'sucesso','dados'=>array()));

            }
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhum aluno retornado!'));

        }

    }

    function insert($matricula = '', $nome = '', $email = ''){ 
        if($matricula == ''|| $nome == ''|| $email == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("INSERT INTO `aluno` (`matricula`,`nome`,`email`) VALUES ('".$this->conn->real_escape_string($matricula)."','".$this->conn->real_escape_string($nome)."','".$this->conn->real_escape_string($email)."');");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Aluno '.$nome.' inserido na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao inserir o aluno na tabela!'));
        }
    }

    function delete($matricula = ''){ 
        if($matricula == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("DELETE FROM `aluno` WHERE `matricula` = '".$this->conn->real_escape_string($matricula)."';");
        if($retorno && $this->conn->affected_rows > 0){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Aluno '.$matricula.' deletado da tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao deletar o aluno da tabela!'));
        }
    }

    function update($pkmatricula = '', $matricula = '', $nome = '', $email = ''){ 
        if($pkmatricula == '' || $matricula == '' && $nome == '' && $email == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        
        $linhas = $this->conn->query("SELECT * FROM aluno WHERE matricula = '".$this->conn->real_escape_string($pkmatricula)."'");
        if($linhas->num_rows == 0){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhum registro retornado pela chave.'));
        }

        $virgula = '';
        if($matricula != ''){
            $matricula = "matricula = '{$this->conn->real_escape_string($matricula)}'";
            $virgula = ',';
        }
        if($nome != ''){
            $nome = "{$virgula} nome = '{$this->conn->real_escape_string($nome)}'";
            $virgula = ',';
        }
        $email = $email != "" ? "{$virgula} email = '{$this->conn->real_escape_string($email)}'" : "";

        $retorno = $this->conn->query("UPDATE `aluno` SET {$matricula} {$nome} {$email} WHERE matricula = '".$this->conn->real_escape_string($pkmatricula)."';");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Registro atualizado na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao atualizar o registro na tabela!'));
        }
    }
}