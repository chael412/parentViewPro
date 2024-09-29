<?php
require_once 'config/dbcon.php';
require_once 'config/auth.php';

if ($_POST['btn_login']) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (login($email, $password, false)) {
        // Assuming the login function stores the role in the session
        session_start();
        $role = $_SESSION['role'] ?? null; // Retrieve the role from the session

        if ($role === 'admin') {
            header('Location: admin/index.php');
        } elseif ($role === 'teacher') {
            header('Location: teacher/index.php');
        } elseif ($role === 'parent') {
            header('Location: parent/index.php');
        }
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}