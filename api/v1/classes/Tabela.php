<?php
class Tabela
{

    public function listar($url)
    {
        $con = new PDO('mysql: host=locahost; dbname=sistema;','root','');

        $tabela = $url[0];
        $metodo = $url[1];

        $sql = "SELECT * FROM " . $url[0] . " ORDER BY id ASC";
        $sql = $con->prepare($sql);
        $sql->execute();

        $resultados = array();

        while($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $resultados[] = $row;
        }

        if (!$resultados) {
            throw new Exception("Nenhum pruduto no estoque!");
        }
        
        return $resultados;
    }
}