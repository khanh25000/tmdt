// Search functionality
document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("search-input");
  const searchSuggestions = document.getElementById("search-suggestions");
  const courseCards = document.querySelectorAll(".course-card");

  // Tạo danh sách các từ khóa gợi ý
  const suggestions = [
    "python",
    "php",
    "javascript",
    "frontend",
    "backend",
    "fullstack",
    "mobile",
    "github",
    "database",
    "cài python",
    "sử dụng github",
    "cài php",
  ];

  // Xử lý sự kiện khi nhập vào ô tìm kiếm
  searchInput.addEventListener("input", function () {
    const value = this.value.toLowerCase();
    searchSuggestions.innerHTML = "";

    if (value) {
      const filteredSuggestions = suggestions.filter((suggestion) =>
        suggestion.toLowerCase().includes(value)
      );

      if (filteredSuggestions.length > 0) {
        searchSuggestions.style.display = "block";

        filteredSuggestions.forEach((suggestion) => {
          const div = document.createElement("div");
          div.className = "suggestion-item";
          div.textContent = suggestion;
          div.addEventListener("click", function () {
            searchInput.value = suggestion;
            searchSuggestions.style.display = "none";
            // Thực hiện tìm kiếm
            filterCourses(suggestion);
          });
          searchSuggestions.appendChild(div);
        });
      } else {
        searchSuggestions.style.display = "none";
      }
    } else {
      searchSuggestions.style.display = "none";
      // Hiển thị tất cả khóa học nếu không có từ khóa
      courseCards.forEach((card) => {
        card.style.display = "block";
      });
    }

    // Lọc khóa học theo từ khóa nhập
    filterCourses(value);
  });

  // Ẩn gợi ý khi click ra ngoài
  document.addEventListener("click", function (e) {
    if (
      !searchInput.contains(e.target) &&
      !searchSuggestions.contains(e.target)
    ) {
      searchSuggestions.style.display = "none";
    }
  });

  // Hàm lọc khóa học
  function filterCourses(keyword) {
    courseCards.forEach((card) => {
      const title = card.getAttribute("data-title").toLowerCase();
      if (title.includes(keyword.toLowerCase())) {
        card.style.display = "block";
      } else {
        card.style.display = "none";
      }
    });
  }

  // Tải và hiển thị khóa học cập nhật liên tục
  loadUpdatedCourses();
});

// Hàm tải khóa học cập nhật liên tục
function loadUpdatedCourses() {
  const container = document.getElementById("updated-courses-container");
  const courses = JSON.parse(localStorage.getItem("updatedCourses")) || [];

  if (courses.length === 0) {
    container.innerHTML =
      '<p style="text-align: center; width: 100%;">Chưa có khóa học nào được cập nhật.</p>';
    return;
  }

  container.innerHTML = "";

  courses.forEach((course) => {
    const courseCard = document.createElement("div");
    courseCard.className = "course-card";
    courseCard.setAttribute("data-title", course.name.toLowerCase());

    courseCard.innerHTML = `
            <img src="${course.image}" alt="${course.name}" class="course-img">
            <div class="course-content">
                <h3 class="course-title">${course.name}</h3>
                <p class="course-desc">${course.description}</p>
                <p><strong>Giảng viên:</strong> ${course.teacher}</p>
                <p><strong>Lịch học:</strong> ${course.schedule}</p>
                <p><strong>Thời gian:</strong> ${course.time}</p>
                
                <div class="course-rating">
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <span class="rating-count">(Mới)</span>
                </div>
                
                <div class="course-price">${course.price}</div>
                
                <div class="course-actions">
                    <button class="btn btn-primary add-to-cart" data-id="${
                      course.id
                    }" data-title="${
      course.name
    }" data-price="${course.price.replace(/[^\d]/g, "")}" data-image="${
      course.image
    }" data-desc="${course.description}">Mua ngay</button>
                    <button class="btn btn-secondary add-to-cart" data-id="${
                      course.id
                    }" data-title="${
      course.name
    }" data-price="${course.price.replace(/[^\d]/g, "")}" data-image="${
      course.image
    }" data-desc="${course.description}">Thêm vào giỏ</button>
                </div>
            </div>
        `;

    container.appendChild(courseCard);
  });
}
