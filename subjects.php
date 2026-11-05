<?php
include "db.php";

if(isset($_POST['save'])){
    $name = $_POST['subject_name'];
    $code = $_POST['subject_code'];

    $stmt = $conn->prepare(
        "INSERT INTO subjects(subject_name,subject_code) VALUES(?,?)"
    );
    $stmt->bind_param("ss",$name,$code);
    $stmt->execute();
}

if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM subjects WHERE subject_id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
}

$result = mysqli_query($conn,"SELECT * FROM subjects");
?>

<!DOCTYPE html>
<html>
<head>
<title>Subjects</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h2>Subjects Management</h2>

<form method="POST" class="card p-3">
<input type="text" name="subject_name" placeholder="Subject Name" class="form-control mb-2" required>
<input type="text" name="subject_code" placeholder="Subject Code" class="form-control mb-2" required>
<button name="save" class="btn btn-primary">Add Subject</button>
</form>

<table class="table table-bordered mt-4">
<tr><th>ID</th><th>Subject</th><th>Code</th><th>Action</th></tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?=$row['subject_id']?></td>
<td><?=htmlspecialchars($row['subject_name'])?></td>
<td><?=htmlspecialchars($row['subject_code'])?></td>
<td><a href="?delete=<?=$row['subject_id']?>" class="btn btn-danger btn-sm">Delete</a></td>
</tr>
<?php } ?>
</table>

</body>
</html>