<?php
require_once './apps/configs/database.php';

class NhanVien
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll($limit, $offset)
    {
        $stmt = $this->conn->prepare("SELECT nv.*, pb.Ten_Phong FROM nhanvien nv JOIN phongban pb ON pb.Ma_Phong = nv.Ma_Phong LIMIT $limit OFFSET $offset");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countTotal()
    {
        $sql = "SELECT COUNT(*) as total FROM nhanvien";
        $result = $this->conn->query($sql);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function create($data)
    {
        try {
            // Validation dữ liệu
            if (empty($data['hoTen'])) {
                throw new Exception("Họ tên không được để trống.");
            }
            if (empty($data['gioiTinh']) || !in_array($data['gioiTinh'], ['Nam', 'Nữ'])) {
                throw new Exception("Giới tính không hợp lệ.");
            }
            if (empty($data['noiSinh'])) {
                throw new Exception("Nơi sinh không được để trống.");
            }
            if (empty($data['maPhong'])) {
                throw new Exception("Phòng ban không được để trống.");
            }
            if (empty($data['luong'])) {
                throw new Exception(" Lương không được để trống.");
            }

            $maPB = 'NV0' . random_int(10, 99);

            // Kiểm tra trùng MaSV
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM nhanvien WHERE Ma_NV = ?");
            $stmt->execute([$maPB]);
            if ($stmt->fetchColumn() > 0) {
                throw new Exception("Mã nhân viên đã tồn tại.");
            }

            // Thêm vào database
            $stmt = $this->conn->prepare("INSERT INTO nhanvien (Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong) VALUES (?, ?, ?, ?, ?, ?)");
            $success = $stmt->execute([
                $maPB,
                $data['hoTen'],
                $data['gioiTinh'],
                $data['noiSinh'],
                $data['maPhong'],
                $data['luong']
            ]);

            if (!$success) {
                throw new Exception("Không thể thêm nhân viên vào cơ sở dữ liệu.");
            }

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT nv.*, pb.Ten_Phong FROM nhanvien nv JOIN phongban pb ON nv.Ma_Phong = pb.Ma_Phong WHERE nv.Ma_NV = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        try {
            // Kiểm tra ID có hợp lệ không
            if (empty($id)) {
                throw new Exception("ID không được rỗng.");
            }

            // Chuẩn bị truy vấn SQL
            $stmt = $this->conn->prepare("DELETE FROM nhanvien WHERE Ma_NV = :MaNV");

            // Bind giá trị vào tham số
            $stmt->bindParam(':MaNV', $id, PDO::PARAM_STR);

            // Thực thi truy vấn
            if ($stmt->execute()) {
                return true;
            }

            return false;
        } catch (PDOException $e) {
            die("Lỗi SQL: " . $e->getMessage());
        } catch (Exception $e) {
            die("Lỗi: " . $e->getMessage());
        }
    }

    public function update($id, $data)
    {
        try {
            // Validation dữ liệu
            if (empty($data['hoTen'])) {
                throw new Exception("Họ tên không được để trống.");
            }
            if (empty($data['gioiTinh']) || !in_array($data['gioiTinh'], ['Nam', 'Nữ'])) {
                throw new Exception("Giới tính không hợp lệ.");
            }
            if (empty($data['noiSinh'])) {
                throw new Exception("Nơi sinh không được để trống.");
            }
            if (empty($data['maPhong'])) {
                throw new Exception("Phòng ban không được để trống.");
            }
            if (empty($data['luong'])) {
                throw new Exception(" Lương không được để trống.");
            }

            // Cập nhật database
            $stmt = $this->conn->prepare("UPDATE nhanvien SET Ten_NV = ?, Phai = ?, Noi_Sinh = ?, Ma_Phong = ?, Luong = ? WHERE Ma_NV = ?");
            $success = $stmt->execute([

                $data['hoTen'],
                $data['gioiTinh'],
                $data['noiSinh'],
                $data['maPhong'],
                $data['luong'],
                $id,
            ]);

            if (!$success) {
                throw new Exception("Không thể cập nhật thông tin sinh viên.");
            }
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
