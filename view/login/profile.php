<?php
session_start();
include '../../model/db.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}

$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ sơ người dùng - Hi English</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../public/css/footer.css">
    <style>
        .profile-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #eee;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: #003366;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        .profile-info {
            flex: 1;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .stat-card {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
        }

        .stat-card i {
            font-size: 2rem;
            color: #003366;
            margin-bottom: 1rem;
        }

        .edit-profile-btn {
            background: #003366;
            color: white;
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .edit-profile-btn:hover {
            background: #004d99;
        }

        .achievements {
            margin-top: 2rem;
        }

        .achievement-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
        }

        .achievement {
            text-align: center;
            padding: 1rem;
        }

        .achievement i {
            font-size: 2rem;
            color: #ffcc00;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="profile-info">
                <h1><?php echo htmlspecialchars($user['username']); ?></h1>
                <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><i class="fas fa-calendar"></i> Tham gia: <?php echo date('d/m/Y', strtotime($user['created_at'])); ?></p>
                <button class="edit-profile-btn">Chỉnh sửa hồ sơ</button>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-book"></i>
                <h3>Bài học đã hoàn thành</h3>
                <p>45</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-tasks"></i>
                <h3>Bài kiểm tra đã làm</h3>
                <p>28</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-star"></i>
                <h3>Điểm trung bình</h3>
                <p>85%</p>
            </div>
        </div>

        <div class="achievements">
            <h2>Thành tích đạt được</h2>
            <div class="achievement-grid">
                <div class="achievement">
                    <i class="fas fa-trophy"></i>
                    <h3>Người học chăm chỉ</h3>
                    <p>Hoàn thành 30 bài học</p>
                </div>
                <div class="achievement">
                    <i class="fas fa-medal"></i>
                    <h3>Điểm số xuất sắc</h3>
                    <p>Đạt điểm tuyệt đối</p>
                </div>
                <div class="achievement">
                    <i class="fas fa-fire"></i>
                    <h3>Streak 7 ngày</h3>
                    <p>Học 7 ngày liên tiếp</p>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>