<?php
require_once("../classes/Circulo.class.php");
require_once("../classes/Unidade.class.php");

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";

if ($id > 0) {
    $forma = Circulo::listar(1, $id)[0];                                    
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0; 
    $raio = isset($_POST['raio']) ? $_POST['raio'] : 0; 
    $unidade = isset($_POST['unidade']) ? $_POST['unidade'] : 0; 
    $cor = isset($_POST['cor']) ? $_POST['cor'] : ""; 
    $acao = isset($_POST['acao']) ? $_POST['acao'] : ""; 

    try {
        $idunidade = UnidadeMedida::listar(1, $unidade)[0];
        $circulo = new Circulo($id, $raio, $idunidade, $cor);

        $resultado = false;

        switch ($acao) {
            case "salvar":
                $resultado = $circulo->incluir();
                break;
            case "excluir":
                $resultado = $circulo->excluir();
                break;
        }

        if ($resultado) {
            header('location: index.php?MSG=Dados inseridos/alterados com sucesso!');
        } else {
            header('location: index.php?MSG=Erro ao inserir/alterar registro');
        }
    } catch (Exception $e) {
        header('location: index.php?MSG=Erro: '.$e->getMessage());
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['busca']) ? $_GET['busca'] : 0;
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;
    $lista = Circulo::listar($tipo, $busca); 
}
?>
