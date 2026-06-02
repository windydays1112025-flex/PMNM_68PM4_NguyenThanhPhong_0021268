<?php
class home{
    public function index(){
        echo "Đây là trang chủ";
        require_once '../app/views/layout/masterlayout.php';
    }
    public function about(){
        echo "Đây là trang giới thiệu";
    }
    public function login(){
        require_once '../app/views/home/login.php';
    }
}