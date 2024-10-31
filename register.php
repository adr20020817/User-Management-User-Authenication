<?php
include 'outline.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Dark Mode Toggle Switch -->
    <div class="dark-mode-toggle">
        <label class="switch">
            <input type="checkbox" onclick="toggleDarkMode()">
            <span class="slider"></span>
        </label>
    </div>

    <!-- Registration Form -->
    <!-- Form submits to registerdata.php and validates password before submission -->
    <form action="registerdata.php" method="post" onsubmit="return validatePassword()">
        <!-- Logo Display -->
        <div class="logo">
            <img src="images.png" alt="Logo">
        </div>

        <!-- Personal Information Fields -->
        First name:<input type="text" 
                        name="fname" 
                        placeholder="Enter first name" 
                        required><br>
        Middle name:<input type="text" 
                        name="mname" 
                        placeholder="Enter middle name" 
                        required><br>
        Last name:<input type="text" 
                        name="lname" 
                        placeholder="Enter last name" 
                        required><br>
        Username:<input type="text" 
                        name="username" 
                        placeholder="Enter username" 
                        required><br>
        Date of birth:<input type="date" 
                        name="dob" 
                        required><br>

        <!-- Gender Selection -->
        Gender:<input type="radio" 
                        name="gender" 
                        value="male">Male
        <input type="radio" 
                        name="gender" 
                        value="female">Female<br>

        <!-- Contact Information -->
        Email:<input type="email" 
                        name="email" 
                        placeholder="Enter email" 
                        required><br>

        <!-- Password Field with Toggle Visibility -->
        <div class="password-container">
            Password:<input type="password" 
                        name="pswd" 
                        id="pswd" 
                        placeholder="Password (min 8 chars, upper, lower, number, symbol)" 
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}" 
                        required>
            <!-- Eye Icon for Password Visibility Toggle -->
            <svg xmlns="http://www.w3.org/2000/svg" 
                fill="none" 
                viewBox="0 0 24 24" 
                strokeWidth={1.5} 
                stroke="currentColor"   
                onclick="togglePasswordVisibility('pswd')">
                <path strokeLinecap="round" strokeLinejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                <path strokeLinecap="round" strokeLinejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            <br>
        </div>

        <!-- Password Confirmation Field with Toggle Visibility -->
        <div class="retypepassword-container">
            Retype password:<input type="password" 
                                name="retypepassword" 
                                id="retypepassword" 
                                placeholder="Retype password" 
                                required>
            <!-- Eye Icon for Password Visibility Toggle -->
            <svg xmlns="http://www.w3.org/2000/svg" 
                fill="none" 
                viewBox="0 0 24 24" 
                stroke-width="1.5" 
                stroke="currentColor" 
                onclick="togglePasswordVisibility('retypepassword')">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
        </div>
        <br>

        <!-- Submit Button -->
        <input type="submit" value="Register"><br>
        
        <!-- Login Link -->
        <a href="login.php">Already a user? Login here</a>
    </form>

    <script>
        /**
         * Toggles password visibility between text and password type
         * @param {string} inputId - The ID of the password input field
         */
        function togglePasswordVisibility(inputId) {
            var input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }

        /**
         * Validates password requirements and matching
         * @returns {boolean} Returns true if password is valid, false otherwise
         */
        function validatePassword() {
            var password = document.getElementById("pswd").value;
            var retypePassword = document.getElementById("retypepassword").value;
            
            // Check if passwords match
            if(password != retypePassword) {
                alert("Passwords do not match!");
                return false;
            }
            
            // Validate password complexity
            // Requires: 8+ chars, uppercase, lowercase, number, and special symbol
            var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/;
            if(!passwordRegex.test(password)) {
                alert("Password must contain at least 8 characters, including uppercase and lowercase letters, numbers and special symbols!");
                return false;
            }
            return true;
        }

        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            document.querySelector('form').classList.toggle('dark-mode');
        }
    </script>
</body>
</html>