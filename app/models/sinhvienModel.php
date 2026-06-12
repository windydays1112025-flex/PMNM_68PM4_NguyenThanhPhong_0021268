<?php
require_once 'app/core/DB.php';
class sinhvienModel{
    private $conn;
    public function __construct()
    {
        $this->conn = ConnectDB::Connect();
    }
    public function getAllSinhVien(){
        $query = "SELECT * FROM tbl_sinhviens";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function create($hoten, $gioitinh, $mssv){
        $query = "INSERT INTO tbl_sinhviens(hoten, gioitinh, mssv) VALUES(".$hoten.",".$gioitinh.",".$mssv.")";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':hoten',$hoten);
        $stmt->bindParam(':gioitinh',$gioitinh);
        $stmt->bindParam(':mssv',$mssv);
        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    public function paging($limit = 5, $offset = 0, $search =""){
        $query = "SELECT * FROM tbl_sinhviens LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $result= $stmt->fetchAll(PDO::FETCH_ASSOC);

        //tính tổng số bản ghi để tính tổng số trang
        $selectAllQuery = $this->conn->query("SELECT COUNT(*) FROM tbl_sinhviens");
        $totalRecord = $selectAllQuery->fetchColumn();
        $totalPage = ceil($totalRecord/$limit);
        return ["sinhviens"=>$result, "totalPage"=>$totalPage];
    }

    public function delete($id){
    $query = "DELETE FROM tbl_sinhviens WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    return $stmt->execute(); 
    }
    
    public function getSinhvienById($id){
        $query = "SELECT * FROM tbl_sinhviens WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function update($id, $hoten, $gioitinh, $mssv){
        $query = "UPDATE tbl_sinhviens SET hoten = :hoten, gioitinh = :gioitinh, mssv = :mssv WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':hoten', $hoten);
        $stmt->bindParam(':gioitinh', $gioitinh);
        $stmt->bindParam(':mssv', $mssv);
        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }
}