CREATE DATABASE IF NOT EXISTS bt2_web;
USE bt2_web;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    phone VARCHAR(15) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL
);

-- Tạo database
CREATE DATABASE IF NOT EXISTS eduweb;
USE eduweb;

-- Tạo bảng courses
CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) DEFAULT 0,
    category VARCHAR(100),
    rating DECIMAL(3,2) DEFAULT 0,
    rating_count INT DEFAULT 0,
    sold_count INT DEFAULT 0,
    image_url VARCHAR(500),
    demo_video VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Thêm dữ liệu mẫu
INSERT INTO courses (title, description, price, category, rating, rating_count, sold_count, image_url) VALUES
('Python', 'Khóa học Python từ cơ bản đến nâng cao', 1200000, 'Công nghệ thông tin', 4.8, 150, 300, 'https://www.google.com/url?sa=i&url=http%3A%2F%2Fwebsitechuyennghiep.vn%2Fpython-la-gi.html&psig=AOvVaw3ueyjjSetB76AUFMOozrbt&ust=1759463987989000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCPjs1aDQhJADFQAAAAAdAAAAABAE'),
('PHP', 'Học PHP và xây dựng ứng dụng web động', 1000000, 'Công nghệ thông tin', 4.5, 120, 250, 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fvn.lovepik.com%2Fimage-500540568%2Fphp-value.html&psig=AOvVaw1cIGQbHCuELaJPvE3-2Pgo&ust=1759464096868000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCKj1qNbQhJADFQAAAAAdAAAAABAE '),
('JavaScript', 'Làm chủ JavaScript và các framework', 1500000, 'Công nghệ thông tin', 4.9, 200, 400, 'https://www.google.com/url?sa=i&url=https%3A%2F%2Frecland.co%2Fblog%2Fngon-ngu-lap-trinh-javascript-la-gi-qvpAJ4jr&psig=AOvVaw1aglKeRg5tg-hnf0L-Ygd9&ust=1759464121856000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCMD31-HQhJADFQAAAAAdAAAAABAW'),
('Fullstack', 'Trở thành lập trình viên Fullstack giỏi', 2500000, 'Công nghệ thông tin', 4.7, 180, 350, 'https://www.google.com/url?sa=i&url=https%3A%2F%2F200lab.io%2Fblog%2Flam-the-nao-de-tro-thanh-full-stack-developer%3Fsrsltid%3DAfmBOoonU4R70ps3ca_lCY7nGXUPsNS2WBW3JCvd10piBZ4RfsB_dn2Q&psig=AOvVaw3tMRlqavwMDNVqwm9bHkY1&ust=1759464164637000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCIjb7fbQhJADFQAAAAAdAAAAABAE'),
('Mobile', 'Phát triển ứng dụng di động đa nền tảng', 1800000, 'Công nghệ thông tin', 4.6, 130, 280, 'https://www.google.com/url?sa=i&url=https%3A%2F%2Ffunix.edu.vn%2Fchia-se-kien-thuc%2Flap-trinh-mobile-la-gi%2F&psig=AOvVaw3Lgvsb8XQ6oqaDYc__LD55&ust=1759464221245000&source=images&cd=vfe&opi=89978449&ved=0CBUQjRxqFwoTCOiCr5HRhJADFQAAAAAdAAAAABAE'),
('Github', 'Sử dụng GitHub để quản lý dự án hiệu quả', 800000, 'Công nghệ thông tin', 4.8, 90, 200, 'https://www.google.com/url?sa=i&url=https%3A%2F%2Finterdata.vn%2Fblog%2Fgithub-la-gi%2F&psig=AOvVaw1WHIKeyiSA1XWPjdm-ZUGi&ust=1759464248438000&source=images&cd=vfe&opi=89978449&ved=0CBUQjRxqFwoTCIjP-Z3RhJADFQAAAAAdAAAAABAE');
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image_url VARCHAR(500),
    price DECIMAL(10,2),
    is_free BOOLEAN DEFAULT FALSE,
    schedule VARCHAR(255),
    time VARCHAR(100),
    category VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    subject VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    priority ENUM('low', 'medium', 'high') DEFAULT 'low',
    status ENUM('pending', 'processing', 'resolved') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);