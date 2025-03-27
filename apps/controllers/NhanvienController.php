<?php
require_once './apps/configs/database.php';
require_once './apps/models/NhanVien.php';
require_once './apps/models/PhongBan.php';
session_start();
class NhanvienController
{
    private $nhanvien;
    private $phongban;
    public function __construct()
    {
        global $conn;
        $this->nhanvien = new NhanVien($conn);
        $this->phongban = new PhongBan($conn);
    }
    public function index()
    {
        $perPage = 5; // Số nhân viên mỗi trang
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($currentPage < 1) $currentPage = 1;

        $totalRecords = $this->nhanvien->countTotal(); // Đếm tổng số nhân viên
        $totalPages = ceil($totalRecords / $perPage);
        $offset = ($currentPage - 1) * $perPage;

        $nhanviens = $this->nhanvien->getAll($perPage, $offset);
        include 'apps/views/Nhanvien/index.php';
    }

    public function create()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                $this->nhanvien->create($_POST);
                header("Location: ../NhanVien");
                exit;
            } catch (Exception $e) {
                $error = $e->getMessage();
                $phongbans = $this->phongban->getAll();
                include 'apps/views/Nhanvien/create.php';
            }
        } else {
            $phongbans = $this->phongban->getAll();
            include 'apps/views/Nhanvien/create.php';
        }
    }

    public function detail($id)
    {
        $currentNhanvien = $this->nhanvien->getById($id);
        if (!$currentNhanvien) {
            $error = "Không tìm thấy sinh viên với mã $id.";
        }
        include 'apps/views/Nhanvien/detail.php';
    }

    public function delete($id)
    {
        $currentNhanvien = $this->nhanvien->getById($id);
        if (!$currentNhanvien) {
            header('Location: ../Nhanvien');
            exit();
        }

        $result = $this->nhanvien->delete($id);
        if ($result) {
            $_SESSION['success'] = "Xóa sản phẩm thành công";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi xóa sản phẩm";
        }

        header('Location: /QLNS/Nhanvien');
        exit();
    }

    public function edit($id)
    {
        $currentNhanvien = $this->nhanvien->getById($id);
        if (!$currentNhanvien) {
            header('Location: /QLNS/Nhanvien');
            exit();
        }

        $phongbans = $this->phongban->getAll();
        $page_title = "Chỉnh sửa nhân viên";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                $this->nhanvien->update($id, $_POST);
                header("Location: /QLNS/Nhanvien");
                exit();
            } catch (Exception $e) {
                $error = $e->getMessage();
                // Giữ lại $student và $majors để hiển thị lại form với dữ liệu cũ
            }
        }

        ob_start();
        require_once 'apps/views/Nhanvien/edit.php';
        $content = ob_get_clean();

        include 'apps/views/layout.php';
    }
}
