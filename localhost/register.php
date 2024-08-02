<?php
require 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Санитизация входных данных
    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    // Валидация данных
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Неверный формат электронной почты";
    } elseif (strlen($password) < 6) {
        $error = "Пароль должен содержать не менее 6 символов";
    } else {
        // Хеширование пароля
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Вставка пользователя в базу данных
        $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        try {
            $stmt->execute([$username, $hashed_password, $email]);
            header("Location: login.php");
            exit();
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Дубликат записи
                $error = "Пользователь с таким именем или почтой уже существует";
            } else {
                $error = "Произошла ошибка при регистрации";
            }
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<h2>Регистрация</h2>
<form method="post">
    <input type="text" name="username" placeholder="Имя пользователя" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <input type="email" name="email" placeholder="Электронная почта" required>
    <button type="submit">Регистрация</button>
</form>
<?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>

</main>
<?php include 'includes/footer.php'; ?>
