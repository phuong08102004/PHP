<?php

$isEdit = isset($donhang) && !empty($donhang['id']);
$actionUrl = $isEdit ? "/admin/order/update/{$donhang['id']}" : "/admin/order/store";
?>

<div class="container mt-4">
    <h2><?= $isEdit ? 'Cập nhật đơn hàng #' . $donhang['id'] : 'Thêm đơn hàng mới' ?></h2>
    
    <form action="<?= $actionUrl ?>" method="POST" class="mt-4">
        
        <div class="mb-3">
            <label>Khách hàng (User):</label>
            <select name="userId" class="form-control" required>
                <option value="">-- Chọn khách hàng --</option>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $u): ?>
                        <option value="<?= $u['id'] ?>" 
                            <?= (isset($donhang['userId']) && $donhang['userId'] == $u['id']) ? 'selected' : '' ?>>
                            ID: <?= $u['id'] ?> - <?= htmlspecialchars($u['name'] ?? $u['username']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            </div>

        <div class="mb-3">
            <label>Tổng tiền (VNĐ):</label>
            <input type="number" name="tongTien" class="form-control" value="<?= $donhang['tongTien'] ?? '' ?>" required>
        </div>

        <div class="mb-3">
            <label>Ngày đặt:</label>
            <input type="datetime-local" name="ngayDat" class="form-control" 
                   value="<?= isset($donhang['ngayDat']) ? date('Y-m-d\TH:i', strtotime($donhang['ngayDat'])) : date('Y-m-d\TH:i') ?>">
        </div>

        <div class="mb-3">
            <label>Trạng thái:</label>
            <select name="trangThai" class="form-control">
                <option value="Chờ xử lý" <?= (isset($donhang['trangThai']) && $donhang['trangThai'] == 'Chờ xử lý') ? 'selected' : '' ?>>Chờ xử lý</option>
                <option value="Đang giao" <?= (isset($donhang['trangThai']) && $donhang['trangThai'] == 'Đang giao') ? 'selected' : '' ?>>Đang giao</option>
                <option value="Hoàn thành" <?= (isset($donhang['trangThai']) && $donhang['trangThai'] == 'Hoàn thành') ? 'selected' : '' ?>>Hoàn thành</option>
                <option value="Đã hủy" <?= (isset($donhang['trangThai']) && $donhang['trangThai'] == 'Đã hủy') ? 'selected' : '' ?>>Đã hủy</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Thông tin giao hàng:</label>
            <textarea name="thongTinGiaoHang" class="form-control" rows="3"><?= $donhang['thongTinGiaoHang'] ?? '' ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Lưu thay đổi' : 'Tạo đơn hàng' ?></button>
        <a href="/admin/order" class="btn btn-secondary">Hủy bỏ</a>
    </form>
</div>