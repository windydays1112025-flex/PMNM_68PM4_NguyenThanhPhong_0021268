<?php
   require_once '../app/core/App.php';
   $middleware = new middleware();
   $middleware->checklogin();
   $app = new App();
?>