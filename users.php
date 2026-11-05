
<?php
include "db.php";

// ADD USER
if (isset($_POST['save'])) {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, password, role)
            VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $username, $password, $role);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('User added successfully');</script>";
    }
}

// UPDATE USER AND PASSWORD
if (isset($_POST['update'])) {
    $id = (int) $_POST['id'];
    $username = trim($_POST['username']);
    $role = $_POST['role'];
    $new_password = $_POST['password'];

    if (!empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $sql = "UPDATE users
                SET username=?, password=?, role=?
                WHERE user_id=?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param(
            $stmt, "sssi", $username, $hashed_password, $role, $id
        );
    } else {
        $sql = "UPDATE users
                SET username=?, role=?
                WHERE user_id=?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $username, $role, $id);
    }

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('User updated successfully');</script>";
    }
}

// DELETE USER
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE user_id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    header("Location: users.php");
    exit;
}

// GET USER FOR EDITING
$edit_user = null;

if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];

    $stmt = mysqli_prepare(
        $conn,
        "SELECT user_id, username, role FROM users WHERE user_id=?"
    );
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $edit_user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

// SELECT ALL USERS
// SELECT ALL USERS
$result = mysqli_query(
    $conn,
    "SELECT user_id, username, role FROM users ORDER BY user_id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Users Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

<h2 class="text-primary mb-3">Users Management</h2>

<form method="POST" class="card p-4 shadow-sm">

    <?php if ($edit_user) { ?>
        <h4>Update User</h4>

        <input type="hidden" name="id"
               value="<?= htmlspecialchars($edit_user['user_id']) ?>">
    <?php } else { ?>
        <h4>Add New User</h4>
    <?php } ?>

    <label class="form-label">Username</label>
    <input type="text" name="username" class="form-control mb-3"
           value="<?= htmlspecialchars($edit_user['username'] ?? '') ?>"
           required>

    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control mb-3"
           placeholder="<?= $edit_user ? 'Enter new password (leave blank to keep current)' : 'Enter password' ?>"
           <?= $edit_user ? '' : 'required' ?>>

    <label class="form-label">Role</label>
    <select name="role" class="form-select mb-3" required>
        <?php
        $roles = ['Admin', 'Teacher', 'Staff'];
        foreach ($roles as $role) {
            $selected = (($edit_user['role'] ?? '') === $role) ? 'selected' : '';
            echo "<option value=\"$role\" $selected>$role</option>";
        }
        ?>
    </select>

    <?php if ($edit_user) { ?>
        <button type="submit" name="update" class="btn btn-success">
            Update User
        </button>
        <a href="users.php" class="btn btn-secondary mt-2">Cancel</a>
    <?php } else { ?>
        <button type="submit" name="save" class="btn btn-primary">
            Add User
        </button>
    <?php } ?>

</form>

<h4 class="mt-4">Users List</h4>

<table class="table table-bordered table-striped mt-3">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['user_id'] ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['role']) ?></td>
            <td>
                <a href="users.php?edit=<?= $row['user_id'] ?>"
                   class="btn btn-warning btn-sm">Edit</a>

                <a href="users.php?delete=<?= $row['user_id'] ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Are you sure you want to delete this user?')">
                    Delete
                </a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>

</body>
</html>
