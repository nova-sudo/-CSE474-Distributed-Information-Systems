<?php
require_once '../middleware/AuthMiddleware.php';

class DashboardController {
    public function index() {
        AuthMiddleware::check();
        require '../views/dashboard.php';
    }
}