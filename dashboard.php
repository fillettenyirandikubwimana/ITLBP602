
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include "db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LOLSchool Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2>LOLSchool Student Management System</h2>

    <div class="alert alert-success">
        Welcome,
        <?= htmlspecialchars($_SESSION['username']) ?>!
        Your role is <?= htmlspecialchars($_SESSION['role']) ?>.
    </div>

    <div class="list-group">
        <a href="students.php" class="list-group-item list-group-item-action">
            Student Management
        </a>
        <a href="attendance.php" class="list-group-item list-group-item-action">
            Attendance Management
        </a>
        <a href="grades.php" class="list-group-item list-group-item-action">
            Examination Grades
        </a>
        <a href="announcements.php" class="list-group-item list-group-item-action">
            School Announcements
        </a>
    </div>

    <a href="logout.php" class="btn btn-danger mt-4">Logout</a>
</div>
</body>
</html>
