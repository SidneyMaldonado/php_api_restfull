<?php

	class Estoque
	{
		public function listar()
		{
			$con = new PDO('mysql:host=sql395.main-hosting.eu; dbname=u475983679_aquarela;','u475983679_aquarela','a1b2C3D4');

			$sql = "SELECT * FROM estoque ORDER BY id ASC";
			$sql = $con->prepare($sql);
			$sql->execute();
			$resultados = array();

			while($row = $sql->fetch(PDO::FETCH_ASSOC)) {
				$resultados[] = $row;
			}

			if (!$resultados) {
				throw new Exception("Nenhum pruduto no estoque!");
			}
			$con = null;
			
			return $resultados;
		}
	}