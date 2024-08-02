<?php include 'includes/header.php'; ?>

<h1>Добро пожаловать в наш интернет-магазин!</h1>
<p>Здесь вы можете найти множество интересных товаров.</p>

<?php
// код для получения товаров из базы данных
// массив товаров 
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

// Объединяем все товары в один массив
$allProducts = [];
foreach ($products as $categoryProducts) {
    $allProducts = array_merge($allProducts, $categoryProducts);
}
?>

<div class="products-section">
    <h2>Все товары</h2>
    <ul class="product-list">
        <?php foreach ($allProducts as $product): ?>
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
</div>

<?php include 'includes/footer.php'; ?>
