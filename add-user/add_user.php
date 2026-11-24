<?php

require_once __DIR__ . "/../config/db.php";

$username = "rochelle";
$password = "rhonda101$";

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare(
    "UPDATE users SET password = ? WHERE username = ?"
);

$stmt->execute([$hashedPassword, $username]);

if ($stmt->rowCount() > 0) {
    echo "Password updated successfully!";
} else {
    echo "User not found or password is unchanged.";
}

?>