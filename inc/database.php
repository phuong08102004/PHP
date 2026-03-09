<?php
class Database{
        static $con;
        public static function getConnection(){
            if (self::$con == null) {
                self::$con = new mysqli("localhost", "root", "", "honeybee_schema");
                self::$con->set_charset("utf8");
            }
            return self::$con;
        } 
        public static function query($s){
            return self::getConnection()->query($s);
        }
        
    }
    
function _header($title){
    echo '
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>'.$title.'</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">

        <!-- HoneyBee CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
        <script src="assets/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
    ';
}

 function _footer(){
    echo '
    <!-- FOOTER -->
    <footer id="footer-section-v2">

        <div class="footer-main-content-v2 py-5">
            <div class="container text-white">
                <div class="row">

                    <div class="col-md-4 mb-4 footer-col-info">
                        <img src="assets/icon/logobee.png" height="50" class="footer-logo-v2">
                        <ul class="list-unstyled text-white-50 small">
                            <li>Đại học khoa học Huế</li>
                            <li>1800 6750</li>
                            <li>22T1020334@husc.edu.vn</li>
                        </ul>
                    </div>

                    <div class="col-md-2 mb-4">
                        <h5 class="mb-3 footer-heading-v2">THÔNG TIN KHÁCH HÀNG</h5>
                        <ul class="footer-links-v2 list-unstyled">
                            <li><a href="index.php">Trang chủ</a></li>
                            <li><a href="#">Sản phẩm</a></li>
                            <li><a href="#">Tin tức</a></li>
                            <li><a href="#">Liên hệ</a></li>
                            <li><a href="#">Giới thiệu</a></li>
                            <li><a href="#">Cẩm nang</a></li>
                        </ul>
                    </div>

                    <div class="col-md-3 mb-4">
                        <h5 class="mb-3 footer-heading-v2">CHÍNH SÁCH MUA HÀNG</h5>
                        <ul class="footer-links-v2 list-unstyled">
                            <li><a href="#">Chính sách đổi trả</a></li>
                            <li><a href="#">Chính sách bảo mật</a></li>
                            <li><a href="#">Thanh toán</a></li>
                            <li><a href="#">Vận chuyển</a></li>
                        </ul>
                    </div>

                    <div class="col-md-3 mb-4">
                        <h5 class="mb-3 footer-heading-v2">DỊCH VỤ HỖ TRỢ</h5>
                        <img src="assets/images/payment.png" class="payment-logos-v2">
                    </div>

                </div>
            </div>
        </div>

        <div class="footer-copyright-v2 py-3">
            <div class="container text-center">
                <span>Chào mừng đến với Honey Bee Store</span>
                <a href="#top" class="back-to-top-btn">^</a>
            </div>
        </div>

            

    </footer>

    <script src="assets/js/style.js"></script>
    </body>
    </html>
    ';
}

