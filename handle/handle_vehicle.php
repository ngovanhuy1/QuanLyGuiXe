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
    $bien_so = trim($_POST['bien_so']);
    $chu_so_huu = trim($_POST['chu_so_huu']);
    $loai_xe = trim($_POST['loai_xe']);

    if (empty($bien_so) || empty($chu_so_huu)) {
        die("Biển số và Chủ sở hữu là bắt buộc.");
    }

    if ($id) {
        $stmt = $conn->prepare("UPDATE vehicles SET bien_so=?, chu_so_huu=?, loai_xe=? WHERE id=?");
        if (!$stmt) die("Prepare failed: " . $conn->error);
        $stmt->bind_param("sssi", $bien_so, $chu_so_huu, $loai_xe, $id);
        $action = "Cập nhật";
    } else {
        $stmt = $conn->prepare("INSERT INTO vehicles (bien_so, chu_so_huu, loai_xe) VALUES (?, ?, ?)");
        if (!$stmt) die("Prepare failed: " . $conn->error);
        $stmt->bind_param("sss", $bien_so, $chu_so_huu, $loai_xe);
        $action = "Thêm mới";
    }

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: ../manage/vehicles.php?success=" . urlencode($action . " xe thành công"));
        exit();
    } else {
        die("Thực thi thất bại: " . $stmt->error);
    }
} else {
    header("Location: ../manage/vehicles.php");
    exit();
}
?>
