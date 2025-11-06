<?php
session_start();
require_once 'config.php';

// Kiểm tra đăng nhập và quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Lấy thông tin admin
$admin_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$admin_id]);
$admin = $stmt->fetch();

// Kiểm tra nếu không tìm thấy admin
if (!$admin) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Xử lý các hành động quản trị
$action = isset($_GET['action']) ? $_GET['action'] : '';
$message = '';

if ($action === 'delete_user' && isset($_GET['id'])) {
    // Xóa người dùng
    $user_id = intval($_GET['id']);
    if ($user_id != $admin_id) {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        if ($stmt->execute([$user_id])) {
            $message = "Xóa người dùng thành công!";
        } else {
            $message = "Lỗi khi xóa người dùng!";
        }
    } else {
        $message = "Không thể xóa chính mình!";
    }
}

if ($action === 'edit_user' && isset($_POST['user_id'])) {
    // Cập nhật thông tin người dùng
    $user_id = intval($_POST['user_id']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $role = $_POST['role'];
    
    // Kiểm tra dữ liệu đầu vào
    if (empty($username) || empty($email) || empty($phone)) {
        $message = "Vui lòng điền đầy đủ thông tin!";
    } else {
        $stmt = $pdo->prepare("UPDATE users SET phone = ?, email = ?, username = ?, role = ? WHERE id = ?");
        if ($stmt->execute([$phone, $email, $username, $role, $user_id])) {
            $message = "Cập nhật thông tin thành công!";
        } else {
            $message = "Lỗi khi cập nhật thông tin!";
        }
    }
}

// Lấy danh sách người dùng
$stmt = $pdo->prepare("SELECT * FROM users ORDER BY id DESC");
$stmt->execute();
$users = $stmt->fetchAll();

// Kiểm tra nếu $users là false, gán thành mảng rỗng
if ($users === false) {
    $users = [];
}

// Thống kê
$total_users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_admins = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")->fetchColumn();
$total_normal_users = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'user'")->fetchColumn();

// Đảm bảo giá trị thống kê không null
$total_users = $total_users ?: 0;
$total_admins = $total_admins ?: 0;
$total_normal_users = $total_normal_users ?: 0;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản Trị</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #8a2be2;
            --secondary: #9370db;
            --accent: #ba55d3;
            --success: #32cd32;
            --warning: #ffa500;
            --error: #ff4500;
            --info: #1e90ff;
            --text: #e0e0e0;
            --text-light: #b0b0b0;
            --bg-dark: #0f0f1a;
            --bg-card: rgba(25, 25, 40, 0.7);
            --bg-hover: rgba(40, 40, 60, 0.5);
            --border: rgba(120, 120, 180, 0.2);
            --sidebar: rgba(20, 20, 35, 0.9);
            --header: rgba(30, 30, 50, 0.8);
            --glow: 0 0 15px rgba(138, 43, 226, 0.5);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #0c0c1a 0%, #1a1a2e 50%, #16213e 100%);
            color: var(--text);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(138, 43, 226, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(147, 112, 219, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(186, 85, 211, 0.05) 0%, transparent 50%);
            z-index: -1;
        }
        
        /* Sidebar */
        .sidebar {
            width: 280px;
            background: var(--sidebar);
            backdrop-filter: blur(10px);
            color: white;
            position: fixed;
            height: 100vh;
            transition: all 0.3s;
            z-index: 1000;
            border-right: 1px solid var(--border);
            box-shadow: var(--glow);
        }
        
        .sidebar-header {
            padding: 25px;
            background: var(--header);
            text-align: center;
            border-bottom: 1px solid var(--border);
        }
        
        .sidebar-header h3 {
            margin-bottom: 10px;
            font-size: 22px;
            background: linear-gradient(to right, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 600;
        }
        
        .sidebar-header p {
            font-size: 13px;
            opacity: 0.7;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .sidebar-menu ul {
            list-style: none;
        }
        
        .sidebar-menu li {
            margin: 8px 0;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        
        .sidebar-menu a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(138, 43, 226, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .sidebar-menu a:hover::before, .sidebar-menu a.active::before {
            left: 100%;
        }
        
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: var(--bg-hover);
            color: white;
            border-left: 4px solid var(--primary);
            padding-left: 21px;
        }
        
        .sidebar-menu i {
            margin-right: 12px;
            font-size: 18px;
            width: 20px;
            text-align: center;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 25px;
            transition: all 0.3s;
        }
        
        .header {
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 15px;
            border: 1px solid var(--border);
            box-shadow: var(--glow);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            font-size: 28px;
            font-weight: 600;
            background: linear-gradient(to right, #fff, var(--text-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
            box-shadow: 0 0 10px rgba(138, 43, 226, 0.5);
        }
        
        .logout-btn {
            background: linear-gradient(135deg, var(--error), #ff6347);
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
            box-shadow: 0 4px 10px rgba(255, 69, 0, 0.3);
        }
        
        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 69, 0, 0.4);
        }
        
        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
            margin-bottom: 35px;
        }
        
        .stat-card {
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 15px;
            border: 1px solid var(--border);
            box-shadow: var(--glow);
            text-align: center;
            transition: all 0.4s;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }
        
        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(138, 43, 226, 0.3);
        }
        
        .stat-card i {
            font-size: 42px;
            margin-bottom: 20px;
            color: var(--primary);
        }
        
        .stat-card.users i { 
            color: var(--info);
        }
        
        .stat-card.admins i { 
            color: var(--primary);
        }
        
        .stat-card.normal i { 
            color: var(--success);
        }
        
        .stat-number {
            font-size: 36px;
            font-weight: bold;
            margin: 15px 0;
            background: linear-gradient(to right, #fff, var(--text-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .stat-label {
            color: var(--text-light);
            font-size: 15px;
            letter-spacing: 0.5px;
        }
        
        /* Table */
        .table-container {
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid var(--border);
            box-shadow: var(--glow);
            overflow: hidden;
        }
        
        .table-header {
            padding: 25px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .table-header h3 {
            font-size: 22px;
            font-weight: 600;
            background: linear-gradient(to right, #fff, var(--text-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 18px 25px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }
        
        th {
            background: rgba(40, 40, 60, 0.5);
            font-weight: 600;
            color: var(--text);
            font-size: 15px;
        }
        
        tr {
            transition: all 0.3s;
        }
        
        tr:hover {
            background: var(--bg-hover);
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
        }
        
        .btn-edit {
            background: linear-gradient(135deg, var(--warning), #ffa500);
            color: white;
            box-shadow: 0 4px 10px rgba(255, 165, 0, 0.3);
        }
        
        .btn-delete {
            background: linear-gradient(135deg, var(--error), #ff6347);
            color: white;
            box-shadow: 0 4px 10px rgba(255, 69, 0, 0.3);
        }
        
        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 165, 0, 0.4);
        }
        
        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 69, 0, 0.4);
        }
        
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(10, 10, 20, 0.8);
            backdrop-filter: blur(5px);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background: var(--bg-card);
            backdrop-filter: blur(15px);
            padding: 35px;
            border-radius: 15px;
            width: 90%;
            max-width: 500px;
            border: 1px solid var(--border);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            animation: modalAppear 0.3s ease-out;
        }
        
        @keyframes modalAppear {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border);
        }
        
        .modal-header h3 {
            font-size: 22px;
            font-weight: 600;
            background: linear-gradient(to right, #fff, var(--text-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .close {
            font-size: 28px;
            cursor: pointer;
            color: var(--text-light);
            transition: all 0.3s;
        }
        
        .close:hover {
            color: white;
            transform: scale(1.1);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-light);
        }
        
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px 15px;
            background: rgba(30, 30, 45, 0.7);
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 15px;
            color: var(--text);
            transition: all 0.3s;
        }
        
        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(138, 43, 226, 0.3);
        }
        
        .modal-buttons {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 25px;
        }
        
        .btn-cancel {
            background: rgba(100, 100, 130, 0.5);
            color: var(--text);
            border: 1px solid var(--border);
        }
        
        .btn-save {
            background: linear-gradient(135deg, var(--success), #32cd32);
            color: white;
            box-shadow: 0 4px 10px rgba(50, 205, 50, 0.3);
        }
        
        .btn-cancel:hover, .btn-save:hover {
            transform: translateY(-2px);
        }
        
        .btn-save:hover {
            box-shadow: 0 6px 15px rgba(50, 205, 50, 0.4);
        }
        
        /* Message */
        .message {
            padding: 18px;
            margin-bottom: 25px;
            border-radius: 10px;
            text-align: center;
            backdrop-filter: blur(10px);
            border-left: 5px solid;
            animation: slideIn 0.5s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .message.success {
            background: rgba(50, 205, 50, 0.1);
            color: var(--success);
            border-left-color: var(--success);
        }
        
        .message.error {
            background: rgba(255, 69, 0, 0.1);
            color: var(--error);
            border-left-color: var(--error);
        }
        
        /* Role badges */
        .role-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .role-admin {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            box-shadow: 0 2px 8px rgba(138, 43, 226, 0.3);
        }
        
        .role-user {
            background: linear-gradient(135deg, var(--success), #32cd32);
            color: white;
            box-shadow: 0 2px 8px rgba(50, 205, 50, 0.3);
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                width: 240px;
            }
            
            .main-content {
                margin-left: 240px;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-crown"></i> Admin</h3>
            <p>Xin chào, <?php echo htmlspecialchars($admin['username'] ?? 'Admin'); ?></p>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li><a href="" class="active"><i class="fas fa-tachometer-alt"></i>Quản lý</a></li>
                <li><a href="thongke.php"><i class="fas fa-chart-bar"></i> Thống kê</a></li>
                <li><a href="adminkh.php"><i class="fa-solid fa-plus"></i></i> Thêm khóa học</a></li>   
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1><i class="fas fa-tachometer-alt"></i> Bảng điều khiển quản trị</h1>
            <div class="user-info">
                <div class="user-avatar">
                    <?php echo strtoupper(substr(($admin['username'] ?? 'A'), 0, 1)); ?>
                </div>
                <span><?php echo htmlspecialchars($admin['username'] ?? 'Admin'); ?></span>
                <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
            </div>
        </div>

        <?php if (!empty($message)): ?>
            <div class="message <?php echo strpos($message, 'thành công') !== false ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- Thống kê -->
        <div class="stats-container">
            <div class="stat-card users">
                <i class="fas fa-users"></i>
                <div class="stat-number"><?php echo $total_users; ?></div>
                <div class="stat-label">Tổng số người dùng</div>
            </div>
            <div class="stat-card admins">
                <i class="fas fa-user-shield"></i>
                <div class="stat-number"><?php echo $total_admins; ?></div>
                <div class="stat-label">Quản trị viên</div>
            </div>
            <div class="stat-card normal">
                <i class="fas fa-user"></i>
                <div class="stat-number"><?php echo $total_normal_users; ?></div>
                <div class="stat-label">Người dùng thường</div>
            </div>
        </div>

        <!-- Bảng người dùng -->
        <div class="table-container">
            <div class="table-header">
                <h3><i class="fas fa-list"></i> Danh sách người dùng</h3>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên đăng nhập</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Vai trò</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['phone']); ?></td>
                            <td>
                                <span class="role-badge <?php echo $user['role'] == 'admin' ? 'role-admin' : 'role-user'; ?>">
                                    <?php echo $user['role'] == 'admin' ? 'Quản trị' : 'Người dùng'; ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-edit" onclick="openEditModal(<?php echo $user['id']; ?>, '<?php echo addslashes($user['username']); ?>', '<?php echo addslashes($user['email']); ?>', '<?php echo addslashes($user['phone']); ?>', '<?php echo $user['role']; ?>')">
                                        <i class="fas fa-edit"></i> Sửa
                                    </button>
                                    <?php if ($user['id'] != $admin_id): ?>
                                    <a href="admin.php?action=delete_user&id=<?php echo $user['id']; ?>" class="btn btn-delete" onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                                        <i class="fas fa-trash"></i> Xóa
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px;">
                                <i class="fas fa-info-circle" style="font-size: 48px; opacity: 0.5; margin-bottom: 15px;"></i>
                                <p style="color: var(--text-light);">Không có người dùng nào</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal chỉnh sửa người dùng -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-edit"></i> Chỉnh sửa người dùng</h3>
                <span class="close" onclick="closeEditModal()">&times;</span>
            </div>
            <form action="admin.php?action=edit_user" method="POST">
                <input type="hidden" name="user_id" id="editUserId">
                <div class="form-group">
                    <label for="editUsername">Tên đăng nhập</label>
                    <input type="text" id="editUsername" name="username" required>
                </div>
                <div class="form-group">
                    <label for="editEmail">Email</label>
                    <input type="email" id="editEmail" name="email" required>
                </div>
                <div class="form-group">
                    <label for="editPhone">Số điện thoại</label>
                    <input type="text" id="editPhone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="editRole">Vai trò</label>
                    <select id="editRole" name="role" required>
                        <option value="user">Người dùng</option>
                        <option value="admin">Quản trị viên</option>
                    </select>
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn btn-cancel" onclick="closeEditModal()">Hủy</button>
                    <button type="submit" class="btn btn-save">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Modal functions
        function openEditModal(id, username, email, phone, role) {
            document.getElementById('editUserId').value = id;
            document.getElementById('editUsername').value = username;
            document.getElementById('editEmail').value = email;
            document.getElementById('editPhone').value = phone;
            document.getElementById('editRole').value = role;
            document.getElementById('editModal').style.display = 'flex';
        }
        
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
        
        // Đóng modal khi click bên ngoài
        window.onclick = function(event) {
            var modal = document.getElementById('editModal');
            if (event.target == modal) {
                closeEditModal();
            }
        }
    </script>
</body>
</html>