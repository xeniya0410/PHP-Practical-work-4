<?php
$products = [
    [
        "product_id" => 101,
        "name" => "Laptop",
        "price" => 85000,
        "in_stock" => true
    ],
    [
        "product_id" => 102,
        "name" => "Smartphone",
        "price" => 15000,
        "in_stock" => true
    ],
    [
        "product_id" => 103,
        "name" => "Headphones",
        "price" => 5000,
        "in_stock" => false
    ],
    [
        "product_id" => 104,
        "name" => "Monitor",
        "price" => 32000,
        "in_stock" => true
    ],
    [
        "product_id" => 105,
        "name" => "Keyboard",
        "price" => 4500,
        "in_stock" => true
    ]
];


function checkProductAvailability($products, $product_id)
{
    foreach ($products as $p) {
        if ($p['product_id'] == $product_id) {
            echo "Товар найден: {$p['name']} | Цена: " . number_format($p['price'], 0, '', ' ') . " тг.\n";
            return;
        }
    }
    echo "Товар с ID $product_id не найден.\n";
}


function applyDiscount($products, $discountPercent)
{
    $products_on_sale = [];
    foreach ($products as $p) {
        $newPrice = $p['price'];
        if ($p['in_stock']) {
            $newPrice = $p['price'] * (1 - $discountPercent / 100);
        }
        $products_on_sale[] = [
            "product_id" => $p['product_id'],
            "name" => $p['name'],
            "price" => $newPrice,
            "in_stock" => $p['in_stock']
        ];
    }

    echo "Список товаров со скидкой {$discountPercent}%:\n";
    foreach ($products_on_sale as $p) {
        $status = $p['in_stock'] ? "В наличии" : "Нет в наличии";
        echo "ID: {$p['product_id']} | {$p['name']} | " . number_format($p['price'], 0, '', ' ') . " тг. | {$status}\n";
    }
    return $products_on_sale;
}


function getProductNames($products)
{
    $names = array_column($products, 'name');
    echo "Список названий товаров:\n";
    foreach ($names as $n) {
        echo "- $n\n";
    }
    return $names;
}


function sortProductsByPrice(&$products)
{
    $prices = array_column($products, 'price');
    array_multisort($prices, SORT_ASC, $products);

    echo "Сортировка товаров по цене по возрастанию:\n";
    foreach ($products as $p) {
        $status = $p['in_stock'] ? "В наличии" : "Нет в наличии";
        echo "ID: {$p['product_id']} | {$p['name']} | " . number_format($p['price'], 0, '', ' ') . " тг. | {$status}\n";
    }
}

do {
    echo "\n=============================\n";
    echo "Каталог интернет-магазина\n";
    echo "=============================\n";
    echo "1 – Проверить наличие товара по ID\n";
    echo "2 – Применить скидку к товарам\n";
    echo "3 – Получить список названий товаров\n";
    echo "4 – Сортировать товары по цене\n";
    echo "0 – Выход\n";
    echo "-----------------------------\n";

    $choice = readline("Ваш выбор: ");

    switch ($choice) {
        case 1:
            $id = readline("Введите ID товара: ");
            checkProductAvailability($products, $id);
            break;
        case 2:
            $discount = readline("Введите размер скидки (%): ");
            $products = applyDiscount($products, $discount);
            break;
        case 3:
            getProductNames($products);
            break;
        case 4:
            sortProductsByPrice($products);
            break;
        case 0:
            echo "Выход...\n";
            break;
        default:
            echo "Неверный выбор!\n";
            break;
    }
} while ($choice != 0);
