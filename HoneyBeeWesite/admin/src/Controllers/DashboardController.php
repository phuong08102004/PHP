<?php
namespace App\Controllers;

use App\Controller;
use App\Models\User;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $userModel = new User();
        $totalUsers = $userModel->countUsers();

        $orderModel = new Order();
        $totalOrders = $orderModel->countOrders();

        $this->render('dashboard/index', [
            'totalUsers' => $totalUsers,
            'totalOrders' => $totalOrders
        ]);
    }
}
