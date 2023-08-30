<?php

header("Content-Type: application/json");
// INSERT INTO `tbleventos` (`id`, `title`, `description`, `color`, `start`, `end`)
// VALUES (NULL, 'Evento 1', 'Flash back aniversário', '#13ec3e', '2023-08-21 20:35:42', '2023-08-22 20:35:42');

$pdo = new PDO("mysql:host=localhost;dbname=agenda", "root", "");


$action = (isset($_GET['action'])) ? $_GET['action'] : 'read';

switch ($action) {
    case 'read':
        $conection = $pdo->prepare("SELECT * FROM tbleventos");
        $conection->execute();
        $result = $conection->fetchAll(PDO::FETCH_ASSOC);
        print_r(json_encode($result));
        break;
    case'create':
        $conection = $pdo->prepare(
            " INSERT INTO `tbleventos` (`id`, `title`, `description`, `color`, `start`, `end`) VALUES (NULL, :title, :description, :color, :start, :end)"
        );
        $conection->execute(
            array(
                "title" => $_POST['title'],
                "description" => $_POST['description'],
                "color" => $_POST['color'],
                "start" => $_POST['fecha'] . " " . $_POST['hora'] . ":00",
                "end" => $_POST['fecha'] . " " . $_POST['hora'] . ":00",

            )
        );
        print_r($_POST);
        break;
    case "update":
        $conection = $pdo->prepare(
            "UPDATE `tbleventos` SET title=:title, description=:description, color=:color, start=:start, end=:end WHERE id =:id"
        );
        $conection->execute(
            array(
                "id" => $_POST['id'],
                "title" => $_POST['title'],
                "description" => $_POST['description'],
                "color" => $_POST['color'],
                "start" => $_POST['fecha'] . " " . $_POST['hora'] . ":00",
                "end" => $_POST['fecha'] . " " . $_POST['hora'] . ":00",
            )
        );
        print_r($_POST);
        break;

    case "delete":
        $conection = $pdo->prepare("DELETE FROM tbleventos WHERE id =:id");
        $conection->execute(
            array(
                "id" => $_POST['id']
            )
        );
        print_r($_POST);
        break;
}


