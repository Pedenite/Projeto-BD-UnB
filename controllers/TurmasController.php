<?php

require_once('Config.php');

require_once('Conn.php');

class TurmasController {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function get(){
        $retorno = $this->conn->query('SELECT * FROM turma');

        if($retorno && $retorno->num_rows > 0){

            $arrayTurma = array();

            for($i = 0; $i < $retorno->num_rows; $i++){

                $arrayTurma[] = $retorno->fetch_object();

            }
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>$arrayTurma));

        }else{

            if($retorno && $retorno->num_rows == 0){
                $this->conn->close();
                return json_encode(array('status'=>'sucesso','dados'=>array()));

            }
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhuma turma retornado!'));

        }

    }

    function insert($id = '', $horario = '', $diciplina = ''){ 
        if($id == '' || $horario == '' || $diciplina == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("INSERT INTO `turma` (`id`,`horario`,`disciplina_codigo`) VALUES ('".$this->conn->real_escape_string($id)."','".$this->conn->real_escape_string($horario)."','".$this->conn->real_escape_string($diciplina)."');");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Turmas '.$id.' inserida na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao inserir a turmas na tabela!'));
        }
    }

    function delete($id = '', $diciplina = ''){ 
        if($id == '' || $diciplina == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("DELETE FROM `turma` WHERE id = '".$this->conn->real_escape_string($id)."' AND disciplina_codigo = '".$this->conn->real_escape_string($diciplina)."';");
        if($retorno && $this->conn->affected_rows > 0){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Turmas '.$id.' deletada da tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao deletar a turmas da tabela!'));
        }
    }

    function update($pkid = '', $pkdisciplina = '', $id = '', $disciplina = '', $horario = ''){ 
        if($pkid == '' || $pkdisciplina == '' || $id == '' && $disciplina == '' && $horario == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        
        $linhas = $this->conn->query("SELECT * FROM `turma` WHERE id = '".$this->conn->real_escape_string($pkid)."' AND disciplina_codigo = '".$this->conn->real_escape_string($pkdiciplina)."'");
        if($linhas->num_rows == 0){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhum registro retornado pela chave.'));
        }

        $virgula = '';
        if($id != ''){
            $id = "id = '{$this->conn->real_escape_string($id)}'";
            $virgula = ',';
        }
        if($disciplina != ''){
            $disciplina = "disciplina_codigo = '{$this->conn->real_escape_string($disciplina)}'";
            $virgula = ',';
        }
        $horario = $horario != "" ? "{$virgula} horario = '{$this->conn->real_escape_string($horario)}'" : "";

        $retorno = $this->conn->query("UPDATE `turma` SET {$id} {$disciplina} {$horario} WHERE id = '".$this->conn->real_escape_string($pkid)."' AND disciplina_codigo = '".$this->conn->real_escape_string($pkdiciplina)."'");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Registro atualizado na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao atualizar o registro na tabela!'));
        }
    }
}