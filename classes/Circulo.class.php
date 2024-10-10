<?php
require_once("Forma.class.php");

class Circulo extends Forma {
    private $raio;

    public function __construct($id, $raio, ?UnidadeMedida $unidade, $cor) { // Ajustado para aceitar null
        parent::__construct($id, 0, $unidade, $cor); // Lado não é utilizado para Circulo
        $this->raio = $raio;
    }

    public function getRaio() {
        return $this->raio;
    }

    public function incluir() {
        $sql = 'INSERT INTO circulo (raio, id_unidade, cor) VALUES (:raio, :id_unidade, :cor)';
        $parametros = array(
            ':raio' => $this->raio,
            ':id_unidade' => $this->getIdUnidade() ? $this->getIdUnidade()->getIdUnidade() : null,
            ':cor' => $this->cor
        );
        return Database::executar($sql, $parametros);
    }

    public function alterar() {
        if ($this->id == 0) {
            throw new Exception("ID não definido para alterar.");
        }

        $sql = 'UPDATE circulo SET raio = :raio, id_unidade = :id_unidade, cor = :cor WHERE id = :id';
        $parametros = array(
            ':id' => $this->id,
            ':raio' => $this->raio,
            ':id_unidade' => $this->getIdUnidade() ? $this->getIdUnidade()->getIdUnidade() : null,
            ':cor' => $this->cor
        );
        return Database::executar($sql, $parametros);
    }

    public function excluir() {
        $sql = 'DELETE FROM circulo WHERE id = :id';
        $parametros = array(':id' => $this->id);
        return Database::executar($sql, $parametros);
    }
    
    public function desenhar() {
        return "<a href='circulo.php?id=" . $this->getId() . "'>
                    <div class='container' style='
                    background-color: " . $this->getCor() . "; 
                    width: " . (2 * $this->getRaio() . $this->getIdUnidade()->getSigla()) . "; 
                    height: " . (2 * $this->getRaio() . $this->getIdUnidade()->getSigla()) . "; 
                    border-radius: 50%;'>
                    </div>
                </a><br>";
    }
}
?>
