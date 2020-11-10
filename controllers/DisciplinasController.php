<?php

require_once('Config.php');

require_once('Conn.php');

class DisciplinasController {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function get(){
        $retorno = $this->conn->query('SELECT * FROM disciplina');

        if($retorno && $retorno->num_rows > 0){

            $arrayDisciplina = array();

            for($i = 0; $i < $retorno->num_rows; $i++){

                $arrayDisciplina[] = $retorno->fetch_object();

            }
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>$arrayDisciplina));

        }else{

            if($retorno && $retorno->num_rows == 0){
                $this->conn->close();
                return json_encode(array('status'=>'sucesso','dados'=>array()));

            }
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhuma disciplina retornada!'));

        }

    }

    function insert($codigo = '', $nome = ''){ 
        if($codigo == '' || $nome == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("INSERT INTO disciplina (codigo, nome) VALUES ('".$this->conn->real_escape_string($codigo)."', '".$this->conn->real_escape_string($nome)."')");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Disciplina '.$codigo.' inserida na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao inserir o Disciplina na tabela!'));
        }
    }

    function delete($codigo = ''){ 
        if($codigo == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("DELETE FROM disciplina WHERE codigo = '".$this->conn->real_escape_string($codigo)."'");
        if($retorno && $this->conn->affected_rows > 0){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Disciplina '.$codigo.' deletada da tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao deletar a disciplina da tabela!'));
        }
    }
}