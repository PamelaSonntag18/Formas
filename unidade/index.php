<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Unidade</title>
    <?php
        include_once('unidadeMedida.php');
    ?>
</head>
<body>
<?php include('../menu.php'); ?>


    <form action="unidadeMedida.php" method="post">
        <fieldset>
            <legend>Cadastro de unidade</legend>

            <label for="id">Id:</label>
            <input type="text" name="id" id="id" value="<?=isset($medida)?$medida->getIdUnidade():0?>" readonly>

            <label for="descricao">Descrição:</label>
            <input type="text" name="descricao" id="descricao" value="<?php if(isset($medida)) echo $medida->getDescricao()?>">

            <label for="sigla">Unidade:</label>
            <input type="text" name="sigla" id="sigla" value="<?php if(isset($medida)) echo $medida->getSigla()?>"><br><br>

            <button type='submit' name='acao' value='salvar'>Salvar</button>
            <button type='submit' name='acao' value='excluir'>Excluir</button>
            <button type='submit' name="acao" value="alterar">Alterar</button>

        </fieldset>
    </form>

    <form action="" method="get">
        <fieldset>
            <legend>Pesquisa</legend>

            <label for="busca">Busca:</label>
            <input type="text" name="busca" id="busca" value="" placeholder="Pesquisar"><br><br>

            <label for="tipo">Tipo:</label>
            <select name="tipo" id="tipo">
                <option value="0">Selecionar</option>
                <option value="1">Id</option>
                <option value="2">Descrição</option>
                <option value="3">Unidade</option>
            </select>

            <button type='submit'>Buscar</button>

        </fieldset>
    </form><br>
    
    <h1>Unidades Cadastradas:</h1>
    <br>
    <table border="1" style="text-align:center">
        <tr>
            <th>Id</th>
            <th>Descrição</th>
            <th>Unidade</th>
        </tr>
        <?php  
            foreach($lista as $unidade){
                echo "<tr><td><a href='index.php?id=".$unidade->getIdUnidade()."'>".$unidade->getIdUnidade()."</a></td><td>".$unidade->getDescricao()."</td><td>".$unidade->getSigla()."</td></tr>";
            }     
        ?>
    </table>
</body> 
</html>