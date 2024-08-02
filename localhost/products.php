<?php
// Подключение заголовка
include 'includes/header.php';

// Получение категории из GET параметра
$category = isset($_GET['category']) ? $_GET['category'] : 'all';

// код для получения товаров из базы данных в зависимости от категории
//  массив товаров 
$products = [
    'smartphones' => [
        ['id' => 1, 'name' => 'iPhone 13', 'image' => 'images/iphone13.jpg', 'price' => 999],
        ['id' => 2, 'name' => 'Samsung Galaxy S21', 'image' => 'images/galaxy_s21.jpg', 'price' => 899],
        ['id' => 3, 'name' => 'Google Pixel 6', 'image' => 'images/pixel6.jpg', 'price' => 799]
    ],
    'tablets' => [
        ['id' => 4, 'name' => 'iPad Pro', 'image' => 'images/ipad_pro.jpg', 'price' => 1099],
        ['id' => 5, 'name' => 'Samsung Galaxy Tab S7', 'image' => 'images/galaxy_tab_s7.jpg', 'price' => 649],
        ['id' => 6, 'name' => 'Microsoft Surface Pro 7', 'image' => 'images/surface_pro7.jpg', 'price' => 749]
    ],
    'computers' => [
        ['id' => 7, 'name' => 'MacBook Pro', 'image' => 'images/macbook_pro.jpg', 'price' => 1299],
        ['id' => 8, 'name' => 'Dell XPS 13', 'image' => 'images/dell_xps13.jpg', 'price' => 999],
        ['id' => 9, 'name' => 'HP Spectre x360', 'image' => 'images/hp_spectre_x360.jpg', 'price' => 1099]
    ]
];

// Если категория указана неправильно, показываем все товары
if (!array_key_exists($category, $products)) {
    $category = 'all';
}

// Если категория "все", объединяем все товары в один массив
if ($category === 'all') {
    $allProducts = [];
    foreach ($products as $categoryProducts) {
        $allProducts = array_merge($allProducts, $categoryProducts);
    }
    $productsToShow = $allProducts;
} else {
    $productsToShow = $products[$category];
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Товары</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .product-list {
            list-style-type: none;
            padding: 0;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .product-item {
            margin: 20px;
            text-align: center;
        }

        .product-link {
            color: black;
            text-decoration: none;
        }

        .product-link:hover .product-name {
            text-decoration: underline;
        }

        .product-image {
            width: 150px;
            height: 150px;
            object-fit: contain; /* Изображение будет полностью видно */
            border-radius: 10px;
            margin-bottom: 10px;
            background-color: #f5f5f5; /* Фон для изображений с прозрачностью */
            padding: 10px;
            box-sizing: border-box;
        }

        .product-name {
            display: block;
            margin-top: 10px;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <h1>Товары</h1>
    <ul class="product-list">
        <?php foreach ($productsToShow as $product): ?>
            <li class="product-item">
                <a class="product-link" href="#">
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="product-image">
                    <span class="product-name"><?php echo $product['name']; ?></span>
                </a>
                <form action="add_to_cart.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
                    <input type="number" name="quantity" value="1" min="1" style="width: 50px;">
                    <button type="submit">Добавить в корзину</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>


