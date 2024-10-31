<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
    <style>
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
        .logo {
            margin-bottom: 20px;
            text-align: center;
        }
        .logo img {
            max-width: 200px;
            height: auto;
        }
        input[type= "text"], input[type= "password"]{
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            float: right;
        }
        input[type="submit"]:hover {    
            background-color: #0056b3;
        }
        form {
            background-color: #fff;
            padding: 100px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
    </style>
</head>
<!-- Renders a login form with fields for username and password, and links for forgot password, registration, and logout.
    The form submits to the login-new.php file, which handles the login logic.-->
<body>
    <form action="login.php" method="post">
        <div class="logo">
            <img src="images.png" alt="Logo">
        </div>
        <input type="text" name="username" placeholder="Enter username" required><br>
        <input type="password" name="pswd" placeholder="Enter password" required><br>
        <input type="submit" value="Login"><br><br>
        <center>
        <a href="forgot-password.php">Forgot password?</a>
        <br>
        <a href="register.php">Not a user? Register here</a>
        </center>
        
    </form>
</body>

<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$dbname = "superuser";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['username']) && isset($_POST['pswd'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $pswd = mysqli_real_escape_string($conn, $_POST['pswd']);
    
    $query = "SELECT * FROM personal WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if($user = mysqli_fetch_assoc($result)) {
        // Verify the password using password_verify
        if(password_verify($pswd, $user['pswd'])) {
            // Password is correct
            $_SESSION['user_id'] = $user['id'];
            header("Location: outline.php");
            exit();
        } else {
            $error = "Invalid email or password";
        }
    } else {
        $error = "Invalid email or password";
    }
}

mysqli_close($conn);

?>

</html>