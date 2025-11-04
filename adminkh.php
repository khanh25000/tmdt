<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý khóa học - Admin Panel</title>
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
            text-decoration: none;
            display: inline-block;
        }
        
        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 69, 0, 0.4);
        }
        
        /* Form Container */
        .form-container {
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
        
        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }
        
        .form-title {
            font-size: 22px;
            margin-bottom: 25px;
            font-weight: 600;
            background: linear-gradient(to right, #fff, var(--text-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text);
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            background: rgba(40, 40, 60, 0.5);
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
            color: var(--text);
        }
        
        .form-control:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(138, 43, 226, 0.2);
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            border: none;
            font-size: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(106, 17, 203, 0.4);
        }
        
        .btn-secondary {
            background: var(--text-light);
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        
        .btn-success {
            background: var(--success);
            color: white;
        }
        
        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
        }
        
        .btn-danger {
            background: var(--danger);
            color: white;
        }
        
        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
        }
        
        /* Courses List */
        .courses-list {
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid var(--border);
            box-shadow: var(--glow);
            overflow: hidden;
            position: relative;
        }
        
        .courses-list::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }
        
        .courses-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .courses-table th,
        .courses-table td {
            padding: 15px 20px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }
        
        .courses-table th {
            background: rgba(40, 40, 60, 0.5);
            font-weight: 600;
            color: var(--text);
            font-size: 15px;
        }
        
        .courses-table tr {
            transition: all 0.3s;
        }
        
        .courses-table tr:hover {
            background: var(--bg-hover);
        }
        
        .course-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid var(--border);
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn-sm {
            padding: 8px 15px;
            font-size: 14px;
        }
        
        .empty-message {
            text-align: center;
            padding: 40px;
            color: var(--text-light);
            font-style: italic;
            font-size: 18px;
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
            
            .form-actions {
                flex-direction: column;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .courses-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-crown"></i> Admin Panel</h3>
            <p>Quản lý khóa học</p>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li><a href="admin.php"><i class="fas fa-tachometer-alt"></i>Quản lý</a></li>
                <li><a href="thongke.php"><i class="fas fa-chart-bar"></i> Thống kê</a></li>
                <li><a href="adminkh.php" class="active"><i class="fa-solid fa-plus"></i> Thêm khóa học</a></li>   
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1><i class="fas fa-graduation-cap"></i> Quản Lý Khóa Học</h1>
            <div class="user-info">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <span>Quản trị viên</span>
                <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
            </div>
        </div>
        
        <!-- Form thêm/sửa khóa học -->
        <div class="form-container">
            <h2 class="form-title" id="form-title"><i class="fas fa-plus-circle"></i> Thêm khóa học mới</h2>
            <form id="course-form">
                <input type="hidden" id="course-id">
                
                <div class="form-group">
                    <label for="course-name" class="form-label">Tên khóa học</label>
                    <input type="text" id="course-name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="course-price" class="form-label">Giá tiền</label>
                    <input type="text" id="course-price" class="form-control" placeholder="Ví dụ: 1.200.000 ₫" required>
                </div>
                
                <div class="form-group">
                    <label for="course-teacher" class="form-label">Giáo viên</label>
                    <input type="text" id="course-teacher" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="course-description" class="form-label">Mô tả khóa học</label>
                    <textarea id="course-description" class="form-control" rows="4" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="course-image" class="form-label">URL hình ảnh</label>
                    <input type="url" id="course-image" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="course-time" class="form-label">Thời gian</label>
                    <input type="text" id="course-time" class="form-control" placeholder="Ví dụ: 19:00 - 21:00" required>
                </div>
                
                <div class="form-group">
                    <label for="course-schedule" class="form-label">Ngày học</label>
                    <input type="text" id="course-schedule" class="form-control" placeholder="Ví dụ: Thứ 2, 4, 6 hàng tuần" required>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" id="submit-btn">Thêm khóa học</button>
                    <button type="button" class="btn btn-secondary" id="cancel-btn">Hủy</button>
                </div>
            </form>
        </div>
        
        <!-- Danh sách khóa học -->
        <div class="courses-list">
            <div class="header" style="margin-bottom: 0; border-radius: 0; box-shadow: none; border: none;">
                <h2><i class="fas fa-list"></i> Danh sách khóa học</h2>
            </div>
            
            <table class="courses-table">
                <thead>
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên khóa học</th>
                        <th>Giá</th>
                        <th>Giáo viên</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody id="courses-table-body">
                    <!-- Danh sách khóa học sẽ được tải ở đây -->
                </tbody>
            </table>
            
            <div id="empty-message" class="empty-message" style="display: none;">
                <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; opacity: 0.5;"></i><br>
                Chưa có khóa học nào. Hãy thêm khóa học mới!
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const courseForm = document.getElementById('course-form');
            const submitBtn = document.getElementById('submit-btn');
            const cancelBtn = document.getElementById('cancel-btn');
            const formTitle = document.getElementById('form-title');
            const courseIdInput = document.getElementById('course-id');
            const coursesTableBody = document.getElementById('courses-table-body');
            const emptyMessage = document.getElementById('empty-message');
            
            let isEditing = false;
            let currentEditId = null;
            
            // Tải danh sách khóa học
            loadCourses();
            
            // Xử lý submit form
            courseForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const courseData = {
                    id: isEditing ? currentEditId : Date.now().toString(),
                    name: document.getElementById('course-name').value,
                    price: document.getElementById('course-price').value,
                    teacher: document.getElementById('course-teacher').value,
                    description: document.getElementById('course-description').value,
                    image: document.getElementById('course-image').value,
                    time: document.getElementById('course-time').value,
                    schedule: document.getElementById('course-schedule').value
                };
                
                saveCourse(courseData);
                resetForm();
                loadCourses();
            });
            
            // Xử lý nút hủy
            cancelBtn.addEventListener('click', resetForm);
            
            // Hàm lưu khóa học
            function saveCourse(courseData) {
                let courses = JSON.parse(localStorage.getItem('updatedCourses')) || [];
                
                if (isEditing) {
                    // Cập nhật khóa học hiện có
                    const index = courses.findIndex(course => course.id === courseData.id);
                    if (index !== -1) {
                        courses[index] = courseData;
                    }
                } else {
                    // Thêm khóa học mới
                    courses.push(courseData);
                }
                
                localStorage.setItem('updatedCourses', JSON.stringify(courses));
                
                // Hiển thị thông báo
                alert(isEditing ? 'Cập nhật khóa học thành công!' : 'Thêm khóa học thành công!');
            }
            
            // Hàm tải danh sách khóa học
            function loadCourses() {
                const courses = JSON.parse(localStorage.getItem('updatedCourses')) || [];
                coursesTableBody.innerHTML = '';
                
                if (courses.length === 0) {
                    emptyMessage.style.display = 'block';
                    return;
                }
                
                emptyMessage.style.display = 'none';
                
                courses.forEach(course => {
                    const row = document.createElement('tr');
                    
                    row.innerHTML = `
                        <td><img src="${course.image}" alt="${course.name}" class="course-image" onerror="this.src='https://via.placeholder.com/80x60/2a2a40/cccccc?text=No+Image'"></td>
                        <td>${course.name}</td>
                        <td>${course.price}</td>
                        <td>${course.teacher}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn btn-success btn-sm edit-btn" data-id="${course.id}">
                                    <i class="fas fa-edit"></i> Sửa
                                </button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="${course.id}">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </div>
                        </td>
                    `;
                    
                    coursesTableBody.appendChild(row);
                });
                
                // Thêm sự kiện cho nút sửa
                document.querySelectorAll('.edit-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        editCourse(id);
                    });
                });
                
                // Thêm sự kiện cho nút xóa
                document.querySelectorAll('.delete-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        deleteCourse(id);
                    });
                });
            }
            
            // Hàm sửa khóa học
            function editCourse(id) {
                const courses = JSON.parse(localStorage.getItem('updatedCourses')) || [];
                const course = courses.find(c => c.id === id);
                
                if (course) {
                    document.getElementById('course-id').value = course.id;
                    document.getElementById('course-name').value = course.name;
                    document.getElementById('course-price').value = course.price;
                    document.getElementById('course-teacher').value = course.teacher;
                    document.getElementById('course-description').value = course.description;
                    document.getElementById('course-image').value = course.image;
                    document.getElementById('course-time').value = course.time;
                    document.getElementById('course-schedule').value = course.schedule;
                    
                    isEditing = true;
                    currentEditId = id;
                    formTitle.innerHTML = '<i class="fas fa-edit"></i> Sửa khóa học';
                    submitBtn.textContent = 'Cập nhật khóa học';
                    
                    // Cuộn lên đầu form
                    document.querySelector('.form-container').scrollIntoView({ behavior: 'smooth' });
                }
            }
            
            // Hàm xóa khóa học
            function deleteCourse(id) {
                if (confirm('Bạn có chắc chắn muốn xóa khóa học này?')) {
                    let courses = JSON.parse(localStorage.getItem('updatedCourses')) || [];
                    courses = courses.filter(course => course.id !== id);
                    localStorage.setItem('updatedCourses', JSON.stringify(courses));
                    
                    loadCourses();
                    alert('Xóa khóa học thành công!');
                }
            }
            
            // Hàm reset form
            function resetForm() {
                courseForm.reset();
                courseIdInput.value = '';
                isEditing = false;
                currentEditId = null;
                formTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Thêm khóa học mới';
                submitBtn.textContent = 'Thêm khóa học';
            }
        });
    </script>
</body>
</html>