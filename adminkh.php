<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý khóa học - EduWeb</title>
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
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header */
        header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            padding: 15px 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
        
        .back-btn {
            color: white;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        
        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }
        
        .back-btn i {
            margin-right: 8px;
        }
        
        /* Main Content */
        .main-content {
            padding: 40px 0;
        }
        
        .page-title {
            text-align: center;
            font-size: 36px;
            margin-bottom: 30px;
            color: var(--primary);
            position: relative;
        }
        
        .page-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--accent));
            border-radius: 2px;
        }
        
        /* Form Styles */
        .form-container {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
        }
        
        .form-title {
            font-size: 24px;
            margin-bottom: 20px;
            color: var(--dark);
            border-bottom: 2px solid var(--light);
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
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 107, 255, 0.2);
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn {
            padding: 12px 24px;
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
        
        .btn-secondary {
            background: var(--gray);
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
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        }
        
        .courses-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .courses-table th,
        .courses-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .courses-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: var(--dark);
        }
        
        .courses-table tr:hover {
            background-color: #f8f9fa;
        }
        
        .course-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 14px;
        }
        
        .empty-message {
            text-align: center;
            padding: 30px;
            color: var(--gray);
            font-style: italic;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .courses-table {
                display: block;
                overflow-x: auto;
            }
            
            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container nav-container">
            <a href="index.php" class="logo">
                <i class="fas fa-graduation-cap"></i>
                EduWeb - Quản lý khóa học
            </a>
            
            <a href="khoahoc.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </header>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <h1 class="page-title">Quản lý khóa học</h1>
            
            <!-- Form thêm/sửa khóa học -->
            <div class="form-container">
                <h2 class="form-title" id="form-title">Thêm khóa học mới</h2>
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
                <h2 class="form-title">Danh sách khóa học</h2>
                
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
                    Chưa có khóa học nào. Hãy thêm khóa học mới!
                </div>
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
                        <td><img src="${course.image}" alt="${course.name}" class="course-image"></td>
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
                    formTitle.textContent = 'Sửa khóa học';
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
                formTitle.textContent = 'Thêm khóa học mới';
                submitBtn.textContent = 'Thêm khóa học';
            }
        });
    </script>
</body>
</html>