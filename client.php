<?php
session_start();
require_once 'config.php';

// Xử lý đăng xuất
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Lấy danh sách khóa học từ database
$courses = [];
try {
    $stmt = $pdo->query("SELECT * FROM courses LIMIT 6");
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Xử lý lỗi nếu cần
    $courses = [];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Học Trực Tuyến - Trang Chủ</title>
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
            background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), url('https://images.unsplash.com/photo-1501504905252-473c47e087f8?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80') center/cover;
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
        
        .cta-btn {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            color: white;
            padding: 14px 32px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 18px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(106, 17, 203, 0.3);
        }
        
        .cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(106, 17, 203, 0.4);
        }
        
        /* Courses Section */
        .courses-section {
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
        
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
        }
        
        .course-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }
        
        .course-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
        }
        
        .course-img {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }
        
        .course-content {
            padding: 20px;
        }
        
        .course-title {
            font-size: 20px;
            margin-bottom: 10px;
            color: var(--dark);
        }
        
        .course-desc {
            color: var(--gray);
            margin-bottom: 20px;
        }
        
        .course-actions {
            display: flex;
            justify-content: space-between;
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
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            color: white;
            border: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(106, 17, 203, 0.3);
        }
        
        .btn-secondary {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }
        
        .btn-secondary:hover {
            background: var(--primary);
            color: white;
        }
        
        /* Benefits Section */
        .benefits-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #f5f7ff 0%, #e6e9ff 100%);
        }
        
        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .benefit-card {
            text-align: center;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .benefit-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .benefit-icon {
            font-size: 48px;
            margin-bottom: 20px;
            color: var(--primary);
        }
        
        .benefit-title {
            font-size: 22px;
            margin-bottom: 15px;
            color: var(--dark);
        }
        
        .benefit-desc {
            color: var(--gray);
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
        
        .contact-info {
            list-style: none;
        }
        
        .contact-info li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            color: #aaa;
        }
        
        .contact-info i {
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
            
            .courses-grid, .benefits-grid {
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
                    <li><a href="">Trang chủ</a></li>
                    <li><a href="khoahoc.php">Khóa học</a></li>
                    <li><a href="lienhe.php">Liên Hệ</a></li>
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
            <h1>Học trực tuyến mọi lúc, mọi nơi</h1>
            <p>Khám phá hàng ngàn khóa học chất lượng cao từ các chuyên gia hàng đầu trong ngành. Nâng cao kỹ năng và phát triển sự nghiệp của bạn ngay hôm nay.</p>
            <a href="khoahoc.php" class="cta-btn">Khám phá khóa học</a>
        </div>
    </section>
    
    <!-- Courses Section -->
    <section class="courses-section">
        <div class="container">
            <h2 class="section-title">Khóa Học Nổi Bật</h2>
            
            <div class="courses-grid">
                <?php if (!empty($courses)): ?>
                    <?php foreach ($courses as $course): ?>
                        <div class="course-card">
                            <!-- Hình ảnh khóa học (thay thế URL bằng hình ảnh thực tế từ database) -->
                            <img src="<?php echo $course['image_url'] ?: 'https://www.google.com/url?sa=i&url=http%3A%2F%2Fwebsitechuyennghiep.vn%2Fpython-la-gi.html&psig=AOvVaw0L3ziLNLWEM1Jj4N9s-wpl&ust=1759463807171000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCMCSjtDPhJADFQAAAAAdAAAAABAE'; ?>" alt="<?php echo $course['title']; ?>" class="course-img">
                            
                            <div class="course-content">
                                <h3 class="course-title"><?php echo $course['title']; ?></h3>
                                <p class="course-desc"><?php echo substr($course['description'], 0, 100) . '...'; ?></p>
                                
                                <div class="course-actions">
                                    <!-- Nút mua khóa học - liên kết đến trang chi tiết khóa học -->
                                    <a href="khoahoc.php?id=<?php echo $course['id']; ?>" class="btn btn-primary">Mua khóa học</a>
                                    
                                    <!-- Nút học thử - liên kết đến video demo (thay URL bằng link thực tế) -->
                                    <a href="<?php echo $course['demo_video'] ?: 'https://youtu.be/bl2m9eXfm_A?si=rL4k9VQO2Qvhnp32'; ?>" class="btn btn-secondary" target="_blank">Học thử</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Hiển thị khóa học mẫu nếu không có dữ liệu từ database -->
                    <?php for ($i = 1; $i <= 6; $i++): ?>
                        <div class="course-card">
                            <img src="https://images.unsplash.com/photo-1501504905252-473c47e087f8?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Khóa học mẫu <?php echo $i; ?>" class="course-img">
                            
                            <div class="course-content">
                                <h3 class="course-title">Khóa học mẫu <?php echo $i; ?></h3>
                                <p class="course-desc">Mô tả ngắn về khóa học mẫu số <?php echo $i; ?> với những kiến thức bổ ích.</p>
                                
                                <div class="course-actions">
                                    <a href="khoahoc.php" class="btn btn-primary">Mua khóa học</a>
                                    <a href="https://www.youtube.com/embed/dQw4w9WgXcQ" class="btn btn-secondary" target="_blank">Học thử</a>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <!-- Benefits Section -->
    <section class="benefits-section">
        <div class="container">
            <h2 class="section-title">Lợi Ích Khi Học Tại EduWeb</h2>
            
            <div class="benefits-grid">
                <div class="benefit-card">
                    <i class="fas fa-laptop benefit-icon"></i>
                    <h3 class="benefit-title">Học mọi lúc, mọi nơi</h3>
                    <p class="benefit-desc">Truy cập khóa học từ bất kỳ thiết bị nào, vào bất kỳ thời điểm nào phù hợp với bạn.</p>
                </div>
                
                <div class="benefit-card">
                    <i class="fas fa-chalkboard-teacher benefit-icon"></i>
                    <h3 class="benefit-title">Giảng viên chất lượng</h3>
                    <p class="benefit-desc">Học từ các chuyên gia hàng đầu với nhiều năm kinh nghiệm trong lĩnh vực giảng dạy.</p>
                </div>
                
                <div class="benefit-card">
                    <i class="fas fa-certificate benefit-icon"></i>
                    <h3 class="benefit-title">Chứng nhận hoàn thành</h3>
                    <p class="benefit-desc">Nhận chứng chỉ được công nhận sau khi hoàn thành khóa học để nâng cao CV của bạn.</p>
                </div>
                
                <div class="benefit-card">
                    <i class="fas fa-comments benefit-icon"></i>
                    <h3 class="benefit-title">Hỗ trợ 24/7</h3>
                    <p class="benefit-desc">Đội ngũ hỗ trợ luôn sẵn sàng giải đáp mọi thắc mắc của bạn bất cứ lúc nào.</p>
                </div>
                
                <div class="benefit-card">
                    <i class="fas fa-sync benefit-icon"></i>
                    <h3 class="benefit-title">Cập nhật liên tục</h3>
                    <p class="benefit-desc">Nội dung khóa học được cập nhật thường xuyên theo xu hướng và công nghệ mới nhất.</p>
                </div>
                
                <div class="benefit-card">
                    <i class="fas fa-hand-holding-usd benefit-icon"></i>
                    <h3 class="benefit-title">Chi phí hợp lý</h3>
                    <p class="benefit-desc">Học phí phải chăng với nhiều chính sách ưu đãi và thanh toán linh hoạt.</p>
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
            
            // Hiệu ứng hiển thị từ từ cho các phần tử
            const animateOnScroll = function() {
                const elements = document.querySelectorAll('.course-card, .benefit-card');
                
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
            const courses = document.querySelectorAll('.course-card');
            const benefits = document.querySelectorAll('.benefit-card');
            
            courses.forEach(card => {
                card.style.opacity = 0;
                card.style.transform = 'translateY(50px)';
                card.style.transition = 'all 0.8s ease';
            });
            
            benefits.forEach(card => {
                card.style.opacity = 0;
                card.style.transform = 'translateY(50px)';
                card.style.transition = 'all 0.8s ease';
            });
            
            // Kích hoạt khi trang được tải và khi cuộn
            window.addEventListener('load', animateOnScroll);
            window.addEventListener('scroll', animateOnScroll);
        });
    </script>
</body>
</html>