

<?php
session_start();
require 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Search user by username
    $sql = "SELECT user_id, username, password, role 
            FROM users 
            WHERE username = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {

            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header('Location: dashboard.php');
            exit;

        } else {
            $error = 'Incorrect username or password.';
        }

        mysqli_stmt_close($stmt);

    } else {
        $error = 'Database query failed.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LOLSchool Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width:450px">
    <div class="card shadow-sm p-4">
        <h2 class="text-center">LOLSchool SMS</h2>
        <p class="text-center">Sign in to your account</p>

        <?php if ($error !== ''): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <label class="form-label">Username</label>
            <input class="form-control mb-3"
                   name="username" required>

            <label class="form-label">Password</label>
            <input type="password" class="form-control mb-3"
                   name="password" required>

            <button type="submit" class="btn btn-primary w-100">
                Login
            </button>
        </form>
    </div>
    <!-- Create Account Link -->
<div class="text-center mt-4">
    <p class="text-muted">
        Don't have an account?
        <a href="users.php"
           class="text-primary fw-bold text-decoration-none">
            Create Account
        </a>
    </p>
</div>

<div class="footer-text">
    © 2026 LOL School. All Rights Reserved.
</div>
</div>
</body>
</html>
