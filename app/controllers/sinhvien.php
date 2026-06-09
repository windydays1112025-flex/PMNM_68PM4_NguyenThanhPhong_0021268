<?php
require_once '../app/core/Controller.php';
class sinhvien extends Controller{
    public function index($limit = 5, $offset = 0){
        $sinhvienModel = $this->model('sinhvienModel');
        
        // Gọi hàm paging từ Model thay vì getAllSinhVien
        $data = $sinhvienModel->paging($limit, $offset);
        
        // Trích xuất dữ liệu từ mảng trả về của Model
        $sinhviens = $data['sinhviens'];
        $totalPage = $data['totalPage'];
        
        // Truyền $sinhviens, $totalPage và cả $pageSize (chính là $limit) sang View
        $this->view('layout/masterlayout', [
            'viewname' => 'sinhvien/index', 
            'sinhviens' => $sinhviens, 
            'totalPage' => $totalPage,
            'pageSize' => $limit,
            'title' => "Danh sách sinh viên"
        ]);
    }
    public function create(){
        require_once '../app/views/sinhvien/create.php';
    }
    public function store(){
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST'){
            $hoten = $_POST['hoten'] ?? '';
            $gioitinh = $_POST['gioitinh'] ?? '';
            $mssv = $_POST['mssv'] ?? '';
            $sinhvienModel = $this->model('sinhvienModel');
            $result = $sinhvienModel->create($hoten, $gioitinh, $mssv);
        if($result){
            echo "Thêm mới sinh viên thành công";
        }
        else{
            echo "Thêm mới sinh viên thất bại";
        }
    }
}
}