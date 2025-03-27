<h2 class="text-center mb-4">Chỉnh sửa sinh viên</h2>
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label class="form-label">Mã NV</label>
        <input type="text" class="form-control" value="<?php echo $currentNhanvien['Ma_NV']; ?>" disabled>
    </div>
    <div class="mb-3">
        <label class="form-label">Họ Tên</label>
        <input type="text" name="hoTen" class="form-control" value="<?php echo $currentNhanvien['Ten_NV']; ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Giới Tính</label>
        <select name="gioiTinh" class="form-select" required>
            <option value="Nam" <?php echo $currentNhanvien['Phai'] === 'Nam' ? 'selected' : ''; ?>>Nam</option>
            <option value="Nữ" <?php echo $studecurrentNhanviennt['Phai'] === 'Nữ' ? 'selected' : ''; ?>>Nữ</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Nơi Sinh</label>
        <input type="text" name="noiSinh" class="form-control" value="<?php echo $currentNhanvien['Phai']; ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Phòng ban</label>
        <select name="maPhong" class="form-select" required>
            <?php foreach ($phongbans as $phongban): ?>
                <option value="<?php echo $phongban['Ma_Phong']; ?>" <?php echo $currentNhanvien['Ma_Phong'] === $phongban['Ma_Phong'] ? 'selected' : ''; ?>>
                    <?php echo $phongban['Ten_Phong']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Lương</label>
        <input type="number" name="luong" class="form-control" value="<?php echo $currentNhanvien['Luong']; ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật</button>
    <a href="/QLNS/Nhanvien" class="btn btn-secondary">Hủy</a>
</form>