<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Quadrados</title>
    <?php
        include_once('quadrado.php'); // Inclui o arquivo de processamento
    ?>
</head>

<body>
    <?php include('../menu.php'); ?> <!-- Inclui o menu -->

    <form action="index.php" method="post">
        <fieldset>
            <legend>Cadastro de Quadrados</legend>

            <label for="id">Id:</label>
            <input type="text" name="id" id="id" value="<?= isset($forma) ? $forma->getId() : 0 ?>" readonly>

            <label for="lado">Tamanho do lado:</label>
            <input type="number" name="lado" id="lado" value="<?php if (isset($forma)) echo $forma->getLado() ?>">

            <label for="unidade">Unidade:</label>
            <select name="unidade" id="unidade">
            <?php  
                // Lista as unidades de medida
                $unidades = UnidadeMedida::listar();
                foreach ($unidades as $unidade) {
                    $str = "<option value='" . $unidade->getIdUnidade() . "'";
                    if (isset($forma) && $forma->getIdUnidade()->getIdUnidade() == $unidade->getIdUnidade()) {
                        $str .= " selected";
                    }
                    $str .= ">" . $unidade->getDescricao() . "</option>";
                    echo $str;
                }
            ?>
            </select>

            <label for="cor">Cor:</label>
            <input type="color" name="cor" id="cor" value="<?php if (isset($quadrado)) echo $quadrado->getCor() ?>"><br><br>

            <button type='submit' name='acao' value='salvar'>Salvar</button>
            <button type='submit' name='acao' value='excluir'>Excluir</button>
            <button type='submit' name='acao' value='alterar'>Alterar</button>

        </fieldset>
    </form>

    <form action="" method="get">
        <fieldset>
            <legend>Pesquisar</legend>

            <label for="busca">Busca:</label>
            <input type="text" name="busca" id="busca" value="" placeholder="Pesquisar"><br><br>

            <label for="tipo">Tipo:</label>
            <select name="tipo" id="tipo">
                <option value="0">Selecione</option>
                <option value="1">Id</option>
                <option value="2">Lado</option>
            </select>

            <button type='submit'>Buscar</button>
        </fieldset>
    </form>

    <br>
    <h1>Quadrados Cadastrados:</h1>
    <br>
    <table border="1" style="text-align:center">
        <tr>
            <th>Id</th>
            <th>Forma</th>
            <th>Lado</th>
            <th>Unidade</th>
            <th>Cor</th>
        </tr>
        
        <?php  
            // Lista os quadrados cadastrados
            foreach ($lista as $quadrado) {
                echo "<tr>
                        <td><a href='index.php?id=" . $quadrado->getId() . "'>" . $quadrado->getId() . "</a></td>
                        <td>Quadrado</td>
                        <td>" . $quadrado->getLado() . "</td>
                        <td>" . $quadrado->getIdUnidade()->getSigla() . "</td>
                        <td style='background-color: " . $quadrado->getCor() . "'>" . $quadrado->getCor() . "</td>
                      </tr>";
                
                // Desenha o quadrado
                echo $quadrado->desenhar();
            }
        ?>
    </table>
</body> 
</html>
