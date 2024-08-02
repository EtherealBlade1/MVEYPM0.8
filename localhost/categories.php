<?php
// Подключение заголовка
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Категории товаров</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .category-list {
            list-style-type: none;
            padding: 0;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .category-item {
            margin: 20px;
            text-align: center;
        }

        .category-link {
            color: black;
            text-decoration: none;
        }

        .category-link:hover .category-name {
            text-decoration: underline;
        }

        .category-image {
            width: 150px;
            height: 150px;
            object-fit: contain; /* Изображение будет полностью видно */
            border-radius: 10px;
            margin-bottom: 10px;
            background-color: #f5f5f5; /* Фон для изображений с прозрачностью */
            padding: 10px;
            box-sizing: border-box;
        }

        .category-name {
            display: block;
            margin-top: 10px;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <h1>Категории товаров</h1>
    <ul class="category-list">
        <li class="category-item">
            <a class="category-link" href="products.php?category=smartphones">
                <img src="images/smartphones.jpg" alt="Смартфоны" class="category-image">
                <span class="category-name">Смартфоны</span>
            </a>
        </li>
        <li class="category-item">
            <a class="category-link" href="products.php?category=tablets">
                <img src="images/tablets.jpg" alt="Планшеты" class="category-image">
                <span class="category-name">Планшеты</span>
            </a>
        </li>
        <li class="category-item">
            <a class="category-link" href="products.php?category=computers">
                <img src="images/computers.jpg" alt="Компьютеры" class="category-image">
                <span class="category-name">Компьютеры</span>
            </a>
        </li>
    </ul>
</body>


</html>
