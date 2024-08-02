<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Получение последнего заказа пользователя для отображения информации о заказе
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$order = $stmt->fetch();

if ($order) {
    $order_id = $order['id'];
    $total_price = $order['total_price'];

    // Получение элементов заказа
    $sql = "SELECT products.name, order_items.quantity, order_items.product_id 
            FROM order_items 
            JOIN products ON order_items.product_id = products.id 
            WHERE order_items.order_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$order_id]);
    $order_items = $stmt->fetchAll();
} else {
    // В случае если заказ не найден, можно добавить обработку ошибки
    $order_items = [];
    $total_price = 0;
}

// Подключение заголовка
include 'includes/header.php';
?>

<h1>Спасибо за ваш заказ!</h1>

<?php if ($order) : ?>
    <p>Ваш заказ успешно оформлен. Номер заказа: <?php echo $order_id; ?></p>
    <p>Общая сумма заказа: <?php echo $total_price; ?>$</p>

    <h2>Детали заказа</h2>
    <ul>
        <?php foreach ($order_items as $item) : ?>
            <li><?php echo htmlspecialchars($item['name']); ?> - Количество: <?php echo $item['quantity']; ?></li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p>Не удалось получить информацию о вашем заказе. Пожалуйста, свяжитесь с поддержкой.</p>
<?php endif; ?>

<?php
// Подключение футера
include 'includes/footer.php';
?>
