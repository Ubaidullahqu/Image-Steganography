<?php 
session_start();    

include("db.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $gmail = $_POST['mail'];
    $password = $_POST['pass'];

    if (!empty($gmail) && !empty($password) && filter_var($gmail, FILTER_VALIDATE_EMAIL)) {
        // Use prepared statements to prevent SQL injection
        $stmt = $con->prepare("SELECT pass FROM form WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $gmail);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // Debugging: Output stored hash and input password
            echo "Stored Hash: " . $hashed_password . "<br>";
            echo "Input Password: " . $password . "<br>";

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_email'] = $gmail;
                header("Location: index.php");
                exit();
            } else {
                echo "<script type='text/javascript'> alert('Password verification failed.'); </script>";
            }
        } else {
            echo "<script type='text/javascript'> alert('Email not found.'); </script>";
        }

        $stmt->close();
    } else {
        echo "<script type='text/javascript'> alert('Please enter valid email and password.'); </script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login">
        <h1>Login</h1>
        <form method="POST">
            <label>Email</label>
            <input type="email" name="mail" required>
            
            <label>Password</label>
            <input type="password" name="pass" required>
            
            <input type="submit" value="Submit">
        </form>
        <p>Not have an account? <a href="signup.php">Sign up here</a></p>
    </div>
</body>
</html>
