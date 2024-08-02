<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Удаление продукта из корзины, если параметры переданы
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
    header("Location: cart.php");
    exit();
}

// Инициализация переменной для общей суммы
$total_price = 0;

// Проверка наличия корзины и вычисление общей суммы заказа
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $total_price = array_sum(array_map(function($item) {
        return $item['price'] * $item['quantity'];
    }, $_SESSION['cart']));
}

// Обработка заказа, если нажата кнопка "Оформить заказ"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order'])) {
    $user_id = $_SESSION['user_id'];

    // Если корзина не пуста, создаем заказ
    if (!empty($_SESSION['cart'])) {
        $sql = "INSERT INTO orders (user_id, total_price) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id, $total_price]);

        $order_id = $pdo->lastInsertId();

        foreach ($_SESSION['cart'] as $product_id => $product) {
            $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$order_id, $product_id, $product['quantity']]);
        }

        // Очищаем корзину после оформления заказа
        unset($_SESSION['cart']);
        header("Location: thank_you.php");
        exit();
    } else {
        // Если корзина пуста, можно добавить соответствующее сообщение или действие
        // Например, перенаправить обратно на корзину с сообщением об ошибке
        header("Location: cart.php?error=empty_cart");
        exit();
    }
}

// Подключение заголовка страницы
include 'includes/header.php';
?>

<h1>Корзина</h1>

<?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) : ?>
    <form method="post">
        <?php foreach ($_SESSION['cart'] as $product_id => $product) : ?>
            <p>
                <?php echo htmlspecialchars($product['name']); ?> - <?php echo $product['quantity']; ?> x <?php echo $product['price']; ?>$
                <a href="cart.php?action=remove&product_id=<?php echo $product_id; ?>">Удалить</a>
            </p>
        <?php endforeach; ?>
        <p>Общая сумма: <?php echo $total_price; ?>$</p>
        <button type="submit" name="order">Оформить заказ</button>
    </form>
<?php else : ?>
    <p>Ваша корзина пуста.</p>
<?php endif; ?>


