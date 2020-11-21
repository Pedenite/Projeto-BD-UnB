<?php

require_once('Config.php');

require_once('Conn.php');

class ProfessoresController {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function get(){
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
    
    function insert($matricula = '', $nome = '', $email = '', $departamento = ''){ 
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

    function delete($matricula = ''){ 
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

    function update($pkmatricula = '', $matricula = '', $nome = '', $email = '', $departamento = ''){ 
        if($pkmatricula == '' || $matricula == '' && $nome == '' && $email == '' && $departamento == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        
        $linhas = $this->conn->query("SELECT * FROM professor WHERE matricula = '".$this->conn->real_escape_string($pkmatricula)."'");
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
        if($email != ''){
            $email = "{$virgula} email = '{$this->conn->real_escape_string($email)}'";
            $virgula = ',';
        }
        $departamento = $departamento != "" ? "{$virgula} departamento_codigo = '{$this->conn->real_escape_string($departamento)}'" : "";

        $retorno = $this->conn->query("UPDATE `professor` SET {$matricula} {$nome} {$email} {$departamento} WHERE matricula = '".$this->conn->real_escape_string($pkmatricula)."';");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Registro atualizado na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao atualizar o registro na tabela!'));
        }
    }
}