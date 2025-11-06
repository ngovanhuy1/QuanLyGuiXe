<?php
session_start();
require_once("config/db_connection.php");

$error = "";

// Khi người dùng bấm nút đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $conn = getDbConnection();

    // Truy vấn lấy thông tin người dùng
    $sql = "SELECT id, username, password, fullname, role FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // So sánh mật khẩu (chưa mã hóa → kiểm tra trực tiếp)
        if ($password === $row["password"]) {
            // Lưu session
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["fullname"] = $row["fullname"];
            $_SESSION["role"] = $row["role"];

            header("Location: index.php");
            exit;
        } else {
            $error = "❌ Sai mật khẩu!";
        }
    } else {
        $error = "❌ Tên đăng nhập không tồn tại!";
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập | DNU Smart Parking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --orange: #f57c00;
            --light-gray: #f8f9fa;
            --dark-gray: #343a40;
        }

        body {
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, var(--orange), #ffffff);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            width: 380px;
            padding: 40px;
            animation: fadeIn 0.8s ease;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(-20px);}
            to {opacity: 1; transform: translateY(0);}
        }

        h2 {
            text-align: center;
            color: var(--orange);
            font-weight: 700;
            margin-bottom: 10px;
        }

        p.subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
        }

        label {
            font-weight: 600;
            color: var(--dark-gray);
        }

        input {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: var(--orange);
            box-shadow: 0 0 6px rgba(245, 124, 0, 0.4);
        }

        .btn-login {
            width: 100%;
            background: var(--orange);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px;
            font-weight: 600;
            margin-top: 15px;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #ef6c00;
            transform: translateY(-1px);
        }

        .error {
            color: red;
            text-align: center;
            font-size: 14px;
            margin-top: 10px;
        }

        .extra-links {
            text-align: center;
            margin-top: 15px;
        }

        .extra-links a {
            text-decoration: none;
            color: var(--dark-gray);
            transition: 0.3s;
        }

        .extra-links a:hover {
            color: var(--orange);
        }

        footer {
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: center;
            color: #555;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <h2>Hệ thống bãi gửi xe DNU</h2>
        <p class="subtitle">Đăng nhập để tiếp tục</p>
        <form method="POST" action="">
            <div class="mb-3">
                <label>Tên đăng nhập</label>
                <input type="text" name="username" required>
            </div>
            <div class="mb-3">
                <label>Mật khẩu</label>
                <input type="password" name="password" required>
            </div>

            <?php if ($error): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <button type="submit" class="btn-login">Đăng nhập</button>
            <div class="extra-links">
                <a href="register.php">Chưa có tài khoản?</a> |
                <a href="#">Quên mật khẩu?</a>
            </div>
        </form>
    </div>

    <footer>
        © 2025 DNU Smart Parking |  <b> 💼</b>
    </footer>
</body>
</html>
