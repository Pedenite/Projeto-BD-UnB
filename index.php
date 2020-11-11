<?php
header("Content-Type: application/json");
function Api(){

    if(isset($_GET['url'])){
        $url = explode('/',$_GET['url']);
        if($url[0] == 'pages'){
            header_remove();
            header("Content-Type: text/html; charset=utf-8");
            switch($url[1]){
                case 'relatorios':
                    require_once('pages/relatorios.php');
                    break;
                default:
                    header("HTTP/1.0 404 Not Found");
            }
            return null;
        }
        $url[0] = ucfirst($url[0]);
        $modulo = $url[0];
        $classe = $url[1];
        $funcao = $url[2];
        if(include_once($modulo.'.php')){
            array_shift($url);
            if(class_exists($classe)){
                array_shift($url);
                if(method_exists($classe,$funcao)){
                    array_shift($url);
                    $retorno = call_user_func_array(array(new $classe, $funcao), $url);
                    return $retorno;
                }else{
                    return json_encode(array('status'=>'erro','dados'=>'Função não foi encontrada!'));
                }
            }else{
                return json_encode(array('status'=>'erro','dados'=>'Classe não foi encontrada!'));
            }
        }else{
            return json_encode(array('status'=>'erro','dados'=>'Modulo não foi encontrado!'));
        }
        
    }
    return json_encode(array('status'=>'erro','dados'=>'Nenhum parametro informado!'));

}
echo Api();
?>