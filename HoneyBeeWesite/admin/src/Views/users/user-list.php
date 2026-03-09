<?php 
/**
 * src/Views/users/user-list.php
 */
ob_start(); ?>

<style>
    .admin-container { font-family: 'Segoe UI', Arial, sans-serif; padding: 30px; background: #f9f9f9; min-height: 100vh; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 3px solid #f4b400; padding-bottom: 10px; }
    .page-title { color: #111; font-weight: 800; text-transform: uppercase; margin: 0; }
    
    .user-table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-radius: 8px; overflow: hidden; }
    .user-table th { background: #111; color: #f4b400; padding: 15px; text-align: left; font-size: 13px; letter-spacing: 1px; }
    .user-table td { padding: 15px; border-bottom: 1px solid #eee; vertical-align: middle; color: #444; }
    .user-table tr:hover { background: #fffdf5; }

    .role-badge { padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; text-transform: uppercase; }
    .role-admin { background: #f4b400; color: #000; }
    .role-user { background: #eee; color: #777; }

    .btn-honey { background: #f4b400; color: #000; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; transition: 0.3s; border: none; }
    .btn-honey:hover { background: #111; color: #f4b400; }
    
    .action-link { text-decoration: none; font-weight: 600; margin-right: 10px; font-size: 14px; }
    .edit-link { color: #007bff; }
    .delete-link { color: #dc3545; }
</style>

<div class="admin-container">
    <div class="page-header">
        <h2 class="page-title">🐝 Quản lý khách hàng</h2>
        <a href="/admin/user/create" class="btn-honey">+ Thêm thành viên</a>
    </div>

    <table class="user-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>HỌ TÊN</th>
                <th>EMAIL</th>
                <th>SỐ ĐIỆN THOẠI</th>
                <th>QUYỀN HẠN</th>
                <th style="text-align: center;">HÀNH ĐỘNG</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $u): ?>
            <tr>
                <td>#<?= $u['id'] ?></td>
                <td><strong><?= htmlspecialchars($u['name']) ?></strong></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= htmlspecialchars($u['phone']) ?></td>
                <td>
                    <span class="role-badge <?= $u['role'] == 1 ? 'role-admin' : 'role-user' ?>">
                        <?= $u['role'] == 1 ? 'Quản trị' : 'Khách hàng' ?>
                    </span>
                </td>
                <td align="center">
                    <a href="/admin/user/edit/<?= $u['id'] ?>" class="action-link edit-link">Sửa</a>
                    <a href="/admin/user/delete/<?= $u['id'] ?>" 
                       class="action-link delete-link" 
                       onclick="return confirm('Bạn có chắc muốn xóa thành viên này?')">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php 
$content = ob_get_clean(); 
echo $content; ?>