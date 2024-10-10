<?php
require_once("../classes/Unidade.class.php");

$id =  isset($_GET['id']) ? $_GET['id'] : 0;
$msg =  isset($_GET['MSG']) ? $_GET['MSG'] : "";
if ($id > 0){
    $medida = UnidadeMedida::listar(1, $id)[0];                                    
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id =  isset($_POST['id']) ? $_POST['id'] : 0; 
    $descricao =  isset($_POST['descricao']) ? $_POST['descricao'] : ""; 
    $sigla =  isset($_POST['sigla']) ? $_POST['sigla'] : ""; 
    $acao =  isset($_POST['acao']) ? $_POST['acao'] : ""; 

    try {
        $unidade = new UnidadeMedida($id, $descricao, $sigla);

        $resultado = "";

        switch($acao) {
            case "salvar":
                $resultado = $unidade->incluir();
                break;
            case "alterar":
                $resultado = $unidade->alterar();
                break;
            case "excluir":
                $resultado = $unidade->excluir();
                break;
        }

        if ($resultado)
            header('location: index.php?MSG=Dados inseridos/alterados com sucesso!');
        else
            header('location: index.php?MSG=Erro ao inserir/alterar registro');
    } catch(Exception $e) {
        header('location: index.php?MSG=Erro: '.$e->getMessage());
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca =  isset($_GET['busca']) ? $_GET['busca'] : 0;
    $tipo =  isset($_GET['tipo']) ? $_GET['tipo'] : 0;
    $lista = UnidadeMedida::listar($tipo, $busca); 
}
?>
