<?php
namespace App\Controllers;

use App\Models\Order;
use App\Controller;
use App\Models\User;

class OrderController extends Controller
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new Order();
    }

    
    public function index()
    {
        $donhangs = $this->orderModel->getAllDonhang();
        $this->render('donhang/order-list', ['donhangs' => $donhangs]);
    }

    
    public function create()
    {
        $userModel = new User();
        $users = $userModel->getAllUsers(); 

        $this->render('donhang/order-form', [
            'donhang' => null,
            'users' => $users 
        ]);
    }

    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $userId = $_POST['userId'] ?? 0;
            $tongTien = $_POST['tongTien'] ?? 0;
            
            $ngayDatRaw = $_POST['ngayDat'] ?? '';
            if (!empty($ngayDatRaw)) {
                $ngayDat = str_replace('T', ' ', $ngayDatRaw);
                if (strlen($ngayDat) == 16) $ngayDat .= ":00"; 
            } else {
                $ngayDat = date('Y-m-d H:i:s');
            }

            $trangThai = $_POST['trangThai'] ?? 'Chờ xử lý';
            $thongTinGiaoHang = $_POST['thongTinGiaoHang'] ?? '';

            $result = $this->orderModel->createDonhang($userId, $tongTien, $ngayDat, $trangThai, $thongTinGiaoHang);
            
            if ($result) {
                header('Location: /admin/order');
                exit;
            } else {
                echo "<h3>Lỗi lưu đơn hàng:</h3>";
                die($this->orderModel->getError());
            }
        }
    }

    
    public function edit($id)
    {
        $userModel = new User();
        $users = $userModel->getAllUsers();
        
        $donhang = $this->orderModel->getDonhangById($id);
        
        if (!$donhang) {
            die("Đơn hàng không tồn tại!");
        }

        $this->render('donhang/order-form', [
            'donhang' => $donhang,
            'users' => $users
        ]);
    }

    
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['userId'] ?? 0;
            $tongTien = $_POST['tongTien'] ?? 0;
            
            $ngayDatRaw = $_POST['ngayDat'] ?? '';
            $ngayDat = str_replace('T', ' ', $ngayDatRaw);
            if (strlen($ngayDat) == 16) $ngayDat .= ":00";

            $trangThai = $_POST['trangThai'] ?? '';
            $thongTinGiaoHang = $_POST['thongTinGiaoHang'] ?? '';

            $result = $this->orderModel->updateDonhang($id, $userId, $tongTien, $ngayDat, $trangThai, $thongTinGiaoHang);
            
            if ($result) {
                header("Location: /admin/order");
                exit;
            } else {
                die("Lỗi cập nhật: " . $this->orderModel->getError());
            }
        }
    }

    
    public function delete($id)
    {
        if ($this->orderModel->deleteDonhang($id)) {
            header("Location: /admin/order");
            exit();
        } else {
            die("Lỗi khi xóa: " . $this->orderModel->getError());
        }
    }
}