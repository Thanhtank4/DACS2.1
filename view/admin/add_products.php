<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'phantan') {
    header("Location: ../dashboard.php");
    exit();
}

include '../../models/connect_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $original_price = $_POST['original_price'];
    $discount_percentage = $_POST['discount_percentage'];
    $category = $_POST['category'];
    $image_url = $_FILES['image']['name'];
    
    move_uploaded_file($_FILES['image']['tmp_name'], '../../images/' . $image_url);
    
    $sql = "INSERT INTO products (name, price, original_price, discount_percentage, category, image_url) 
            VALUES ('$name', '$price', '$original_price', '$discount_percentage', '$category', '$image_url')";
    
    if (mysqli_query($conn, $sql)) {
        $success_message = "Sản phẩm đã được thêm thành công!";
    } else {
        $error_message = "Lỗi khi thêm sản phẩm: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm mới</title>
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
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 80px 20px 20px;
        }

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
        
    </style>
</head>
<body>
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="home_product.php">
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
                <a href="categories.php">
                    <i class="fas fa-tags"></i>
                    <span>Danh mục</span>
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Đăng xuất</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="header">
        <h2>Quản lý sản phẩm</h2>
        <div class="user-info">
            <span>Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
        </div>
    </div>

    <div class="main-content">
        <div class="form-container">
            <h2 class="form-title">Thêm sản phẩm mới</h2>
            
            <?php if (isset($success_message)): ?>
                <div class="message success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error_message)): ?>
                <div class="message error"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Tên sản phẩm:</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="price">Giá:</label>
                    <input type="number" id="price" name="price" required>
                </div>

                <div class="form-group">
                    <label for="original_price">Giá gốc:</label>
                    <input type="number" id="original_price" name="original_price" required>
                </div>

                <div class="form-group">
                    <label for="discount_percentage">Giảm giá (%):</label>
                    <input type="number" id="discount_percentage" name="discount_percentage" required>
                </div>

                <div class="form-group">
                    <label for="category">Danh mục:</label>
                    <select id="category" name="category" required>
                        <option value="Programming">Lập trình</option>
                        <option value="Self-help">Tự giúp mình</option>
                        <option value="Finance">Tài chính</option>
                        <option value="History">Lịch sử</option>
                        <option value="Psychology">Tâm lý học</option>
                        <option value="Fiction">Tiểu thuyết</option>
                        <option value="Science">Khoa học</option>
                        <option value="Philosophy">Triết học</option>
                        <option value="Fantasy">Giả tưởng</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="image">Chọn hình ảnh:</label>
                    <input type="file" id="image" name="image" required>
                </div>

                <button type="submit" class="submit-btn">Thêm sản phẩm</button>
            </form>
        </div>
    </div>
</body>
</html>