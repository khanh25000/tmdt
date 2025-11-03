<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Học Trực Tuyến - Khóa Học</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/khoahoc.css">
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
                    <li><a href="lienhe.php">Liên Hệ</a></li>
                </ul>
            </nav>
            
            <div class="nav-right">
                <!-- Liên kết đến giỏ hàng (cần tạo file cart.php) -->
                <a href="shop.php" class="cart-btn">
                    <i class="fas fa-shopping-cart"></i> Giỏ hàng
                </a>
            
            <div class="nav-right">
                <a href="?logout=true" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                </a>
            </div>
        </div>
    </header>
    
    <!-- Search Section -->
    <section class="search-section">
        <div class="container">
            <div class="search-container">
                <h2 class="search-title">Tìm kiếm khóa học và sách</h2>
                <form class="search-form">
                    <input type="text" class="search-input" placeholder="Nhập tên khóa học hoặc sách..." id="search-input">
                    <button type="button" class="search-btn">Tìm kiếm</button>
                </form>
                <div class="search-suggestions" id="search-suggestions"></div>
                
                <div class="search-results" id="search-results">
                    <!-- Kết quả tìm kiếm sẽ được hiển thị ở đây -->
                </div>
            </div>
        </div>
    </section>
    
    <!-- Lịch học trực tiếp -->
    <section class="section" id="live-courses">
        <div class="container">
            <h2 class="section-title">Lịch Học Trực Tiếp</h2>
            
            <div class="courses-grid">
                <!-- Khóa học mẫu -->
                <div class="course-card" data-title="cài python">
                    <img src="https://f.howkteam.vn/Upload/cke/images/2_IMAGE%20TUTORIAL/3_Python/01_Python%20c%C6%A1%20b%E1%BA%A3n/B02_C%C3%A0i%20%C4%91%E1%BA%B7t%20m%C3%B4i%20tr%C6%B0%E1%BB%9Dng%20Python/5_C%C3%A0i%20%C4%91%E1%BA%B7t%20m%C3%B4i%20tr%C6%B0%E1%BB%9Dng%20Python_Howkteam_vn.jpg" alt="Cài Python" class="course-img">
                    <div class="course-content">
                        <span class="free-badge">Miễn Phí</span>
                        <h3 class="course-title">Cài Python</h3>
                        <p class="course-desc">Hướng dẫn cài đặt và cấu hình môi trường Python</p>
                        <p><strong>Lịch học:</strong> Thứ 2, 4, 6 hàng tuần</p>
                        <p><strong>Thời gian:</strong> 19:00 - 21:00</p>
                        <div class="course-actions">
                            <button class="btn btn-primary add-to-cart" data-id="7" data-title="Cài Python" data-price="0" data-image="https://images.unsplash.com/photo-1526379879527-8559ecfcaec0?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" data-desc="Hướng dẫn cài đặt và cấu hình môi trường Python">Đăng ký ngay</button>
                            <a href="https://youtu.be/W99c8zVOkkg?si=6ntblk02__qpDCMH" class="btn btn-secondary" target="_blank">Học thử</a>
                        </div>
                    </div>
                </div>
                
                <div class="course-card" data-title="database">
                    <img src="https://png.pngtree.com/element_our/png_detail/20181227/database-settings-glyph-black-icon-png_291832.jpg" alt="Database" class="course-img">
                    <div class="course-content">
                        <span class="free-badge">Miễn Phí</span>
                        <h3 class="course-title">Database</h3>
                        <p class="course-desc">Tìm hiểu về cơ sở dữ liệu và hệ quản trị cơ sở dữ liệu</p>
                        <p><strong>Lịch học:</strong> Thứ 2, 4, 6 hàng tuần</p>
                        <p><strong>Thời gian:</strong> 19:00 - 21:00</p>
                        <div class="course-actions">
                            <button class="btn btn-primary add-to-cart" data-id="8" data-title="Database" data-price="0" data-image="https://images.unsplash.com/photo-1543946608-3b7a50f67c68?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" data-desc="Tìm hiểu về cơ sở dữ liệu và hệ quản trị CSDL">Đăng ký ngay</button>
                            <a href="https://youtu.be/Z6xSj0A1FYw?si=sH3BA0UwX2Jb6hx-" class="btn btn-secondary" target="_blank">Học thử</a>
                        </div>
                    </div>
                </div>
                
                <div class="course-card" data-title="sử dụng github">
                    <img src="data:image/jpeg;base64,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" alt="Sử dụng Github" class="course-img">
                    <div class="course-content">
                        <span class="free-badge">Miễn Phí</span>
                        <h3 class="course-title">Sử dụng Github</h3>
                        <p class="course-desc">Hướng dẫn sử dụng GitHub từ cơ bản đến nâng cao</p>
                        <p><strong>Lịch học:</strong> Thứ 2, 4, 6 hàng tuần</p>
                        <p><strong>Thời gian:</strong> 19:00 - 21:00</p>
                        <div class="course-actions">
                            <button class="btn btn-primary add-to-cart" data-id="9" data-title="Sử dụng Github" data-price="0" data-image="https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" data-desc="Hướng dẫn sử dụng GitHub từ cơ bản đến nâng cao">Đăng ký ngay</button>
                            <a href="https://youtu.be/rtg6_QtEsYw?si=76Wk8qe5iV2oAZl8" class="btn btn-secondary" target="_blank">Học thử</a>
                        </div>
                    </div>
                </div>
                
                <div class="course-card" data-title="cài php">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSMf73p478P_H6AnVO76unU2tVXUEslvBsgbQ&s" alt="Cài PHP" class="course-img">
                    <div class="course-content">
                        <span class="free-badge">Miễn Phí</span>
                        <h3 class="course-title">Cài PHP</h3>
                        <p class="course-desc">Cài đặt và cấu hình môi trường PHP development</p>
                        <p><strong>Lịch học:</strong> Thứ 2, 4, 6 hàng tuần</p>
                        <p><strong>Thời gian:</strong> 19:00 - 21:00</p>
                        <div class="course-actions">
                            <button class="btn btn-primary add-to-cart" data-id="10" data-title="Cài PHP" data-price="0" data-image="https://images.unsplash.com/photo-1599507593499-a3f7d7d04067?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" data-desc="Cài đặt và cấu hình môi trường PHP development">Đăng ký ngay</button>
                            <a href="https://youtu.be/0Zay4yjYxJc?si=QOrNfbwFagkme4G6" class="btn btn-secondary" target="_blank">Học thử</a>
                        </div>
                    </div>
                </div>
                
                <div class="course-card" data-title="frontend">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSvPIXo5P2Uwtwpf5hczQPyv6PwjI_LPg1Usw&s" alt="Frontend" class="course-img">
                    <div class="course-content">
                        <span class="free-badge">Miễn Phí</span>
                        <h3 class="course-title">Frontend</h3>
                        <p class="course-desc">Xây dựng giao diện người dùng với HTML, CSS, JS</p>
                        <p><strong>Lịch học:</strong> Thứ 2, 4, 6 hàng tuần</p>
                        <p><strong>Thời gian:</strong> 19:00 - 21:00</p>
                        <div class="course-actions">
                            <button class="btn btn-primary add-to-cart" data-id="11" data-title="Frontend" data-price="0" data-image="https://images.unsplash.com/photo-1627398242454-45a1465c2479?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" data-desc="Xây dựng giao diện người dùng với HTML, CSS, JS">Đăng ký ngay</button>
                            <a href="https://youtu.be/D4cP-k5PmsM?si=VwS-FKYtqBO03ByR" class="btn btn-secondary" target="_blank">Học thử</a>
                        </div>
                    </div>
                </div>
                
                <div class="course-card" data-title="backend">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQefEij1xETQe_hM51-8SutvaOb64OehRM9vg&s" alt="Backend" class="course-img">
                    <div class="course-content">
                        <span class="free-badge">Miễn Phí</span>
                        <h3 class="course-title">Backend</h3>
                        <p class="course-desc">Phát triển phần server-side, API, kết nối fontend và backend</p>
                        <p><strong>Lịch học:</strong> Thứ 2, 4, 6 hàng tuần</p>
                        <p><strong>Thời gian:</strong> 19:00 - 21:00</p>
                        <div class="course-actions">
                            <button class="btn btn-primary add-to-cart" data-id="12" data-title="Backend" data-price="0" data-image="https://images.unsplash.com/photo-1555066931-4365d14bab8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" data-desc="Phát triển phần server-side và API">Đăng ký ngay</button>
                            <a href="https://youtu.be/QMAz9fShzwA?si=M5T8HQt15qzYKDYn" class="btn btn-secondary" target="_blank">Học thử</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Top khóa học bán chạy -->
    <section class="section" style="background-color: #f8f9fa;" id="top-courses">
        <div class="container">
            <h2 class="section-title">Top Khóa Học Bán Chạy</h2>
            
            <div class="courses-grid">
                <div class="course-card" data-title="python">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR5wSBL-98CzlOwGLH818559XBMhFeksCGnhA&s" alt="Python" class="course-img">
                    <div class="course-content">
                        <h3 class="course-title">Python</h3>
                        <p class="course-desc">Khóa học Python từ cơ bản đến nâng cao</p>
                        
                        <div class="course-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="rating-count">(150)</span>
                        </div>
                        
                        <div class="course-price">1.200.000 ₫</div>
                        
                        <div class="course-actions">
                            <button class="btn btn-primary add-to-cart" data-id="1" data-title="Python" data-price="1200000" data-image="https://images.unsplash.com/photo-1526379879527-8559ecfcaec0?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" data-desc="Khóa học Python từ cơ bản đến nâng cao">Mua ngay</button>
                            <button class="btn btn-secondary add-to-cart" data-id="1" data-title="Python" data-price="1200000" data-image="https://images.unsplash.com/photo-1526379879527-8559ecfcaec0?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" data-desc="Khóa học Python từ cơ bản đến nâng cao">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
                
                <div class="course-card" data-title="php">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg" alt="PHP" class="course-img">
                    <div class="course-content">
                        <h3 class="course-title">PHP</h3>
                        <p class="course-desc">Học PHP và xây dựng ứng dụng web động</p>
                        
                        <div class="course-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="rating-count">(120)</span>
                        </div>
                        
                        <div class="course-price">1.000.000 ₫</div>
                        
                        <div class="course-actions">
                            <button class="btn btn-primary add-to-cart" data-id="2" data-title="PHP" data-price="1000000" data-image="https://images.unsplash.com/photo-1599507593499-a3f7d7d04067?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" data-desc="Học PHP và xây dựng ứng dụng web động">Mua ngay</button>
                            <button class="btn btn-secondary add-to-cart" data-id="2" data-title="PHP" data-price="1000000" data-image="https://images.unsplash.com/photo-1599507593499-a3f7d7d04067?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" data-desc="Học PHP và xây dựng ứng dụng web động">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
                
                <div class="course-card" data-title="javascript">
                    <img src="https://img.icons8.com/color/452/javascript.png" class="course-img">
                    <div class="course-content">
                        <h3 class="course-title">JavaScript</h3>
                        <p class="course-desc">Làm chủ JavaScript và các framework</p>
                        
                        <div class="course-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="rating-count">(200)</span>
                        </div>
                        
                        <div class="course-price">1.500.000 ₫</div>
                        
                        <div class="course-actions">
                            <button class="btn btn-primary add-to-cart" data-id="3" data-title="JavaScript" data-price="1500000" data-image="https://images.unsplash.com/photo-1627398242454-45a1465c2479?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" data-desc="Làm chủ JavaScript và các framework phổ biến">Mua ngay</button>
                            <button class="btn btn-secondary add-to-cart" data-id="3" data-title="JavaScript" data-price="1500000" data-image="https://images.unsplash.com/photo-1627398242454-45a1465c2479?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" data-desc="Làm chủ JavaScript và các framework phổ biến">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
                
                <div class="course-card" data-title="fullstack">
                    <img src="https://img.freepik.com/free-vector/programmer-working-desk_23-2148288753.jpg" alt="Fullstack" class="course-img">
                    <div class="course-content">
                        <h3 class="course-title">Fullstack</h3>
                        <p class="course-desc">Trở thành lập trình viên Fullstack giỏi</p>
                        
                        <div class="course-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="rating-count">(180)</span>
                        </div>
                        
                        <div class="course-price">2.500.000 ₫</div>
                        
                        <div class="course-actions">
                            <button class="btn btn-primary add-to-cart" data-id="4" data-title="Fullstack" data-price="2500000" data-image="https://images.unsplash.com/photo-1611224923853-80b023f02d71?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" data-desc="Trở thành lập trình viên Fullstack chuyên nghiệp">Mua ngay</button>
                            <button class="btn btn-secondary add-to-cart" data-id="4" data-title="Fullstack" data-price="2500000" data-image="https://images.unsplash.com/photo-1611224923853-80b023f02d71?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" data-desc="Trở thành lập trình viên Fullstack chuyên nghiệp">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
                
                <div class="course-card" data-title="mobile">
                    <img src="https://img.freepik.com/free-vector/app-development-illustration_52683-47931.jpg" alt="Mobile" class="course-img">
                    <div class="course-content">
                        <h3 class="course-title">Mobile</h3>
                        <p class="course-desc">Phát triển ứng dụng di động đa nền tảng</p>
                        
                        <div class="course-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="rating-count">(130)</span>
                        </div>
                        
                        <div class="course-price">1.800.000 ₫</div>
                        
                        <div class="course-actions">
                            <button class="btn btn-primary add-to-cart" data-id="5" data-title="Mobile" data-price="1800000" data-image="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" data-desc="Phát triển ứng dụng di động đa nền tảng">Mua ngay</button>
                            <button class="btn btn-secondary add-to-cart" data-id="5" data-title="Mobile" data-price="1800000" data-image="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" data-desc="Phát triển ứng dụng di động đa nền tảng">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
                
                <div class="course-card" data-title="github">
                    <img src="https://github.githubassets.com/images/modules/logos_page/GitHub-Mark.png" alt="Github" class="course-img">
                    <div class="course-content">
                        <h3 class="course-title">Github</h3>
                        <p class="course-desc">Sử dụng GitHub để quản lý dự án hiệu quả</p>
                        
                        <div class="course-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="rating-count">(90)</span>
                        </div>
                        
                        <div class="course-price">800.000 ₫</div>
                        
                        <div class="course-actions">
                            <button class="btn btn-primary add-to-cart" data-id="6" data-title="Github" data-price="800000" data-image="https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" data-desc="Sử dụng GitHub để quản lý dự án hiệu quả">Mua ngay</button>
                            <button class="btn btn-secondary add-to-cart" data-id="6" data-title="Github" data-price="800000" data-image="https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" data-desc="Sử dụng GitHub để quản lý dự án hiệu quả">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- KHÓA HỌC CẬP NHẬT LIÊN TỤC - PHẦN MỚI THÊM -->
    <section class="section" id="updated-courses">
        <div class="container">
            <h2 class="section-title">Khóa Học Cập Nhật Liên Tục</h2>
            
            <div class="courses-grid" id="updated-courses-container">
                <!-- Các khóa học sẽ được tải động từ localStorage -->
            </div>
        </div>
    </section>
    
    <!-- Sách hay nên đọc -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Sách Hay Nên Đọc</h2>
            
            <div class="books-grid">
                <!-- Sách 1 -->
                <div class="book-card">
                    <a href="https://example.com/book1" target="_blank">
                        <img src="https://i.ebayimg.com/images/g/fnoAAOSwHzBmCVTx/s-l1600.webp" alt="Sách 1" class="book-img">
                    </a>
                    <div class="book-content">
                        <h3 class="book-title">The Pragmatic Programmer</h3>
                    </div>
                </div>
                
                <!-- Sách 2 -->
                <div class="book-card">
                    <a href="https://example.com/book2" target="_blank">
                        <img src="https://i.ebayimg.com/images/g/5W8AAeSwVplo12SM/s-l1600.webp" alt="Sách 2" class="book-img">
                    </a>
                    <div class="book-content">
                        <h3 class="book-title">Coding for Beginners Using Python</h3>
                    </div>
                </div>
                
                <!-- Sách 3 -->
                <div class="book-card">
                    <a href="https://example.com/book3" target="_blank">
                        <img src="https://i.ebayimg.com/images/g/ePwAAOSwA3dYMgSW/s-l960.webp" alt="Sách 3" class="book-img">
                    </a>
                    <div class="book-content">
                        <h3 class="book-title">Coding For Dummies </h3>
                    </div>
                </div>
                
                <!-- Sách 4 -->
                <div class="book-card">
                    <a href="https://example.com/book4" target="_blank">
                        <img src="https://i.ebayimg.com/images/g/o9oAAOSwx6pYpCpT/s-l960.webp" alt="Sách 4" class="book-img">
                    </a>
                    <div class="book-content">
                        <h3 class="book-title">C++ Programming Language, the 4th Edition</h3>
                    </div>
                </div>
                
                <!-- Sách 5 -->
                <div class="book-card">
                    <a href="https://example.com/book5" target="_blank">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRkdJtFdU7mjrDZ5VTU2lDryH_U9aBzNux48w&s">
                    </a>
                    <div class="book-content">
                        <h3 class="book-title">Beginning Programming All‑in‑One For Dummies</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Đội ngũ giảng viên -->
    <section class="section" style="background-color: #f8f9fa;" id="teachers">
        <div class="container">
            <h2 class="section-title">Đội Ngũ Giảng Viên</h2>
            
            <div class="teachers-slider">
                <div class="teachers-track">
                    <!-- Giảng viên 1 -->
                    <div class="teacher-card">
                        <img src="https://upload.wikimedia.org/wikipedia/en/1/1f/Martin_Fowler_2024.jpg" alt="Giảng viên 1" class="teacher-img">
                        <div class="teacher-content">
                            <h3 class="teacher-name">Martin Fowler</h3>
                            <p class="teacher-quote">"Bất kỳ kẻ ngốc nào cũng có thể viết mã mà máy tính hiểu được. Lập trình viên giỏi viết mã mà con người cũng có thể hiểu."</p>
                        </div>
                    </div>
                    
                    <!-- Giảng viên 2 -->
                    <div class="teacher-card">
                        <img src="https://vcdn1-sohoa.vnecdn.net/2021/04/25/CaoViet-1619326559-5919-1619339888.jpg?w=1200&h=0&q=100&dpr=1&fit=crop&s=e2tCQotoF2I4xDvU1t1Fug" alt="Giảng viên 2" class="teacher-img">
                        <div class="teacher-content">
                            <h3 class="teacher-name">Cao Văn Việt</h3>
                            <p class="teacher-quote">"Việc lập trình như bài tập thể dục mỗi ngày."</p>
                        </div>
                    </div>
                    
                    <!-- Giảng viên 3 -->
                    <div class="teacher-card">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTkKAnBLp8uvuYqxKcGJTfxxp4jy5qiUzcFGQ&s" alt="Giảng viên 3" class="teacher-img">
                        <div class="teacher-content">
                            <h3 class="teacher-name">Linus Torvalds</h3>
                            <p class="teacher-quote">"Lời nói thì rẻ rúng. Hãy cho tôi xem mã nguồn đi."</p>
                        </div>
                    </div>
                    
                    <!-- Giảng viên 4 -->
                    <div class="teacher-card">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/2/23/Dennis_Ritchie_2011.jpg" alt="Giảng viên 4" class="teacher-img">
                        <div class="teacher-content">
                            <h3 class="teacher-name">Dennis Ritchie</h3>
                            <p class="teacher-quote">"Cách duy nhất để học một ngôn ngữ lập trình mới là viết chương trình bằng nó."</p>
                        </div>
                    </div>
                    
                    <!-- Giảng viên 5 -->
                    <div class="teacher-card">
                        <img src="https://londonspeakerbureau.com/wp-content/uploads/2021/10/Kent-Beck-Keynote-Speaker.jpg" alt="Giảng viên 5" class="teacher-img">
                        <div class="teacher-content">
                            <h3 class="teacher-name">Kent Beck</h3>
                            <p class="teacher-quote">"Tôi không phải là lập trình viên vĩ đại; tôi chỉ là lập trình viên tốt với thói quen tuyệt vời."</p>
                        </div>
                    </div>
                    
                    <!-- Giảng viên 6 -->
                    <div class="teacher-card">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSVzEjSeeqCy5eTJBhjnk4pghepRTxOn7cp4w&s" alt="Giảng viên 6" class="teacher-img">
                        <div class="teacher-content">
                            <h3 class="teacher-name">Robert C. Martin (“Uncle Bob”)</h3>
                            <p class="teacher-quote">"Bạn nên đặt tên biến với cùng mức cẩn trọng như khi bạn đặt tên cho đứa con đầu lòng."</p>
                        </div>
                    </div>
                    
                    <!-- Tạo bản sao của các giảng viên để tạo hiệu ứng vòng lặp liên tục -->
                    <div class="teacher-card">
                        <img src="https://upload.wikimedia.org/wikipedia/en/1/1f/Martin_Fowler_2024.jpg" alt="Giảng viên 1" class="teacher-img">
                        <div class="teacher-content">
                            <h3 class="teacher-name">Martin Fowler</h3>
                            <p class="teacher-quote">"Bất kỳ kẻ ngốc nào cũng có thể viết mã mà máy tính hiểu được. Lập trình viên giỏi viết mã mà con người cũng có thể hiểu."</p>
                        </div>
                    </div>
                    
                    <div class="teacher-card">
                        <img src="https://vcdn1-sohoa.vnecdn.net/2021/04/25/CaoViet-1619326559-5919-1619339888.jpg?w=1200&h=0&q=100&dpr=1&fit=crop&s=e2tCQotoF2I4xDvU1t1Fug" alt="Giảng viên 2" class="teacher-img">
                        <div class="teacher-content">
                            <h3 class="teacher-name">Cao Văn Việt</h3>
                            <p class="teacher-quote">"Mỗi ngày tôi bỏ ra 1-2 tiếng lập trình … dồn toàn tâm toàn lực."</p>
                        </div>
                    </div>
                    
                    <div class="teacher-card">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTkKAnBLp8uvuYqxKcGJTfxxp4jy5qiUzcFGQ&s" alt="Giảng viên 3" class="teacher-img">
                        <div class="teacher-content">
                            <h3 class="teacher-name">Linus Torvalds</h3>
                            <p class="teacher-quote">"Lời nói thì rẻ rúng. Hãy cho tôi xem mã nguồn đi."</p>
                        </div>
                    </div>
                    
                    <div class="teacher-card">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/2/23/Dennis_Ritchie_2011.jpg" alt="Giảng viên 4" class="teacher-img">
                        <div class="teacher-content">
                            <h3 class="teacher-name">Dennis Ritchie</h3>
                            <p class="teacher-quote">"Cách duy nhất để học một ngôn ngữ lập trình mới là viết chương trình bằng nó."</p>
                        </div>
                    </div>
                    
                    <div class="teacher-card">
                        <img src="https://londonspeakerbureau.com/wp-content/uploads/2021/10/Kent-Beck-Keynote-Speaker.jpg" alt="Giảng viên 5" class="teacher-img">
                        <div class="teacher-content">
                            <h3 class="teacher-name">Kent Beck</h3>
                            <p class="teacher-quote">"Tôi không phải là lập trình viên vĩ đại; tôi chỉ là lập trình viên tốt với thói quen tuyệt vời."</p>
                        </div>
                    </div>
                    
                    <div class="teacher-card">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSVzEjSeeqCy5eTJBhjnk4pghepRTxOn7cp4w&s" alt="Giảng viên 6" class="teacher-img">
                        <div class="teacher-content">
                            <h3 class="teacher-name">Robert C. Martin (“Uncle Bob”)</h3>
                            <p class="teacher-quote">"Bạn nên đặt tên biến với cùng mức cẩn trọng như khi bạn đặt tên cho đứa con đầu lòng."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-col">
                    <div class="footer-logo">
                        <i class="fas fa-graduation-cap"></i>
                        EduWeb
                    </div>
                    <p class="footer-desc">EduWeb là nền tảng học trực tuyến hàng đầu, cung cấp các khóa học chất lượng cao với đội ngũ giảng viên chuyên nghiệp.</p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                    </div>
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
                
                <div class="footer-col">
                    <h3 class="footer-heading">Liên hệ</h3>
                    <ul class="contact-info">
                        <li><i class="fas fa-map-marker-alt"></i> 123 Đường ABC, Quận 1, TP.HCM</li>
                        <li><i class="fas fa-phone"></i> (0123) 456 789</li>
                        <li><i class="fas fa-envelope"></i> info@eduweb.vn</li>
                        <li><i class="fas fa-clock"></i> Thứ 2 - Thứ 6: 8:00 - 17:00</li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2023 EduWeb. Tất cả các quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>
    
    <script src="js/khoahoc.js"></script>
    <script>
        // Thêm sự kiện cho các nút "Thêm vào giỏ" và "Mua ngay"
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartButtons = document.querySelectorAll('.add-to-cart');
            
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const courseId = this.getAttribute('data-id');
                    const courseTitle = this.getAttribute('data-title');
                    const coursePrice = this.getAttribute('data-price');
                    const courseImage = this.getAttribute('data-image');
                    const courseDesc = this.getAttribute('data-desc');
                    
                    // Lưu thông tin khóa học vào sessionStorage (tùy chọn)
                    const courseData = {
                        id: courseId,
                        title: courseTitle,
                        price: coursePrice,
                        image: courseImage,
                        description: courseDesc
                    };
                    sessionStorage.setItem('lastAddedCourse', JSON.stringify(courseData));
                    
                    // Chuyển hướng đến trang giỏ hàng
                    window.location.href = `shop.php?course_id=${courseId}`;
                });
            });
        });
    </script>
</body>
</html>