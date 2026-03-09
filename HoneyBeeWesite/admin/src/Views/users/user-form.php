<?php 
/**
 * src/Views/users/user-form.php
 */
ob_start(); 
$isEdit = isset($user) && isset($user['id']);
?>

<style>
    .form-container { font-family: 'Segoe UI', sans-serif; max-width: 600px; margin: 50px auto; background: #fff; padding: 40px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-top: 5px solid #f4b400; }
    .form-title { font-weight: 800; margin-bottom: 30px; text-align: center; color: #111; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; font-size: 14px; }
    .form-control { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 15px; }
    .form-control:focus { border-color: #f4b400; outline: none; box-shadow: 0 0 5px rgba(244, 180, 0, 0.3); }
    
    .btn-group { display: flex; gap: 10px; margin-top: 30px; }
    .btn-submit { flex: 2; background: #f4b400; color: #000; border: none; padding: 15px; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 16px; }
    .btn-cancel { flex: 1; background: #eee; color: #333; text-align: center; padding: 15px; border-radius: 6px; text-decoration: none; font-weight: bold; }
    .btn-submit:hover { background: #111; color: #f4b400; }
</style>

<div class="form-container">
    <h2 class="form-title"><?= $isEdit ? 'CẬP NHẬT THÀNH VIÊN' : 'TẠO TÀI KHOẢN MỚI' ?></h2>

    <form method="POST" action="<?= $isEdit ? '/admin/user/update/' . $user['id'] : '/admin/user/store' ?>">
        
        <div class="form-group">
            <label>Họ và tên</label>
            <input type="text" class="form-control" name="name" value="<?= $user['name'] ?? '' ?>" required placeholder="Ví dụ: Nguyễn Văn A">
        </div>

        <div class="form-group">
            <label>Email liên hệ</label>
            <input type="email" class="form-control" name="email" value="<?= $user['email'] ?? '' ?>" required placeholder="email@example.com">
        </div>

        <div class="form-group">
            <label>Số điện thoại</label>
            <input type="text" class="form-control" name="phone" value="<?= $user['phone'] ?? '' ?>" required>
        </div>

        <div class="form-group">
            <label>Mật khẩu <?= $isEdit ? '(Để trống nếu giữ nguyên)' : '' ?></label>
            <input type="password" class="form-control" name="password" <?= $isEdit ? '' : 'required' ?>>
        </div>

        <div class="form-group">
            <label>Phân quyền hệ thống</label>
            <select name="role" class="form-control">
                <option value="0" <?= (isset($user['role']) && $user['role'] == 0) ? 'selected' : '' ?>>Khách hàng (User)</option>
                <option value="1" <?= (isset($user['role']) && $user['role'] == 1) ? 'selected' : '' ?>>Quản trị viên (Admin)</option>
            </select>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn-submit">LƯU THÔNG TIN</button>
            <a href="/admin/user" class="btn-cancel">HỦY</a>
        </div>
    </form>
</div>

<?php 
$content = ob_get_clean(); 
echo $content; ?>