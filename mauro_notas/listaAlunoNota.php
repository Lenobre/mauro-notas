<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <label for="student-id">Selecionar aluno</label>
        <select name="student-id">
            <?php 
            include_once("./database.php");
            $students = $pdo->query("select alunos.id as id, alunos.nome as nome, turmas.nome as turma from `alunos` inner join turmas on turmas.id = alunos.turma_id")->fetchAll();

            for ($i = 0; $i < count($students); $i++):
                $student = $students[$i];
            ?>
                <option value="<?= $student["id"] ?>"><?= $student["nome"] . " - " . $student["turma"] ?></option>
            <?php 
            endfor;
            ?>
        </select>

        <input type="submit" value="Filtrar">
    </form>

    <?php 
    $userID = (isset($_POST["student-id"]) ? $_POST["student-id"] : null);

    if ($userID == null) 
        return;
    ?>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Turma</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $usersData = $pdo->prepare("select alunos.id as id, alunos.nome as nome, turmas.nome as turma, notas.valor as nota from alunos inner join turmas on turmas.id = alunos.turma_id inner join notas on notas.aluno_id = :userID where alunos.id = :userID");
            $usersData->execute([":userID" => $userID]);
            $usersData = $usersData->fetchAll(PDO::FETCH_ASSOC);

            for ($i = 0; $i < count($usersData); $i++) {
                echo "<tr>";
                $data = $usersData[$i];
            
                echo "<td>" . $data["id"] . "</td>";
                echo "<td>" . $data["nome"] . "</td>";
                echo "<td>" . $data["turma"] . "</td>";
                echo "<td>" . $data["nota"] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>