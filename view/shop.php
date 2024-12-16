<?php
session_start();
include '../model/db.php';
include '../model/Course.php';  // Bao gồm model khóa học
include '../model/Cart.php';    // Bao gồm model giỏ hàng

// Lấy danh sách khóa học từ database
$courses = Course::getAllCourses();

if (isset($_GET['action'])) {
    $courseId = $_GET['id'];

    if ($_GET['action'] == 'add') {
        Cart::addItem($courseId);
    } elseif ($_GET['action'] == 'remove') {
        Cart::removeItem($courseId);
    }

    header('Location: shop.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hi English - Shop Khóa Học</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/index.css">
</head>
<style>
    .main-content {
        padding: 2rem 0;
        background: #f8f9fa;
    }

    .course-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        padding: 1rem;
    }

    .course-item {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .course-item:hover {
        transform: translateY(-5px);
    }

    .course-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #2196F3, #00BCD4);
    }

    .course-item h3 {
        color: #333;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .course-item .price {
        font-size: 1.25rem;
        color: #2196F3;
        font-weight: 600;
        margin: 1rem 0;
    }

    .course-item .features {
        margin: 1rem 0;
        padding: 0;
        list-style: none;
    }

    .course-item .features li {
        padding: 0.5rem 0;
        color: #666;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .course-item .features li::before {
        content: '✓';
        color: #4CAF50;
        font-weight: bold;
    }

    .btn-add-to-cart {
        display: inline-block;
        width: 100%;
        padding: 1rem;
        background: #2196F3;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        text-align: center;
        transition: background 0.3s ease;
        margin-top: 1rem;
    }

    .btn-add-to-cart:hover {
        background: #1976D2;
    }

    cart-summary {
        position: fixed;
        bottom: 1rem;
        right: 1rem;
        background: white;
        padding: 1rem;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        width: 250px;
        max-height: 300px;
        overflow-y: auto;
        z-index: 1000;
        transition: all 0.3s ease;
    }

    .cart-summary.minimized {
        width: auto;
        height: auto;
        padding: 0.5rem;
        cursor: pointer;
    }

    .cart-summary h3 {
        margin: 0 0 0.5rem 0;
        color: #333;
        font-size: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cart-toggle {
        background: none;
        border: none;
        color: #666;
        cursor: pointer;
        padding: 0.25rem;
    }

    
.cart-summary ul {
        list-style: none;
        padding: 0;
        margin: 0.5rem 0;
    }

    .cart-summary li {
        padding: 0.25rem 0;
        border-bottom: 1px solid #eee;
        font-size: 0.9rem;
    }
    .cart-summary .btn {
        display: block;
        width: 100%;
        padding: 0.5rem;
        background: #2196F3;
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 4px;
        margin-top: 0.5rem;
    }


    .cart-total {
        font-weight: bold;
        margin: 0.5rem 0;
        text-align: right;
    }
    .premium-header {
        background: linear-gradient(135deg, #2a2a72 0%, #009ffd 74%);
        padding: 3rem 0;
        color: white;
        margin-bottom: 2rem;
    }

    .premium-content {
        text-align: center;
    }

    .premium-title {
        margin-bottom: 1rem;
    }

    .premium-title i {
        font-size: 2.0rem;
        color: #ffd700;
        margin-bottom: 1rem;
    }

    .premium-title h1 {
        font-size: 2rem;
        margin: 0.5rem 0;
    }

    .premium-title p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .btn-remove {
        color: red;
        margin-left: 10px;
        text-decoration: none;
        font-size: 0.9rem;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .btn-remove:hover {
        color: darkred;
    }
    .nav-btn {
    text-decoration: none;
    font-weight: bold;    
    color: #333;          
    font-size: 20px;
    padding: 0.5rem 1rem;
    display: inline-block;
    transition: color 0.3s ease; 
}
.nav-btn {
    position: relative;
    margin: 0 1rem;
}
.nav-btn::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 0;
    height: 2px;
    background: #2196F3;
    transition: width 0.3s ease;
}

.nav-btn:hover::after {
    width: 100%;
}
.premium-header {
    background: linear-gradient(135deg, #1a237e 0%, #0d47a1 50%, #01579b 100%);
    position: relative;
    overflow: hidden;
}

.premium-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="rgba(255,255,255,0.05)"/></svg>') center/50px 50px repeat;
    opacity: 0.1;
}

</style>

<body>
    <!-- Banner -->
    <nav class="navbar">
        <section class="banner">
            <img src="../public/img/index.jpg" alt="Banner" class="banner-image">
        </section>
        <div class="container-logo">
            <div class="logo">
                <a href="../index.php">English Learning</a>
            </div>
            <div class="login-success">
                <?php if (isset($_SESSION['username'])): ?>
                    <div class="user-menu">
                        <div class="welcome-message">
                            <p>Chào mừng, <?php echo htmlspecialchars($_SESSION['username']); ?> <i class="fas fa-chevron-down"></i></p>
                        </div>
                        <div class="user-menu-content">
                            <?php if ($_SESSION['username'] == 'thanhtan'): ?>
                                <!-- Thêm quyền quản trị viên cho thanh tân -->
                            <?php endif; ?>
                            <a href="../view/login/profile.php"><i class="fas fa-user"></i> Hồ sơ</a>
                            <a href="../view/login/progress.php"><i class="fas fa-chart-line"></i> Tiến độ học tập</a>
                            <a href="../view/admin/admin.php"><i class="fas fa-tachometer-alt"></i> Bảng điều khiển quản trị</a>
                            <a href="../view/login/change_password.php"><i class="fas fa-key"></i> Đổi mật khẩu</a>
                            <a href="../view/login/logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="nav-buttons">
                        <a href="../view/login.php" class="btn"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>
                        <a href="../view/register.php" class="btn"><i class="fas fa-user-plus"></i> Đăng ký</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Nav Menu -->
    <div class="nav-menu">
        <div class="container">
            <a href="../index.php" class="nav-btn">
                <i class="fas fa-book"></i> GRAMMAR LESSONS
            </a>
            <a href="../index.php" class="nav-btn">
                <i class="fas fa-tasks"></i> PRACTICE TESTS
            </a>
            <a href="../index.php" class="nav-btn">
                <i class="fas fa-comments"></i> CONVERSATIONS
            </a>
        </div>
    </div>

    <!-- Premium Banner -->
    <div class="premium-header">
        <div class="container">
            <div class="premium-content">
                <div class="premium-title">
                    <i class="fas fa-crown"></i>
                    <h1>Premium Courses</h1>
                    <p>Nâng cao kỹ năng với các khóa học chuyên sâu</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content: Hiển thị danh sách khóa học -->
    <div class="container main-content">
        <h2>Premium Courses</h2>
        <div class="course-list">
            <?php foreach ($courses as $course): ?>
                <div class="course-item">
                    <h3><?php echo htmlspecialchars($course['name']); ?></h3>
                    <div class="price"><?php echo number_format($course['price']); ?> VNĐ</div>
                    <ul class="features">
                        <?php foreach (json_decode($course['features']) as $feature): ?>
                            <li><?php echo htmlspecialchars($feature); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="shop.php?action=add&id=<?php echo $course['id']; ?>" class="btn-add-to-cart">
                        <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Giỏ hàng -->
    <div class="cart-summary" id="cartSummary">
        <h3>
            <span>
                <i class="fas fa-shopping-cart"></i>
                Giỏ Hàng
            </span>
            <button class="cart-toggle" onclick="toggleCart()">
                <i class="fas fa-minus" id="cartIcon"></i>
            </button>
        </h3>
        <div id="cartContent">
            <?php
            $cartItems = Cart::getCartItems();
            $total = 0;
            if (empty($cartItems)): ?>
                <p>Giỏ hàng trống</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($cartItems as $item):
                        $total += $item['price'];
                    ?>
                        <li>
                            <?php echo htmlspecialchars($item['name']); ?> - <?php echo number_format($item['price']); ?> VNĐ
                            <a href="shop.php?action=remove&id=<?php echo $item['id']; ?>" class="btn-remove">
                                <i class="fas fa-trash"></i> Xóa
                            </a>
                        </li>
                    <?php endforeach; ?>

                </ul>
                <div class="cart-total">
                    Tổng: <?php echo number_format($total); ?> VNĐ
                </div>
                <a href="checkout.php" class="btn">Thanh toán</a>
            <?php endif; ?>
        </div>
    </div>

    <script>
        
        function toggleCart() {
            const cart = document.getElementById('cartSummary');
            const content = document.getElementById('cartContent');
            const icon = document.getElementById('cartIcon');

            cart.classList.toggle('minimized');
            content.style.display = content.style.display === 'none' ? 'block' : 'none';
            icon.className = content.style.display === 'none' ? 'fas fa-plus' : 'fas fa-minus';
        }
    </script>

    <!-- Footer -->
    <?php include '../view/page/footer.php'; ?>
</body>

</html>