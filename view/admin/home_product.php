<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'thanhtan') {
    header("Location: ../../index.php");
    exit();
}

include '../../model/db.php';
include '../../model/Course.php';  // Bao gồm model Course

// Lấy tất cả khóa học từ cơ sở dữ liệu
$courses = Course::getAllCourses();  // Lấy danh sách tất cả khóa học
$products_count = count($courses);   // Đếm số lượng khóa học
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6D28D9;
            --sidebar-width: 250px;
            --header-height: 60px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
        }

        .sidebar {
            width: var(--sidebar-width);
            background: var(--primary-color);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            color: white;
            padding-top: var(--header-height);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu li {
            padding: 15px 25px;
            transition: all 0.3s;
        }

        .sidebar-menu li:hover {
            background: rgba(255, 255, 255, 0.1);
            cursor: pointer;
        }

        .sidebar-menu a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--header-height);
            background: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 80px 20px 20px;
        }

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        .form-title {
            color: var(--primary-color);
            margin-bottom: 30px;
            font-size: 24px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .submit-btn {
            background: var(--primary-color);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background 0.3s;
        }

        .submit-btn:hover {
            background: #5b21b6;
        }

        .message {
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }

        .success {
            background: #d1fae5;
            color: #065f46;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .stat-info h3 {
            margin: 0;
            font-size: 24px;
        }

        .stat-info p {
            margin: 5px 0 0;
            color: #666;
        }

        .recent-products {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .recent-products h2 {
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        .product-list {
            list-style: none;
            padding: 0;
        }

        .product-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .welcome-banner {
            background: linear-gradient(135deg, var(--primary-color), #4C1D95);
            color: white;
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .welcome-banner h1 {
            margin: 0;
            font-size: 28px;
        }

        .welcome-banner p {
            margin: 10px 0 0;
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <!-- Giữ nguyên sidebar từ file trước -->
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="home_product.php" class="active">
                    <i class="fas fa-home"></i>
                    <span>Trang chủ</span>
                </a>
            </li>
            <li>
                <a href="all_product.php">
                    <i class="fas fa-list"></i>
                    <span>Danh sách sản phẩm</span>
                </a>
            </li>
            <li>
                <a href="add_products.php">
                    <i class="fas fa-plus"></i>
                    <span>Thêm sản phẩm</span>
                </a>
            </li>
            <li>
                <a href="../login/logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Đăng xuất</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="header">
        <h2>Bảng điều khiển</h2>
        <div class="user-info">
            <span>Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
        </div>
    </div>

    <div class="main-content">
        <div class="welcome-banner">
            <h1>Chào mừng trở lại, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>Đây là tổng quan về cửa hàng của bạn</p>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon" style="background: #E8F5E9; color: #2E7D32;">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $products_count; ?></h3>
                    <p>Tổng số sản phẩm</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: #E3F2FD; color: #1565C0;">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="stat-info">
                    <h3></h3>
                    <p>Danh mục</p>
                </div>
            </div>
        </div>

        <div class="recent-products">
            <h2>Quản lí khoá học</h2>
            <ul class="product-list">

                <li class="product-item">
                    <div>
                    </div>

                </li>
            </ul>
        </div>
    </div>
</body>

</html>