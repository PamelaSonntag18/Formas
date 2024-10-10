<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Triângulos</title>
    <?php
        include_once('../triangulo/triangulo.php');
    ?>
</head>
<body>
<?php include('../menu.php'); ?>

    <form action="index.php" method="post">
        <fieldset>
            <legend>Cadastro de Triângulos Equiláteros:</legend>

            <label for="id">Id:</label>
            <input type="text" name="id" id="id" value="<?= isset($forma) ? $forma->getId() : 0 ?>" readonly>

            <label for="lado">Tamanho da base:</label>
            <input type="number" name="lado" id="lado" value="<?php if (isset($forma)) echo $forma->getLado() ?>">

            <label for="altura">Altura:</label>
            <input type="number" name="altura" id="altura" value="<?php if (isset($forma)) echo $forma->getAltura() ?>">

            <label for="unidade">Unidade:</label>
            <select name="unidade" id="unidade">
            <?php  
                $unidades = UnidadeMedida::listar();
                foreach ($unidades as $unidade) {
                    $str = "<option value='" . $unidade->getIdUnidade() . "'";
                    if (isset($triangulo))
                        if ($forma->getIdUnidade()->getIdUnidade() == $unidade->getIdUnidade())
                            $str .= " selected";
                    $str .= ">" . $unidade->getDescricao() . "</option>";
                    echo $str;
                }
            ?>
            </select>

            <label for="cor">Cor:</label>
            <input type="color" name="cor" id="cor" value="<?php if (isset($triangulo)) echo $triangulo->getCor() ?>"><br><br>

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
                <option value="2">Base</option>
            </select>

            <button type='submit'>Buscar</button>
        </fieldset>
    </form>

    <br>
    <h1>Triângulos Equiláteros Cadastrados:</h1>
    <br>
    <table border="1" style="text-align:center">
        <tr>
            <th>Id</th>
            <th>Forma</th>
            <th>Base</th>
            <th>Altura</th>
            <th>Unidade</th>
            <th>Cor</th>
        </tr>
        
        <?php  
            foreach ($lista as $triangulo) {
                echo "<tr>
                        <td><a href='index.php?id=" . $triangulo->getId() . "'>" . $triangulo->getId() . "</a></td>
                        <td>Triângulo</td>
                        <td>" . $triangulo->getLado() . "</td>
                        <td>" . $triangulo->getAltura() . "</td>
                        <td>" . $triangulo->getIdUnidade()->getSigla() . "</td>
                        <td style='background-color: " . $triangulo->getCor() . "'>" ."</td>
                      </tr>";
                
                // Desenha o triângulo
                echo $triangulo->desenhar();
            }
        ?>
    </table>
</body> 
</html>
