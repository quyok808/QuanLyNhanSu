<!-- student_list.php -->
<?php
$page_title = "Thêm mới nhân viên";
ob_start();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Danh sách sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 30px;
        }

        .table img {
            border-radius: 8px;
            object-fit: cover;
        }

        .table-hover tbody tr:hover {
            background-color: #e9ecef;
        }

        .preview-img {
            max-width: 100px;
            margin-top: 10px;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <a onclick="history.back()" class="btn btn-back">⬅ Quay lại danh sách</a>
    <div class="card p-4 shadow-sm">

        <h4 class="text-center">Thêm Nhân Viên</h4>
        <form method="post">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"> <?php echo $error; ?> </div>
            <?php endif; ?>
            <div class="mb-3">
                <label class="form-label">Họ Tên</label>
                <input type="text" name="hoTen" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Giới Tính</label>
                <select name="gioiTinh" class="form-select">
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nơi sinh</label>
                <input type="text" name="noiSinh" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phòng Ban</label>
                <select name="maPhong" class="form-select">
                    <?php foreach ($phongbans as $phongban): ?>
                        <option value="<?php echo $phongban['Ma_Phong']; ?>"><?php echo $phongban['Ten_Phong']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Lương</label>
                <input type="text" name="luong" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Thêm</button>

        </form>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
$content = ob_get_clean();
include './apps/views/Layout.php';
?>