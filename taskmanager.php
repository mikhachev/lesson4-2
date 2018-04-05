<?php

include("config.php");

$description = "";

if (empty($_GET['oper']))
{
    $oper = null;
}else
{
    $_GET['oper'];
}


if (!isset($_GET['id']) && isset($_POST['save']) && !empty($_POST['description'])) {
    $description = $_POST['description'];
    $sql = "INSERT INTO tasks (description, date_added) VALUES (?, NOW())";
    $stm = $pdo->prepare($sql);
    $stm->execute([
        $description
    ]);

    header("Loc: /emikhachev/lesson4-2/taskmanager.php");
}

if (!empty($oper) && !empty($_GET['id'])) {
    $id = (int)$_GET['id'];

    if ($oper == 'delete') {
        $sql = "DELETE FROM tasks WHERE id = ?";
        $stm = $pdo->prepare($sql);
        $stm->execute([
            $id
        ]);
    }

    if ($oper == 'done') {
        $sql = "UPDATE tasks SET is_done = 1 WHERE id = ?";
        $stm = $pdo->prepare($sql);
        $stm->execute([
            $id
        ]);

        header("Loc: /emikhachev/lesson4-2/taskmanager.php");
    }

    if (!empty($_POST['description'])) {
        $description = $_POST['description'];

        $sql = "UPDATE tasks SET description = ? WHERE id = ?";
        $stm = $pdo->prepare($sql);
        $stm->execute([
            $description,
            $id
        ]);

        header("Loc: /emikhachev/lesson4-2/taskmanager.php");
    }

    if ($oper == 'edit') {
        $sql = "SELECT description FROM tasks WHERE id = ?";
        $stm = $pdo->prepare($sql);
        $stm->execute([$id]);

        $description = $stm->fetchColumn();
    }
}

$sql = "SELECT * FROM tasks";
$stm = $pdo->prepare($sql);
$stm->execute();

$tasks = $stm->fetchAll();

?>
    <style>

        table td, table th {
            border: 1px solid #ccc;
            padding: 5px;
        }

    </style>

    <h1>Список задач для спасения мира</h1>
    <div>
        <form method="POST">
            <input type="text" name="description" placeholder="Задача" value="<?=$description?>" />
            <input type="submit" name="save" value="<?php echo ($oper == 'edit' ? 'Введите новое описание' : 'Добавить') ?>" />
        </form>
    </div>


    <table margin='1'>
        echo  <tr>
            <th>Описание задачи</th>
            <th>Дата добавления</th>
            <th>Статус</th>
            <th></th>
        </tr>
<?php foreach ($tasks as $row) {
    echo "<tr>\n";
    echo "  <td>" . $row['description'] . "</td>\n";
    echo "  <td>" . $row['date_added'] . "</td>\n";
    echo "  <td>" . ($row['is_done'] ? "Выполнено" : "В процессе") . "</td>\n";
    echo "  <td>
        <a href='?id=" . $row['id'] . "&oper=edit'>Изменить</a>
        <a href='?id=" . $row['id'] . "&oper=done'>Выполнить</a>
        <a href='?id=" . $row['id'] . "&oper=delete'>Удалить</a>
    </td>\n";
    echo "</tr>\n";
}
echo "</table>";