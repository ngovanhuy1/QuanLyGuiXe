<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: ../login.php");
    exit();
}

require_once __DIR__ . '/../config/db_connection.php';
$conn = getDbConnection();

// Xử lý xóa khách hàng
if (isset($_GET['delete'])) {
    $idToDelete = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM customers WHERE id = ?");
    $stmt->bind_param("i", $idToDelete);
    $stmt->execute();
    $stmt->close();
    header("Location: ../manage/customers.php?success=" . urlencode("Xóa khách hàng thành công"));
    exit();
}

// Xử lý thêm/sửa khách hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $ma_kh = trim($_POST['ma_kh']);
    $ten_kh = trim($_POST['ten_kh']);
    $bien_so = trim($_POST['bien_so']);
    $loai_ve = trim($_POST['loai_ve']);

    if (empty($ma_kh) || empty($ten_kh) || empty($bien_so)) {
        die("Mã KH, Tên KH và Biển số là bắt buộc.");
    }

    if ($id) {
        $stmt = $conn->prepare("UPDATE customers SET ma_kh=?, ten_kh=?, bien_so=?, loai_ve=? WHERE id=?");
        if (!$stmt) die("Prepare failed: " . $conn->error);
        $stmt->bind_param("ssssi", $ma_kh, $ten_kh, $bien_so, $loai_ve, $id);
        $action = "Cập nhật";
    } else {
        $stmt = $conn->prepare("INSERT INTO customers (ma_kh, ten_kh, bien_so, loai_ve) VALUES (?, ?, ?, ?)");
        if (!$stmt) die("Prepare failed: " . $conn->error);
        $stmt->bind_param("ssss", $ma_kh, $ten_kh, $bien_so, $loai_ve);
        $action = "Thêm mới";
    }

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: ../manage/customers.php?success=" . urlencode($action . " khách hàng thành công"));
        exit();
    } else {
        die("Thực thi thất bại: " . $stmt->error);
    }
} else {
    header("Location: ../manage/customers.php");
    exit();
}
?>
