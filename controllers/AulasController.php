<?php

require_once('Config.php');

require_once('Conn.php');

class AulasController {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function get(){
        $retorno = $this->conn->query('SELECT * FROM aula');

        if($retorno && $retorno->num_rows > 0){

            $arrayAula = array();

            for($i = 0; $i < $retorno->num_rows; $i++){

                $arrayAula[] = $retorno->fetch_object();

            }
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>$arrayAula));

        }else{

            if($retorno && $retorno->num_rows == 0){
                $this->conn->close();
                return json_encode(array('status'=>'sucesso','dados'=>array()));

            }
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhuma aula retornado!'));

        }

    }

    function insert($numero = '', $data = '', $duracao = '', $sincrona = '', $turma = '', $disciplina = '', $plataforma = ''){ 
        if($numero == '' || $data == '' || $turma == '' || $disciplina == '' || $plataforma == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $duracao = $duracao != "" ? "'{$this->conn->real_escape_string($duracao)}'" : "null";
        $retorno = $this->conn->query("INSERT INTO aula(numero, data, duracao, e_sincrona, turma_id, turma_disciplina_codigo, plataforma_id) VALUES ('".$this->conn->real_escape_string($numero)."', '".$this->conn->real_escape_string($data)."', ".$duracao.", '".$this->conn->real_escape_string($sincrona)."', '".$this->conn->real_escape_string($turma)."', '".$this->conn->real_escape_string($disciplina)."', '".$this->conn->real_escape_string($plataforma)."')");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Aula '.$numero.' inserida na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao inserir a aula na tabela!'));
        }
    }

    function delete($numero = '', $turma = '', $disciplina = ''){ 
        if($numero == '' || $turma == '' || $disciplina == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("DELETE FROM aula WHERE numero = '".$this->conn->real_escape_string($numero)."' AND turma_id = '".$this->conn->real_escape_string($turma)."' AND turma_disciplina_codigo = '".$this->conn->real_escape_string($disciplina)."'");
        if($retorno && $this->conn->affected_rows > 0){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Aula '.$numero.' deletada da tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao deletar a aula da tabela!'));
        }
    }

    function update($pknumero = '', $pkturma = '', $pkdisciplina = '', $numero = '', $data = '', $duracao = '', $sincrona = '', $turma = '', $disciplina = '', $plataforma = ''){ 
        if($pknumero == '' || $pkturma == '' || $pkdisciplina == '' || $numero == '' && $data == '' && $duracao == '' && $sincrona == '' && $turma == '' && $disciplina == '' && $plataforma == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        
        $linhas = $this->conn->query("SELECT * FROM aula WHERE numero = '".$this->conn->real_escape_string($pknumero)."' AND turma_id = '".$this->conn->real_escape_string($pkturma)."' AND turma_disciplina_codigo = '".$this->conn->real_escape_string($pkdisciplina)."'");
        if($linhas->num_rows == 0){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhum registro retornado pela chave.'));
        }

        $virgula = '';
        if($numero != ''){
            $numero = "numero = '{$this->conn->real_escape_string($numero)}'";
            $virgula = ',';
        }
        if($data != ''){
            $data = "{$virgula} data_id = '{$this->conn->real_escape_string($data)}'";
            $virgula = ',';
        }
        if($duracao != ''){
            $duracao = "{$virgula} duracao = '{$this->conn->real_escape_string($duracao)}'";
            $virgula = ',';
        }
        if($sincrona != ''){
            $sincrona = "{$virgula} e_sincrona = '{$this->conn->real_escape_string($sincrona)}'";
            $virgula = ',';
        }
        if($turma != ''){
            $turma = "{$virgula} turma_id = '{$this->conn->real_escape_string($turma)}'";
            $virgula = ',';
        }
        if($disciplina != ''){
            $disciplina = "{$virgula} turma_disciplina_codigo = '{$this->conn->real_escape_string($disciplina)}'";
            $virgula = ',';
        }
        $plataforma = $plataforma != "" ? "{$virgula} plataforma_id = '{$this->conn->real_escape_string($plataforma)}'" : "";

        $retorno = $this->conn->query("UPDATE `aula` SET {$numero} {$data} {$duracao} {$sincrona} {$turma} {$disciplina} {$plataforma} WHERE numero = '".$this->conn->real_escape_string($pknumero)."' AND turma_id = '".$this->conn->real_escape_string($pkturma)."' AND turma_disciplina_codigo = '".$this->conn->real_escape_string($pkdisciplina)."'");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Registro atualizado na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao atualizar o registro na tabela!'));
        }
    }
}