<?php
require 'config.php';
session_start();

// Проверка авторизации пользователя
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Проверка данных POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $quantity = $_POST['quantity'];

    // Инициализация корзины, если её нет
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Добавление продукта в корзину
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = [
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => $quantity
        ];
    }

    header("Location: cart.php");
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>
