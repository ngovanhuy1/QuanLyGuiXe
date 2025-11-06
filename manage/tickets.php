<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../login.php");
    exit();
}

require_once __DIR__ . '/../config/db_connection.php';
$conn = getDbConnection();

// Xử lý xóa vé
if (isset($_GET['delete'])) {
    $idToDelete = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM tickets WHERE id = ?");
    $stmt->bind_param("i", $idToDelete);
    $stmt->execute();
    $stmt->close();
    header("Location: tickets.php?success=" . urlencode("Xóa vé thành công"));
    exit();
}

// Xử lý chỉnh sửa
$edit = false;
$ticket = null;
if (isset($_GET['edit'])) {
    $edit = true;
    $idToEdit = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM tickets WHERE id = ?");
    $stmt->bind_param("i", $idToEdit);
    $stmt->execute();
    $resultEdit = $stmt->get_result();
    $ticket = $resultEdit->fetch_assoc();
    $stmt->close();
}

// Lấy danh sách vé
$result = $conn->query("SELECT * FROM tickets ORDER BY id DESC");
$successMsg = $_GET['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý vé | Bãi gửi xe DNU</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { background-color: #f8f9fa; }
.sidebar { background-color: #212529; min-height: 100vh; color: white; }
.sidebar a { color: #fff; display: block; padding: 12px 20px; text-decoration: none; }
.sidebar a:hover, .sidebar a.active { background-color: #ff6b00; color: #fff; }
.content { padding: 30px; }
.logout-btn { background: transparent; border: none; color: #ff6b00; text-decoration: underline; cursor: pointer; }
</style>
</head>
<body>
<div class="container-fluid">
<div class="row">
    <div class="col-md-3 col-lg-2 sidebar">
        <h4 class="text-center mt-4">Bãi xe DNU</h4>
        <p class="text-center small text-secondary">Xin chào, <?= htmlspecialchars($_SESSION["fullname"]) ?></p>
        <hr>
        <a href="../dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Bảng điều khiển</a>
        <a href="vehicles.php"><i class="bi bi-car-front me-2"></i>Quản lý xe</a>
        <a href="tickets.php" class="active"><i class="bi bi-ticket-perforated me-2"></i>Quản lý vé</a>
        <a href="employees.php"><i class="bi bi-people-fill me-2"></i>Quản lý nhân viên</a>
        <a href="customers.php"><i class="bi bi-person-badge me-2"></i>Quản lý khách hàng</a>
        <hr>
        <form method="POST" action="../logout.php" class="text-center">
            <button type="submit" class="logout-btn">Đăng xuất</button>
        </form>
    </div>

    <div class="col-md-9 col-lg-10 content">
        <h2 class="mb-4"><i class="bi bi-ticket-perforated text-success"></i> Quản lý vé</h2>

        <?php if ($successMsg): ?>
            <div class="alert alert-success"><?= htmlspecialchars($successMsg) ?></div>
        <?php endif; ?>

        <!-- Form Thêm / Sửa vé -->
        <div class="card p-4 mb-4 shadow-sm">
            <form method="POST" action="../handle/handle_ticket.php">
                <input type="hidden" name="id" value="<?= $edit ? $ticket['id'] : '' ?>">
                <div class="row g-3">
                    <div class="col-md-2">
                        <input type="text" name="ma_ve" class="form-control" placeholder="Mã vé" value="<?= $edit ? htmlspecialchars($ticket['ma_ve']) : '' ?>" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="ma_kh" class="form-control" placeholder="Mã KH" value="<?= $edit ? htmlspecialchars($ticket['ma_kh']) : '' ?>" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="bien_so" class="form-control" placeholder="Biển số" value="<?= $edit ? htmlspecialchars($ticket['bien_so']) : '' ?>" required>
                    </div>
                    <div class="col-md-3">
                        <input type="datetime-local" name="ngay_gui" class="form-control" value="<?= $edit ? date('Y-m-d\TH:i', strtotime($ticket['ngay_gui'])) : '' ?>" required>
                    </div>
                    <div class="col-md-3">
                        <input type="datetime-local" name="ngay_nhan" class="form-control" value="<?= $edit && $ticket['ngay_nhan'] ? date('Y-m-d\TH:i', strtotime($ticket['ngay_nhan'])) : '' ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100"><?= $edit ? 'Cập nhật' : 'Thêm' ?></button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Bảng vé -->
        <table class="table table-bordered text-center align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mã vé</th>
                    <th>Mã KH</th>
                    <th>Biển số</th>
                    <th>Ngày gửi</th>
                    <th>Ngày nhận</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['ma_ve']) ?></td>
                        <td><?= htmlspecialchars($row['ma_kh']) ?></td>
                        <td><?= htmlspecialchars($row['bien_so']) ?></td>
                        <td><?= $row['ngay_gui'] ?></td>
                        <td><?= $row['ngay_nhan'] ?? '' ?></td>
                        <td>
                            <a href="tickets.php?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                            <a href="tickets.php?delete=<?= $row['id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa?')" class="btn btn-sm btn-danger">Xóa</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Chưa có vé nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>
</div>
</body>
</html>
<?php $conn->close(); ?>
