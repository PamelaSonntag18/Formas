<?php
require_once("Forma.class.php");

class Triangulo extends Forma {

    // Método para calcular a altura do triângulo equilátero
    public function getAltura() {
        return ($this->lado * sqrt(3)) / 2;  // Altura de um triângulo equilátero utilizando da fórmula h = (L * √3) / 2
    }

    // Método para desenhar o triângulo
    public function desenhar() {
        $altura = $this->getAltura();  // Usando o método getAltura()

        // Gerando o HTML do triângulo com a altura e lado calculados
        return "<a href='triangulo.php?id=" . $this->getId() . "'>
                    <div class='container' style='
                    width: 0; 
                    height: 0; 
                    border-left:" . ($this->getLado() / 2) . $this->getIdUnidade()->getSigla() . " solid transparent; 
                    border-right:" . ($this->getLado() / 2) . $this->getIdUnidade()->getSigla() . " solid transparent; 
                    border-bottom:" . $altura . $this->getIdUnidade()->getSigla() . " solid " . $this->getCor() . ";'>
                    </div>
                </a><br>";
    }
}
?>
