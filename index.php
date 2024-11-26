<?php session_start();
include './model/db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hi English - App học tiếng Anh miễn phí</title>
    <link rel="stylesheet" href="./public/css/style.css">
    <style>
        .nav-menu {
            background: #f5f5f5;
            padding: 1rem 0;
            margin-bottom: 2rem;
        }

        .nav-menu .container {
            display: flex;
            justify-content: center;
            gap: 2rem;
        }

        .nav-menu button {
            padding: 0.5rem 1.5rem;
            border: none;
            background: none;
            font-size: 1rem;
            cursor: pointer;
            position: relative;
            color: #333;
            transition: color 0.3s;
        }

        .nav-menu button.active {
            color: #007bff;
            font-weight: bold;
        }

        .nav-menu button.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #007bff;
        }

        .course-section {
            display: block;
            /* Display all sections initially */
        }

        .course-section.active {
            display: block;
        }

        .course-section.hidden {
            display: none;
        }

        /* Navbar */
        .navbar {
            background-color: #003366;
            /* Nền xanh đậm tạo cảm giác chuyên nghiệp */
            padding: 1.2rem 2rem;
            color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            /* Bóng đổ nhẹ để tạo chiều sâu */
        }

        .container-logo {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo a {
            color: #fff;
            font-size: 2rem;
            font-weight: 700;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: color 0.3s;
        }

        .logo a:hover {
            color: #ffcc00;
            /* Màu vàng nổi bật khi hover */
        }

        .login-success {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .welcome-message {
            font-size: 1.1rem;
            color: #fff;
            margin-left: 50px;
        }

        .nav-buttons {
            display: flex;
            gap: 15px;
        }

        .nav-buttons .btn:hover {
            background-color: #003366;
            color: #ffcc00;
            transform: translateY(-2px);
        }
        @media screen and (max-width: 768px) {
            .container-logo {
                flex-direction: column;
                align-items: flex-start;
            }

            .nav-buttons {
                margin-top: 10px;
                gap: 10px;
            }

            .welcome-message {
                margin-right: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="container-logo">
            <div class="logo"><a href="index.php">English Learning</a></div>
            <div class="login-success">
                <?php if (isset($_SESSION['username'])): ?>
                    <div class="welcome-message">
                        <p>Chào mừng, <?php echo htmlspecialchars($_SESSION['username']); ?>! <a href="./view/logout.php" class="btn">Đăng xuất</a></p>
                    </div>
                <?php else: ?>
                    <div class="nav-buttons">
                        <a href="./view/login.php" class="btn">Đăng nhập</a>
                        <a href="./view/register.php" class="btn">Đăng ký</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Section Navigation Menu -->
    <div class="nav-menu">
        <div class="container">
            <button class="nav-btn active" data-section="grammar">GRAMMAR LESSONS</button>
            <button class="nav-btn" data-section="practice">PRACTICE TESTS</button>
            <button class="nav-btn" data-section="conversation">CONVERSATIONS</button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container main-content">
        <!-- Grammar Section -->
        <section class="course-section" id="grammar-section">
            <div class="section-header">
                <img src="assets/icons/book.png" alt="Grammar" class="section-icon">
                <h2>GRAMMAR LESSONS</h2>
            </div>
            <div class="course-grid">
                <?php
                for ($i = 1; $i <= 6; $i++) {
                    echo "
                    <div class='course-card'>
                        <div class='card-header'>
                            <h3>Level $i</h3>
                            <div class='lesson-count'>15 lessons</div>
                        </div>
                        <div class='card-content'>
                            <a href='./view/lessons.php?level=$i' class='start-btn'>Start Learning</a>
                        </div>
                    </div>";
                }
                ?>
            </div>
        </section>

        <!-- Practice Tests Section -->
        <section class="course-section hidden" id="practice-section">
            <div class="section-header">
                <img src="assets/icons/test.png" alt="Tests" class="section-icon">
                <h2>PRACTICE TESTS</h2>
            </div>
            <div class="course-grid">
                <?php
                for ($i = 1; $i <= 6; $i++) {
                    echo "
                    <div class='course-card'>
                        <div class='card-header'>
                            <h3>Level $i</h3>
                            <div class='lesson-count'>50 tests</div>
                        </div>
                        <div class='card-content'>
                            <a href='./view/partice.php?level=$i' class='start-btn'>Start Test</a>
                        </div>
                    </div>";
                }
                ?>
            </div>
        </section>

        <!-- Conversation Section -->
        <section class="course-section hidden" id="conversation-section">
            <div class="section-header">
                <img src="assets/icons/conversation.png" alt="Conversations" class="section-icon">
                <h2>CONVERSATIONS</h2>
            </div>
            <div class="course-grid">
                <?php
                for ($i = 1; $i <= 6; $i++) {
                    echo "
                    <div class='course-card'>
                        <div class='card-header'>
                            <h3>Level $i</h3>
                            <div class='lesson-count'>20 dialogues</div>
                        </div>
                        <div class='card-content'>
                            <a href='./view/conver.php?level=$i' class='start-btn'>Start Practice</a>
                        </div>
                    </div>";
                }
                ?>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navButtons = document.querySelectorAll('.nav-btn');
            const sections = document.querySelectorAll('.course-section');

            // Default: show all sections without hiding any
            sections.forEach(section => {
                section.classList.remove('hidden');
            });

            navButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    navButtons.forEach(btn => btn.classList.remove('active'));

                    // Add active class to clicked button
                    button.classList.add('active');

                    // Hide all sections
                    sections.forEach(section => {
                        section.classList.add('hidden');
                    });

                    // Show the corresponding section
                    const sectionId = `${button.dataset.section}-section`;
                    document.getElementById(sectionId).classList.remove('hidden');
                });
            });
        });
    </script>
</body>

</html>