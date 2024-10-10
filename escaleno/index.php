<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Triângulos Escalenos</title>
    <?php
        include_once('../escaleno/TrianguloEscaleno.php');
        include_once('../classes/TrianguloEscaleno.class.php');  // Incluindo o Triângulo Escaleno
    ?>
</head>
<body>
<?php include('../menu.php'); ?>

<form action="TrianguloEscaleno.php" method="post">
    <fieldset>
        <legend>Cadastro de Triângulos Escalenos</legend>

        <label for="id">Id:</label>
        <input type="text" name="id" id="id" value="<?= isset($forma) ? $forma->getId() : 0 ?>" readonly>

        <label for="lado">Tamanho da base:</label>
        <input type="number" name="lado" id="lado" value="<?= isset($forma) ? $forma->getLado() : 0 ?>">

        <label for="lado2">Tamanho do lado 2:</label>
        <input type="number" name="lado2" id="lado2" value="<?= isset($forma) ? $forma->getLado2() : 0 ?>">

        <label for="lado3">Tamanho do lado 3:</label>
        <input type="number" name="lado3" id="lado3" value="<?= isset($forma) ? $forma->getLado3() : 0 ?>">

        <label for="unidade">Unidade:</label>
        <select name="unidade" id="unidade">
        <?php
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
            <input type="color" name="cor" id="cor" value="<?php if (isset($triangulo)) echo $triangulo->getCor() ?>"><br><br>

            <button type='submit' name='acao' value='salvar'>Salvar</button>
            <button type='submit' name='acao' value='excluir'>Excluir</button>
            <button type='submit' name='acao' value='alterar'>Alterar</button>

        </fieldset>
    </form>

    <br>
    <h1>Triângulos Escalenos Cadastrados:</h1>
    <br>
    <table border="1" style="text-align:center">
        <tr>
            <th>Id</th>
            <th>Forma</th>
            <th>Base</th>
            <th>Lado 2</th>
            <th>Lado 3</th>
            <th>Unidade</th>
            <th>Cor</th>
        </tr>
        
        <?php  
            // Listando apenas triângulos escalenos
            $lista = TrianguloEscaleno::listar(); // Remove as condições de busca

            foreach ($lista as $triangulo) {
                echo "<tr>
                        <td><a href='index.php?id=" . $triangulo->getId() . "'>" . $triangulo->getId() . "</a></td>
                        <td>Triângulo Escaleno</td>
                        <td>" . $triangulo->getLado() . "</td>
                        <td>" . $triangulo->getLado2() . "</td>
                        <td>" . $triangulo->getLado3() . "</td>
                        <td>" . $triangulo->getIdUnidade()->getSigla() . "</td>
                        <td style='background-color: " . $triangulo->getCor() . "'></td>
                      </tr>";
                
                // Desenha o triângulo
                echo $triangulo->desenhar();
            }
        ?>
    </table>
</body> 
</html>
