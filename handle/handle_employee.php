<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: ../login.php");
    exit();
}

require_once __DIR__ . '/../config/db_connection.php';
$conn = getDbConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $ma_nv = trim($_POST['ma_nv']);
    $ten_nv = trim($_POST['ten_nv']);
    $chuc_vu = trim($_POST['chuc_vu']);
    $sdt = trim($_POST['sdt']);

    if (empty($ma_nv) || empty($ten_nv)) {
        die("Mã NV và Tên NV là bắt buộc.");
    }

    if ($id) {
        $stmt = $conn->prepare("UPDATE employees SET ma_nv=?, ten_nv=?, chuc_vu=?, sdt=? WHERE id=?");
        $stmt->bind_param("ssssi", $ma_nv, $ten_nv, $chuc_vu, $sdt, $id);
        $action = "Cập nhật";
    } else {
        $stmt = $conn->prepare("INSERT INTO employees (ma_nv, ten_nv, chuc_vu, sdt) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $ma_nv, $ten_nv, $chuc_vu, $sdt);
        $action = "Thêm mới";
    }

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        // Redirect về employees.php trong manage
        header("Location: ../manage/employees.php?success=" . urlencode($action . " nhân viên thành công"));
        exit();
    } else {
        die("Lỗi: " . $stmt->error);
    }
} else {
    header("Location: ../manage/employees.php");
    exit();
}
?>
