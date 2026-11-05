
<?php
session_start();
require_once "db.php";

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === "" || $password === "") {
        $error = "Please fill in all fields.";
    } else {

        $sql = "SELECT user_id, username, password, role
                FROM users WHERE username = ? LIMIT 1";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {

            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header("Location: dashboard.php");
            exit;

        } else {
            $error = "Incorrect username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>LOL School | Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    min-height: 100vh;
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #061b49, #0875c9);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.login-wrapper {
    width: 100%;
    max-width: 950px;
    min-height: 550px;
    background: white;
    display: grid;
    grid-template-columns: 1fr 1fr;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(0,0,0,0.25);
}

.left-side {
    background: linear-gradient(150deg, #082b65, #087bd0);
    color: white;
    padding: 55px 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.logo {
    width: 85px;
    height: 85px;
    border-radius: 50%;
    background: white;
    color: #0875c9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 40px;
    margin-bottom: 25px;
}

.left-side h1 {
    font-weight: bold;
    font-size: 32px;
}

.left-side p {
    line-height: 1.8;
    color: #e1edff;
}

.right-side {
    padding: 55px 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.right-side h2 {
    color: #082b65;
    font-weight: bold;
}

.form-control {
    height: 48px;
    border-radius: 9px;
}

.input-group-text {
    background: #f2f6fb;
}

.btn-login {
    height: 48px;
    border-radius: 9px;
    background: #0875c9;
    color: white;
    font-weight: bold;
    border: none;
}

.btn-login:hover {
    background: #082b65;
    color: white;
}

.footer-text {
    font-size: 13px;
    color: #777;
    text-align: center;
    margin-top: 30px;
}

@media(max-width: 700px) {
    .login-wrapper {
        grid-template-columns: 1fr;
    }

    .left-side {
        padding: 30px;
        text-align: center;
        align-items: center;
    }

    .right-side {
        padding: 35px 25px;
    }
}
</style>
</head>

<body>

<div class="login-wrapper">

    <div class="left-side">

        <div class="logo">
            <i class="bi bi-mortarboard-fill"></i>
        </div>

        <h1>LOL SCHOOL</h1>

        <h5>Student Management System</h5>

        <p class="mt-3">
            Welcome to LOL School digital platform.
            Manage student registration, attendance,
            academic grades and school announcements
            in one place.
        </p>

        <p class="mt-4">
            <i class="bi bi-shield-check"></i>
            Secure access for authorized users.
        </p>

    </div>

    <div class="right-side">

        <h2>Welcome Back!</h2>

        <p class="text-muted mb-4">
            Login to access your account.
        </p>

        <?php if ($error !== "") { ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle"></i>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php } ?>

        <form method="POST" action="">

            <div class="mb-3">
                <label class="form-label fw-bold">Username</label>

                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>

                    <input type="text"
                           name="username"
                           class="form-control"
                           placeholder="Enter username"
                           autocomplete="username"
                           required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Password</label>

                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>

                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control"
                           placeholder="Enter password"
                           autocomplete="current-password"
                           required>

                    <button type="button"
                            class="btn btn-outline-secondary"
                            onclick="togglePassword()">
                        <i class="bi bi-eye" id="eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit"
                    class="btn btn-login w-100">
                <i class="bi bi-box-arrow-in-right"></i>
                LOGIN
            </button>

        </form>

        <div class="footer-text">
            © 2026 LOL School. All Rights Reserved.
        </div>

    </div>

</div>

<script>
function togglePassword() {
    const input = document.getElementById("password");
    const eye = document.getElementById("eye");

    if (input.type === "password") {
        input.type = "text";
        eye.classList.replace("bi-eye", "bi-eye-slash");
    } else {
        input.type = "password";
        eye.classList.replace("bi-eye-slash", "bi-eye");
    }
}
</script>

</body>
</html>
