<?php

require_once('Config.php');

require_once('Conn.php');

class DepartamentosController {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function get(){
        $retorno = $this->conn->query('SELECT * FROM departamento');

        if($retorno && $retorno->num_rows > 0){

            $arrayDepartamento = array();

            for($i = 0; $i < $retorno->num_rows; $i++){

                $arrayDepartamento[] = $retorno->fetch_object();

            }
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>$arrayDepartamento));

        }else{

            if($retorno && $retorno->num_rows == 0){
                $this->conn->close();
                return json_encode(array('status'=>'sucesso','dados'=>array()));

            }
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhum departamento retornado!'));

        }

    }

    function insert($codigo = '', $nome = ''){ 
        if($codigo == '' || $nome == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("INSERT INTO `departamento` (`codigo`,`nome`) VALUES ('".$this->conn->real_escape_string($codigo)."', '".$this->conn->real_escape_string($nome)."');");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Departamento '.$nome.' inserido na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao inserir o departamento na tabela!'));
        }
    }

    function delete($codigo = ''){ 
        if($codigo == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("DELETE FROM `departamento` WHERE codigo = '".$this->conn->real_escape_string($codigo)."';");
        if($retorno && $this->conn->affected_rows > 0){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Departamento '.$codigo.' deletado da tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao deletar o departamento da tabela!'));
        }
    }

    function update($pkcodigo = '', $codigo = '', $nome = ''){ 
        if($pkcodigo == '' || $codigo == '' && $nome == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        
        $linhas = $this->conn->query("SELECT * FROM `departamento` WHERE codigo = '".$this->conn->real_escape_string($pkcodigo)."'");
        if($linhas->num_rows == 0){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhum registro retornado pela chave.'));
        }

        $virgula = '';
        if($codigo != ''){
            $codigo = "codigo = '{$this->conn->real_escape_string($codigo)}'";
            $virgula = ',';
        }
        $nome = $nome != "" ? "{$virgula} nome = '{$this->conn->real_escape_string($nome)}'" : "";

        $retorno = $this->conn->query("UPDATE `departamento` SET {$codigo} {$nome} WHERE codigo = '".$this->conn->real_escape_string($pkcodigo)."'");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Registro atualizado na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao atualizar o registro na tabela!'));
        }
    }
}