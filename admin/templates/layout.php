<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Admin HoneyBee' ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #f5f6fa; }
        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: #111;
        }
        .sidebar a {
            color: #fff;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #f4b400;
            color: #000;
        }
        .content {
            padding: 30px;
        }
    </style>
</head>
<body>

<div class="d-flex">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h5 class="text-warning text-center py-3">HONEYBEE ADMIN</h5>

        <a href="/admin">Dashboard</a>
        <a href="/admin/user">Quản lý User</a>
        <a href="/admin/order">Quản lý Đơn hàng</a>
        <a href="/admin/product">Quản lý Sản phẩm</a>

        <hr class="text-secondary">

        <a href="/">← Về website</a>
        <a href="/logout.php">Đăng xuất</a>
    </div>

    <!-- CONTENT -->
    <div class="flex-grow-1 content">
        <?= $content ?>
    </div>

</div>

</body>
</html>