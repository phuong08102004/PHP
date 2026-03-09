<?php
/**
 * donhang/donhang-list.php
 */
ob_start(); ?>

<style>
    
    .order-container {
        font-family: Arial, sans-serif;
        color: #333;
    }
    .order-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #111;
    }
    .order-table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .order-table th {
        background-color: #111;
        color: #fff;
        text-align: left;
        padding: 12px 15px;
    }
    .order-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
    }
    .order-table tr:hover {
        background-color: #f9f9f9;
    }
    .price-text {
        color: #d93025;
        font-weight: bold;
    }
    .status-badge {
        padding: 4px 8px;
        border-radius: 4px;
        background: #f1f3f4;
        font-size: 13px;
    }
    .btn-edit {
        color: #1a73e8;
        text-decoration: none;
        margin-right: 5px;
    }
    .btn-delete {
        color: #d93025;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-add-new {
        display: inline-block;
        margin-top: 25px;
        padding: 10px 20px;
        background: #28a745;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        transition: background 0.3s;
    }
    .btn-add-new:hover {
        background: #218838;
    }
</style>

<div class="order-container">
    <h1 class="order-title">Danh sách đơn hàng</h1>

    <table class="order-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Tổng tiền</th>
                <th>Ngày đặt</th>
                <th>Trạng thái</th>
                <th>Thông tin giao hàng</th>
                <th style="text-align: center;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($donhangs)): ?>
            <?php foreach ($donhangs as $dh): ?>
                <tr>
                    <td align="center"><?= $dh['id'] ?></td>
                    <td align="center"><?= (int)$dh['userId'] ?></td>
                    <td align="right" class="price-text">
                        <?= number_format($dh['tongTien'], 0, ',', '.') ?> VNĐ
                    </td>
                    <td align="center">
                        <?= date('d/m/Y H:i', strtotime($dh['ngayDat'])) ?>
                    </td>
                    <td align="center">
                        <span class="status-badge">
                            <?= htmlspecialchars($dh['trangThai']) ?>
                        </span>
                    </td>
                    <td style="font-size: 14px; line-height: 1.4;">
                        <?= nl2br(htmlspecialchars($dh['thongTinGiaoHang'])) ?>
                    </td>
                    <td align="center">
                        <a href="/admin/order/edit/<?= $dh['id'] ?>" class="btn-edit">Sửa</a>
                        <span style="color: #ccc;">|</span>
                        <a href="/admin/order/delete/<?= $dh['id'] ?>" 
                           class="btn-delete" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">
                           Xóa
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7" align="center" style="padding: 40px;">Chưa có đơn hàng nào trong hệ thống.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <a href="/admin/order/create" class="btn-add-new">
        + Thêm đơn hàng mới
    </a>
</div>

<?php 
$content = ob_get_clean(); 
echo $content; 
?>