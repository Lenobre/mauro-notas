<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar aluno</title>
</head>
<body>
    <form method="post">
        <label for="name">
            Nome
        </label>
        <input type="text" name="name">

        <label for="class-id">Selecionar turma</label>
        <select name="class-id">
            <?php 
            include_once("./database.php");

            $classes = $pdo->query("select id, nome from `turmas`")->fetchAll();

            for ($i = 0; $i < count($classes); $i++):
                $class = $classes[$i];
            ?>
                <option value="<?= $class["id"] ?>"><?= $class["nome"] ?></option>
            <?php 
            endfor;
            ?>
        </select>

        <input type="submit" value="Criar">
    </form>
    <?php 
    $name = (isset($_POST["name"])) ? $_POST["name"] : "";
    $classID = (isset($_POST["class-id"])) ? $_POST["class-id"] : "";

    if ($name === "") {
        echo "<span>Preencha o nome do aluno</span>";
        return;
    }

    if ($classID === "")  {
        echo "<span>Selecione a turma do aluno</span>";
        return;
    }

    $existClass = $pdo->prepare("select id from `turmas` where `id` = :classID")->execute([":classID" => $classID]);

    if (!$existClass)  {
        echo "<span>A turma selecionada não existe.</span>";
        return;
    }

    $queryResult = $pdo->prepare("insert into `alunos` (`nome`, `turma_id`) values (:name, :classID)")->execute([":name"=> $name, ":classID" => $classID]);

    if ($queryResult)
        echo "<span>Aluno cadastrado com sucesso</span>";

    ?>
</body>
</html>