function navbar($categories = [], $cartCount = 0, $user = null){
    
    
    
    if (isset($_GET['id_product'])) {

    
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit();
    }

    
    addProductToCart($_GET['id_product']);

    
    header("Location: index.php");
    exit();
    }

    $s = '
    <nav>

        <!-- DẢI VÀNG -->
        <div class="honey-welcome-bar">
            <img src="assets/icon/logobee.png" height="55">
            <span>CHÀO MỪNG ĐẾN VỚI HONEYBEE STORE</span>
        </div>

        <!-- MENU ĐEN -->
        <div class="navbar navbar-expand-lg sticky-top honey-navbar">
            <div class="container">

                <!-- MENU TRÁI -->
                <ul class="navbar-nav me-auto align-items-center">

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="index.php">Trang chủ</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" data-bs-toggle="dropdown">
                            Sản phẩm
                        </a>
                        <ul class="dropdown-menu">';

                        foreach ($categories as $c) {
                            $s .= '<li>
                                <a class="dropdown-item" href="index.php?id_category='.$c['id'].'">
                                    '.$c['name'].'
                                </a>
                            </li>';
                        }

                    $s .= '
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="about.php">Giới thiệu</a>
                    </li>
                </ul>

                <!-- LOGO -->
                <div class="nav-logo">
                    <img src="assets/images/logo.png" height="55">
                </div>

                <!-- MENU PHẢI -->
                <div class="menu-right d-flex align-items-center">

                    <!-- SEARCH -->
                    <form action="search.php" method="get" class="honey-search-box">
                        <input class="honey-search-input" name="keyword" placeholder="Tìm sản phẩm...">
                        <button class="honey-search-btn">
                            <img src="https://cdn-icons-png.flaticon.com/512/622/622669.png" width="18">
                        </button>
                    </form>

                    <!-- CART -->
                    <a href="cart.php" class="nav-link icon-link position-relative me-3">
                        <img src="https://cdn-icons-png.flaticon.com/512/833/833314.png" width="24">
                        <span class="cart-badge">'.$cartCount.'</span>
                    </a>';

    if ($user == null) {
        $s .= '
                    <a href="login.php" class="nav-link icon-link">
                        <img src="https://cdn-icons-png.flaticon.com/512/456/456212.png" width="22">
                    </a>';
    } else {
    $s .= '
        <div class="dropdown">
                    <a class="nav-link dropdown-toggle text-white" data-bs-toggle="dropdown">
                        HI, '.$user['name'].'
                    </a>
                    <ul class="dropdown-menu">';

            
            if ($user['role'] == 1) {
                $s .= '
                    <li>
                        <a class="dropdown-item text-warning fw-bold" href="/admin">
                            Trang quản trị
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>';
            }

            $s .= '
                    <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>';
        }

    $s .= '
                </div>
            </div>
        </div>
    </nav>';

    echo $s;
}
function jumbotron(){
    $s = '
    <!-- JUMBOTRON / HERO -->
    <div class="honey-hero">
        <div class="honey-hero-content">
            <h1>';

    if (!isset($_GET['id_category'])) {
        $s .= 'Sản phẩm của chúng tôi';
    } else {
        $q = Database::query("SELECT name FROM categories WHERE id = " . intval($_GET['id_category']));
        if ($r = $q->fetch_array()) {
            $s .= '' . $r['name'];
        } else {
            $s .= 'Sản phẩm của chúng tôi';
        }
    }

    $s .= '</h1>
            <p>Mật ong nguyên chất – Nhập khẩu chính hãng – 100% tự nhiên</p>
        </div>
    </div>
    ';

    echo $s;
}


function body(){
    if (!isset($_GET['id_category'])) {
        $qCat = Database::query("SELECT * FROM categories");
    } else {
        $qCat = Database::query(
            "SELECT * FROM categories WHERE id=" . intval($_GET['id_category'])
        );
    }

    while ($cat = $qCat->fetch_array()) {

        echo '
        <section>
            <div class="container my-5">

                <header class="mb-4">
                    <h3 class="category-title">'.$cat['name'].'</h3>
                </header>

                <div class="row">';

        // LẤY SẢN PHẨM THEO CATEGORY
        if (!isset($_GET['id_category'])) {
            $qPro = Database::query(
                "SELECT * FROM products 
                 WHERE id_category=".$cat['id']." AND status=1"
            );
        } else {
            $qPro = Database::query(
                "SELECT * FROM products 
                 WHERE id_category=".$cat['id']
            );
        }

        while ($p = $qPro->fetch_array()) {

            echo '
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="product-card">

                    <div class="product-img">
                        <img src="/admin/assets/images/'.$p['image'].'" class="img-fluid">
                    </div>

                    <div class="product-info">
                        <h5 class="product-name">'.$p['name'].'</h5>
                        <p class="product-price">'.$p['price'].' VNĐ</p>';

            // NÚT ADD TO CART
            if (!isset($_SESSION['user'])) {
                echo '<a href="login.php" class="btn-buy">Thêm vào giỏ</a>';
            } else {
                echo '<a href="index.php?id_product='.$p['id'].'" class="btn-buy">
                        Thêm vào giỏ
                      </a>';
            }

            echo '
                    </div>
                </div>
            </div>';
        }

        echo '
                </div>
            </div>
        </section>';
    }
}


