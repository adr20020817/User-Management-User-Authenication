<?php
session_start();

// Redirect if no reset code in session
if (!isset($_SESSION['reset_code']) || !isset($_SESSION['reset_email'])) {
    header("Location: forgot-password.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code</title>
    <style>
        .error {
            color: red;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #D4B8FF;
            margin: 0;
            padding: 0;
        }
        input[type= "text"] {
            width: 300px;
            padding: 10px;
            margin: 5px auto;
            border: 1px solid #ccc;
            border-radius: 3px;
            display: block;
        }
        button[type= "submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            display: block;
            margin: 5px auto;
            float: right;
        }
        button[type= "submit"]:hover {
            background-color: #0056b3;
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
    <form method="POST" action="forgot-password.php">
        <h2>Verify Code</h2>
        <?php if(isset($error)) { echo "<div class='error'>".$error."</div>"; } ?>
        <p>We sent a verification code to <?php echo htmlspecialchars($_SESSION['reset_email']); ?></p>
        
        <input type="text" 
               name="code" 
               placeholder="Enter verification code" 
               required 
               pattern="[0-9]{6}" 
               title="Please enter the 6-digit code">
        
        <button type="submit" name="verify_code">Verify Code</button>
    </form>
</body>
</html> 