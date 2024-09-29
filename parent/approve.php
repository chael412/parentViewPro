<?php
require_once '../config/dbcon.php';
require '../config/PHPMailer/src/PHPMailer.php';
require '../config/PHPMailer/src/SMTP.php';
require '../config/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$request_id = $_GET['id'];

// Prepare and execute the query to fetch user and child details from account_requests
$sql = "SELECT email, firstname, lastname, middlename, child_id FROM account_requests WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $request_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    $email = $row['email'];
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $middlename = $row['middlename'];
    $child_id = $row['child_id'];  // Retrieve child_id from account request

    // Generate a temporary password
    $password = substr(md5(uniqid(rand(), true)), 0, 8);

    // Update account_requests status
    $sql_update = "UPDATE account_requests SET status = 'Approved', password = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("si", $password, $request_id);

    if ($stmt_update->execute()) {
        // Insert into users table
        $sql_user = "INSERT INTO users (first_name, last_name, middle_name, email, role, password)
                    VALUES (?, ?, ?, ?, 'parent', ?)";
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->bind_param("sssss", $firstname, $lastname, $middlename, $email, $password);

        if ($stmt_user->execute()) {
            // Get the parent_id from the newly created user
            $parent_id = $stmt_user->insert_id;

            // Update the students table to set the parent_id for the approved child
            $sql_update_student = "UPDATE students SET parent_id = ? WHERE id = ?";
            $stmt_student = $conn->prepare($sql_update_student);
            $stmt_student->bind_param("ii", $parent_id, $child_id);

            if ($stmt_student->execute()) {
                // Send the approval email
                $mail = new PHPMailer(true);
                try {
                    // SMTP configuration
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'perezmarkangelo50@gmail.com';  // Your Gmail address
                    $mail->Password = 'tmwy wdvl csjd xlyw';  // Your App Password
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    // Set email format and recipient
                    $mail->setFrom('perezmarkangelo50@gmail.com', 'ParentViewPro');
                    $mail->addAddress($email);

                    // Compose email
                    $mail->isHTML(true);
                    $mail->Subject = "Account Request Approved";
                    $mail->Body = "Your account request has been approved. Your login credentials are:<br>Email: $email<br>Password: $password";

                    // Send the email
                    $mail->send();
                    echo "<script>
                        alert('Request Approved, the email has been sent'); 
                        window.location.href='admins.php';
                    </script>";

                } catch (Exception $e) {
                    echo "Error sending email: {$mail->ErrorInfo}";
                }
            } else {
                echo "Error updating parent_id in students table: " . $conn->error;
            }
        } else {
            echo "Error inserting into users table: " . $conn->error;
        }
    } else {
        echo "Error updating account request: " . $conn->error;
    }
} else {
    echo "Request not found.";
}

$conn->close();
