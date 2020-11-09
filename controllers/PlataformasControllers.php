<?php

require_once('Config.php');

require_once('Conn.php');

class PlataformasControllers {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function getPlataformas(){
        $retorno = $this->conn->query('SELECT * FROM plataforma');

        if($retorno && $retorno->num_rows > 0){

            $arrayPlataforma = array();

            for($i = 0; $i < $retorno->num_rows; $i++){

                $arrayPlataforma[] = $retorno->fetch_object();

            }
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>$arrayPlataforma));

        }else{

            if($retorno && $retorno->num_rows == 0){
                $this->conn->close();
                return json_encode(array('status'=>'sucesso','dados'=>array()));

            }
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhuma plataforma retornada!'));

        }

    }

    function insertPlataforma($nome = ''){ 
        if($nome == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("INSERT INTO plataforma(nome) VALUES ('".$this->conn->real_escape_string($nome)."')");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Plataforma '.$nome.' inserido na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao inserir a plataforma na tabela!'));
        }
    }

    function deletePlataforma($id = ''){ 
        if($id == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("DELETE FROM plataforma WHERE id = '".$this->conn->real_escape_string($id)."'");
        if($retorno && $this->conn->affected_rows > 0){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Plataforma '.$id.' deletada da tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao deletar a plataforma da tabela!'));
        }
    }
}