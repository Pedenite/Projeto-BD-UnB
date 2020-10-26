<?php

require_once('controllers/Config.php');
require_once('controllers/Conn.php');

$conn = new Conn(HOST,USUARIO,SENHA,DB);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "<h1>Connected successfully</h1>";

$retorno = $conn->query('SELECT * FROM aluno');

if($retorno){

    while($row = $retorno->fetch_assoc()) {
        echo $row['nome']."<br>";
      }

} else {
    echo "Emptyness :´(";
}
