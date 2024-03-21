
<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "market";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$login_message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

       
        if (password_verify($password, $user['password'])) {
            $login_message = "Login successful!";
            header("Location: home.html");
            exit();
        } else {
            $login_message = "Login failed. Invalid password.";
        }
    } else {
        $login_message = "Login failed. User not found.";
    }
}

$conn->close();
?>

<!-• Login form -->
<<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title></title>
</head>
<body>
<h1>LOGIN</h1>
<form method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
    <p class="<?php echo $login_message === "Login successful!" ? 'success' : 'error'; ?>">
    <?php echo $login_message; ?></p>
    <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
</form>

</body>
</html>


