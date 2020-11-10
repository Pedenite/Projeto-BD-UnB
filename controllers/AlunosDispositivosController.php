<?php

require_once('Config.php');

require_once('Conn.php');

class AlunosDispositivosController {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function getAlunosDispositivos(){
        $retorno = $this->conn->query('SELECT * FROM aluno_dispositivo');

        if($retorno && $retorno->num_rows > 0){

            $arrayAlunoDispositivo = array();

            for($i = 0; $i < $retorno->num_rows; $i++){

                $arrayAlunoDispositivo[] = $retorno->fetch_object();

            }
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>$arrayAlunoDispositivo));

        }else{

            if($retorno && $retorno->num_rows == 0){
                $this->conn->close();
                return json_encode(array('status'=>'sucesso','dados'=>array()));

            }
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhuma relação de alunos com dispositivos retornadas!'));

        }

    }

    function insertAlunoDispositivo($aluno = '', $dispositivo = '', $disponibilidade = ''){ 
        if($aluno == '' || $dispositivo == '' || $disponibilidade == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("INSERT INTO aluno_dispositivo (aluno_matricula, dispositivo_id, disponibilidade) VALUES ('".$this->conn->real_escape_string($aluno)."', '".$this->conn->real_escape_string($dispositivo)."', '".$this->conn->real_escape_string($disponibilidade)."')");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Relação do aluno '.$aluno.' com o dispositivo '.$dispositivo.' inserido na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao inserir a relação de aluno com dispositivo na tabela!'));
        }
    }

    function deleteAlunoDispositivo($aluno = '', $dispositivo = ''){ 
        if($aluno == '' || $dispositivo == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("DELETE FROM aluno_dispositivo WHERE aluno_matricula = '".$this->conn->real_escape_string($aluno)."' AND dispositivo_id = '".$this->conn->real_escape_string($dispositivo)."'");
        if($retorno && $this->conn->affected_rows > 0){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Relação do aluno '.$aluno.' com o dispositivo '.$dispositivo.' deletado da tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao deletar a relação de aluno com dispositivo da tabela!'));
        }
    }
}