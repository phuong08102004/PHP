<?php
namespace App\Controllers;

use App\Controller;
use App\Models\User;

class UserController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index()
    {
        $users = $this->userModel->getAllUsers();
        $this->render('users/user-list', ['users' => $users]);
    }

    
    public function edit($id)
    {
        $user = $this->userModel->getUserById($id);
        $this->render('users/user-form', ['user' => $user]);
    }

    
    public function store()
    {
        $this->userModel->createUser($_POST);
        header("Location: /admin/user");
        exit;
    }

    
    public function update($id)
    {
        $this->userModel->updateUser($id, $_POST);
        header("Location: /admin/user");
        exit;   
    }

    
    public function delete($id)
    {
        if ($this->userModel->canDelete($id)) {
            $this->userModel->deleteUser($id);
            header("Location: /admin/user");
        } else {
            
            echo "<script>alert('Không thể xóa người dùng này vì họ đã có đơn hàng!'); window.location.href='/admin/user';</script>";
        }
        exit;
    }
    public function create()
    {
        
        $this->render('users/user-form');
    }
    public function deleteUser($id)
    {
        $check = $this->connection->query(
            "SELECT COUNT(*) total FROM donhang WHERE userId = $id"
        )->fetch_assoc();

        if ($check['total'] > 0) {
            die("Không thể xóa user đã có đơn hàng");
        }   

        $this->connection->query("DELETE FROM users WHERE id=$id");
        header("Location: /admin/user");
        exit;
    }
}
