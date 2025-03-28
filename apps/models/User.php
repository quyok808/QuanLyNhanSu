<?php
require_once './apps/configs/database.php';

class User
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login($data)
    {
        try {
            // Kiểm tra dữ liệu đầu vào
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$data['username']]);
            $nhanvien = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($nhanvien && $data['password'] == $nhanvien['password']) {
                $_SESSION['role'] = $nhanvien['role'];
                return $nhanvien; // Trả về thông tin nhân viên nếu đăng nhập thành công
            }
            // Lưu mã sinh viên vào session
            return null;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
