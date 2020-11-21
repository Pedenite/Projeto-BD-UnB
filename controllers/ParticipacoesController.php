<?php

require_once('Config.php');

require_once('Conn.php');

class ParticipacoesController {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function get(){
        $retorno = $this->conn->query('SELECT * FROM participacao');

        if($retorno && $retorno->num_rows > 0){

            $arrayParticipacao = array();

            for($i = 0; $i < $retorno->num_rows; $i++){

                $arrayParticipacao[] = $retorno->fetch_object();

            }
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>$arrayParticipacao));

        }else{

            if($retorno && $retorno->num_rows == 0){
                $this->conn->close();
                return json_encode(array('status'=>'sucesso','dados'=>array()));

            }
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhuma participacao retornada!'));

        }

    }

    function insert($tempo = '', $aluno = '', $tipo = '', $aula = '', $turma = '', $disciplina = ''){ 
        if($aluno == '' || $tipo == '' || $aula == '' || $turma == '' || $disciplina == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $tempo = $tempo != "" ? "'{$this->conn->real_escape_string($tempo)}'" : "null";
        $retorno = $this->conn->query("INSERT INTO participacao (tempo, aluno_matricula, tipo_participacao_id, aula_numero, aula_turma_id, aula_turma_disciplina_codigo) VALUES (".$tempo.", '".$this->conn->real_escape_string($aluno)."', '".$this->conn->real_escape_string($tipo)."', '".$this->conn->real_escape_string($aula)."', '".$this->conn->real_escape_string($turma)."', '".$this->conn->real_escape_string($disciplina)."')");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Participacao inserida na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao inserir a participacao na tabela!'));
        }
    }

    function delete($id = ''){ 
        if($id == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("DELETE FROM participacao WHERE id = '".$this->conn->real_escape_string($id)."'");
        if($retorno && $this->conn->affected_rows > 0){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Participacao '.$id.' deletada da tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao deletar a participacao da tabela!'));
        }
    }

    function update($pkid = '', $tempo = '', $aluno = '', $tipo = '', $aula = '', $turma = '', $disciplina = ''){ 
        if($pkid == '' || $tempo == '' && $aluno == '' && $tipo == '' && $aula == '' && $turma == '' && $disciplina == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        
        $linhas = $this->conn->query("SELECT * FROM participacao WHERE id = '".$this->conn->real_escape_string($pkid)."'");
        if($linhas->num_rows == 0){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhum registro retornado pela chave.'));
        }

        $virgula = '';
        if($tempo != ''){
            $tempo = "{$virgula} tempo_id = '{$this->conn->real_escape_string($tempo)}'";
            $virgula = ',';
        }
        if($aluno != ''){
            $aluno = "{$virgula} aluno_matricula = '{$this->conn->real_escape_string($aluno)}'";
            $virgula = ',';
        }
        if($tipo != ''){
            $tipo = "{$virgula} tipo_participacao_id = '{$this->conn->real_escape_string($tipo)}'";
            $virgula = ',';
        }
        if($aula != ''){
            $aula = "{$virgula} aula_numero = '{$this->conn->real_escape_string($aula)}'";
            $virgula = ',';
        }
        if($turma != ''){
            $turma = "{$virgula} aula_turma_id = '{$this->conn->real_escape_string($turma)}'";
            $virgula = ',';
        }
        $disciplina = $disciplina != "" ? "{$virgula} aula_turma_disciplina_codigo = '{$this->conn->real_escape_string($disciplina)}'" : "";

        $retorno = $this->conn->query("UPDATE `participacao` SET {$tempo} {$aluno} {$tipo} {$aula} {$turma} {$disciplina} WHERE id = '".$this->conn->real_escape_string($pknumero)."'");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Registro atualizado na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao atualizar o registro na tabela!'));
        }
    }
}