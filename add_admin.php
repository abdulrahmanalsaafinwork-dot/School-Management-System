<?php
include 'DB_connection.php'; // your PDO connection

// Admin info
$username = 'Ar';
$password = 'ar12345';
$fname = 'Ar';
$lname = 'Al-saafin';

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Prepare and execute insert using PDO
$sql = "INSERT INTO admin (username, password, fname, lname) VALUES (:username, :password, :fname, :lname)";
$stmt = $conn->prepare($sql);
$result = $stmt->execute([
    ':username' => $username,
    ':password' => $hashedPassword,
    ':fname' => $fname,
    ':lname' => $lname
]);

if ($result) {
    echo "Admin added successfully!";
} else {
    echo "Error adding admin.";
}
?>
