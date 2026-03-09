<?php
session_start();
include_once 'inc/database.php';

$keyword = $_GET['keyword'] ?? '';

_header("Tìm kiếm sản phẩm");
navbar([], count($_SESSION['cart'] ?? []), $_SESSION['user'] ?? null);

if ($keyword != '') {
    searchBody($keyword);
} else {
    echo '<div class="container my-5"><p>Vui lòng nhập từ khóa tìm kiếm.</p></div>';
}

_footer();
