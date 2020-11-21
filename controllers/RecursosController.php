<?php

require_once('Config.php');

require_once('Conn.php');

class RecursosController {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function get(){
        $retorno = $this->conn->query('SELECT * FROM recurso');

        if($retorno && $retorno->num_rows > 0){

            $arrayRecurso = array();

            for($i = 0; $i < $retorno->num_rows; $i++){

                $arrayRecurso[] = $retorno->fetch_object();

            }
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>$arrayRecurso));

        }else{

            if($retorno && $retorno->num_rows == 0){
                $this->conn->close();
                return json_encode(array('status'=>'sucesso','dados'=>array()));

            }
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhum recurso retornado!'));

        }

    }

    function insert($recurso = '', $plataforma = ''){ 
        if($recurso == '' || $plataforma == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("INSERT INTO recurso(recurso, plataforma_id) VALUES ('".$this->conn->real_escape_string($recurso)."', '".$this->conn->real_escape_string($plataforma)."')");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Recurso '.$recurso.' inserido na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao inserir o recurso na tabela!'));
        }
    }

    function delete($recurso = '', $plataforma = ''){ 
        if($recurso == '' || $plataforma == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("DELETE FROM recurso WHERE recurso = '".$this->conn->real_escape_string($recurso)."' AND plataforma_id = '".$this->conn->real_escape_string($plataforma)."'");
        if($retorno && $this->conn->affected_rows > 0){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Recurso '.$recurso.' deletado da tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao deletar o recurso da tabela!'));
        }
    }

    function update($pkrecurso = '', $pkplataforma = '', $recurso = '', $plataforma = ''){ 
        if($pkrecurso == '' || $pkplataforma == '' || $recurso == '' && $plataforma == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        
        $linhas = $this->conn->query("SELECT * FROM `recurso` WHERE recurso = '".$this->conn->real_escape_string($pkrecurso)."' AND plataforma_id = '".$this->conn->real_escape_string($pkplataforma)."'");
        if($linhas->num_rows == 0){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhum registro retornado pela chave.'));
        }

        $virgula = '';
        if($recurso != ''){
            $recurso = "recurso = '{$this->conn->real_escape_string($recurso)}'";
            $virgula = ',';
        }
        $plataforma = $plataforma != "" ? "{$virgula} plataforma = '{$this->conn->real_escape_string($plataforma)}'" : "";

        $retorno = $this->conn->query("UPDATE `recurso` SET {$recurso} {$plataforma} WHERE recurso = '".$this->conn->real_escape_string($pkrecurso)."' AND plataforma_id = '".$this->conn->real_escape_string($pkplataforma)."'");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Registro atualizado na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao atualizar o registro na tabela!'));
        }
    }
}