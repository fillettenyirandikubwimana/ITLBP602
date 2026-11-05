<?php
include "db.php";

if(isset($_POST['save'])){
    $title = $_POST['title'];
    $message = $_POST['message'];
    $date = $_POST['publication_date'];
    $posted_by = $_POST['posted_by'];

    $stmt = $conn->prepare(
        "INSERT INTO announcements(title,message,publication_date,posted_by)
         VALUES(?,?,?,?)"
    );

    $stmt->bind_param("sssi",$title,$message,$date,$posted_by);
    $stmt->execute();
}

if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM announcements WHERE announcement_id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
}

$result = mysqli_query($conn,
"SELECT announcements.*,users.username
 FROM announcements
 JOIN users ON announcements.posted_by=users.user_id");
?>

<!DOCTYPE html>
<html>
<head>
<title>Announcements</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h2>Announcements Management</h2>

<form method="POST" class="card p-3">

<input type="text" name="title" placeholder="Announcement Title" class="form-control mb-2" required>

<textarea name="message" placeholder="Write announcement" class="form-control mb-2" required></textarea>

<input type="date" name="publication_date" class="form-control mb-2" required>

<label>Posted By (User ID)</label>
<input type="number" name="posted_by" class="form-control mb-2" required>

<button name="save" class="btn btn-primary">Publish Announcement</button>
</form>

<table class="table table-bordered mt-4">
<tr><th>ID</th><th>Title</th><th>Message</th><th>Date</th><th>Posted By</th><th>Action</th></tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?=$row['announcement_id']?></td>
<td><?=htmlspecialchars($row['title'])?></td>
<td><?=htmlspecialchars($row['message'])?></td>
<td><?=$row['publication_date']?></td>
<td><?=htmlspecialchars($row['username'])?></td>
<td><a href="?delete=<?=$row['announcement_id']?>" class="btn btn-danger btn-sm">Delete</a></td>
</tr>
<?php } ?>
</table>

</body>
</html>