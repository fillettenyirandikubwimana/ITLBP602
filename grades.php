<?php
include "db.php";

if(isset($_POST['save'])){
    $student = $_POST['student_id'];
    $subject = $_POST['subject_id'];
    $type = $_POST['assessment_type'];
    $marks = $_POST['marks'];
    $year = $_POST['academic_year'];

    if($marks >= 0 && $marks <= 100){

        $stmt = $conn->prepare(
            "INSERT INTO grades(student_id,subject_id,assessment_type,marks,academic_year)
             VALUES(?,?,?,?,?)"
        );

        $stmt->bind_param("iisds",$student,$subject,$type,$marks,$year);
        $stmt->execute();

    } else {
        echo "Marks must be between 0 and 100";
    }
}

if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM grades WHERE grade_id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
}

$result = mysqli_query($conn,
"SELECT grades.*,students.names,subjects.subject_name
 FROM grades
 JOIN students ON grades.student_id=students.student_id
 JOIN subjects ON grades.subject_id=subjects.subject_id");
?>

<!DOCTYPE html>
<html>
<head>
<title>Grades</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h2>Grades Management</h2>

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

<label>Subject</label>
<select name="subject_id" class="form-control mb-2" required>
<?php
$s = mysqli_query($conn,"SELECT * FROM subjects");
while($subject=mysqli_fetch_assoc($s)){
?>
<option value="<?=$subject['subject_id']?>">
<?=htmlspecialchars($subject['subject_name'])?>
</option>
<?php } ?>
</select>

<input type="text" name="assessment_type" placeholder="Assessment Type" class="form-control mb-2" required>
<input type="number" name="marks" min="0" max="100" step="0.01" placeholder="Marks" class="form-control mb-2" required>
<input type="text" name="academic_year" placeholder="Academic Year" class="form-control mb-2" required>

<button name="save" class="btn btn-primary">Save Grade</button>
</form>

<table class="table table-bordered mt-4">
<tr><th>ID</th><th>Student</th><th>Subject</th><th>Assessment</th><th>Marks</th><th>Year</th><th>Action</th></tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?=$row['grade_id']?></td>
<td><?=htmlspecialchars($row['names'])?></td>
<td><?=htmlspecialchars($row['subject_name'])?></td>
<td><?=htmlspecialchars($row['assessment_type'])?></td>
<td><?=$row['marks']?></td>
<td><?=$row['academic_year']?></td>
<td><a href="?delete=<?=$row['grade_id']?>" class="btn btn-danger btn-sm">Delete</a></td>
</tr>
<?php } ?>
</table>

</body>
</html>