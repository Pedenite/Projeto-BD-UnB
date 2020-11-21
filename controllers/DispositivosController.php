<?php

require_once('Config.php');

require_once('Conn.php');

class DispositivosController {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function get(){
        $retorno = $this->conn->query('SELECT * FROM dispositivo');

        if($retorno && $retorno->num_rows > 0){

            $arrayDispositivo = array();

            for($i = 0; $i < $retorno->num_rows; $i++){

                $arrayDispositivo[] = $retorno->fetch_object();

            }
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>$arrayDispositivo));

        }else{

            if($retorno && $retorno->num_rows == 0){
                $this->conn->close();
                return json_encode(array('status'=>'sucesso','dados'=>array()));

            }
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhum dispositivo retornado!'));

        }

    }

    function insert($nome = ''){ 
        if($nome == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("INSERT INTO `dispositivo` (`descricao`) VALUES ('".$this->conn->real_escape_string($nome)."');");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Dispositivo '.$nome.' inserido na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao inserir o dispositivo na tabela!'));
        }
    }

    function delete($id = ''){ 
        if($id == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("DELETE FROM `dispositivo` WHERE id = '".$this->conn->real_escape_string($id)."';");
        if($retorno && $this->conn->affected_rows > 0){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Dispositivo '.$id.' deletado da tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao deletar o dispositivo da tabela!'));
        }
    }

    function update($pkid = '', $id = '', $nome = ''){ 
        if($pkid == '' || $id == '' && $nome == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        
        $linhas = $this->conn->query("SELECT * FROM `dispositivo` WHERE id = '".$this->conn->real_escape_string($pkid)."'");
        if($linhas->num_rows == 0){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhum registro retornado pela chave.'));
        }

        $virgula = '';
        if($id != ''){
            $id = "id = '{$this->conn->real_escape_string($id)}'";
            $virgula = ',';
        }
        $nome = $nome != "" ? "{$virgula} nome = '{$this->conn->real_escape_string($nome)}'" : "";

        $retorno = $this->conn->query("UPDATE `dispositivo` SET {$id} {$nome} WHERE id = '".$this->conn->real_escape_string($pkid)."'");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Registro atualizado na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao atualizar o registro na tabela!'));
        }
    }
}