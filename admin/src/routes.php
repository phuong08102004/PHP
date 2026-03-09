<?php

use App\Controllers\UserController;
use App\Controllers\OrderController;
use App\Controllers\DashboardController;    
use App\Controllers\ProductController;

$user = new UserController();
$order = new OrderController();
$dashboard = new DashboardController();
$product = new ProductController();

// --- DASHBOARD ---
$router->addRoute('#^/admin$#', [$dashboard, 'index']);
$router->addRoute('#^/admin/dashboard$#', [$dashboard, 'index']);

// --- QUẢN LÝ USER ---
$router->addRoute('#^/admin/user$#', [$user, 'index']);
$router->addRoute('#^/admin/user/create$#', [$user, 'create']);
$router->addRoute('#^/admin/user/store$#', [$user, 'store']);
$router->addRoute('#^/admin/user/edit/(\d+)$#', [$user, 'edit']);
$router->addRoute('#^/admin/user/update/(\d+)$#', [$user, 'update']);
$router->addRoute('#^/admin/user/delete/(\d+)$#', [$user, 'delete']);

// --- QUẢN LÝ ĐƠN HÀNG ---
$router->addRoute('#^/admin/order$#', [$order, 'index']);
$router->addRoute('#^/admin/order/create$#', [$order, 'create']); 
$router->addRoute('#^/admin/order/store$#', [$order, 'store']);   
$router->addRoute('#^/admin/order/edit/(\d+)$#', [$order, 'edit']);
$router->addRoute('#^/admin/order/update/(\d+)$#', [$order, 'update']); 
$router->addRoute('#^/admin/order/delete/(\d+)$#', [$order, 'delete']); 

// --- QUẢN LÝ SẢN PHẨM (PRODUCT) ---
$router->addRoute('#^/admin/product$#', [$product, 'index']); 
$router->addRoute('#^/admin/product/create$#', [$product, 'create']);
$router->addRoute('#^/admin/product/store$#', [$product, 'store']);
$router->addRoute('#^/admin/product/edit/(\d+)$#', [$product, 'edit']);
$router->addRoute('#^/admin/product/update/(\d+)$#', [$product, 'update']);
$router->addRoute('#^/admin/product/delete/(\d+)$#', [$product, 'delete']);