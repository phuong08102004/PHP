<?php
session_start();
include_once 'inc/database.php';

handleCartAction();

_header("Giỏ hàng");
navbar([], count($_SESSION['cart'] ?? []), $_SESSION['user'] ?? null);

echo '<div class="container my-5">';
echo '<h3 class="mb-4">Giỏ hàng của bạn</h3>';

cartBody();

echo '</div>';
_footer();
