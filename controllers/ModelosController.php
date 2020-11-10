<?php

require_once('Config.php');

require_once('Conn.php');

class ModelosController {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function get(){
        $retorno = $this->conn->query('SELECT * FROM --');

        if($retorno && $retorno->num_rows > 0){

            $arrayModelo = array();

            for($i = 0; $i < $retorno->num_rows; $i++){

                $arrayModelo[] = $retorno->fetch_object();

            }
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>$arrayModelo));

        }else{

            if($retorno && $retorno->num_rows == 0){
                $this->conn->close();
                return json_encode(array('status'=>'sucesso','dados'=>array()));

            }
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhum modelo retornado!'));

        }

    }

    function insert($identidade = ''){ 
        if($identidade == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        //$this->conn->real_escape_string($identidade)
        $retorno = $this->conn->query("INSERT INTO --");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Modelo '.$identidade.' inserido na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao inserir o modelo na tabela!'));
        }
    }

    function delete($identidade = ''){ 
        if($identidade == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("DELETE FROM --");
        if($retorno && $this->conn->affected_rows > 0){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Modelo '.$identidade.' deletado da tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao deletar o modelo da tabela!'));
        }
    }
}