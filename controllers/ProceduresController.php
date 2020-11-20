<?php

require_once('Config.php');

require_once('Conn.php');

class ProceduresController {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function proc1(){
        $retorno = $this->conn->query('EXEC proc1');

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

    function proc2(){ 
        $retorno = $this->conn->query('EXEC proc2');

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