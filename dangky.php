<?php
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];
    
    if ($password !== $confirm_password) {
        $error = "Mật khẩu nhập lại không khớp!";
    } else {
        // Kiểm tra xem username đã tồn tại chưa
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ? OR phone = ?");
        $stmt->execute([$username, $email, $phone]);
        
        if ($stmt->rowCount() > 0) {
            $error = "Tên đăng nhập, email hoặc số điện thoại đã tồn tại!";
        } else {
            // Mã hóa mật khẩu
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Thêm người dùng mới
            $stmt = $pdo->prepare("INSERT INTO users (phone, email, username, password, role) VALUES (?, ?, ?, ?, ?)");
            
            if ($stmt->execute([$phone, $email, $username, $hashed_password, $role])) {
                $success = "Đăng ký thành công! Bạn sẽ được chuyển hướng đến trang đăng nhập.";
                header("refresh:3;url=login.php");
            } else {
                $error = "Đã xảy ra lỗi khi đăng ký. Vui lòng thử lại!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6a11cb;
            --secondary: #2575fc;
            --success: #2ecc71;
            --error: #e74c3c;
            --text: #333;
            --light: #f8f9fa;
            --dark: #343a40;
            --gray: #6c757d;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            transform: rotate(30deg);
            z-index: 0;
        }
        
        .container {
            width: 100%;
            max-width: 480px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2), 0 0 0 1px rgba(255, 255, 255, 0.1);
            overflow: hidden;
            transition: all 0.4s ease;
            position: relative;
            z-index: 1;
            backdrop-filter: blur(10px);
        }
        
        .container:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1);
        }
        
        .form-container {
            padding: 40px;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo i {
            font-size: 42px;
            color: var(--primary);
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }
        
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: var(--text);
            font-weight: 700;
            font-size: 28px;
            position: relative;
        }
        
        h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 2px;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 25px;
        }
        
        .input-group input, .input-group select {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            outline: none;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #fff;
            color: var(--text);
        }
        
        .input-group input:focus, .input-group select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(106, 17, 203, 0.2);
            transform: translateY(-2px);
        }
        
        .input-group i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 18px;
        }
        
        .btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(106, 17, 203, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.6s ease;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(106, 17, 203, 0.4);
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(106, 17, 203, 0.4);
        }
        
        .links {
            text-align: center;
            margin-top: 25px;
        }
        
        .links a {
            color: var(--primary);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
        }
        
        .links a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            transition: width 0.3s ease;
        }
        
        .links a:hover {
            color: var(--secondary);
        }
        
        .links a:hover::after {
            width: 100%;
        }
        
        .error {
            color: var(--error);
            text-align: center;
            margin-bottom: 20px;
            padding: 12px;
            background: rgba(231, 76, 60, 0.1);
            border-radius: 8px;
            border-left: 4px solid var(--error);
            animation: shake 0.5s ease;
        }
        
        .success {
            color: var(--success);
            text-align: center;
            margin-bottom: 20px;
            padding: 12px;
            background: rgba(46, 204, 113, 0.1);
            border-radius: 8px;
            border-left: 4px solid var(--success);
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-5px); }
            40%, 80% { transform: translateX(5px); }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 576px) {
            .form-container {
                padding: 30px 20px;
            }
            
            .container {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="logo">
                <i class="fas fa-user-plus"></i>
            </div>
            <h2>Đăng ký tài khoản</h2>
            <?php if (!empty($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>
            <form action="" method="POST">
                                <div class="input-group">
                    <input type="text" name="username" placeholder="Tên đăng nhập" required>
                    <i class="fas fa-user"></i>
                </div>
                                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="input-group">
                    <input type="text" name="phone" placeholder="Số điện thoại" required>
                    <i class="fas fa-phone"></i>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Mật khẩu" required>
                    <i class="fas fa-lock"></i>
                </div>
                <div class="input-group">
                    <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
                    <i class="fas fa-lock"></i>
                </div>
                <div class="input-group">
                    <select name="role" required>
                        <option value="">Chọn vai trò</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                    <i class="fas fa-user-tag"></i>
                </div>
                <button type="submit" class="btn">Đăng ký</button>
            </form>
            <div class="links">
                <a href="login.php">Đã có tài khoản? Đăng nhập</a>
            </div>
        </div>
    </div>
</body>
</html>