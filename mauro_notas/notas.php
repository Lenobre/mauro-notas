<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar aluno</title>
</head>
<body>
    <form method="post">
        <label for="note">
            Nota
        </label>
        <input type="number" name="note" min="0" max="10">

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

        <input type="submit" value="Criar">
    </form>
    <?php 
    $value = (isset($_POST["note"])) ? $_POST["note"] : "";
    $studentID = (isset($_POST["student-id"])) ? $_POST["student-id"] : "";

    if ($value === "") {
        echo "<span>Preencha a nota do aluno</span>";
        return;
    }

    $value = intval($value);
    if ($value < 0 || $value > 10) {
        echo "<span>Insira uma nota válida<span>";
        return;
    }

    if ($studentID === "")  {
        echo "<span>Selecione o aluno</span>";
        return;
    }

    $existStudent = $pdo->prepare("select id from `alunos` where `id` = :studentID")->execute([":studentID" => $studentID]);

    if (!$existStudent)  {
        echo "<span>O aluno selecionado não existe.</span>";
        return;
    }

    $queryResult = $pdo->prepare("insert into `notas` (`aluno_id`, `valor`) values (:studentID, :value)")->execute([":studentID"=> $studentID, ":value" => $value]);

    if ($queryResult)
        echo "<span>Nota cadastrada com sucesso</span>";
    ?>
</body>
</html>