<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'classes/Tabela.php';

class Rest
{
	public static function get($uri)
	{
        if ($uri[0] === "/"){
            $uri = substr($uri,1,strlen($uri));
        }

		$url = explode('/',$uri);
        $classe = "Tabela";
		$entidade = $url[0];
		$metodo = $url[1];
	
        try {
			if (class_exists($classe)) {
				if (method_exists($classe, $metodo)) {
					$retorno = call_user_func_array(array(new $classe, $metodo), array($url));
					return json_encode(array('status' => 'sucesso', 'dados' => $retorno));
				} else {
					return json_encode(array('status' => 'erro', 'dados' => 'Método inexistente!', 'classe' => $classe));
				}
			} else {
				return json_encode(array('status' => 'erro', 'dados' => 'Classe inexistente!', 'classe' => $classe ));
			}	
		} catch (Exception $e) {
			return json_encode(array('status' => 'erro', 'dados' => $e->getMessage()));
		}
	}
	public static function post($uri)
	{

		if ($uri[0] === "/"){
            $uri = substr($uri,1,strlen($uri));
        }

		$url = explode('/',$uri);
		$entidade = $url[0];
        $classe = "Tabela";
		$metodo = "incluir";

		$input = (array) json_decode(file_get_contents('php://input'), TRUE);
		try {
			if (class_exists($classe)) {
				if (method_exists($classe, $metodo)) {
					
					$tabela = new Tabela();

					//$retorno = call_user_func_array(array(new $classe, $metodo),$par);
					$retorno = $tabela->incluir($url, $input);

					return json_encode(array('status' => 'sucesso', 'dados' => $retorno));
				} else {
					return json_encode(array('status' => 'erro', 'dados' => 'Método inexistente!', 'classe' => $classe));
				}
			} else {
				return json_encode(array('status' => 'erro', 'dados' => 'Classe inexistente!', 'classe' => $classe ));
			}	
		} catch (Exception $e) {
			return json_encode(array('status' => 'erro', 'dados' => $e->getMessage()));
		}
	}
	public static function put($uri)
	{

		if ($uri[0] === "/"){
            $uri = substr($uri,1,strlen($uri));
        }

		$url = explode('/',$uri);
		$entidade = $url[0];
        $classe = "Tabela";
		$metodo = "alterar";

		$input = (array) json_decode(file_get_contents('php://input'), TRUE);
		try {
			if (class_exists($classe)) {
				if (method_exists($classe, $metodo)) {
					
					$tabela = new Tabela();

					//$retorno = call_user_func_array(array(new $classe, $metodo),$par);
					$retorno = $tabela->alterar($url, $input);

					return json_encode(array('status' => 'sucesso', 'dados' => $retorno));
				} else {
					return json_encode(array('status' => 'erro', 'dados' => 'Método inexistente!', 'classe' => $classe));
				}
			} else {
				return json_encode(array('status' => 'erro', 'dados' => 'Classe inexistente!', 'classe' => $classe ));
			}	
		} catch (Exception $e) {
			return json_encode(array('status' => 'erro', 'dados' => $e->getMessage()));
		}
	}
	public static function delete($uri)
	{

		if ($uri[0] === "/"){
            $uri = substr($uri,1,strlen($uri));
        }

		$url = explode('/',$uri);
		$entidade = $url[0];
        $classe = "Tabela";
		$metodo = "alterar";

		$input = (array) json_decode(file_get_contents('php://input'), TRUE);
		try {
			if (class_exists($classe)) {
				if (method_exists($classe, $metodo)) {
					
					$tabela = new Tabela();

					//$retorno = call_user_func_array(array(new $classe, $metodo),$par);
					$retorno = $tabela->excluir($url, $input);

					return json_encode(array('status' => 'sucesso', 'dados' => $retorno));
				} else {
					return json_encode(array('status' => 'erro', 'dados' => 'Método inexistente!', 'classe' => $classe));
				}
			} else {
				return json_encode(array('status' => 'erro', 'dados' => 'Classe inexistente!', 'classe' => $classe ));
			}	
		} catch (Exception $e) {
			return json_encode(array('status' => 'erro', 'dados' => $e->getMessage()));
		}
	}
}

if (isset($_REQUEST) && empty($_REQUEST) == 0) {
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		echo Rest::get($_REQUEST["url"]);
    }
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		echo Rest::post($_REQUEST["url"]);
    }
	if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
		echo Rest::put($_REQUEST["url"]);
    }
	if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
		echo Rest::delete($_REQUEST["url"]);
    }
} else {
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		echo Rest::get($_SERVER["PATH_INFO"]);
    }
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		echo Rest::post($_SERVER["PATH_INFO"]);
    }
	if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
		echo Rest::put($_SERVER["PATH_INFO"]);
    }
	if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
		echo Rest::delete($_SERVER["PATH_INFO"]);
    }
}