<?php
require_once './apps/models/User.php';
session_start();
class AuthController
{
    private $user;
    public function __construct()
    {
        global $conn;
        $this->user = new User($conn);
    }
    public function index()
    {
        include 'apps/views/Auth/index.php';
    }

    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            print_r($_POST);
            $Check = $this->user->login($_POST);
            if (is_null($Check)) {
                header("Location: /QLNS/Auth");
                exit;
            } else {
                header("Location: /QLNS/Nhanvien");
                exit;
            }
        }
    }

    public function Logout()
    {
        session_start();
        session_unset();  // Xóa tất cả biến session
        session_destroy(); // Hủy session hoàn toàn
        header("Location: /QLNS/Nhanvien");
        exit;
    }
}
