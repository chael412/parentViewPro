<?php
require_once '../config/dbcon.php';
require '../config/PHPMailer/src/PHPMailer.php';
require '../config/PHPMailer/src/SMTP.php';
require '../config/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$request_id = $_GET['id'];

$sql = "SELECT email FROM account_requests WHERE id = $request_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$email = $row['email'];

if ($email) {
    $sql = "UPDATE account_requests SET status = 'Rejected' WHERE id = $request_id";

    if ($conn->query($sql) === TRUE) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'perezmarkangelo50@gmail.com';
            $mail->Password = 'tmwy wdvl csjd xlyw';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('perezmarkangelo50@gmail.com', 'ParentViewPro');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Account Request Rejected";
            $mail->Body = "We regret to inform you that your account request has been rejected.";

            $mail->send();
            echo "<script>
                    alert('Request rejected, the email has been send');
                    window.location.href = 'admins.php'; 
                </script>";
        } catch (Exception $e) {
            echo "Error sending email: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Request not found.";
}

$conn->close();
