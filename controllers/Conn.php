<?php 

class Conn extends mysqli{
    function __construct($host, $usuario, $senha, $db)
    {
        $this->retornoJson = new \stdClass();
        parent::__construct($host, $usuario, $senha, $db);
        if($this->connect_errno){
            header('HTTP/1.1 406 Not Acceptable; Content-Type: application/json; charset=utf-8');
            $this->retornoJson->status = 'erro';
            $this->retornoJson->descricao = 'Falha na conexao com o banco de dados';
            echo json_encode($this->retornoJson, JSON_UNESCAPED_UNICODE);
            exit();
        }
        $this->set_charset("utf8mb4");
    }
}