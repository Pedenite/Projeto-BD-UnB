<?php

require_once('Config.php');

require_once('Conn.php');

class ModelosControllers {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function getModelos(){
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

    function insertModelo($id = ''){ 
        if($id == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        //$this->conn->real_escape_string($id)
        $retorno = $this->conn->query("INSERT --");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Modelo '.$id.' inserido na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao inserir o modelo na tabela!'));
        }
    }

    function deleteModelo($id = ''){ 
        if($id == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("DELETE --");
        if($retorno && $this->conn->affected_rows > 0){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Modelo '.$id.' deletado da tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao deletar o modelo da tabela!'));
        }
    }
}