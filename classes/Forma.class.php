<?php
require_once("../classes/Database.class.php");
require_once("../classes/Unidade.class.php");

abstract class Forma {

    protected $id;
    protected $lado; // Este pode ser removido, pois Circulo não usa
    protected $id_unidade; // Renomeado para seguir a convenção
    protected $cor;

    public function __construct($id = 0, $lado = 0, ?UnidadeMedida $id_unidade = null, $cor = "null") {
        $this->setId($id);

        // Só define o lado se a classe não for Circulo
        if (static::class != 'Circulo') {
            $this->setLado($lado);
        }
        
        $this->setIdUnidade($id_unidade);
        $this->setCor($cor);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getLado() {
        return $this->lado;
    }

    public function setLado($lado) {
        $this->lado = $lado;
        return $this;
    }

    public function getIdUnidade() {
        return $this->id_unidade;
    }
    
    public function setIdUnidade(?UnidadeMedida $id_unidade) {
        $this->id_unidade = $id_unidade;
        return $this;
    }

    public function getCor() {
        return $this->cor;
    }

    public function setCor($cor) {
        $this->cor = $cor;
        return $this;
    }

    public function incluir() {
        // Definir a SQL para inserção
        $sql = 'INSERT INTO ' . strtolower(get_called_class()) . ' (lado, id_unidade, cor)   
                VALUES (:lado, :id_unidade, :cor)';

        // Parâmetros a serem passados para a SQL
        $parametros = array(
            ':lado' => $this->lado,
            ':id_unidade' => $this->getIdUnidade() ? $this->getIdUnidade()->getIdUnidade() : null,
            ':cor' => $this->cor
        );

        // Executa a SQL e retorna o resultado (true ou false)
        return Database::executar($sql, $parametros);
    }

    public function alterar() {
        if ($this->id == 0) {
            throw new Exception("ID não definido para alterar.");
        }
    
        // Definir a SQL para alteração
        $sql = 'UPDATE ' . strtolower(get_called_class()) . ' 
                SET lado = :lado, id_unidade = :id_unidade, cor = :cor
                WHERE id = :id';
        
        // Parâmetros a serem passados para a SQL
        $parametros = array(
            ':id' => $this->id,
            ':lado' => $this->lado,
            ':id_unidade' => $this->getIdUnidade() ? $this->getIdUnidade()->getIdUnidade() : null,
            ':cor' => $this->cor
        );
    
        // Executa a SQL e retorna o resultado (true ou false)
        return Database::executar($sql, $parametros);
    }

    public function excluir() {
        if ($this->id == 0) {
            throw new Exception("ID não definido para exclusão.");
        }
    
        // Definir a SQL para exclusão
        $sql = 'DELETE FROM ' . strtolower(get_called_class()) . ' WHERE id = :id';
    
        // Parâmetros a serem passados para a SQL
        $parametros = array(':id' => $this->id);
    
        // Executa a SQL e retorna o resultado (true ou false)
        return Database::executar($sql, $parametros);
    }

    public static function listar($tipo = 0, $busca = "") {
        $sql = "SELECT * FROM " . strtolower(get_called_class());
        $parametros = array();

        if ($tipo > 0) {
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE id = :busca";
                    break;
                case 2:
                    $sql .= " WHERE lado like :busca";
                    $busca = "%{$busca}%";
                    break;
            }
            $parametros = array(':busca' => $busca);
        }

        $registros = Database::executar($sql, $parametros);

        $formas = array();

        while ($registro = $registros->fetch()) {
            $id_unidade = UnidadeMedida::listar(1, $registro['id_unidade'])[0];

            // Verifica se é um Círculo e usa "raio" ao invés de "lado"
            if (static::class == 'Circulo') {
                $forma = new static($registro['id'], $registro['raio'], $id_unidade, $registro['cor']);
            } else {
                $forma = new static($registro['id'], $registro['lado'], $id_unidade, $registro['cor']);
            }

            array_push($formas, $forma);
        }
        return $formas;
    }

    abstract public function desenhar(); // Método abstrato
}
?>
