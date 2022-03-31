<?php
class Tabela
{
    public function listar($url)
    {
        $con = new PDO('mysql:host=sql395.main-hosting.eu; dbname=u475983679_aquarela;','u475983679_aquarela','a1b2C3D4');
        $tabela = $url[0];
        $metodo = $url[1];
        $sql = "SELECT * FROM " . $tabela . " limit 10";
        $sql = $con->prepare($sql);
        $sql->execute();
        $resultados = $sql->fetchAll();
        if (!$resultados) {
            throw new Exception("Nenhum registro encontrado!");
        }
        return $resultados;
    }

    public function filtrar($url)
    {
        $con = new PDO('mysql:host=sql395.main-hosting.eu; dbname=u475983679_aquarela;','u475983679_aquarela','a1b2C3D4');
        $tabela = $url[0];
        $metodo = $url[1];
        $coluna = $url[2];
        $valor = $url[3];
        $tipo = $this->type($con, $tabela, $coluna);
        $sql = "";
        if (str_starts_with($tipo, "varchar")){
           $sql = "SELECT * FROM " . $tabela . " where ". $coluna . " like '%" . $valor . "%' limit 30";
        } elseif (str_starts_with($tipo, "int")) {
            $sql = "SELECT * FROM " . $tabela . " where ". $coluna . " = " . $valor . " limit 30";
        }
        $sql = $con->prepare($sql);
        $sql->execute();
        $resultados = $sql->fetchAll();

        if (!$resultados) {
            throw new Exception("Nenhum registro encontrado!");
        }
        return $resultados;
    }

    public function ver($url){
        $con = new PDO('mysql:host=sql395.main-hosting.eu; dbname=u475983679_aquarela;','u475983679_aquarela','a1b2C3D4');
        $tabela = $url[0];
        $metodo = $url[1];
        $registro = $url[2];
        $primarykey = $this->pk($con, $tabela);

        $sql = "SELECT * FROM " . $tabela . " where " . $primarykey ." = " . $registro . " limit 10";
          $sql = $con->prepare($sql);
        $sql->execute();

        $resultados = array();

        while($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $resultados[] = $row;
        }

        if (!$resultados) {
            throw new Exception("Registro não encontrado!");
        }
        
        return $resultados;
    }
    public function incluir( $url, $input ){
        $con = new PDO('mysql:host=sql395.main-hosting.eu; dbname=u475983679_aquarela;','u475983679_aquarela','a1b2C3D4');

        $tabela = $url[0];
        $colunas = "";
        $dados = "";
        $primarykey = $this->pk($con, $tabela);

        foreach($input as $key=>$value)
        {
            if ($key != $primarykey){
                $colunas .= $key . ",";
                $dados .= "'". $value . "',";
            }
        }

        $colunas = substr($colunas, 0, strlen($colunas)-1);
        $dados = substr($dados, 0, strlen($dados)-1);
        $sql = "insert into " . $tabela . "(" . $colunas . ") values (" . $dados . ") ";
        $sql = $con->prepare($sql);
        $sql->execute();
        $id = $con->lastInsertId();
        $input[$primarykey] = $id;
        
        return $input;
    }

    public function alterar( $url, $input ){
        $con = new PDO('mysql:host=sql395.main-hosting.eu; dbname=u475983679_aquarela;','u475983679_aquarela','a1b2C3D4');

        $tabela = $url[0];
        $atualizar = "";
        $chave = "";
        $primarykey = $this->pk($con, $tabela);

        foreach($input as $key=>$value)
        {
            if ($key != $primarykey){
                $atualizar .= $key . "=". "'" . $value . "',";
            } else {

                $chave .= $key . "=" . "'" . $value . "' and ";
            }
        }

        $chave = substr($chave, 0, strlen($chave)-4);
        $atualizar = substr($atualizar, 0, strlen($atualizar)-1);
        $sql = "update " . $tabela . " set " . $atualizar . " where " . $chave;
        $sql = $con->prepare($sql);
        $sql->execute();
        return $input;
    }
    public function excluir( $url, $input ){
        $con = new PDO('mysql:host=sql395.main-hosting.eu; dbname=u475983679_aquarela;','u475983679_aquarela','a1b2C3D4');

        $tabela = $url[0];
        $atualizar = "";
        $chave = "";
        $primarykey = $this->pk($con, $tabela);

        foreach($input as $key=>$value)
        {
            if ($key == $primarykey){
               $chave .= $key . "=" . "'" . $value . "' and ";
            }
        }

        $chave = substr($chave, 0, strlen($chave)-4);
        $sql = "delete from " . $tabela . " where " . $chave;
        $sql = $con->prepare($sql);
        $sql->execute();
        return $input;
    }

    private function estrutura($con, $url){
        $tabela = $url[0];
        $sql = "describe " . $tabela;
        $sql = $con->prepare($sql);
        $sql->execute();
        $resultados = $sql->fetchAll();
        if (!$resultados) {
            throw new Exception("Tabela não encontrada!");
        }
        
        return $resultados;
    }

    private function pk($con, $tabela){
    
        $sql = "show columns from " . $tabela . " where `key` = 'PRI'";
        $sql = $con->prepare($sql);
        $sql->execute();

        while($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            return $row["Field"];
        }
        return "id";
    }

    private function type($con, $tabela, $coluna){
        $sql = "show columns from " . $tabela . " where field = '$coluna'";
        $sql = $con->prepare($sql);
        $sql->execute();
        $resultados = $sql->fetchAll();
        return $resultados[0]["Type"];
    }

}