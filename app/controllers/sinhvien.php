<?php
class sinhvien{
    public function index(){
        //trả về view
        require_once '../app/views/sinhvien/index.php';
    }
    public function create(){
        //trả về view
        require_once '../app/views/sinhvien/create.php';
    }
}