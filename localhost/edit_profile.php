<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $photo = $_FILES['photo'];

    if ($photo['name']) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($photo["name"]);
        move_uploaded_file($photo["tmp_name"], $target_file);

        $sql = "UPDATE users SET username = ?, email = ?, photo = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $email, $photo["name"], $user_id]);
    } else {
        $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $email, $user_id]);
    }

    $success = "Данные успешно обновлены.";
}

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<?php include 'includes/header.php'; ?>

<h1>Редактировать профиль</h1>
<form method="post" enctype="multipart/form-data">
    <label>Имя пользователя:</label>
    <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
    <br>
    <label>Электронная почта:</label>
    <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
    <br>
    <label>Фотография:</label>
    <input type="file" name="photo">
    <br>
    <button type="submit">Сохранить изменения</button>
</form>
<p><?php echo isset($success) ? $success : ''; ?></p>
<p><?php echo isset($error) ? $error : ''; ?></p>

<?php include 'includes/footer.php'; ?>
