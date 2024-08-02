<?php
$dsn = 'mysql:host=localhost;dbname=online_store';
$username = 'root';
$password = ''; // незнаю почему но если ставить отдельные значения даже сли убирать строчку с паролем и оставлять рут или просто тупо его убирать будет Ошибка подключения к базе данных: SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost' (using password: YES)

$options = [];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo 'Подключение не удалось: ' . $e->getMessage();
}
?>
