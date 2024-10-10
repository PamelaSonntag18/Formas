<?php
// Importa a classe base Forma
require_once("Forma.class.php");

// Define a classe TrianguloEscaleno que estende a classe Forma
class TrianguloEscaleno extends Forma {

    // Declara as propriedades privadas para os lados do triângulo
    private $lado2; // Lado 2 do triângulo
    private $lado3; // Lado 3 do triângulo

    // Construtor da classe TrianguloEscaleno
    public function __construct($id = 0, $lado1 = 0, $lado2 = 0, $lado3 = 0, ?UnidadeMedida $id_unidade = null, $cor = "null") {
        // Chama o construtor da classe pai Forma
        parent::__construct($id, $lado1, $id_unidade, $cor);
        // Define os lados do triângulo usando os métodos set
        $this->setLado2($lado2);
        $this->setLado3($lado3);
    }

    // Método para obter o lado principal (lado 1)
    public function getLado() {
        return $this->lado; // Retorna o valor do lado
    }
    
    // Método para obter o lado 2
    public function getLado2() {
        return $this->lado2; // Retorna o lado 2
    }

    // Método para definir o lado 2
    public function setLado2($lado2) {
        // Verifica se lado 2 é maior que zero
        if ($lado2 <= 0) {
            throw new Exception("Lado 2 deve ser maior que zero."); // Lança uma exceção se a condição não for atendida
        }
        $this->lado2 = $lado2; // Define o valor de lado 2
        return $this; // Retorna a instância atual
    }

    // Método para obter o lado 3
    public function getLado3() {
        return $this->lado3; // Retorna o lado 3
    }

    // Método para definir o lado 3
    public function setLado3($lado3) {
        // Verifica se lado 3 é maior que zero
        if ($lado3 <= 0) {
            throw new Exception("Lado 3 deve ser maior que zero."); // Lança uma exceção se a condição não for atendida
        }
        $this->lado3 = $lado3; // Define o valor de lado 3
        return $this; // Retorna a instância atual
    }

    // Método para calcular a altura usando a fórmula de Herão
    public function getAltura() {
        // Verifica se os lados são válidos
        if ($this->lado <= 0 || $this->lado2 <= 0 || $this->lado3 <= 0) {
            throw new Exception("Os lados do triângulo devem ser maiores que zero."); // Lança uma exceção se a condição não for atendida
        }

        // Calcula o semiperímetro
        $s = ($this->lado + $this->lado2 + $this->lado3) / 2;
        // Calcula a área do triângulo
        $area = sqrt($s * ($s - $this->lado) * ($s - $this->lado2) * ($s - $this->lado3));
        
        // Adicionando verificação para evitar divisão por zero
        if ($this->lado == 0) {
            throw new Exception("O lado não pode ser zero para calcular a altura."); // Lança uma exceção se o lado for zero
        }

        // Retorna a altura do triângulo
        return (2 * $area) / $this->lado;
    }

    // Método para desenhar o triângulo escaleno
    public function desenhar() {
        $altura = $this->getAltura(); // Obtém a altura do triângulo

        // Usando lado 1 como base e os outros lados como laterais
        $base = $this->getLado();
        $ladoEsquerdo = $this->getLado2();
        $ladoDireito = $this->getLado3();

        // Gera o HTML do triângulo escaleno
        return "<a href='triangulo_escaleno.php?id=" . $this->getId() . "'>
                    <div class='container' style='
                    position: relative; 
                    width: " . $base . $this->getIdUnidade()->getSigla() . "; 
                    height: " . $altura . $this->getIdUnidade()->getSigla() . ";'>
                        <div style='
                            position: absolute; 
                            width: 0; 
                            height: 0; 
                            border-left: " . ($ladoEsquerdo / 2) . $this->getIdUnidade()->getSigla() . " solid transparent; 
                            border-right: " . ($ladoDireito / 2) . $this->getIdUnidade()->getSigla() . " solid transparent; 
                            border-bottom: " . $altura . $this->getIdUnidade()->getSigla() . " solid " . $this->getCor() . ";
                            left: 50%; 
                            margin-left: -" . ($ladoEsquerdo / 2) . $this->getIdUnidade()->getSigla() . ";'>
                        </div>
                    </div>
                </a><br>"; // Retorna a representação visual do triângulo em HTML
    }

    // Método para incluir o triângulo escaleno no banco de dados
    public function incluir() {
        // Verificar se os lados são válidos
        if ($this->lado <= 0 || $this->lado2 <= 0 || $this->lado3 <= 0) {
            throw new Exception("Os lados do triângulo devem ser maiores que zero para inclusão."); // Lança uma exceção se a condição não for atendida
        }

        // Prepara a consulta SQL para inserir o triângulo
        $sql = 'INSERT INTO trianguloescaleno (lado1, lado2, lado3, id_unidade, cor)   
                VALUES (:lado, :lado2, :lado3, :id_unidade, :cor)';

        // Define os parâmetros para a consulta
        $parametros = array(
            ':lado' => $this->lado, // Lado 1
            ':lado2' => $this->lado2, // Lado 2
            ':lado3' => $this->lado3, // Lado 3
            ':id_unidade' => $this->getIdUnidade() ? $this->getIdUnidade()->getIdUnidade() : null, // ID da unidade de medida
            ':cor' => $this->cor // Cor do triângulo
        );

        // Executa a consulta e retorna o resultado
        return Database::executar($sql, $parametros);
    }

    // Método para excluir o triângulo escaleno do banco de dados
    public function excluir() {
        // Prepara a consulta SQL para deletar o triângulo
        $sql = 'DELETE 
                  FROM trianguloescaleno
                 WHERE id = :id';

        // Define os parâmetros para a consulta
        $parametros = array(':id' => $this->id); // ID do triângulo a ser excluído

        // Executa a consulta e retorna o resultado
        return Database::executar($sql, $parametros);
    }  

    // Método estático para listar triângulos escaleno do banco de dados
    public static function listar($tipo = 0, $busca = "") {
        $sql = "SELECT * FROM trianguloescaleno"; // Consulta SQL inicial
        $parametros = array(); // Inicializa um array para os parâmetros

        // Se tipo for maior que 0, aplica filtros
        if ($tipo > 0) {
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE id = :busca"; // Filtra por ID
                    break;
                case 2:
                    $sql .= " WHERE lado1 like :busca"; // Filtra por lado 1
                    $busca = "%{$busca}%"; // Adiciona % para busca parcial
                    break;
            }
            $parametros = array(':busca' => $busca); // Define os parâmetros de busca
        }

        // Executa a consulta e obtém os registros
        $registros = Database::executar($sql, $parametros);
        $formas = array(); // Inicializa um array para armazenar as formas

        // Loop pelos registros obtidos
        while ($registro = $registros->fetch(PDO::FETCH_ASSOC)) {
            // Obtém a unidade de medida correspondente ao ID
            $id_unidade = UnidadeMedida::listar(1, $registro['id_unidade'])[0];
            // Cria uma nova instância de TrianguloEscaleno com os dados do registro
            $forma = new TrianguloEscaleno($registro['id'], $registro['lado1'], $registro['lado2'], $registro['lado3'], $id_unidade, $registro['cor']);
            // Adiciona a forma ao array de formas
            array_push($formas, $forma);
        }

        return $formas; // Retorna o array de formas
    }
}
?>