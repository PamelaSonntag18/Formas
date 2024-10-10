<?php
require_once("../classes/Database.class.php");

class UnidadeMedida {
    private $id; 
    private $descricao; 
    private $sigla;


    public function __construct($id = 0, $descricao = "null", $sigla = "null"){
        $this->setId($id); 
        $this->setDescricao($descricao); 
        $this->setSigla($sigla); 
    }

    public function getIdUnidade() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
        return $this;
    }

    public function getSigla() {
        return $this->sigla;
    }

    public function setSigla($sigla) {
        $this->sigla = $sigla;
        return $this; 
    }

    public function incluir() {

        $sql = 'INSERT INTO unidade (descricao, sigla)   
                     VALUES (:descricao, :sigla)';

        $parametros = array(':descricao' => $this->descricao,

                            ':sigla' => $this->sigla);
                            
        return Database::executar($sql, $parametros);
    }    
    
    public function excluir() {

        $sql = 'DELETE 
                  FROM unidade
                 WHERE id = :id';

        $parametros = array(':id' => $this->id);

        return Database::executar($sql, $parametros);
    }  

    public function alterar() {

        $sql = 'UPDATE unidade 
                   SET descricao = :descricao, sigla = :sigla
                 WHERE id = :id';
                
        $parametros = array(':id' => $this->id,
                            ':descricao' => $this->descricao,
                            ':sigla' => $this->sigla);

        return Database::executar($sql, $parametros);
    }    

    public static function listar($tipo = 0, $busca = "") {
        $sql = "SELECT * FROM unidade"; 

        $parametros = array(); 

        if ($tipo > 0) {
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE id = :busca";
                    break;
                case 2:
                    $sql .= " WHERE descricao like :busca";
                    $busca = "%{$busca}%";
                    break;
                case 3:
                    $sql .= " WHERE sigla like :busca";
                    $busca = "%{$busca}%";
                    break;
            }
            $parametros = array(':busca' => $busca);
        }
        $registros = Database::executar($sql, $parametros);

        $unidades = array();

        while ($registro = $registros->fetch()) {  
            $unidade = new UnidadeMedida($registro['id'], $registro['descricao'], $registro['sigla']);
            array_push($unidades, $unidade); 
        }
        
        return $unidades; 
    }    
}

?>
