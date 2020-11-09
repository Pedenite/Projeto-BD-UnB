<?php

require_once('Config.php');

require_once('Conn.php');

class RecursosControllers {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function getRecursos(){
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

    function insertRecurso($recurso = '', $plataforma = ''){ 
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

    function deleteRecurso($recurso = '', $plataforma = ''){ 
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
}