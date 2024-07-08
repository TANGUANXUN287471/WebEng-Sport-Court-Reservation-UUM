<?php
// Include the database connection file
global $conn;
include 'dbconnect.php';

// Retrieve form data
$user_id = $_POST['user_id'];
$password = $_POST['password'];

// Query the database
$sql = "SELECT matricNo, passwordHash FROM users WHERE matricNo = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $matricNo = $row['matricNo'];
  $hashed_password = $row['passwordHash'];

  // Verify password
  if (password_verify($password, $hashed_password)) {
    // Password is correct
    // Check if matricNo is equal to 1
    if ($matricNo == 1) {
      // Redirect to admin.html
      header("Location: ../admin.html");

    } else {
      // Redirect to index.html (or any other page for non-admin users)
      header("Location: ../index.html");

    }
  } else {
    // Password is incorrect
    echo "Invalid password.";
  }
} else {
  // User not found
  echo "Invalid user ID.";
}

// Close database connection (you can omit this if you want to reuse the connection in other parts of your script)
$conn->close();
?>
