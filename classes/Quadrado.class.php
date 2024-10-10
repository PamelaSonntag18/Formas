<?php
require_once("Forma.class.php");

class Quadrado extends Forma {

    public function excluir() {

        $sql = 'DELETE 
                  FROM quadrado
                 WHERE id = :id';

        $parametros = array(':id' => $this->id);

        return Database::executar($sql, $parametros);
    }  
    
    public function desenhar() {
        // Gerando o HTML do quadrado com lado e unidade de medida corretos
        return "<a href='quadrado.php?id=" . $this->getId() . "'>
                    <div class='container' style='
                    background-color: " . $this->getCor() . "; 
                    width: " . $this->getLado() . $this->getIdUnidade()->getSigla() . "; 
                    height: " . $this->getLado() . $this->getIdUnidade()->getSigla() . ";'>
                    </div>
                </a><br>";
    }
}
?>
