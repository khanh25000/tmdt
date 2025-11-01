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

// Dữ liệu mẫu cho biểu đồ - lượt mua khóa học từ tháng 1 đến tháng 10 năm 2025
$monthly_purchases = [
    'Tháng 1' => 130,
    'Tháng 2' => 100,
    'Tháng 3' => 70,
    'Tháng 4' => 100,
    'Tháng 5' => 30,
    'Tháng 6' => 20,
    'Tháng 7' => 60,
    'Tháng 8' => 50,
    'Tháng 9' => 75,
    'Tháng 10' =>70
];

// Thống kê tổng quan
$total_purchases = array_sum($monthly_purchases);
$peak_month = array_search(max($monthly_purchases), $monthly_purchases);
$peak_value = max($monthly_purchases);
$average_purchases = round($total_purchases / count($monthly_purchases), 1);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống Kê Khóa Học</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        
        .stat-card.total i { 
            color: var(--info);
        }
        
        .stat-card.peak i { 
            color: var(--primary);
        }
        
        .stat-card.average i { 
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
        
        /* Chart Container */
        .chart-container {
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 15px;
            border: 1px solid var(--border);
            box-shadow: var(--glow);
            margin-bottom: 35px;
            position: relative;
            overflow: hidden;
        }
        
        .chart-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }
        
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .chart-header h3 {
            font-size: 22px;
            font-weight: 600;
            background: linear-gradient(to right, #fff, var(--text-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .chart-wrapper {
            position: relative;
            height: 400px;
            width: 100%;
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
            
            .header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
            
            .chart-wrapper {
                height: 300px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-crown"></i> Admin Panel</h3>
            <p>Xin chào, <?php echo htmlspecialchars($admin['username']); ?></p>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li><a href="admin.php"><i class="fas fa-tachometer-alt"></i>Quản lý</a></li>
                <li><a href="" class="active"><i class="fas fa-chart-bar"></i> Thống kê</a></li>
                <li><a href="adminkh.php"><i class="fa-solid fa-plus"></i></i> Thêm khóa học</a></li>   
            </ul>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1><i class="fas fa-chart-bar"></i> Thống Kê Khóa Học 2025</h1>
            <div class="user-info">
                <div class="user-avatar">
                    <?php echo strtoupper(substr($admin['username'], 0, 1)); ?>
                </div>
                <span><?php echo htmlspecialchars($admin['username']); ?></span>
                <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
            </div>
        </div>

        <!-- Thống kê tổng quan -->
        <div class="stats-container">
            <div class="stat-card total">
                <i class="fas fa-shopping-cart"></i>
                <div class="stat-number"><?php echo $total_purchases; ?></div>
                <div class="stat-label">Tổng lượt mua khóa học</div>
            </div>
            <div class="stat-card peak">
                <i class="fas fa-chart-line"></i>
                <div class="stat-number"><?php echo $peak_value; ?></div>
                <div class="stat-label">Lượt mua cao nhất (<?php echo $peak_month; ?>)</div>
            </div>
            <div class="stat-card average">
                <i class="fas fa-calculator"></i>
                <div class="stat-number"><?php echo $average_purchases; ?></div>
                <div class="stat-label">Trung bình lượt mua mỗi tháng</div>
            </div>
        </div>

        <!-- Biểu đồ -->
        <div class="chart-container">
            <div class="chart-header">
                <h3><i class="fas fa-chart-bar"></i> Biểu Đồ Lượt Mua Khóa Học (Tháng 1-10/2025)</h3>
            </div>
            <div class="chart-wrapper">
                <canvas id="purchaseChart"></canvas>
            </div>
        </div>

        <!-- Bảng dữ liệu -->
        <div class="table-container">
            <div class="table-header">
                <h3><i class="fas fa-table"></i> Dữ Liệu Chi Tiết</h3>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Tháng</th>
                        <th>Lượt mua</th>
                        <th>Tỷ lệ phần trăm</th>
                        <th>Xu hướng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $previous_value = null;
                    foreach ($monthly_purchases as $month => $purchases): 
                        $percentage = $total_purchases > 0 ? round(($purchases / $total_purchases) * 100, 1) : 0;
                        
                        // Xác định xu hướng
                        $trend = '';
                        if ($previous_value !== null) {
                            if ($purchases > $previous_value) {
                                $trend = '<span style="color: var(--success);"><i class="fas fa-arrow-up"></i> Tăng</span>';
                            } elseif ($purchases < $previous_value) {
                                $trend = '<span style="color: var(--error);"><i class="fas fa-arrow-down"></i> Giảm</span>';
                            } else {
                                $trend = '<span style="color: var(--text-light);"><i class="fas fa-minus"></i> Ổn định</span>';
                            }
                        } else {
                            $trend = '<span style="color: var(--text-light);">-</span>';
                        }
                        $previous_value = $purchases;
                    ?>
                    <tr>
                        <td><?php echo $month; ?></td>
                        <td><?php echo $purchases; ?></td>
                        <td><?php echo $percentage; ?>%</td>
                        <td><?php echo $trend; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Dữ liệu cho biểu đồ
        const monthlyData = {
            labels: <?php echo json_encode(array_keys($monthly_purchases)); ?>,
            datasets: [{
                label: 'Lượt mua khóa học',
                data: <?php echo json_encode(array_values($monthly_purchases)); ?>,
                backgroundColor: 'rgba(138, 43, 226, 0.3)',
                borderColor: 'rgba(138, 43, 226, 1)',
                borderWidth: 2,
                pointBackgroundColor: 'rgba(138, 43, 226, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                fill: true,
                tension: 0.4
            }]
        };

        // Cấu hình biểu đồ
        const config = {
            type: 'line',
            data: monthlyData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#e0e0e0',
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(25, 25, 40, 0.9)',
                        titleColor: '#e0e0e0',
                        bodyColor: '#e0e0e0',
                        borderColor: 'rgba(138, 43, 226, 0.5)',
                        borderWidth: 1
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(120, 120, 180, 0.2)'
                        },
                        ticks: {
                            color: '#b0b0b0'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(120, 120, 180, 0.2)'
                        },
                        ticks: {
                            color: '#b0b0b0'
                        }
                    }
                }
            }
        };

        // Khởi tạo biểu đồ
        window.onload = function() {
            const ctx = document.getElementById('purchaseChart').getContext('2d');
            new Chart(ctx, config);
        };
    </script>
</body>
</html>