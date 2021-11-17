<?php
header('Content-Type: application/json; charset=utf-8');

require_once 'classes/Estoque.php';
require_once 'classes/Tabela.php';

class Rest
{
	public static function get($requisicao)
	{
		$url = explode('/', $requisicao['url']);
		$metodo = $url[1];
		$classe = "Tabela";
		try {
			if (class_exists($classe)) {
				if (method_exists($classe, $metodo)) {
					$retorno = call_user_func_array(array(new $classe, $metodo), array($url));
					return json_encode(array('status' => 'sucesso', 'dados' => $retorno));
				} else {
					return json_encode(array('status' => 'erro', 'dados' => 'Método inexistente!'));
				}
			} else {
				return json_encode(array('status' => 'erro', 'dados' => 'Classe inexistente!'));
			}	
		} catch (Exception $e) {
			return json_encode(array('status' => 'erro', 'dados' => $e->getMessage()));
		}
	}
	public static function post($requisicao)
	{
		$input = (array) json_decode(file_get_contents('php://input'), TRUE);

		// fazer o processamento de post aqui

		return json_encode($input);
	}
}

if (isset($_REQUEST)) {
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		echo Rest::get($_REQUEST);
    }
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		echo Rest::post($_REQUEST);
    }
}