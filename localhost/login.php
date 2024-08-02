<?php
require 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Санитизация входных данных
    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];

    // Проверка наличия пользователя в базе данных
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username']; //  имя пользователя в сессию
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Неверное имя пользователя или пароль";
    }
}
?>

<?php include 'includes/header.php'; ?>

<h2>Авторизация</h2>
<form method="post">
    <input type="text" name="username" placeholder="Имя пользователя" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit">Войти</button>
</form>
<?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>

</main>
<?php include 'includes/footer.php'; ?>
