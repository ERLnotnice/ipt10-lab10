<?php

namespace App\Controllers;

use App\Models\User; // Make sure to include your User model
use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $template = 'home';
        $data = [
            'student' => 'DON HENESSY S. DAVID',
            'title' => 'IPT10 Laboratory Activity #9',
            'college' => 'College of Computer Studies',
            'university' => 'Angeles University Foundation',
            'location' => 'Angeles City, Pampanga, Philippines'
        ];
        $output = $this->render($template, $data);
        return $output;
    }

    public function welcome()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
            header("Location: /login-form");
            exit;
        }

        $user = new User();
        $users = $user->getAllUsers(); 

        $username = $_SESSION['username'];

        $template = 'welcome';
        $data = [
            'title' => 'Welcome',
            'message' => "Welcome to IPT10, $username!",
            'data' => $users
        ];
        
        $output = $this->render($template, $data);
        return $output;
    }
}
