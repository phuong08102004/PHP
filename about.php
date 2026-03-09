<?php
session_start();
require_once 'inc/database.php';

// 1. Khởi tạo dữ liệu cho Navbar
$categories = [];
$q = Database::query("SELECT * FROM categories");
while($r = $q->fetch_assoc()) $categories[] = $r;

$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

// 2. Gọi giao diện
_header("Giới thiệu - Honey Bee Store");
navbar($categories, $cartCount, $user);

// 3. GỌI FUNCTION ABOUT 
about();

_footer();
?>