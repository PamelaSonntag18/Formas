<?php
require_once("../classes/Quadrado.class.php");
require_once("../classes/Unidade.class.php");

$id = isset($_GET['id']) ? $_GET['id'] : 0; // Captura o ID, se estiver na URL
$msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";

// Verifica se há um ID passado, e carrega o quadrado para edição se houver
if ($id > 0) {
    $forma = Quadrado::listar(1, $id)[0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0; // Captura o ID enviado pelo formulário
    $lado = isset($_POST['lado']) ? $_POST['lado'] : 0; // Captura o lado do quadrado
    $unidade = isset($_POST['unidade']) ? $_POST['unidade'] : 0; // Captura a unidade
    $cor = isset($_POST['cor']) ? $_POST['cor'] : ""; // Captura a cor
    $acao = isset($_POST['acao']) ? $_POST['acao'] : ""; // Ação (salvar, alterar, excluir)

    try {
        // Obtém a unidade de medida correspondente
        $idunidade = UnidadeMedida::listar(1, $unidade)[0];
        $quadrado = new Quadrado($id, $lado, $idunidade, $cor);

        $resultado = false; // Inicializa a variável para armazenar o resultado da ação

        switch ($acao) {
            case "salvar":
                $resultado = $quadrado->incluir(); // Chama o método para salvar
                break;
            case "alterar":
                $resultado = $quadrado->alterar(); // Chama o método para alterar
                break;
            case "excluir":
                $resultado = $quadrado->excluir(); // Chama o método para excluir
                break;
        }

        // Verifica se a ação foi bem-sucedida e redireciona com a mensagem correspondente
        if ($resultado) {
            header('location: index.php?MSG=Operação realizada com sucesso!');
        } else {
            header('location: index.php?MSG=Erro ao realizar a operação.');
        }
    } catch (Exception $e) {
        // Se houver exceção, redireciona com a mensagem de erro
        header('location: index.php?MSG=Erro: ' . $e->getMessage());
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Caso seja uma requisição GET (busca de dados)
    $busca = isset($_GET['busca']) ? $_GET['busca'] : 0; // Filtro de busca
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0; // Tipo de busca (ex: todos os quadrados)
    $lista = Quadrado::listar($tipo, $busca); // Lista os quadrados de acordo com os filtros
}
?>
