
<?php
// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "market"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$signup_message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    
    if (!preg_match("/^[a-zA-Z ]*$/", $username)) {
        $signup_message = "Username should contain only letters and space.";
    } 
    
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $signup_message = "Invalid email format.";
    }
    
    elseif ($password !== $confirm_password) {
        $signup_message = "Passwords do not match.";
    } else {
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        if ($conn->query($sql) === TRUE) {
            $signup_message = "Signup successful!";
            header("Location: home.html");
            exit();
        } else {
            $signup_message = "Signup failed. Please try again.";
        }
    }
}

$conn->close();
?>

<!-• Signup form -->
<<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title></title>
</head>
<body>
    <h1>SIGNUP</h1>
<form method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
    <button type="submit">Sign Up</button>
    <p class="<?php echo $signup_message === "Signup successful!" ? 'success' : 'error'; ?>">
    <?php echo $signup_message; ?></p>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</form>
</body>
</html>
