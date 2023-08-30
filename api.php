<?php

header("Content-Type: application/json");
// INSERT INTO `tbleventos` (`id`, `title`, `description`, `color`, `start`, `end`)
// VALUES (NULL, 'Evento 1', 'Flash back aniversário', '#13ec3e', '2023-08-21 20:35:42', '2023-08-22 20:35:42');

$pdo = new PDO("mysql:host=localhost;dbname=agenda", "root", "");
$conection = $pdo->prepare("SELECT * FROM tbleventos");
$conection->execute();

$result = $conection->fetchAll(PDO::FETCH_ASSOC);
print_r(json_encode($result));

