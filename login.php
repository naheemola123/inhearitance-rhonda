
<?php
session_start();
require_once "config/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare(
        "SELECT * FROM users WHERE username = ?"
    );

    $stmt->execute([$username]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {

        session_regenerate_id(true);

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];

        header("Location: dashboard.php");
        exit();

    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login</title>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <form method="POST" class="bg-white p-8 rounded-xl shadow-lg w-96">

        <h1 class="text-3xl font-bold mb-6">Login</h1>

        <?php if ($error): ?>
            <p class="text-red-500 mb-4">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>

        <input
            type="text"
            name="username"
            placeholder="Username"
            required
            class="w-full border p-3 rounded-lg mb-4"
        >

        <input
            type="password"
            name="password"
            placeholder="Password"
            required
            class="w-full border p-3 rounded-lg mb-6"
        >

        <button
            type="submit"
            class="w-full bg-blue-600 text-white p-3 rounded-lg">
            Login
        </button>

    </form>

</body>
</html>
