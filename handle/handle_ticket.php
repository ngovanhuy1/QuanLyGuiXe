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
    $ma_ve = trim($_POST['ma_ve']);
    $ma_kh = trim($_POST['ma_kh']);
    $bien_so = trim($_POST['bien_so']);
    $ngay_gui = $_POST['ngay_gui'];
    $ngay_nhan = $_POST['ngay_nhan'] ?: null;

    if (empty($ma_ve) || empty($ma_kh) || empty($bien_so) || empty($ngay_gui)) {
        die("Mã vé, Mã KH, Biển số và Ngày gửi là bắt buộc.");
    }

    if ($id) {
        // Cập nhật vé
        $stmt = $conn->prepare("UPDATE tickets SET ma_ve=?, ma_kh=?, bien_so=?, ngay_gui=?, ngay_nhan=? WHERE id=?");
        if (!$stmt) die("Prepare failed: " . $conn->error);
        $stmt->bind_param("sssssi", $ma_ve, $ma_kh, $bien_so, $ngay_gui, $ngay_nhan, $id);
        $action = "Cập nhật";
    } else {
        // Thêm vé mới
        $stmt = $conn->prepare("INSERT INTO tickets (ma_ve, ma_kh, bien_so, ngay_gui, ngay_nhan) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) die("Prepare failed: " . $conn->error);
        $stmt->bind_param("sssss", $ma_ve, $ma_kh, $bien_so, $ngay_gui, $ngay_nhan);
        $action = "Thêm mới";
    }

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: ../manage/tickets.php?success=" . urlencode($action . " vé thành công"));
        exit();
    } else {
        die("Thực thi thất bại: " . $stmt->error);
    }
} else {
    header("Location: ../manage/tickets.php");
    exit();
}
?>