function login(){
    if (isset($_POST['emailphone']) && isset($_POST['password'])) {
        $emailphone = addslashes($_POST['emailphone']);
        $password   = addslashes($_POST['password']);

        $q = Database::query("
            SELECT * FROM users 
            WHERE (email='$emailphone' OR phone='$emailphone')
            AND password='$password'
        ");

        if ($r = $q->fetch_array()) {
            $_SESSION['user'] = $r;  // Lưu thông tin người dùng vào session

            if ($r['role'] == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit();  // Ngừng thực thi sau khi chuyển hướng
        } else {
            $_SESSION['user'] = $user;

        if ($user['role'] == 1) {
            header("Location: /admin");
        } else {
            header("Location: index.php");
        }
        exit(); // Ngừng thực thi sau khi chuyển hướng
        }
    }

    $s = '
    <section class="login-section">
        <div class="login-wrapper">
            <h2 class="login-title">Đăng nhập</h2>
            <p class="login-sub">Chào mừng bạn đến với HoneyBee Store</p>';

    if (!empty($_SESSION['login_fail'])) {
        $s .= '<div class="login-error">'.$_SESSION['login_fail'].'</div>';
        unset($_SESSION['login_fail']);
    }

    $s .= '
        <form method="post">
            <div class="mb-3">
                <input type="text" name="emailphone" class="form-control"
                       placeholder="Email hoặc số điện thoại" required>
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control"
                       placeholder="Mật khẩu" required>
            </div>

            <button type="submit" class="btn btn-login">Đăng nhập</button>

            <div class="login-footer">
                Chưa có tài khoản? <a href="register.php">Đăng ký</a>
            </div>
        </form>
        </div>
    </section>';

    echo $s;

    // Kết thúc output buffering và xuất ra toàn bộ nội dung
    ob_end_flush();
}

function register(){

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    include_once 'inc/database.php';

    // XỬ LÝ ĐĂNG KÝ
    if (isset($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['password'])) {

        $name     = trim($_POST['name']);
        $email    = trim($_POST['email']);
        $phone    = trim($_POST['phone']);
        $password = trim($_POST['password']);

        $check = Database::query("
            SELECT id FROM users 
            WHERE email='$email' OR phone='$phone'
        ");

        if ($check->fetch_array()) {
            $_SESSION['register_error'] = 'Email hoặc số điện thoại đã tồn tại!';
        } else {
            Database::query("
                INSERT INTO users(name, email, phone, password, role)
                VALUES('$name', '$email', '$phone', '$password', 'user')
            ");
            $_SESSION['register_success'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
            header("Location: login.php");
            exit();
        }
    }

    // GIAO DIỆN
    $s = '
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <title>Đăng ký - HoneyBee</title>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/auth.css">
    </head>
    <body>

    <section class="register-section">
        <div class="register-card">
            <h2 class="register-title">Đăng ký</h2>
            <p class="register-sub">Tạo tài khoản HoneyBee Store</p>';

    if (!empty($_SESSION['register_error'])) {
        $s .= '<div class="register-error">'.$_SESSION['register_error'].'</div>';
        unset($_SESSION['register_error']);
    }

    $s .= '
            <form method="post">
                <input type="text" name="name" class="form-control" placeholder="Họ và tên" required>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
                <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" required>
                <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>

                <button type="submit" class="btn btn-register">Đăng ký</button>

                <div class="register-footer">
                    Đã có tài khoản? <a href="login.php">Đăng nhập</a>
                </div>
            </form>
        </div>
    </section>

    </body>
    </html>';

    echo $s;
}

function addProductToCart($id_product, $quantity = 1) {

    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $found = false;

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $id_product) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }
    unset($item);

    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => (int)$id_product,
            'quantity' => (int)$quantity
        ];
    }
}

function handleCartAction() {

    if (!isset($_GET['action'], $_GET['id']) || !isset($_SESSION['cart'])) return;

    $id = (int)$_GET['id'];

    foreach ($_SESSION['cart'] as $key => &$item) {

        if ($item['id'] == $id) {

            if ($_GET['action'] === 'inc') {
                $item['quantity']++;
            }

            if ($_GET['action'] === 'dec') {
                $item['quantity']--;
                if ($item['quantity'] <= 0) {
                    unset($_SESSION['cart'][$key]);
                }
            }

            if ($_GET['action'] === 'del') {
                unset($_SESSION['cart'][$key]);
            }

            break;
        }
    }

    unset($item);
    $_SESSION['cart'] = array_values($_SESSION['cart']);

    header("Location: cart.php");
    exit();
}


function cartBody() {

    if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
        echo '<p>Giỏ hàng đang trống.</p>';
        return;
    }

    $total = 0;

    echo '
    <table class="table table-bordered align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>Hình ảnh</th>
                <th>Sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
    ';

    foreach ($_SESSION['cart'] as $item) {

        $id = (int)$item['id'];
        $quantity = (int)$item['quantity'];

        $q = Database::query("SELECT * FROM products WHERE id = $id");
        if (!$p = $q->fetch_array()) continue;

        $subTotal = $p['price'] * $quantity;
        $total += $subTotal;

        echo '
        <tr>
            <td><img src="/assets/images/'.$p['image'].'" width="80"></td>
            <td>'.$p['name'].'</td>
            <td>'.number_format($p['price']).' VNĐ</td>
            <td>
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <a href="cart.php?action=dec&id='.$id.'" class="btn btn-sm btn-outline-secondary">−</a>
                    <strong>'.$quantity.'</strong>
                    <a href="cart.php?action=inc&id='.$id.'" class="btn btn-sm btn-outline-secondary">+</a>
                    <a href="cart.php?action=del&id='.$id.'" 
                       class="btn btn-sm btn-outline-danger ms-2"
                       onclick="return confirm(\'Xóa sản phẩm này?\')">🗑</a>
                </div>
            </td>
            <td>'.number_format($subTotal).' VNĐ</td>
        </tr>';
    }

    echo '
        </tbody>
    </table>

    <h4 class="text-end">
        Tổng tiền: <span class="text-danger">'.number_format($total).' VNĐ</span>
    </h4>

    <div class="text-end mt-4">
        <a href="index.php" class="btn btn-secondary">Tiếp tục mua</a>
        <a href="checkout.php" class="btn btn-warning">Thanh toán</a>
    </div>
    ';
}

