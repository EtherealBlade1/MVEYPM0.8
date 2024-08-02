<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Получение данных пользователя из базы данных
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Проверка на успешное выполнение запроса и наличие данных
if ($user) {
    $username = htmlspecialchars($user['username']);
    $email = htmlspecialchars($user['email']);
    $photo = htmlspecialchars($user['photo']);
} else {
    // Обработка ошибки, если пользователь не найден
    $username = 'Не найдено';
    $email = 'Не найдено';
    $photo = 'default.jpg'; // Или другой placeholder
}
?>

<?php include 'includes/header.php'; ?>

<h1>Личный кабинет</h1>
<p>Имя пользователя: <?php echo $username; ?> <a href="edit_profile.php">Редактировать</a></p>
<p>Электронная почта: <?php echo $email; ?></p>
<p>Фотография: <img src="uploads/<?php echo $photo; ?>" alt="Фото профиля" style="width: 100px; height: 100px;"></p>

<?php include 'includes/footer.php'; ?>
