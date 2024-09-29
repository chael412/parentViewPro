<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

require_once '../config/dbcon.php';
require_once '../config/PHPMailer/src/PHPMailer.php';
require_once '../config/PHPMailer/src/SMTP.php';
require_once '../config/PHPMailer/src/Exception.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $middle_name = $_POST['middle_name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $plainTextPassword = generateRandomPassword();
    $password = $plainTextPassword;

    $sql = "INSERT INTO users (first_name, last_name, middle_name, email, password, role) 
            VALUES ('$first_name', '$last_name', '$middle_name', '$email', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        sendAccountCredentials($first_name, $last_name, $email, $plainTextPassword);
        echo "<script>
            alert('User created successfully');
            window.location.href = 'index.php';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function generateRandomPassword($length = 8)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $password;
}

function sendAccountCredentials($first_name, $last_name, $email, $password)
{
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'perezmarkangelo50@gmail.com';
    $mail->Password = 'tmwy wdvl csjd xlyw';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('perezmarkangelo50@gmail.com', 'ParentViewPro');
    $mail->addAddress($email, $first_name . ' ' . $last_name);
    $mail->Subject = 'Your account credentials';
    $mail->Body = "Dear $first_name $last_name,\n\nYour account has been created. Here are your login credentials:\n\nEmail: $email\nPassword: $password\n\nPlease change your password after logging in.";

    if (!$mail->send()) {
        echo 'Email sending failed: ' . $mail->ErrorInfo;
    }
}
?>