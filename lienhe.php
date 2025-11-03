<?php
session_start();
require_once 'config.php';

// Xử lý đăng xuất
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Xử lý gửi form liên hệ
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $messageText = $_POST['message'] ?? '';
    
    // Kiểm tra dữ liệu đầu vào
    if (empty($name) || empty($email) || empty($subject) || empty($messageText)) {
        $message = 'Vui lòng điền đầy đủ thông tin.';
        $messageType = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Địa chỉ email không hợp lệ.';
        $messageType = 'error';
    } else {
        // Xử lý lưu thông tin liên hệ vào database (nếu cần)
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $email, $subject, $messageText]);
            
            $message = 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.';
            $messageType = 'success';
        } catch (PDOException $e) {
            $message = 'Có lỗi xảy ra khi gửi thông tin. Vui lòng thử lại sau.';
            $messageType = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ - EduWeb-N3</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4a6bff;
            --secondary: #ff6b6b;
            --accent: #6a11cb;
            --light: #f8f9fa;
            --dark: #343a40;
            --text: #333;
            --gray: #6c757d;
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
        
        nav ul li a:hover {
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
        }
        
        .cart-btn:hover, .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }
        
        .cart-btn i, .logout-btn i {
            margin-right: 8px;
        }
        
        /* Hero Section */
        .hero {
            padding: 80px 0;
            background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), url('https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80') center/cover;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            color: var(--primary);
        }
        
        .hero p {
            font-size: 20px;
            max-width: 800px;
            margin: 0 auto 30px;
            color: var(--dark);
        }
        
        /* Contact Section */
        .contact-section {
            padding: 80px 0;
            background-color: white;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
            font-size: 36px;
            color: var(--primary);
            position: relative;
        }
        
        .section-title::after {
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
        
        .contact-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
        }
        
        .contact-info {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .contact-info h3 {
            font-size: 24px;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
        }
        
        .contact-info h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: white;
        }
        
        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
        }
        
        .contact-icon {
            font-size: 20px;
            margin-right: 15px;
            margin-top: 5px;
            width: 24px;
            text-align: center;
        }
        
        .contact-details h4 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .contact-details p {
            color: rgba(255, 255, 255, 0.8);
        }
        
        .contact-form {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(74, 107, 255, 0.2);
            outline: none;
        }
        
        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }
        
        .btn {
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            border: none;
            font-size: 16px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(106, 17, 203, 0.3);
        }
        
        .btn-block {
            display: block;
            width: 100%;
        }
        
        .message {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        /* Map Section */
        .map-section {
            padding: 60px 0;
            background: linear-gradient(135deg, #f5f7ff 0%, #e6e9ff 100%);
        }
        
        .map-container {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            height: 400px;
        }
        
        .map-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
        
        /* FAQ Section */
        .faq-section {
            padding: 80px 0;
            background-color: white;
        }
        
        .faq-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .faq-item {
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .faq-question {
            background: var(--light);
            padding: 20px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .faq-question:hover {
            background: #e9ecef;
        }
        
        .faq-question.active {
            background: var(--primary);
            color: white;
        }
        
        .faq-answer {
            padding: 0 20px;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .faq-answer.active {
            padding: 20px;
            max-height: 500px;
        }
        
        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            padding: 60px 0 30px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
        }
        
        .footer-logo {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        
        .footer-logo i {
            margin-right: 10px;
            color: var(--primary);
        }
        
        .footer-desc {
            margin-bottom: 20px;
            color: #aaa;
        }
        
        .footer-heading {
            font-size: 18px;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-heading::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--primary);
        }
        
        .social-links {
            display: flex;
            gap: 15px;
        }
        
        .social-link {
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
        
        .social-link:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }
        
        .contact-info-list {
            list-style: none;
        }
        
        .contact-info-list li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            color: #aaa;
        }
        
        .contact-info-list i {
            margin-right: 10px;
            color: var(--primary);
            font-size: 18px;
        }
        
        .copyright {
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
            
            .hero h1 {
                font-size: 36px;
            }
            
            .hero p {
                font-size: 18px;
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
            
            .contact-container {
                grid-template-columns: 1fr;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .footer-heading::after {
                left: 50%;
                transform: translateX(-50%);
            }
            
            .social-links {
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
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><a href="khoahoc.php">Khóa học</a></li>
                    <li><a href="tt.php">Liên Hệ</a></li>
                </ul>
            </nav>
            
            <div class="nav-right">
                <!-- Liên kết đến giỏ hàng (cần tạo file cart.php) -->
                <a href="shop.php" class="cart-btn">
                    <i class="fas fa-shopping-cart"></i> Giỏ hàng
                </a>
                
                <!-- Nút đăng xuất -->
                <a href="?logout=true" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                </a>
            </div>
        </div>
    </header>
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Liên Hệ Với Chúng Tôi</h1>
            <p>Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn. Hãy liên hệ với chúng tôi nếu bạn có bất kỳ câu hỏi hoặc thắc mắc nào.</p>
        </div>
    </section>
    
    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <h2 class="section-title">Liên Hệ</h2>
            
            <div class="contact-container">
                <div class="contact-info">
                    <h3>Thông Tin Liên Hệ</h3>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Địa Chỉ</h4>
                            <p>123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Điện Thoại</h4>
                            <p>+84 123 456 789</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Email</h4>
                            <p>contact@eduweb.vn</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Giờ Làm Việc</h4>
                            <p>Thứ 2 - Thứ 6: 8:00 - 17:00<br>Thứ 7: 8:00 - 12:00</p>
                        </div>
                    </div>
                </div>
                
                <div class="contact-form">
                    <h3>Gửi Tin Nhắn</h3>
                    
                    <?php if (!empty($message)): ?>
                        <div class="message <?php echo $messageType; ?>">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="name">Họ và Tên</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Tiêu Đề</label>
                            <input type="text" id="subject" name="subject" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Nội Dung</label>
                            <textarea id="message" name="message" class="form-control" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block">Gửi Tin Nhắn</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Map Section -->
    <section class="map-section">
        <div class="container">
            <h2 class="section-title">Vị Trí Của Chúng Tôi</h2>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.424184103986!2d106.69531431533437!3d10.779733992321197!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f38f7a7c7c9%3A0x5c503b7c7a7c7c7c!2s123%20%C4%90%C6%B0%E1%BB%9Dng%20ABC%2C%20Qu%E1%BA%ADn%20XYZ%2C%20TP.%20H%E1%BB%93%20Ch%C3%AD%20Minh!5e0!3m2!1svi!2s!4v1620000000000!5m2!1svi!2s" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>
    
    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <h2 class="section-title">Câu Hỏi Thường Gặp</h2>
            
            <div class="faq-container">
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Tôi có thể học thử trước khi đăng ký khóa học không?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Có, chúng tôi cung cấp bài học thử miễn phí cho hầu hết các khóa học. Bạn có thể truy cập trang khóa học và nhấp vào nút "Học thử" để trải nghiệm trước khi quyết định đăng ký.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Làm thế nào để thanh toán cho khóa học?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Chúng tôi chấp nhận nhiều hình thức thanh toán khác nhau bao gồm chuyển khoản ngân hàng, thẻ tín dụng/ghi nợ và ví điện tử. Sau khi chọn khóa học, bạn sẽ được chuyển hướng đến trang thanh toán an toàn để hoàn tất giao dịch.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Tôi có thể học trên thiết bị di động không?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Có, nền tảng của chúng tôi hoàn toàn tương thích với các thiết bị di động. Bạn có thể học mọi lúc, mọi nơi thông qua trình duyệt web trên điện thoại thông minh hoặc máy tính bảng.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Làm thế nào để nhận chứng chỉ sau khi hoàn thành khóa học?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Sau khi hoàn thành tất cả các bài học và vượt qua bài kiểm tra cuối khóa (nếu có), chứng chỉ kỹ thuật số sẽ tự động được tạo và có sẵn trong tài khoản của bạn. Bạn có thể tải xuống hoặc chia sẻ chứng chỉ này.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-about">
                    <div class="footer-logo">
                        <i class="fas fa-graduation-cap"></i>
                        EduWeb-N3
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
                    <ul class="contact-info-list">
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
        // JavaScript cho hiệu ứng scroll và các tương tác
        document.addEventListener('DOMContentLoaded', function() {
            // Thêm hiệu ứng khi cuộn trang
            window.addEventListener('scroll', function() {
                const header = document.querySelector('header');
                if (window.scrollY > 50) {
                    header.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.2)';
                    header.style.background = 'linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%)';
                } else {
                    header.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.1)';
                    header.style.background = 'linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%)';
                }
            });
            
            // Xử lý FAQ accordion
            const faqQuestions = document.querySelectorAll('.faq-question');
            
            faqQuestions.forEach(question => {
                question.addEventListener('click', function() {
                    const answer = this.nextElementSibling;
                    const icon = this.querySelector('i');
                    
                    // Đóng tất cả các câu hỏi khác
                    faqQuestions.forEach(q => {
                        if (q !== this) {
                            q.classList.remove('active');
                            q.nextElementSibling.classList.remove('active');
                            q.querySelector('i').classList.remove('fa-chevron-up');
                            q.querySelector('i').classList.add('fa-chevron-down');
                        }
                    });
                    
                    // Mở/đóng câu hỏi hiện tại
                    this.classList.toggle('active');
                    answer.classList.toggle('active');
                    
                    if (this.classList.contains('active')) {
                        icon.classList.remove('fa-chevron-down');
                        icon.classList.add('fa-chevron-up');
                    } else {
                        icon.classList.remove('fa-chevron-up');
                        icon.classList.add('fa-chevron-down');
                    }
                });
            });
            
            // Hiệu ứng hiển thị từ từ cho các phần tử
            const animateOnScroll = function() {
                const elements = document.querySelectorAll('.contact-item, .form-group, .faq-item');
                
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
            const contactItems = document.querySelectorAll('.contact-item');
            const formGroups = document.querySelectorAll('.form-group');
            const faqItems = document.querySelectorAll('.faq-item');
            
            contactItems.forEach(item => {
                item.style.opacity = 0;
                item.style.transform = 'translateY(30px)';
                item.style.transition = 'all 0.6s ease';
            });
            
            formGroups.forEach(group => {
                group.style.opacity = 0;
                group.style.transform = 'translateY(30px)';
                group.style.transition = 'all 0.6s ease';
            });
            
            faqItems.forEach(item => {
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