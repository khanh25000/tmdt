<?php
session_start();

// Kiểm tra nếu giỏ hàng trống thì chuyển hướng về trang giỏ hàng
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    header("Location: shop.php");
    exit();
}

// Tính tổng tiền
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán - EduWeb</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/khoahoc.css">
    <style>
        .checkout-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }
        
        .checkout-title {
            text-align: center;
            margin-bottom: 30px;
            color: var(--dark);
            font-size: 28px;
        }
        
        .checkout-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        .checkout-section {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .section-title {
            font-size: 20px;
            margin-bottom: 20px;
            color: var(--primary);
            border-bottom: 2px solid var(--primary);
            padding-bottom: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }
        
        .form-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        
        .order-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
        }
        
        .order-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .order-total {
            font-weight: bold;
            font-size: 18px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #ddd;
        }
        
        .payment-methods {
            margin: 20px 0;
        }
        
        .payment-method {
            margin-bottom: 10px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .payment-method:hover {
            border-color: var(--primary);
            background: #f8f9ff;
        }
        
        .payment-method.selected {
            border-color: var(--primary);
            background: #e8f4ff;
        }
        
        .confirm-btn {
            display: block;
            width: 100%;
            padding: 15px;
            background: var(--success);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
            transition: background 0.3s ease;
        }
        
        .confirm-btn:hover {
            background: #218838;
        }
        
        :root {
            --success: #28a745;
        }
    </style>
</head>
<body>
    <!-- Header & Navigation -->
    <header>
        <div class="container nav-container">
            <a href="index.php" class="logo">
                <i class="fas fa-graduation-cap"></i>
                EduWeb
            </a>
            
            <nav>
                <ul>
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><a href="khoahoc.php">Khóa học</a></li>
                    <li><a href="shop.php">Giỏ hàng</a></li>
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
    
    <div class="container checkout-container">
        <h1 class="checkout-title">Thanh Toán</h1>
        
        <div class="checkout-content">
            <!-- Thông tin khách hàng -->
            <div class="checkout-section">
                <h2 class="section-title">Thông tin thanh toán</h2>
                
                <form id="checkout-form">
                    <div class="form-group">
                        <label class="form-label">Họ và tên *</label>
                        <input type="text" class="form-input" name="fullname" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-input" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Số điện thoại *</label>
                        <input type="tel" class="form-input" name="phone" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" class="form-input" name="address">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Ghi chú</label>
                        <textarea class="form-input" name="note" rows="3" placeholder="Ghi chú cho đơn hàng..."></textarea>
                    </div>
                </form>
            </div>
            
            <!-- Tóm tắt đơn hàng -->
            <div class="checkout-section">
                <h2 class="section-title">Đơn hàng của bạn</h2>
                
                <div class="order-summary">
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                        <div class="order-item">
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
                    
                    <div class="order-item order-total">
                        <span>Tổng cộng:</span>
                        <span><?php echo number_format($total, 0, ',', '.'); ?> ₫</span>
                    </div>
                </div>
                
                <h3 class="section-title" style="margin-top: 30px;">Phương thức thanh toán</h3>
                
                <div class="payment-methods">
                    <div class="payment-method selected" data-method="banking">
                        <strong>Chuyển khoản ngân hàng</strong>
                        <p>Chuyển khoản qua tài khoản ngân hàng</p>
                    </div>
                    
                    <div class="payment-method" data-method="momo">
                        <strong>Ví MoMo</strong>
                        <p>Thanh toán qua ví điện tử MoMo</p>
                    </div>
                    
                    <div class="payment-method" data-method="cod">
                        <strong>Thanh toán khi nhận hàng</strong>
                        <p>Chỉ áp dụng cho khóa học offline</p>
                    </div>
                </div>
                
                <button type="button" class="confirm-btn" onclick="processPayment()">
                    <i class="fas fa-lock"></i> Xác nhận thanh toán
                </button>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Về chúng tôi</h3>
                    <p>EduWeb là nền tảng học trực tuyến hàng đầu Việt Nam, cung cấp các khóa học chất lượng cao với đội ngũ giảng viên giàu kinh nghiệm.</p>
                </div>
                
                <div class="footer-section">
                    <h3>Liên kết nhanh</h3>
                    <ul>
                        <li><a href="index.php">Trang chủ</a></li>
                        <li><a href="khoahoc.php">Khóa học</a></li>
                        <li><a href="tt.php">Truyền thông</a></li>
                        <li><a href="shop.php">Giỏ hàng</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Liên hệ</h3>
                    <p><i class="fas fa-map-marker-alt"></i> 123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh</p>
                    <p><i class="fas fa-phone"></i> (0123) 456 789</p>
                    <p><i class="fas fa-envelope"></i> info@eduweb.vn</p>
                </div>
                
                <div class="footer-section">
                    <h3>Theo dõi chúng tôi</h3>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2023 EduWeb. Tất cả quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>
    
    <script>
        // Xử lý chọn phương thức thanh toán
        document.querySelectorAll('.payment-method').forEach(method => {
            method.addEventListener('click', function() {
                document.querySelectorAll('.payment-method').forEach(m => {
                    m.classList.remove('selected');
                });
                this.classList.add('selected');
            });
        });
        
        // Xử lý thanh toán
        function processPayment() {
            const form = document.getElementById('checkout-form');
            const selectedMethod = document.querySelector('.payment-method.selected').getAttribute('data-method');
            
            // Kiểm tra form
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            // Hiển thị thông báo
            alert('Thanh toán thành công! Cảm ơn bạn đã mua khóa học.');
            
            // Chuyển hướng về trang chủ (trong thực tế sẽ xử lý thanh toán thật)
            window.location.href = 'khoahoc.php';
        }
    </script>
</body>
</html>