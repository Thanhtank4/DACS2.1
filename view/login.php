<?php
session_start();
require_once '../model/db.php';
require_once '../controller/AuthController.php';

// Loại bỏ phần kiểm tra và chuyển hướng khi đã đăng nhập
// if (isset($_SESSION['username'])) {
//     header('Location: ../index.php');
//     exit();
// }

$error = '';  // Chỉ cần khai báo biến lỗi

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $authController = new AuthController($conn);
    $result = $authController->processLogin($_POST['username'], $_POST['password']);
    
    if ($result['success']) {
        // Chuyển hướng người dùng sau khi đăng nhập thành công
        header('Location: ../index.php');
        exit();
    } else {
        $error = $result['message'];  // Chỉ hiển thị lỗi nếu đăng nhập không thành công
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Hi English</title>
    <link rel="stylesheet" href="./public/css/style.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }

        .form-group input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .btn-login {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-login:hover {
            background: #0056b3;
        }

        .error-message {
            color: #dc3545;
            margin-bottom: 15px;
            text-align: center;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
        }

        .register-link a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Đăng nhập</h2>
        <?php if ($error): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn-login">Đăng nhập</button>
        </form>
        
        <div class="register-link">
            Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>
        </div>
    </div>
</body>
</html>
