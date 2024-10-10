<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Círculos</title>
    <?php
        include_once('circulo.php');
    ?>
</head>

<body>
<?php include('../menu.php'); ?>

    <form action="index.php" method="post">
        <fieldset>
            <legend>Cadastro de Círculos</legend>

            <label for="id">Id:</label>
            <input type="text" name="id" id="id" value="<?= isset($forma) ? $forma->getId() : 0 ?>" readonly>

            <label for="raio">Tamanho do raio:</label>
            <input type="number" name="raio" id="raio" value="<?php if (isset($forma)) echo $forma->getRaio() ?>">

            <label for="unidade">Unidade:</label>
            <select name="unidade" id="unidade">
            <?php  
                $unidades = UnidadeMedida::listar();
                foreach ($unidades as $unidade) {
                    $str = "<option value='" . $unidade->getIdUnidade() . "'";
                    if (isset($circulo))
                        if ($forma->getIdUnidade()->getIdUnidade() == $unidade->getIdUnidade())
                            $str .= " selected";
                    $str .= ">" . $unidade->getDescricao() . "</option>";
                    echo $str;
                }
            ?>
            </select>

            <label for="cor">Cor:</label>
            <input type="color" name="cor" id="cor" value="<?php if (isset($circulo)) echo $circulo->getCor() ?>"><br><br>

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
                <option value="2">Raio</option>
            </select>

            <button type='submit'>Buscar</button>
        </fieldset>
    </form>

    <br>
    <h1>Círculos Cadastrados:</h1>
    <br>
    <table border="1" style="text-align:center">
        <tr>
            <th>Id</th>
            <th>Forma</th>
            <th>Raio</th>
            <th>Unidade</th>
            <th>Cor</th>
        </tr>
        
        <?php  
            foreach ($lista as $circulo) {
                echo "<tr>
                        <td><a href='index.php?id=" . $circulo->getId() . "'>" . $circulo->getId() . "</a></td>
                        <td>Círculo</td>
                        <td>" . $circulo->getRaio() . "</td>
                        <td>" . $circulo->getIdUnidade()->getSigla() . "</td>
                        <td style='background-color: " . $circulo->getCor() . "'>" . $circulo->getCor() . "</td>
                      </tr>";
                
                // Desenha o círculo
                echo $circulo->desenhar();
            }
        ?>
    </table>
</body> 
</html>
