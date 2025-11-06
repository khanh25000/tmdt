<?php
session_start();

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Xử lý thêm khóa học vào giỏ hàng
if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
    
    // Dữ liệu khóa học mẫu
    $courses = [
        1 => [
            'id' => 1, 
            'title' => 'Python', 
            'price' => 1200000, 
            'image' => 'https://images.unsplash.com/photo-1526379879527-8559ecfcaec0?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
            'description' => 'Khóa học Python từ cơ bản đến nâng cao'
        ],
        2 => [
            'id' => 2, 
            'title' => 'PHP', 
            'price' => 1000000, 
            'image' => 'https://images.unsplash.com/photo-1599507593499-a3f7d7d04067?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
            'description' => 'Học PHP và xây dựng ứng dụng web động'
        ],
        3 => [
            'id' => 3, 
            'title' => 'JavaScript', 
            'price' => 1500000, 
            'image' => 'https://images.unsplash.com/photo-1627398242454-45a1465c2479?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
            'description' => 'Làm chủ JavaScript và các framework phổ biến'
        ],
        4 => [
            'id' => 4, 
            'title' => 'Fullstack', 
            'price' => 2500000, 
            'image' => 'https://images.unsplash.com/photo-1611224923853-80b023f02d71?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
            'description' => 'Trở thành lập trình viên Fullstack chuyên nghiệp'
        ],
        5 => [
            'id' => 5, 
            'title' => 'Mobile', 
            'price' => 1800000, 
            'image' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
            'description' => 'Phát triển ứng dụng di động đa nền tảng'
        ],
        6 => [
            'id' => 6, 
            'title' => 'Github', 
            'price' => 800000, 
            'image' => 'https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
            'description' => 'Sử dụng GitHub để quản lý dự án hiệu quả'
        ],
        7 => [
            'id' => 7, 
            'title' => 'Cài Python', 
            'price' => 0, 
            'image' => 'https://images.unsplash.com/photo-1526379879527-8559ecfcaec0?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
            'description' => 'Hướng dẫn cài đặt và cấu hình môi trường Python'
        ],
        8 => [
            'id' => 8, 
            'title' => 'Database', 
            'price' => 0, 
            'image' => 'https://images.unsplash.com/photo-1543946608-3b7a50f67c68?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
            'description' => 'Tìm hiểu về cơ sở dữ liệu và hệ quản trị CSDL'
        ],
        9 => [
            'id' => 9, 
            'title' => 'Sử dụng Github', 
            'price' => 0, 
            'image' => 'https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
            'description' => 'Hướng dẫn sử dụng GitHub từ cơ bản đến nâng cao'
        ],
        10 => [
            'id' => 10, 
            'title' => 'Cài PHP', 
            'price' => 0, 
            'image' => 'https://images.unsplash.com/photo-1599507593499-a3f7d7d04067?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
            'description' => 'Cài đặt và cấu hình môi trường PHP development'
        ],
        11 => [
            'id' => 11, 
            'title' => 'Frontend', 
            'price' => 0, 
            'image' => 'https://images.unsplash.com/photo-1627398242454-45a1465c2479?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
            'description' => 'Xây dựng giao diện người dùng với HTML, CSS, JS'
        ],
        12 => [
            'id' => 12, 
            'title' => 'Backend', 
            'price' => 0, 
            'image' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
            'description' => 'Phát triển phần server-side và API'
        ]
    ];
    
    if (isset($courses[$course_id])) {
        $course = $courses[$course_id];
        
        // Kiểm tra xem khóa học đã có trong giỏ chưa
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $course['id']) {
                $item['quantity'] += 1;
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            $course['quantity'] = 1;
            $_SESSION['cart'][] = $course;
        }
        
        // Chuyển hướng để tránh thêm trùng lặp khi refresh
        header("Location: shop.php");
        exit();
    }
}

// Xử lý xóa khóa học khỏi giỏ hàng
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $remove_id) {
                unset($_SESSION['cart'][$key]);
                break;
            }
        }
        // Đảm bảo mảng được lập chỉ mục lại
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    header("Location: shop.php");
    exit();
}

// Xử lý cập nhật số lượng
if (isset($_POST['update_quantity'])) {
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $item_id) {
                $item['quantity'] = max(1, $quantity); // Đảm bảo số lượng ít nhất là 1
                break;
            }
        }
    }
    header("Location: shop.php");
    exit();
}

