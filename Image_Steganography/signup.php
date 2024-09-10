<?php
session_start();

include("db.php");

// Ensure the connection is established
if ($con === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Retrieve and sanitize user inputs
    $firstname = htmlspecialchars(trim($_POST['fname']));
    $lastname  = htmlspecialchars(trim($_POST['lname']));
    $gender = htmlspecialchars(trim($_POST['gender']));
    $num = htmlspecialchars(trim($_POST['number']));
    $address = htmlspecialchars(trim($_POST['add']));
    $gmail = htmlspecialchars(trim($_POST['mail']));
    $password = $_POST['pass']; // Password will be hashed later, no need to sanitize here

    // Validate inputs
    if (!empty($gmail) && !empty($password) && filter_var($gmail, FILTER_VALIDATE_EMAIL)) {
        // Hash the password securely
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Use prepared statements to prevent SQL injection
        $stmt = $con->prepare("INSERT INTO form (fname, lname, gender, cnum, address, email, pass) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $firstname, $lastname, $gender, $num, $address, $gmail, $hashed_password);

        // Execute the query and check for errors
        if ($stmt->execute()) {
            echo "<script type='text/javascript'> alert('Successfully Registered'); window.location.href='login.php'; </script>";
        } else {
            echo "<script type='text/javascript'> alert('Registration failed. Please try again later.'); </script>";
        }

        $stmt->close();
    } else {
        echo "<script type='text/javascript'> alert('Please enter valid information.'); </script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <title>Sign Up</title>
</head>
<body>
    <div class="signup">
        <h1>Sign Up</h1>
        <form method="POST">
            <label>First Name</label>
            <input type="text" name="fname" required>
            
            <label>Last Name</label>
            <input type="text" name="lname" required>
            
            <label>Gender</label>
            <select name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            
            <label>Contact Address</label>
            <input type="tel" name="number" required>
            
            <label>Address</label>
            <input type="text" name="add" required>
            
            <label>Email</label>
            <input type="email" name="mail">
            
            <label>Password</label>
            <input type="password" name="pass" required>
            
            <input type="submit" value="Submit">
        </form>
        <p>By clicking the Sign Up button, you agree to our<br>
        <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>
        </p>
        <p>Already have an account? <a href="login.php">Login Here</a></p>
    </div>
</body>
</html>
