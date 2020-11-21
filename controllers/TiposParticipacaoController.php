<?php

require_once('Config.php');

require_once('Conn.php');

class TiposParticipacaoController {

    function __construct(){

        $this->conn = new Conn(HOST,USUARIO,SENHA,DB);

    }
    function get(){
        $retorno = $this->conn->query('SELECT * FROM tipo_participacao');

        if($retorno && $retorno->num_rows > 0){

            $arrayTipoParticipacao = array();

            for($i = 0; $i < $retorno->num_rows; $i++){

                $arrayTipoParticipacao[] = $retorno->fetch_object();

            }
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>$arrayTipoParticipacao));

        }else{

            if($retorno && $retorno->num_rows == 0){
                $this->conn->close();
                return json_encode(array('status'=>'sucesso','dados'=>array()));

            }
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhum tipo de participacao retornado!'));

        }

    }

    function insert($tipo = '', $pontuacao = '', $porTempo = ''){ 
        if($tipo == '' || $pontuacao == '' || $porTempo == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("INSERT INTO tipo_participacao (tipo, pontuacao, pontuacao_por_tempo) VALUES ('".$this->conn->real_escape_string($tipo)."', '".$this->conn->real_escape_string($pontuacao)."', '".$this->conn->real_escape_string($porTempo)."')");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Tipo de participacao '.$tipo.' inserido na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao inserir o tipo de participacao na tabela!'));
        }
    }

    function delete($id = ''){ 
        if($id == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        $retorno = $this->conn->query("DELETE FROM tipo_participacao WHERE id = '".$this->conn->real_escape_string($id)."'");
        if($retorno && $this->conn->affected_rows > 0){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Tipo de participacao '.$id.' deletado da tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao deletar o tipo de participacao da tabela!'));
        }
    }

    function update($pkid = '', $tipo = '', $pontuacao = '', $porTempo = ''){ 
        if($pkid == '' || $tipo == '' && $pontuacao == '' && $porTempo == ''){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Parametros insuficientes!'));
        }
        
        $linhas = $this->conn->query("SELECT * FROM `tipo_participacao` WHERE id = '".$this->conn->real_escape_string($pkid)."'");
        if($linhas->num_rows == 0){
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Nenhum registro retornado pela chave.'));
        }

        $virgula = '';
        if($tipo != ''){
            $tipo = "tipo = '{$this->conn->real_escape_string($tipo)}'";
            $virgula = ',';
        }
        if($pontuacao != ''){
            $pontuacao = "pontuacao = '{$virgula} {$this->conn->real_escape_string($pontuacao)}'";
            $virgula = ',';
        }
        $porTempo = $porTempo != "" ? "{$virgula} pontuacao_por_tempo = '{$this->conn->real_escape_string($porTempo)}'" : "";

        $retorno = $this->conn->query("UPDATE `tipo_participacao` SET {$tipo} {$pontuacao} {$porTempo} WHERE id = '".$this->conn->real_escape_string($pkid)."'");
        if($retorno){
            $this->conn->close();
            return json_encode(array('status'=>'sucesso','dados'=>'Registro atualizado na tabela.'));
        }else{
            $this->conn->close();
            return json_encode(array('status'=>'erro','dados'=>'Erro ao atualizar o registro na tabela!'));
        }
    }
}