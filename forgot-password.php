<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database configuration
$host = "localhost";  // Your database host
$username = "root";   // Your database username 
$password = "";       // Your database password
$dbname = "superuser"; // Your database name

// Create database connection
$con = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$error = ''; // Initialize error variable

if(isset($_POST['submit'])) {
    // Sanitize the email input to prevent SQL injection
    // mysqli_real_escape_string escapes special characters in the string
    $email = mysqli_real_escape_string($con, $_POST['email']);
    
    // Check if email exists
    $query = "SELECT * FROM personal WHERE email = '$email'";
    $result = mysqli_query($con, $query);
    
    if(mysqli_num_rows($result) > 0) {
        // Add debugging output
        echo "Email found in database<br>";
        
        // Generate confirmation code
        $confirmation_code = rand(100000, 999999);
        
        // Store code in session
        $_SESSION['reset_code'] = $confirmation_code;
        $_SESSION['reset_email'] = $email;
        
        // Email configuration
        $to = $email;
        $subject = "Password Reset Confirmation Code";
        $message = "Your confirmation code is: " . $confirmation_code;
        $headers = "From: email";
        // Send email
        
        
        
        require 'vendor/autoload.php';
        $mail = new PHPMailer(true);

        try {
            // Add debugging output
            echo "Attempting to send email...<br>";
            
            $mail->SMTPDebug = 2; // Enable verbose debug output
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Gmail SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'youremail@server.com'; // Your Gmail email
            $mail->Password = 'your-mail-password';      // Your Gmail password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('adrianjustine73@gmail.com', 'Adrian Justine');
            $mail->addAddress($email);
            $mail->Subject = $subject;
            $mail->Body = $message;

            if($mail->send()) {
                $_SESSION['email_sent'] = true;
                header("Location: verify-code.php");
                exit();
            }
        } catch (Exception $e) {
            $error = "Failed to send confirmation code. Error: " . $mail->ErrorInfo;
        }
    } else {
        $error = "Email address not found.";
    }
}

// Verify code and create new password
if(isset($_POST['verify_code'])) {
    $entered_code = $_POST['code'];
    if($entered_code == $_SESSION['reset_code']) {
        header("Location: new-password.php");
        exit();
    } else {
        $error = "Invalid confirmation code.";
    }
}

// Handle new password creation
if(isset($_POST['create_password'])) {
    $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);
    
    if($new_password === $confirm_password) {
        // Hash the password consistently using PASSWORD_DEFAULT
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        $email = $_SESSION['reset_email'];
        // Update query using prepared statement
        $update_query = "UPDATE personal SET pswd = ? WHERE email = ?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $email);
        
        if(mysqli_stmt_execute($stmt)) {
            // Password updated successfully
            session_destroy();
            header("Location: login.php?password_updated=true");
            exit();
        } else {
            $error = "Failed to update password.";
        }
    } else {
        $error = "Passwords do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .error {
            color: red;
        }
      body {
            font-family: Arial, sans-serif;
            background-color: #D4B8FF;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
      }
      input[type= "email"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        button[type= "submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            float: right;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
            float: left;
        }
        .back-link:hover {
            text-decoration: underline;
            color: #007bff;
        }
        form {
            background-color: #fff;
            padding: 80px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<form method="POST" action="">
    <h2>Forgot Password</h2>
    <?php if(isset($error)) { echo "<div class='error'>".$error."</div>"; } ?>
    <input type="email" name="email" placeholder="Enter your email" required>
    <button type="submit" name="submit">Send Code</button>
    <a href="login.php" class="back-link">Back to Login</a>
</form>
</body>
</html>

