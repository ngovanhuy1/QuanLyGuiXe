<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bảng điều khiển | Bãi gửi xe DNU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            background-color: #212529;
            min-height: 100vh;
            color: white;
        }
        .sidebar a {
            color: #fff;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #ff6b00;
            color: #fff;
        }
        .content {
            padding: 30px;
        }
        .logout-btn {
            background-color: transparent;
            border: none;
            color: #ff6b00;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar">
            <h4 class="text-center mt-4">Bãi xe DNU</h4>
            <p class="text-center small text-secondary">Xin chào, <?= htmlspecialchars($_SESSION["fullname"]) ?></p>
            <hr>
            <a href="dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Trang chính</a>
            <a href="manage/vehicles.php"><i class="bi bi-car-front me-2"></i>Quản lý xe</a>
            <a href="manage/tickets.php"><i class="bi bi-ticket-perforated me-2"></i>Quản lý vé</a>
            <a href="manage/employees.php"><i class="bi bi-people-fill me-2"></i>Quản lý nhân viên</a>
            <a href="manage/customers.php"><i class="bi bi-person-badge me-2"></i>Quản lý khách hàng</a>
            <hr>
            <form method="POST" action="logout.php" class="text-center">
                <button type="submit" class="logout-btn">Đăng xuất</button>
            </form>
        </div>

        <!-- Content -->
        <div class="col-md-9 col-lg-10 content">
            <h2 class="mb-4">Bảng điều khiển</h2>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card shadow-sm p-4 text-center">
                        <i class="bi bi-car-front fs-1 text-warning"></i>
                        <h5 class="mt-2">Quản lý xe</h5>
                        <p class="text-muted">Xem, thêm, sửa, xóa thông tin xe.</p>
                        <a href="manage/vehicles.php" class="btn btn-outline-warning btn-sm">Đi tới</a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm p-4 text-center">
                        <i class="bi bi-ticket-perforated fs-1 text-primary"></i>
                        <h5 class="mt-2">Quản lý vé</h5>
                        <p class="text-muted">Theo dõi vé xe và thời gian gửi.</p>
                        <a href="manage/tickets.php" class="btn btn-outline-primary btn-sm">Đi tới</a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm p-4 text-center">
                        <i class="bi bi-people-fill fs-1 text-success"></i>
                        <h5 class="mt-2">Nhân viên</h5>
                        <p class="text-muted">Quản lý thông tin nhân viên.</p>
                        <a href="manage/employees.php" class="btn btn-outline-success btn-sm">Đi tới</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>
