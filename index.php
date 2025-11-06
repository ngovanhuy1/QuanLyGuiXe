<?php
session_start();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang chủ | Bãi gửi xe DNU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --orange: #FF6B00;
            --gray-light: #F8F9FA;
            --gray-dark: #333;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--gray-light);
        }

        /* Navbar */
        .navbar {
            transition: 0.3s;
        }

        .navbar .navbar-brand span {
            color: var(--orange);
            font-weight: 700;
        }

        .nav-link:hover {
            color: var(--orange) !important;
        }

        /* Buttons */
        .btn-orange {
            background-color: var(--orange);
            color: #fff;
            border: none;
        }
        .btn-orange:hover {
            background-color: #e65c00;
        }

        /* Hero section */
        .hero {
            background: linear-gradient(rgba(255,107,0,0.85), rgba(255,107,0,0.85)),
                        url('https://images.unsplash.com/photo-1504215680853-026ed2a45def?auto=format&fit=crop&w=1400&q=80') center/cover no-repeat;
            height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }

        /* Section */
        section {
            padding: 80px 0;
        }

        .text-orange {
            color: var(--orange);
        }

        /* Card hover */
        .card {
            border-radius: 15px;
            transition: 0.3s;
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        footer {
            background-color: #222;
            color: #ddd;
            padding: 15px;
        }

        /* User dropdown */
        .user-menu {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-name {
            font-weight: 600;
            color: var(--gray-dark);
        }

        .logout-btn {
            border: none;
            background: transparent;
            color: var(--orange);
            font-weight: 500;
            text-decoration: underline;
            cursor: pointer;
        }

        .logout-btn:hover {
            color: #e65c00;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="https://cdn-icons-png.flaticon.com/512/741/741407.png" width="40" class="me-2">
                <span>Bãi gửi xe DNU</span>
            </a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="navMenu" class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#intro">Giới thiệu</a></li>
                    <li class="nav-item"><a class="nav-link" href="#service">Dịch vụ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Liên hệ</a></li>

                    <?php if (isset($_SESSION["username"]) && isset($_SESSION["fullname"])): ?>
                        <li class="nav-item ms-3">
                            <div class="user-menu">
                                <i class="bi bi-person-circle fs-5 text-orange"></i>
                                <span class="user-name">
                                    Xin chào, <strong><?= htmlspecialchars($_SESSION["fullname"]); ?></strong>
                                    <?php if (!empty($_SESSION["role"])): ?>
                                        (<?= htmlspecialchars($_SESSION["role"]); ?>)
                                    <?php endif; ?>
                                </span>
                                <form method="POST" action="logout.php" class="d-inline">
                                    <button type="submit" class="logout-btn">Đăng xuất</button>
                                </form>
                            </div>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-3"><a href="login.php" class="btn btn-outline-dark btn-sm">Đăng nhập</a></li>
                        <li class="nav-item ms-2"><a href="register.php" class="btn btn-orange btn-sm">Đăng ký</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="container">
            <h1 class="display-5 fw-bold">Chào mừng đến với Hệ thống bãi gửi xe DNU</h1>
            <p class="lead mt-3">Giải pháp gửi xe thông minh – An toàn – Nhanh chóng</p>
            <a href="<?= isset($_SESSION['username']) ? 'dashboard.php'  : 'login.php' ?>" 
               class="btn btn-light mt-4 px-4 py-2 fw-semibold">
               <?= isset($_SESSION['username']) ? 'Bắt đầu quản lý' : 'Đăng nhập ngay' ?>
            </a>
        </div>
    </section>

    <!-- Intro -->
    <section id="intro" class="bg-light text-center">
        <div class="container">
            <h2 class="text-orange mb-4">Giới thiệu</h2>
            <p class="text-muted mx-auto" style="max-width: 700px;">
                Hệ thống DNU giúp quản lý xe ra vào, nhân viên và thanh toán tự động, mang lại sự tiện lợi và an toàn cho khách hàng.
            </p>
        </div>
    </section>

    <!-- Service -->
    <section id="service" class="text-center">
        <div class="container">
            <h2 class="mb-5 text-orange">Dịch vụ nổi bật</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card p-4">
                        <i class="bi bi-car-front fs-1 text-orange"></i>
                        <h5 class="mt-3">Quản lý xe thông minh</h5>
                        <p class="text-muted">Theo dõi thông tin xe, biển số, thời gian gửi, thanh toán nhanh chóng.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4">
                        <i class="bi bi-people-fill fs-1 text-secondary"></i>
                        <h5 class="mt-3">Quản lý nhân viên</h5>
                        <p class="text-muted">Phân quyền và giám sát nhân viên hiệu quả qua hệ thống online.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4">
                        <i class="bi bi-shield-check fs-1 text-success"></i>
                        <h5 class="mt-3">Bảo mật dữ liệu</h5>
                        <p class="text-muted">Áp dụng mã hóa để bảo vệ thông tin người dùng và phương tiện.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section id="contact" class="bg-light text-center">
        <div class="container">
            <h2 class="text-orange mb-4">Liên hệ</h2>
            <p>Email: <strong>hotro@baiguixednu.vn</strong></p>
            <p>Hotline: <strong>038 809 5450</strong></p>
        </div>
    </section>

    <footer class="text-center">
        <p>© 2025 Bãi gửi xe DNU | Tử tế từ tâm <span style="color:#FF6B00">Huy</span></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
