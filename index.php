<?php
session_start();
include 'inc/database.php';



$categories = [];
$q = Database::query("SELECT * FROM categories");
while ($row = $q->fetch_array()) {
    $categories[] = $row;
}

$cartCount = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartCount += $item['quantity'];
    }
}

_header('HoneyBee');


navbar($categories, $cartCount, $_SESSION['user'] ?? null);

if (isset($_SESSION['success'])) {
    echo '
    <div class="container mt-4">
        <div class="alert alert-success text-center">
            '.$_SESSION['success'].'
        </div>
    </div>';
    unset($_SESSION['success']);
}

jumbotron();
body();
_footer();