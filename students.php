<?php
session_start();
require 'db.php';

// Check login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$message = '';

// Check database connection
if (!isset($pdo)) {
    die("Database connection error: PDO variable \$pdo is missing.");
}

// Register student
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        http_response_code(403);
        exit('Only administrators can register students.');
    }}
    ?><?php
session_start();
require 'db.php';

// Check login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$message = '';

// Check database connection
if (!isset($pdo)) {
    die("Database connection error: PDO variable \$pdo is missing.");
}

// Register student
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        http_response_code(403);
        exit('Only administrators can register students.');
    }}
    ?><?php
session_start();
require 'db.php';

// Check login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$message = '';

// Check database connection
if (!isset($pdo)) {
    die("Database connection error: PDO variable \$pdo is missing.");
}

// Register student
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        http_response_code(403);
        exit('Only administrators can register students.');
    }}
    ?><?php
session_start();
require 'db.php';

// Check login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$message = '';

// Check database connection
if (!isset($pdo)) {
    die("Database connection error: PDO variable \$pdo is missing.");
}

// Register student
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        http_response_code(403);
        exit('Only administrators can register students.');
    }}
    ?>
    <?php
session_start();
require 'db.php';

// Check login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$message = '';

// Check database connection
if (!isset($pdo)) {
    die("Database connection error: PDO variable \$pdo is missing.");
}

// Register student
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        http_response_code(403);
        exit('Only administrators can register students.');
    }}
    ?>

    <?php
session_start();
require 'db.php';

// Check login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$message = '';

// Check database connection
if (!isset($pdo)) {
    die("Database connection error: PDO variable \$pdo is missing.");
}

// Register student
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        http_response_code(403);
        exit('Only administrators can register students.');
    }}
    ?>