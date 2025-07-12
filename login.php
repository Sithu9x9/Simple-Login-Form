<?php
$host = "localhost";
$dbname = "register";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$input_password = $_POST['password'];

// Fetch user from database
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();
  
  if (password_verify($input_password, $user['password'])) {
    echo "Login successful! Welcome, " . htmlspecialchars($user['name']) . ".";
    // You can use session_start() here to manage sessions
  } else {
    echo "Invalid password.";
  }
} else {
  echo "No user found with that email.";
}

$stmt->close();
$conn->close();
?>