function handleCheckout() {
    if (!isset($_POST['checkout'])) return;

    if (!isset($_SESSION['user'], $_SESSION['cart']) || count($_SESSION['cart']) == 0) {
        return;
    }

    $user_id = $_SESSION['user']['id'];
    $address = addslashes($_POST['address']);
    $note    = addslashes($_POST['note']);
    $date    = date('Y-m-d H:i:s');
    $status  = "Chờ xử lý";

    
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $q = Database::query("SELECT price FROM products WHERE id=" . (int)$item['id']);
        if ($p = $q->fetch_array()) {
            $total += $p['price'] * $item['quantity'];
        }
    }

    
    $shippingInfo = "Địa chỉ: $address | Ghi chú: $note";
    $sqlOrder = "INSERT INTO donhang (userId, tongTien, ngayDat, trangThai, thongTinGiaoHang) 
                 VALUES ($user_id, $total, '$date', '$status', '$shippingInfo')";
    
    if (Database::query($sqlOrder)) {
        
        $order_id = Database::getConnection()->insert_id;

        foreach ($_SESSION['cart'] as $item) {
            $id_sp = (int)$item['id'];
            $sl    = (int)$item['quantity'];

            $q = Database::query("SELECT price FROM products WHERE id=$id_sp");
            if ($p = $q->fetch_array()) {
                $gia = $p['price'];
                
                $sqlDetail = "INSERT INTO chitietdon (donhangId, sanphamId, soluong, gia) 
                              VALUES ($order_id, $id_sp, $sl, $gia)";
                Database::query($sqlDetail);
            }
        }

        unset($_SESSION['cart']);
        $_SESSION['success'] = "🎉 Đặt hàng thành công!";
        header("Location: index.php");
        exit();
    } else {
        die("Lỗi MySQL: " . Database::getConnection()->error);
    }
}

function checkoutForm($total) {

    if (!isset($_SESSION['user'])) return;

    $name  = $_SESSION['user']['name'];
    $phone = $_SESSION['user']['phone'];

    $shipping = 15000;
    $grandTotal = $total + $shipping;

    echo '
    <div class="container my-5">
        <div class="row">

            <!-- CỘT TRÁI -->
            <div class="col-md-7">
                <h4 class="mb-4">Thông tin khách hàng</h4>

                <div class="mb-3">
                    <label>Họ tên</label>
                    <input class="form-control" value="'.$name.'" disabled>
                </div>

                <div class="mb-3">
                    <label>Số điện thoại</label>
                    <input class="form-control" value="'.$phone.'" disabled>
                </div>

                <form method="post">
                    <div class="mb-3">
                        <label>Địa chỉ giao hàng</label>
                        <textarea name="address" class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Ghi chú</label>
                        <textarea name="note" class="form-control"></textarea>
                    </div>

                    <button name="checkout" class="btn btn-warning w-100 fw-bold">
                        ĐẶT HÀNG NGAY
                    </button>
                </form>
            </div>

            <!-- CỘT PHẢI -->
            <div class="col-md-5">

                <!-- CARD DETAILS -->
                <div class="card mb-4">
                    <div class="card-body">

                        <h5 class="mb-3">Card details</h5>

                        <div class="mb-3">
                            <img src="assets/images/payment.png" height="28">
                        </div>

                        <div class="mb-3">
                            <label>Cardholder Name</label>
                            <input class="form-control" placeholder="Your name">
                        </div>

                        <div class="mb-3">
                            <label>Card Number</label>
                            <input class="form-control" placeholder="1234 5678 9012 3457">
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label>Expiration</label>
                                <input class="form-control" placeholder="MM/YY">
                            </div>
                            <div class="col-6 mb-3">
                                <label>CVV</label>
                                <input class="form-control" placeholder="***">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TỔNG TIỀN -->
                <div class="card">
                    <div class="card-body">
                        <p>Tạm tính <span class="float-end">'.number_format($total).' đ</span></p>
                        <p>Phí vận chuyển <span class="float-end">'.number_format($shipping).' đ</span></p>
                        <hr>
                        <h5 class="text-warning">
                            Tổng cộng
                            <span class="float-end">'.number_format($grandTotal).' đ</span>
                        </h5>
                    </div>
                </div>

            </div>
        </div>
    </div>';
}

