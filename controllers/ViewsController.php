<?php

require_once('Config.php');

require_once('Conn.php');

class ViewsController {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function pessoas(){
        $retorno = $this->conn->query('SELECT * FROM pessoas');

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

    function participacao_info(){ 
        $retorno = $this->conn->query('SELECT * FROM participacao_info');

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

    function disciplinas_sem_aulas(){ 
        $retorno = $this->conn->query('SELECT * FROM disciplinas_sem_aulas');

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
}