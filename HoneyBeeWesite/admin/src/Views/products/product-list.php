<?php ob_start(); ?>

<style>
    :root { --honey: #f4b400; --dark: #111; }
    
    .admin-card { background: #fff; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden; margin-top: 20px; }
    
    /* Header */
    .card-header-custom { background: var(--dark); color: var(--honey); padding: 20px 30px; display: flex; justify-content: space-between; align-items: center; }
    .btn-add { background: var(--honey); color: var(--dark); padding: 10px 20px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 14px; transition: 0.3s; }
    .btn-add:hover { background: #fff; color: var(--dark); }

    /* Table */
    .product-table { width: 100%; border-collapse: collapse; }
    .product-table th { background: #f8f9fa; color: #666; padding: 15px; text-align: left; font-size: 12px; text-transform: uppercase; border-bottom: 2px solid #eee; }
    .product-table td { padding: 15px; border-bottom: 1px solid #eee; vertical-align: middle; }
    
    .product-img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 2px solid var(--honey); }
    .price-tag { color: #d32f2f; font-weight: bold; font-size: 15px; }
    .stock-badge { background: #fff3cd; color: #856404; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }

    .action-group { display: flex; gap: 15px; align-items: center; justify-content: flex-start; }
    .action-btn { text-decoration: none; font-weight: 600; font-size: 14px; transition: 0.2s; }
    .edit-btn { color: #007bff; }
    .edit-btn:hover { color: #0056b3; text-decoration: underline; }
    .delete-btn { color: #dc3545; }
    .delete-btn:hover { color: #a71d2a; text-decoration: underline; }

    /* Pagination */
    .pagination { display: flex; justify-content: center; gap: 8px; padding: 30px; list-style: none; }
    .page-link { padding: 8px 16px; border: 1px solid #ddd; text-decoration: none; color: #333; border-radius: 4px; transition: 0.3s; }
    .page-link:hover { background: #f8f9fa; }
    .page-link.active { background: var(--honey); border-color: var(--honey); font-weight: bold; color: var(--dark); }
</style>

<div class="admin-card">
    <div class="card-header-custom">
        <h2 style="margin:0; font-size: 22px;">🐝 QUẢN LÝ KHO MẬT ONG</h2>
        <a href="/admin/product/create" class="btn-add">+ THÊM SẢN PHẨM</a>
    </div>

    <form method="GET" action="/admin/product" style="padding: 20px; border-bottom: 1px solid #eee; display: flex; gap: 10px;">
        <input type="text" name="search" style="flex:1; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" placeholder="Tìm tên sản phẩm..." value="<?= htmlspecialchars($keyword ?? '') ?>">
        
        <select name="category_id" onchange="this.form.submit()" style="padding: 10px; border: 1px solid #ddd; border-radius: 5px; cursor: pointer; background: #fff;">
            <option value="0">Tất cả danh mục</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= (isset($categoryId) && $categoryId == $cat['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <button type="submit" style="padding: 10px 25px; background: var(--dark); color: var(--honey); border:none; border-radius: 5px; cursor:pointer; font-weight:bold;">TÌM</button>
    </form>

    <table class="product-table">
        <thead>
            <tr>
                <th width="100">Ảnh</th>
                <th>Sản phẩm</th>
                <th>Danh mục</th>
                <th>Giá bán</th>
                <th>Tồn kho</th>
                <th width="150">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($products)): ?>
                <tr><td colspan="6" style="text-align:center; padding: 50px; color: #999;">Không có sản phẩm nào phù hợp.</td></tr>
            <?php else: ?>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td>
                        <img src="/admin/assets/images/<?= $p['image'] ?>" class="product-img" onerror="this.src='https://placehold.co/100x100?text=No+Image'">
                    </td>
                    <td>
                        <div style="font-weight: bold; color: #333;"><?= htmlspecialchars($p['name']) ?></div>
                        <small style="color: #999;">ID: #<?= $p['id'] ?></small>
                    </td>
                    <td style="font-size: 14px; color: #666;"><?= htmlspecialchars($p['category_name'] ?? 'Mặc định') ?></td>
                    <td><span class="price-tag"><?= number_format($p['price'], 0, ',', '.') ?>đ</span></td>
                    <td><span class="stock-badge"><?= $p['quantity'] ?> sản phẩm</span></td>
                    <td>
                        <div class="action-group">
                            <a href="/admin/product/edit/<?= $p['id'] ?>" class="action-btn edit-btn">Sửa</a>
                            <a href="/admin/product/delete/<?= $p['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">Xóa</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if (isset($totalPages) && $totalPages > 1): ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>&search=<?= urlencode($keyword ?? '') ?>&category_id=<?= $categoryId ?? 0 ?>" 
               class="page-link <?= (isset($currentPage) && $i == $currentPage) ? 'active' : '' ?>">
               <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</div>

<?php echo ob_get_clean(); ?>