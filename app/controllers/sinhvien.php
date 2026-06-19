<?php
require_once '../app/Core/Controller.php';

class sinhvien extends Controller {

    private $limit = 6; 

    public function index() {
        $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $keyword     = trim($_GET['keyword']   ?? '');
        $malop       = trim($_GET['malop']     ?? '');
        $sortBy      = $_GET['sortBy']         ?? 'hoten';
        $sortOrder   = $_GET['sortOrder']      ?? 'ASC';
        $offset      = ($currentPage - 1) * $this->limit;

        $sinhvienModel = $this->model('sinhvienModel');

        $sinhviens    = $sinhvienModel->search($keyword, $malop, $sortBy, $sortOrder, $this->limit, $offset);
        $totalRecords = $sinhvienModel->countSearch($keyword, $malop);
        $totalPages   = $totalRecords > 0 ? ceil($totalRecords / $this->limit) : 1;
        $danhSachLop  = $sinhvienModel->getAllLop();

        if ($currentPage > $totalPages) {
            header('Location: /sinhvien/index?page=' . $totalPages . '&keyword=' . urlencode($keyword) . '&malop=' . urlencode($malop));
            exit();
        }

        $this->view('layout/masterlayout', [
            'title'       => 'Danh sách sinh viên',
            'sinhviens'   => $sinhviens,
            'currentPage' => $currentPage,
            'totalPages'  => $totalPages,
            'offset'      => $offset,
            'keyword'     => $keyword,
            'malop'       => $malop,
            'sortBy'      => $sortBy,
            'sortOrder'   => $sortOrder,
            'danhSachLop' => $danhSachLop,
            'viewname'    => 'sinhvien/index',
        ]);
    }

    public function create() {
        $page = $_GET['page'] ?? 1;
        $this->view('sinhvien/create', ['page' => $page]);
    }

    public function store() {
        if (isset($_POST['hoten'], $_POST['mssv'], $_POST['gioitinh'])) {
            $hoten    = trim($_POST['hoten']);
            $mssv     = trim($_POST['mssv']);
            $gioitinh = $_POST['gioitinh'];

            $sinhvienModel = $this->model('sinhvienModel');
            $result = $sinhvienModel->addSinhVien($hoten, $mssv, $gioitinh);

            if ($result) {
                $total    = $sinhvienModel->countSinhVien();
                $lastPage = ceil($total / $this->limit);
                header('Location: /sinhvien/index?page=' . $lastPage);
                exit();
            } else {
                echo "Lỗi khi thêm sinh viên.";
            }
        }
    }

    public function edit($id) {
        $page          = $_GET['page'] ?? 1;
        $sinhvienModel = $this->model('sinhvienModel');
        $sinhvien      = $sinhvienModel->getSinhVienById($id);

        $this->view('sinhvien/edit', [
            'sinhvien' => $sinhvien,
            'page'     => $page, 
        ]);
    }

    public function delete($id) {
        $page          = $_GET['page'] ?? 1;
        $sinhvienModel = $this->model('sinhvienModel');
        $result        = $sinhvienModel->deleteSinhVien($id);

        if ($result) {
            $total      = $sinhvienModel->countSinhVien();
            $totalPages = ceil($total / $this->limit) ?: 1;
            $page       = min($page, $totalPages);

            header('Location: /sinhvien/index?page=' . $page);
            exit();
        } else {
            echo "Lỗi khi xóa sinh viên.";
        }
    }

    public function update() {
        if (isset($_POST['id'], $_POST['hoten'], $_POST['mssv'], $_POST['gioitinh'])) {
            $id       = (int)$_POST['id'];
            $hoten    = trim($_POST['hoten']);
            $mssv     = trim($_POST['mssv']);
            $gioitinh = $_POST['gioitinh'];
            $page     = $_POST['page'] ?? 1;

            $sinhvienModel = $this->model('sinhvienModel');
            $result        = $sinhvienModel->updateSinhVien($id, $hoten, $mssv, $gioitinh);

            if ($result) {
                header('Location: /sinhvien/index?page=' . $page);
                exit();
            } else {
                echo "Lỗi khi cập nhật sinh viên.";
            }
        }
    }
}