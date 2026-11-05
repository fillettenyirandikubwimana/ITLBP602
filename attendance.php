<?php
include "db.php";

if(isset($_POST['save'])){
    $student = $_POST['student_id'];
    $date = $_POST['attendance_date'];
    $status = $_POST['attendance_status'];

    $stmt = $conn->prepare(
        "INSERT INTO attendance(student_id,attendance_date,attendance_status)
         VALUES(?,?,?)"
    );
    $stmt->bind_param("iss",$student,$date,$status);
    $stmt->execute();
}

if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM attendance WHERE attendance_id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
}

$result = mysqli_query($conn,
"SELECT attendance.*,students.names
 FROM attendance
 JOIN students ON attendance.student_id=students.student_id");
?>

<!DOCTYPE html>
<html>
<head>
<title>Attendance</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h2>Attendance Management</h2>

<form method="POST" class="card p-3">

<label>Student</label>
<select name="student_id" class="form-control mb-2" required>
<?php
$s = mysqli_query($conn,"SELECT * FROM students");
while($student=mysqli_fetch_assoc($s)){
?>
<option value="<?=$student['student_id']?>">
<?=htmlspecialchars($student['names'])?>
</option>
<?php } ?>
</select>

<label>Date</label>
<input type="date" name="attendance_date" class="form-control mb-2" required>

<label>Status</label>
<select name="attendance_status" class="form-control mb-2">
<option>Present</option>
<option>Absent</option>
<option>Late</option>
<option>Excused</option>
</select>

<button name="save" class="btn btn-primary">Save Attendance</button>
</form>

<table class="table table-bordered mt-4">
<tr><th>ID</th><th>Student</th><th>Date</th><th>Status</th><th>Action</th></tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?=$row['attendance_id']?></td>
<td><?=htmlspecialchars($row['names'])?></td>
<td><?=$row['attendance_date']?></td>
<td><?=$row['attendance_status']?></td>
<td><a href="?delete=<?=$row['attendance_id']?>" class="btn btn-danger btn-sm">Delete</a></td>
</tr>
<?php } ?>
</table>

</body>
</html>