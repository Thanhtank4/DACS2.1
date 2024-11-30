<?php
session_start();
include '../model/db.php';
include '../model/Cart.php';
include '../model/Course.php';

$cartItems = Cart::getCartItems();
$subtotal = array_sum(array_column($cartItems, 'price'));
$shipping = 30000; // Phí ship cố định
$total = $subtotal + $shipping;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Hi English</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: #333;
            margin: 0;
            padding: 0;
        }

        .checkout-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 1rem;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            animation: fadeIn 1s ease-in-out;
        }

        .checkout-form, .order-summary {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .checkout-form:hover, .order-summary:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.3);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
            font-weight: 600;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .payment-methods {
            margin: 1.5rem 0;
        }

        .payment-method {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .payment-method:hover {
            border-color: #2575fc;
            background: rgba(37, 117, 252, 0.1);
        }

        .payment-method img {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }

        .order-summary h3 {
            margin-bottom: 1.5rem;
            color: #333;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .summary-item:last-child {
            border-bottom: none;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .btn-checkout, .btn-back {
            display: block;
            width: 100%;
            padding: 1rem;
            margin: 1rem 0;
            background: #2575fc;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            text-align: center;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn-checkout:hover, .btn-back:hover {
            background: #0d47a1;
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .checkout-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="checkout-container animate__animated animate__fadeIn">
        <div class="checkout-form">
            <h2>Thông tin thanh toán</h2>
            <form action="process_order.php" method="POST">
                <div class="form-group">
                    <label>Họ và tên</label>
                    <input type="text" name="fullname" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="tel" name="phone" required>
                </div>
                <div class="form-group">
                    <label>Địa chỉ</label>
                    <input type="text" name="address" required>
                </div>

                <h3>Phương thức thanh toán</h3>
                <div class="payment-methods">
                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="momo" required>
                        <img src="../public/img/momo-logo.png" alt="MoMo">
                        <span>Ví MoMo</span>
                    </label>
                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="vnpay" required>
                        <img src="../public/img/vnpay-logo.png" alt="VNPay">
                        <span>VNPay</span>
                    </label>
                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="bank" required>
                        <img src="../public/img/bank-transfer.png" alt="Bank Transfer">
                        <span>Chuyển khoản ngân hàng</span>
                    </label>
                </div>

                <button type="submit" class="btn-checkout">
                    <i class="fas fa-lock"></i> Thanh toán an toàn
                </button>
            </form>
            <a href="shop.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Quay lại mua khóa học
            </a>
        </div>

        <div class="order-summary">
            <h3>Đơn hàng của bạn</h3>
            <?php foreach ($cartItems as $item): ?>
                <div class="summary-item">
                    <span><?php echo htmlspecialchars($item['name']); ?></span>
                    <span><?php echo number_format($item['price']); ?> VNĐ</span>
                </div>
            <?php endforeach; ?>
            <div class="summary-item">
                <span>Phí vận chuyển</span>
                <span><?php echo number_format($shipping); ?> VNĐ</span>
            </div>
            <div class="summary-item">
                <span>Tổng cộng</span>
                <span><?php echo number_format($total); ?> VNĐ</span>
            </div>
        </div>
    </div>
</body>
</html>
