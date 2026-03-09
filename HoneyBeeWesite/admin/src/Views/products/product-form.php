<?php ob_start(); 
$isEdit = !empty($product) && isset($product['id']);


$actionUrl = $isEdit ? '/admin/product/update/' . $product['id'] : '/admin/product/store';
?>
<style>
    :root { --honey: #f4b400; --dark: #111; }
    body { font-family: 'Segoe UI', sans-serif; background: #f4f4f4; padding: 40px; margin: 0; }
    .form-card { max-width: 900px; margin: 0 auto; background: #fff; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); display: flex; flex-wrap: wrap; overflow: hidden; }
    .form-header { width: 100%; background: var(--dark); color: var(--honey); padding: 20px; text-align: center; font-weight: bold; font-size: 20px; text-transform: uppercase; }
    .form-main { flex: 2; padding: 30px; min-width: 300px; }
    .form-side { flex: 1; padding: 30px; background: #fdfdfd; border-left: 1px solid #eee; min-width: 250px; text-align: center; }
    .group { margin-bottom: 20px; text-align: left; }
    .group label { display: block; margin-bottom: 8px; font-weight: 600; color: #444; }
    .input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 14px; }
    .input:focus { border-color: var(--honey); outline: none; box-shadow: 0 0 5px rgba(244, 180, 0, 0.3); }
    .img-preview { width: 100%; height: 200px; border: 2px dashed #ddd; border-radius: 8px; margin-bottom: 15px; display: flex; align-items: center; justify-content: center; overflow: hidden; cursor: pointer; background: #f9f9f9; }
    .img-preview img { max-width: 100%; max-height: 100%; object-fit: cover; }
    .btn-save { background: var(--honey); color: var(--dark); border: none; padding: 15px 30px; border-radius: 6px; font-weight: bold; cursor: pointer; width: 100%; font-size: 16px; transition: 0.3s; }
    .btn-save:hover { background: var(--dark); color: var(--honey); }
    .btn-back { display: block; text-align: center; margin-top: 15px; color: #777; text-decoration: none; font-size: 14px; }
    .btn-back:hover { color: var(--dark); text-decoration: underline; }
</style>

<div class="form-card">
    <div class="form-header"><?= $isEdit ? '🐝 CHỈNH SỬA SẢN PHẨM' : '🐝 THÊM MẬT ONG MỚI' ?></div>
    
    <form action="<?= $actionUrl ?>" method="POST" enctype="multipart/form-data" style="display: contents;">
        <div class="form-main">
            <div class="group">
                <label>Tên sản phẩm</label>
                <input type="text" name="name" class="input" required placeholder="Nhập tên loại mật ong..." value="<?= htmlspecialchars($product['name'] ?? '') ?>">
            </div>
            
            <div style="display: flex; gap: 15px;">
                <div class="group" style="flex: 1;">
                    <label>Giá bán (VNĐ)</label>
                    <input type="text" name="price" class="input" required placeholder="Ví dụ: 150000" value="<?= $product['price'] ?? '' ?>">
                </div>
                <div class="group" style="flex: 1;">
                    <label>Số lượng kho</label>
                    <input type="number" name="quantity" class="input" min="0" value="<?= $product['quantity'] ?? 0 ?>">
                </div>
            </div>
        </div>

        <div class="form-side">
            <div class="group">
                <label>Ảnh đại diện</label>
                <div class="img-preview" onclick="document.getElementById('fileInput').click()">
                    <?php 
                        
                        $imagePath = (!empty($product['image'])) ? '/admin/assets/images/'.$product['image'] : 'https://placehold.co/400x400?text=Bam+de+chon+anh'; 
                    ?>
                    <img id="preview" src="<?= $imagePath ?>" onerror="this.src='https://placehold.co/400x400?text=Anh+loi'">
                </div>
                <input type="file" name="image" id="fileInput" style="display: none;" onchange="previewImg(this)">
                
                <?php if($isEdit): ?>
                    <input type="hidden" name="current_image" value="<?= $product['image'] ?>">
                <?php endif; ?>
                <p style="font-size: 12px; color: #888;">(Click vào khung để đổi ảnh)</p>
            </div>

            <div class="group">
                <label>Danh mục</label>
                <select name="id_category" class="input">
                    <?php foreach($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" 
                            <?= (isset($product['id_category']) && $product['id_category'] == $cat['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="group">
                <label>Trạng thái</label>
                <select name="status" class="input">
                    <option value="1" <?= (isset($product['status']) && $product['status'] == 1) ? 'selected' : '' ?>>Đang kinh doanh</option>
                    <option value="0" <?= (isset($product['status']) && $product['status'] == 0) ? 'selected' : '' ?>>Tạm ngừng</option>
                </select>
            </div>

            <button type="submit" class="btn-save">LƯU DỮ LIỆU</button>
            <a href="/admin/product" class="btn-back">← Quay lại danh sách</a>
        </div>
    </form>
</div>

<script>
    function previewImg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) { 
                document.getElementById('preview').src = e.target.result; 
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?php echo ob_get_clean(); ?>