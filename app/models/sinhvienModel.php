<?php
require_once '../app/Core/DB.php';

class sinhvienModel {
    private $conn;

    public function __construct() {
        $this->conn = (new connectDB())->connect();
    }

    public function countSinhVien() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM sinhvien");
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function paging($limit = 6, $offset = 0) {
        $sql = "SELECT sv.*, l.tenlop 
                FROM sinhvien sv
                LEFT JOIN lop l ON sv.malop = l.malop
                LIMIT :limit OFFSET :offset";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            $totalRecords = $this->countSinhVien(); 
            $totalPages   = $totalRecords > 0 ? ceil($totalRecords / $limit) : 1;

            return [$stmt->fetchAll(PDO::FETCH_ASSOC), $totalPages];
        } catch (PDOException $e) {
            error_log("paging(): " . $e->getMessage());
            return [[], 1];
        }
    }

    public function addSinhVien($hoten, $mssv, $gioitinh, $malop = null) {
        $sql = "INSERT INTO sinhvien (hoten, mssv, gioitinh, malop) 
                VALUES (:hoten, :mssv, :gioitinh, :malop)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':hoten',    $hoten);
            $stmt->bindValue(':mssv',     $mssv);
            $stmt->bindValue(':gioitinh', $gioitinh);
            $stmt->bindValue(':malop',    $malop);  
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("addSinhVien(): " . $e->getMessage());
            return false;
        }
    }

    public function getSinhVienById($id) {
        $sql = "SELECT sv.*, l.tenlop 
                FROM sinhvien sv
                LEFT JOIN lop l ON sv.malop = l.malop
                WHERE sv.id = :id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("getSinhVienById(): " . $e->getMessage());
            return null;
        }
    }

    public function updateSinhVien($id, $hoten, $mssv, $gioitinh, $malop = null) {
        $sql = "UPDATE sinhvien 
                SET hoten=:hoten, mssv=:mssv, gioitinh=:gioitinh, malop=:malop 
                WHERE id=:id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id',       $id,       PDO::PARAM_INT);
            $stmt->bindValue(':hoten',    $hoten);
            $stmt->bindValue(':mssv',     $mssv);
            $stmt->bindValue(':gioitinh', $gioitinh);
            $stmt->bindValue(':malop',    $malop);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("updateSinhVien(): " . $e->getMessage());
            return false;
        }
    }

    public function deleteSinhVien($id) {
        $sql = "DELETE FROM sinhvien WHERE id = :id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("deleteSinhVien(): " . $e->getMessage());
            return false;
        }
    }

    public function search($keyword = '', $malop = '', $sortBy = 'hoten', $sortOrder = 'ASC', $limit = 6, $offset = 0) {
        // $allowSort  = ['hoten', 'mssv', 'malop'];
        // $allowOrder = ['ASC', 'DESC'];
        // $sortBy    = in_array($sortBy, $allowSort)   ? $sortBy    : 'hoten';
        // $sortOrder = in_array($sortOrder, $allowOrder) ? $sortOrder : 'ASC';
        if ($sortBy === 'mssv_asc') {
            $sortBy    = 'CAST(sv.mssv AS UNSIGNED)';
            $sortOrder = 'ASC';
        } elseif ($sortBy === 'mssv_desc') {
            $sortBy    = 'CAST(sv.mssv AS UNSIGNED)';
            $sortOrder = 'DESC';
        } else {
            $allowSort  = ['hoten', 'mssv', 'malop'];
            $allowOrder = ['ASC', 'DESC'];
            $sortBy    = in_array($sortBy, $allowSort)    ? "sv.$sortBy" : 'sv.hoten';
            $sortOrder = in_array($sortOrder, $allowOrder) ? $sortOrder  : 'ASC';
        }

        $sql = "SELECT sv.*, l.tenlop 
                FROM sinhvien sv
                LEFT JOIN lop l ON sv.malop = l.malop
                WHERE (:keyword = '' OR sv.hoten LIKE :keyword)
                AND (:malop   = '' OR sv.malop  = :malop)
                ORDER BY $sortBy $sortOrder
                LIMIT :limit OFFSET :offset";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':keyword', $keyword ? "%$keyword%" : '', PDO::PARAM_STR);
            $stmt->bindValue(':malop',   $malop,                      PDO::PARAM_STR);
            $stmt->bindValue(':limit',   $limit,                      PDO::PARAM_INT);
            $stmt->bindValue(':offset',  $offset,                     PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("search(): " . $e->getMessage());
            return [];
        }
    }

    public function countSearch($keyword = '', $malop = '') {
        $sql = "SELECT COUNT(*) FROM sinhvien sv
                WHERE (:keyword = '' OR sv.hoten LIKE :keyword)
                AND (:malop   = '' OR sv.malop  = :malop)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':keyword', $keyword ? "%$keyword%" : '', PDO::PARAM_STR);
            $stmt->bindValue(':malop',   $malop,                      PDO::PARAM_STR);
            $stmt->execute();
            return (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("countSearch(): " . $e->getMessage());
            return 0;
        }
    }

    public function getAllLop() {
        $stmt = $this->conn->prepare("SELECT malop, tenlop FROM lop ORDER BY malop");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}