<?php

include "db.php";
if(isset($_POST['save'])){
    $name = $_POST['class_name'];
    $year = $_POST['academic_year'];

    $stmt = $conn->prepare(
        "INSERT INTO classes(class_name,academic_year) VALUES(?,?)"
    );
    $stmt->bind_param("ss",$name,$year);
    $stmt->execute();
}

if(isset($_POST['update'])){
    $id = $_POST['id'];
    $name = $_POST['class_name'];
    $year = $_POST['academic_year'];

    $stmt = $conn->prepare(
        "UPDATE classes SET class_name=?,academic_year=? WHERE class_id=?"
    );
    $stmt->bind_param("ssi",$name,$year,$id);
    $stmt->execute();
}

if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM classes WHERE class_id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
}

$result = mysqli_query($conn,"SELECT * FROM classes");
?>

<!DOCTYPE html>
<html>
<head>
<title>Classes</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h2>Classes Management</h2>

<form method="POST" class="card p-3">
<input type="text" name="class_name" placeholder="Class Name" class="form-control mb-2" required>
<input type="text" name="academic_year" placeholder="Academic Year" class="form-control mb-2" required>
<button name="save" class="btn btn-primary">Save Class</button>
</form>

<table class="table table-bordered mt-4">
<tr><th>ID</th><th>Class Name</th><th>Academic Year</th><th>Action</th></tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?=$row['class_id']?></td>
<td><?=htmlspecialchars($row['class_name'])?></td>
<td><?=htmlspecialchars($row['academic_year'])?></td>
<td><a href="?delete=<?=$row['class_id']?>" class="btn btn-danger btn-sm">Delete</a></td>
</tr>
<?php } ?>
</table>

</body>
</html>