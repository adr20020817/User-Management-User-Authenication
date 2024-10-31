<?php
// Start PHP session to access session variables
session_start();

// Security Check: Prevent direct access to this page
// If user hasn't gone through the forgot password process (no reset code or email in session)
// Redirect them back to the beginning of the process
if(!isset($_SESSION['reset_code']) || !isset($_SESSION['reset_email'])) {
    header("Location: forgot-password.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #fff;
            padding: 80px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- 
        Form submits to forgot-password.php where the password update logic exists
        Method: POST for secure data transmission
    -->
    <form method="POST" action="forgot-password.php">
        <h2>Create New Password</h2>
        
        <!-- Display error messages if any -->
        <?php if(isset($error)) { echo "<div class='error'>".$error."</div>"; } ?>
        
        <div>
            <!-- 
                New Password Input
                - required: field cannot be empty
                - minlength="8": password must be at least 8 characters
                - type="password": masks the input
            -->
            <input type="password" 
                   name="new_password" 
                   placeholder="Enter new password" 
                   required 
                   minlength="8">
        </div>
        
        <div>
            <!-- 
                Confirm Password Input
                - Must match the new password input
                - Same validation as above
            -->
            <input type="password" 
                   name="confirm_password" 
                   placeholder="Confirm new password" 
                   required 
                   minlength="8">
        </div>
        
        <!-- 
            Submit button
            - name="create_password": identifies this action in forgot-password.php
        -->
        <button type="submit" name="create_password">Reset Password</button>
    </form>
</body>
</html> 