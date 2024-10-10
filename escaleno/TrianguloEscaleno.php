<?php
require_once("../classes/TrianguloEscaleno.class.php");
require_once("../classes/Unidade.class.php");

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";

// Inicializar o objeto TrianguloEscaleno com o ID, se disponível
$forma = null;
$lista = TrianguloEscaleno::listar(1, $id);
if (!empty($lista)) {
    $forma = $lista[0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0; // Capturando o ID corretamente
    $lado1 = isset($_POST['lado']) ? $_POST['lado'] : 0;
    $lado2 = isset($_POST['lado2']) ? $_POST['lado2'] : 0;
    $lado3 = isset($_POST['lado3']) ? $_POST['lado3'] : 0;
    $unidade = isset($_POST['unidade']) ? $_POST['unidade'] : 0;
    $cor = isset($_POST['cor']) ? $_POST['cor'] : "";
    $acao = isset($_POST['acao']) ? $_POST['acao'] : "";

    try {
        $idunidade = UnidadeMedida::listar(1, $unidade)[0];
        $trianguloEscaleno = new TrianguloEscaleno($id, $lado1, $lado2, $lado3, $idunidade, $cor);

        $resultado = false;

        switch ($acao) {
            case "salvar":
                $resultado = $trianguloEscaleno->incluir();
                break;
            case "alterar":
                $resultado = $trianguloEscaleno->alterar();
                break;
            case "excluir":
                $resultado = $trianguloEscaleno->excluir(); // Executando a exclusão
                break;
        }

        if ($resultado) {
            header('location: index.php?MSG=Operação realizada com sucesso!');
        } else {
            header('location: index.php?MSG=Erro ao realizar a operação.');
        }
    } catch (Exception $e) {
        header('location: index.php?MSG=Erro: ' . $e->getMessage());
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['busca']) ? $_GET['busca'] : 0;
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;

    $lista = TrianguloEscaleno::listar($tipo, $busca);
}
?>
