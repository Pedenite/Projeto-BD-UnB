<?php

require_once('Config.php');

require_once('Conn.php');

class AlunosControllers {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function getAlunos(){
        $retorno = $this->conn->query('SELECT * FROM aluno');

        if($retorno){

            $arratAluno = array();

            for($i = 0; $i < $retorno->num_rows; $i++){

                $arratAluno[] = $retorno->fetch_object();

            }

            return json_encode(array('status'=>'sucesso','dados'=>$arratAluno));

        }
    }
}