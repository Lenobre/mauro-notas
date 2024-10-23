<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar turma</title>
</head>
<body>
    <form method="post">
        <label for="name">
            Nome
        </label>
        <input type="text" name="name">

        <input type="submit" value="Criar">
    </form>
    <?php 
    $name = (isset($_POST["name"])) ? $_POST["name"] : null;
    ?>

    <?php
    if ($name === null):
    ?>
        <span>Preencha o nome da classe</span>
    <?php
        return;
    endif
    ?>
    <?php
    include_once("./database.php");

    $queryResult = $pdo->prepare("insert into `turmas` (`nome`) values (:name)")->execute([":name"=> $name]);

    if ($queryResult):
    ?>
        <span>Turma cadastrada com sucesso</span>
    <?php
    endif;
    ?>
</body>
</html>