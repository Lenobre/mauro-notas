<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <label for="class-id">Selecione a turma a ser listada</label>
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

        <input type="submit" value="Filtrar">
    </form>

    <?php 
    $classID = (isset($_POST["class-id"]) ? $_POST["class-id"] : null);

    if ($classID == null) 
        return;
    ?>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Turma</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $usersData = $pdo->prepare("select alunos.id as id, alunos.nome as nome, turmas.nome as turma from alunos inner join turmas on turmas.id = alunos.turma_id where turmas.id = :classID");
            $usersData->execute([":classID" => $classID]);
            $usersData = $usersData->fetchAll(PDO::FETCH_ASSOC);

            for ($i = 0; $i < count($usersData); $i++) {
                echo "<tr>";
                $data = $usersData[$i];
            
                echo "<td>" . $data["id"] . "</td>";
                echo "<td>" . $data["nome"] . "</td>";
                echo "<td>" . $data["turma"] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>