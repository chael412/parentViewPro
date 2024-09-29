<?php
session_start();
require_once 'dbcon.php';

function login($email, $password)
{
    global $conn;

    // Check the `users` table
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        error_log("Error preparing statement for users table: " . $conn->error);
        return false;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Check plaintext password
        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
    }

    // Check `account_requests` table
    $sql = "SELECT * FROM account_requests WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        error_log("Error preparing statement for account_requests table: " . $conn->error);
        return false;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $account_request = $result->fetch_assoc();

        // Check plaintext password
        if ($password === $account_request['password']) {
            $_SESSION['user_id'] = $account_request['id'];
            $_SESSION['role'] = $account_request['role'];
            return true;
        } else {
            error_log("Password mismatch for account request.");
        }
    } else {
        error_log("No account request found with the provided email.");
    }

    return false;
}
