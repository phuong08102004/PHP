<?php
namespace App\Controllers;
use App\Models\Product;
use App\Controller;

class ProductController extends Controller {
    private $productModel;
    public function __construct() { $this->productModel = new Product(); }

    public function index() {
        $keyword = $_GET['search'] ?? '';
        $categoryId = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $products = $this->productModel->getProductsPaginated($keyword, $categoryId, $limit, $offset);
        $total = $this->productModel->getTotalProducts($keyword, $categoryId);

        $this->render('products/product-list', [
            'products' => $products,
            'categories' => $this->productModel->getCategories(),
            'keyword' => $keyword,
            'categoryId' => $categoryId,
            'totalPages' => ceil($total / $limit),
            'currentPage' => $page
        ]);
    }

    public function store() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $price = str_replace(['.', ','], '', $_POST['price'] ?? '0');
        $data = [
            'name'        => $_POST['name'],
            'price'       => (double)$price,
            'quantity'    => (int)$_POST['quantity'],
            'status'      => (int)$_POST['status'],
            'id_category' => (int)$_POST['id_category'],
            'image'       => $this->processUpload('image') ?: 'default.png'
            
        ];

        if ($this->productModel->create($data)) {
            header('Location: /admin/product');
            exit;
        }
    }
    }

    private function processUpload($inputName) {
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] == 0) {
            $targetDir = __DIR__ . '/../../assets/images/';
            if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
            $newName = time() . '_' . $_FILES[$inputName]['name'];
            if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $targetDir . $newName)) return $newName;
        }
        return null;
    }
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $oldProduct = $this->productModel->getProductById($id);
            
            
            $price = str_replace(['.', ','], '', $_POST['price'] ?? '0');
            
            
            $imageName = $this->processUpload('image');
            if (!$imageName) {
                $imageName = $oldProduct['image']; 
            }

            $data = [
                'name'        => $_POST['name'],
                'price'       => (double)$price,
                'quantity'    => (int)$_POST['quantity'],
                'status'      => (int)$_POST['status'],
                'id_category' => (int)$_POST['id_category'],
                'image'       => $imageName
            ];

            
            if ($this->productModel->update($id, $data)) {
                header('Location: /admin/product');
                exit;
            } else {
                echo "Lỗi: Không thể cập nhật sản phẩm.";
            }
        }
    }
    
    public function create() { $this->render('products/product-form', ['product' => [], 'categories' => $this->productModel->getCategories()]); }
    public function edit($id) { $this->render('products/product-form', ['product' => $this->productModel->getProductById($id), 'categories' => $this->productModel->getCategories()]); }
    public function delete($id) { $this->productModel->delete($id); header('Location: /admin/product'); exit; }
}