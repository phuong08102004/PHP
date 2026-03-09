<?php
session_start();
include_once 'inc/database.php';

_header("Thanh toán");
navbar([], count($_SESSION['cart'] ?? []), $_SESSION['user'] ?? null);

// xử lý đặt hàng
handleCheckout();

// thông báo
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success text-center mt-4">'
        .$_SESSION['success'].
        '</div>';
    unset($_SESSION['success']);
}

// tính tổng
$total = 0;
foreach ($_SESSION['cart'] ?? [] as $item) {
    $q = Database::query("SELECT price FROM products WHERE id=".$item['id']);
    if ($p = $q->fetch_array()) {
        $total += $p['price'] * $item['quantity'];
    }
}

checkoutForm($total);

_footer();
