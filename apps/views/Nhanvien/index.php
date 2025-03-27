<!-- student_list.php -->
<?php
$page_title = "Danh sách nhân viên";
ob_start();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Danh sách nhân viên</title>
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
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center mb-4">Danh sách nhân viên</h2>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
            <div class="text-end mb-3">
                <a href="./Nhanvien/create" class="btn btn-primary">Thêm nhân viên mới</a>
            </div>
        <?php endif; ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Mã NV</th>
                        <th>Tên Nhân Viên</th>
                        <th>Giới Tính</th>
                        <th>Nơi sinh</th>
                        <th>Tên phòng</th>
                        <th>Lương</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($nhanviens as $nhanvien): ?>
                        <tr>
                            <td><?php echo $nhanvien['Ma_NV']; ?></td>
                            <td><?php echo $nhanvien['Ten_NV']; ?></td>
                            <td>
                                <?php if ($nhanvien['Phai'] == "Nam"): ?>
                                    <img src="./public/images/nam.jpg" width="80" height="80" alt="Hình NV">
                                <?php else: ?>
                                    <img src="./public/images/nu.jpg" width="80" height="80" alt="Hình NV">
                                <?php endif; ?>
                            </td>
                            <td><?php echo $nhanvien['Noi_Sinh']; ?></td>
                            <td><?php echo $nhanvien['Ten_Phong']; ?></td>
                            <td><?php echo $nhanvien['Luong']; ?></td>
                            <td>
                                <a href="./Nhanvien/detail/<?php echo $nhanvien['Ma_NV']; ?>" class="btn btn-info btn-sm">Chi tiết</a>
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                                    <a href="./Nhanvien/edit/<?php echo $nhanvien['Ma_NV']; ?>" class="btn btn-success btn-sm">Sửa</a>
                                    <a href="./Nhanvien/delete/<?php echo $nhanvien['Ma_NV']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xoá nhân viên này?');">Xoá</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-4">
                <nav>
                    <ul class="pagination">
                        <?php if ($currentPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>">Trước</a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($currentPage < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>">Sau</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
$content = ob_get_clean();
include './apps/views/Layout.php';
?>