// Xử lý thanh toán
if (isset($_POST['checkout'])) {
    // Ở đây bạn có thể thêm code xử lý thanh toán
    // Sau khi thanh toán thành công, xóa giỏ hàng
    unset($_SESSION['cart']);
    header("Location: thanhtoan.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng - Web Học Trực Tuyến</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/khoahoc.css">
    <style>
        :root {
            --primary: #4a6bff;
            --secondary: #ff6b6b;
            --accent: #6a11cb;
            --light: #f8f9fa;
            --dark: #343a40;
            --text: #333;
            --gray: #6c757d;
            --success: #28a745;
            --danger: #dc3545;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7ff;
            color: var(--text);
            line-height: 1.6;
        }
        
        /* Header & Navigation */
        header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 24px;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .logo i {
            margin-right: 10px;
            font-size: 28px;
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li {
            margin: 0 15px;
        }
        
        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 8px 12px;
            border-radius: 6px;
        }
        
        nav ul li a:hover, nav ul li a.active {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        
        .nav-right {
            display: flex;
            align-items: center;
        }
        
        .cart-btn, .logout-btn {
            color: white;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            margin-left: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        
        .cart-btn:hover, .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }
        
        .cart-btn i, .logout-btn i {
            margin-right: 8px;
        }
        
        /* Cart Container */
        .cart-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        
        .cart-title {
            text-align: center;
            margin-bottom: 40px;
            color: var(--dark);
            font-size: 36px;
            position: relative;
        }
        
        .cart-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--accent));
            border-radius: 2px;
        }
        
        .cart-items {
            margin-bottom: 40px;
        }
        
        .cart-item {
            display: flex;
            align-items: center;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .cart-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        
        .cart-item-img {
            width: 120px;
            height: 90px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 25px;
        }
        
        .cart-item-details {
            flex-grow: 1;
        }
        
        .cart-item-title {
            font-size: 20px;
            margin-bottom: 8px;
            color: var(--dark);
        }
        
        .cart-item-desc {
            color: var(--gray);
            font-size: 14px;
            margin-bottom: 8px;
            max-width: 400px;
        }
        
        .cart-item-price {
            font-weight: bold;
            color: var(--primary);
            font-size: 18px;
        }
        
        .cart-item-actions {
            display: flex;
            align-items: center;
        }
        
        .quantity-input {
            width: 70px;
            padding: 8px;
            text-align: center;
            margin-right: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            border: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(106, 17, 203, 0.3);
        }
        
        .btn-danger {
            background: var(--danger);
            color: white;
            padding: 8px 15px;
            margin-left: 15px;
        }
        
        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
        }
        
        .cart-summary {
            background: linear-gradient(135deg, #f5f7ff 0%, #e6e9ff 100%);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .summary-title {
            font-size: 24px;
            margin-bottom: 20px;
            color: var(--dark);
            position: relative;
            padding-bottom: 10px;
        }
        
        .summary-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--primary);
            border-radius: 2px;
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .summary-total {
            font-weight: bold;
            font-size: 20px;
            border-top: 2px solid var(--primary);
            padding-top: 15px;
            margin-top: 15px;
            color: var(--dark);
        }
        
        .checkout-btn {
            display: block;
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--success) 0%, #20c997 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 25px;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        
        .checkout-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
        }
        
        .empty-cart {
            text-align: center;
            padding: 60px 0;
        }
        
        .empty-cart i {
            font-size: 80px;
            color: var(--gray);
            margin-bottom: 25px;
        }
        
        .empty-cart p {
            font-size: 20px;
            color: var(--dark);
            margin-bottom: 30px;
        }
        
        .continue-shopping {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(106, 17, 203, 0.3);
        }
        
        .continue-shopping:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(106, 17, 203, 0.4);
        }
        
        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            padding: 60px 0 30px;
            margin-top: 60px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
        }
        
        .footer-section h3 {
            font-size: 18px;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-section h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--primary);
        }
        
        .footer-section p, .footer-section li {
            color: #aaa;
            margin-bottom: 15px;
        }
        
        .footer-section ul {
            list-style: none;
        }
        
        .footer-section ul li a {
            color: #aaa;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-section ul li a:hover {
            color: var(--primary);
        }
        
        .social-icons {
            display: flex;
            gap: 15px;
        }
        
        .social-icons a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #aaa;
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .nav-container {
                flex-direction: column;
            }
            
            nav ul {
                margin: 20px 0;
            }
            
            .cart-item {
                flex-direction: column;
                text-align: center;
            }
            
            .cart-item-img {
                margin-right: 0;
                margin-bottom: 15px;
            }
            
            .cart-item-actions {
                margin-top: 15px;
                justify-content: center;
            }
        }
        
        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
                align-items: center;
            }
            
            nav ul li {
                margin: 10px 0;
            }
            
            .nav-right {
                margin-top: 20px;
            }
            
            .cart-container {
                padding: 20px;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .footer-section h3::after {
                left: 50%;
                transform: translateX(-50%);
            }
            
            .social-icons {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header & Navigation -->
    <header>
        <div class="container nav-container">
            <a href="index.php" class="logo">
                <i class="fas fa-graduation-cap"></i>
                EduWeb-N3   
            </a>
            
            <nav>
                <ul>
                    <li><a href="client.php">Trang chủ</a></li>
                    <li><a href="khoahoc.php">Khóa học</a></li>
                    <li><a href="lienhe.php">Liên hệ</a></li>
                </ul>
            </nav>
            
            <div class="nav-right">
                <a href="shop.php" class="cart-btn">
                    <i class="fas fa-shopping-cart"></i> Giỏ hàng
                    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                        <span style="background: white; color: var(--primary); border-radius: 50%; padding: 2px 6px; margin-left: 5px;">
                            <?php echo count($_SESSION['cart']); ?>
                        </span>
                    <?php endif; ?>
                </a>
                
                <a href="?logout=true" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                </a>
            </div>
        </div>
    </header>
    
    <div class="container cart-container">
        <h1 class="cart-title">Giỏ Hàng Của Bạn</h1>
        
        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
            <div class="cart-items">
                <?php 
                $total = 0;
                foreach ($_SESSION['cart'] as $item): 
                    $item_total = $item['price'] * $item['quantity'];
                    $total += $item_total;
                ?>
                    <div class="cart-item">
                        <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>" class="cart-item-img">
                        
                        <div class="cart-item-details">
                            <h3 class="cart-item-title"><?php echo $item['title']; ?></h3>
                            <p class="cart-item-desc"><?php echo $item['description']; ?></p>
                            <div class="cart-item-price">
                                <?php 
                                if ($item['price'] > 0) {
                                    echo number_format($item['price'], 0, ',', '.') . ' ₫';
                                } else {
                                    echo 'Miễn phí';
                                }
                                ?>
                            </div>
                        </div>
                        
                        <div class="cart-item-actions">
                            <form method="POST" action="shop.php" style="display: flex; align-items: center;">
                                <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="quantity-input">
                                <button type="submit" name="update_quantity" class="btn btn-primary" style="margin-left: 10px;">Cập nhật</button>
                            </form>
                            
                            <a href="shop.php?remove=<?php echo $item['id']; ?>" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Xóa
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="cart-summary">
                <h2 class="summary-title">Tóm tắt đơn hàng</h2>
                
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <div class="summary-item">
                        <span><?php echo $item['title']; ?> (x<?php echo $item['quantity']; ?>)</span>
                        <span>
                            <?php 
                            if ($item['price'] > 0) {
                                echo number_format($item['price'] * $item['quantity'], 0, ',', '.') . ' ₫';
                            } else {
                                echo 'Miễn phí';
                            }
                            ?>
                        </span>
                    </div>
                <?php endforeach; ?>
                
                <div class="summary-item summary-total">
                    <span>Tổng cộng:</span>
                    <span><?php echo number_format($total, 0, ',', '.'); ?> ₫</span>
                </div>
                
                <form method="POST" action="thanhtoan.php">
                    <button type="submit" name="checkout" class="checkout-btn">
                        <i class="fas fa-credit-card"></i> Thanh toán
                    </button>
                </form>
            </div>
        <?php else: ?>
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <p>Giỏ hàng của bạn đang trống</p>
                <a href="khoahoc.php" class="continue-shopping">Tiếp tục mua sắm</a>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-about">
                    <div class="footer-logo">
                        <i class="fas fa-graduation-cap"></i>
                        EduWeb
                    </div>
                    <p class="footer-desc">Nền tảng học trực tuyến hàng đầu Việt Nam, mang đến những khóa học chất lượng cao với đội ngũ giảng viên tận tâm và giàu kinh nghiệm.</p>
                </div>
                
                <div class="footer-social">
                    <h3 class="footer-heading">Kết nối với chúng tôi</h3>
                    <div class="social-links">
                        <!-- Liên kết mạng xã hội (thay URL bằng link thực tế) -->
                        <a href="https://github.com" class="social-link" target="_blank">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="https://youtube.com" class="social-link" target="_blank">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="https://tiktok.com" class="social-link" target="_blank">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>
                </div>
                
                <div class="footer-contact">
                    <h3 class="footer-heading">Liên hệ với chúng tôi</h3>
                    <ul class="contact-info">
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>contact@eduweb.vn</span>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <span>+84 123 456 789</span>
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2023 EduWeb. Tất cả quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>
    
    <script>
        // Xử lý dữ liệu từ sessionStorage nếu có
        document.addEventListener('DOMContentLoaded', function() {
            const lastAddedCourse = sessionStorage.getItem('lastAddedCourse');
            if (lastAddedCourse) {
                // Hiển thị thông báo hoặc thực hiện hành động nào đó
                console.log('Đã thêm khóa học:', JSON.parse(lastAddedCourse));
                
                // Xóa dữ liệu sau khi sử dụng
                sessionStorage.removeItem('lastAddedCourse');
            }
            
            // Hiệu ứng hiển thị từ từ cho các phần tử
            const animateOnScroll = function() {
                const elements = document.querySelectorAll('.cart-item');
                
                elements.forEach(element => {
                    const position = element.getBoundingClientRect();
                    
                    // Nếu phần tử nằm trong viewport
                    if(position.top < window.innerHeight - 100) {
                        element.style.opacity = 1;
                        element.style.transform = 'translateY(0)';
                    }
                });
            };
            
            // Thiết lập ban đầu
            const cartItems = document.querySelectorAll('.cart-item');
            
            cartItems.forEach(item => {
                item.style.opacity = 0;
                item.style.transform = 'translateY(30px)';
                item.style.transition = 'all 0.6s ease';
            });
            
            // Kích hoạt khi trang được tải và khi cuộn
            window.addEventListener('load', animateOnScroll);
            window.addEventListener('scroll', animateOnScroll);
        });
    </script>
</body>
</html>