function searchBody($keyword) {

    $keyword = addslashes($keyword);

    $q = Database::query("
        SELECT * FROM products
        WHERE status = 1
        AND name LIKE '%$keyword%'
    ");

    echo '
    <div class="container my-5">
        <h3 class="mb-4">
            Kết quả tìm kiếm cho: <span class="text-warning">'.$keyword.'</span>
        </h3>
        <div class="row">
    ';

    if ($q->num_rows == 0) {
        echo '<p>Không tìm thấy sản phẩm phù hợp.</p>';
    }

    while ($p = $q->fetch_array()) {

        echo '
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="product-card">

                <div class="product-img">
                    <img src="assets/images/'.$p['image'].'" class="img-fluid">
                </div>

                <div class="product-info">
                    <h5 class="product-name">'.$p['name'].'</h5>
                    <p class="product-price">'.number_format($p['price']).' VNĐ</p>';

        if (!isset($_SESSION['user'])) {
            echo '<a href="login.php" class="btn-buy">Thêm vào giỏ</a>';
        } else {
            echo '<a href="index.php?id_product='.$p['id'].'" class="btn-buy">
                    Thêm vào giỏ
                  </a>';
        }

        echo '
                </div>
            </div>
        </div>';
    }

    echo '
        </div>
    </div>';
}

function about() {
    echo '
    <div class="about-hero d-flex align-items-center justify-content-center text-center text-white">
        <div class="hero-overlay"></div>
        <div class="hero-content position-relative">
            <h1 class="display-3 fw-bold mb-3">HONEY BEE STORE</h1>
            <p class="fs-4 fw-light italic">"Ngọt ngào từ thiên nhiên – Chất lượng từ tâm"</p>
        </div>
    </div>

    <section class="py-5 my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center intro-text">
                    <h2 class="fw-bold text-warning mb-4 section-title">Về chúng tôi</h2>
                    <p class="lead mb-4">
                        Honey Bee Store là cửa hàng chuyên cung cấp các sản phẩm
                        <span class="text-highlight">mật ong thiên nhiên</span>, sản phẩm chăm sóc sức khỏe
                        và quà tặng từ thiên nhiên.
                    </p>
                    <p class="fs-5 text-muted">
                        Chúng tôi cam kết mang đến cho khách hàng những sản phẩm
                        <strong class="text-dark">an toàn – chất lượng – nguồn gốc rõ ràng</strong>. 
                        Mỗi giọt mật ong đều là tinh hoa được chắt lọc từ những cánh rừng nguyên sinh.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="about-values-v2 py-5 bg-light">
        <div class="container text-center py-4">
            <h2 class="fw-bold mb-5 section-title">Giá trị cốt lõi</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="value-card">
                        <div class="icon-circle">🍯</div>
                        <h4 class="fw-bold mt-3">Thiên nhiên</h4>
                        <p class="text-muted">Sản phẩm 100% từ tự nhiên, không qua xử lý nhiệt hay pha trộn hóa chất.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="value-card">
                        <div class="icon-circle">⭐</div>
                        <h4 class="fw-bold mt-3">Chất lượng</h4>
                        <p class="text-muted">Được kiểm định nghiêm ngặt về độ tinh khiết và hàm lượng dinh dưỡng cao.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="value-card">
                        <div class="icon-circle">❤️</div>
                        <h4 class="fw-bold mt-3">Uy tín</h4>
                        <p class="text-muted">Đặt sức khỏe và sự tin tưởng của khách hàng lên trên mọi lợi nhuận kinh doanh.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 my-5">
        <div class="container text-center">
            <div class="commitment-box p-5 shadow-sm border-0">
                <h2 class="fw-bold text-warning mb-4">Cam kết của Honey Bee</h2>
                <div class="row justify-content-center">
                    <div class="col-md-10 d-flex flex-wrap justify-content-center gap-4">
                        <div class="commit-item"><i class="text-success">✔</i> Hoàn tiền nếu sản phẩm không đúng mô tả</div>
                        <div class="commit-item"><i class="text-success">✔</i> Giao hàng hỏa tốc trong 24h</div>
                        <div class="commit-item"><i class="text-success">✔</i> Hỗ trợ tư vấn chuyên sâu 24/7</div>
                    </div>
                </div>
            </div>
        </div>
    </section>';
}





