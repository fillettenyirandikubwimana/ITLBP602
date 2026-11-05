<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>stylesheet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap.min.css"rel="stylesheet">
</head>
<body>
    <a href="home.php">home</a>
     <a href="main.php">fruit</a>
      <a href="sales.php">sales</a>
      <div>
        <table border="1" class="table-table-bordered table-striped table-hover">
            <tr>
            <th>No</th>
            <th>Fruit name</th>
            <th>Price</th>
             <th>Status</th>
              <th>legeng</th>
              <th>action</th>
            </tr>

<?php
include "db.php";
$con=mysqli_connect("localhost","root","","lol_sms");
$sql=mysqli_query($con,"select * from fruit");
while($data=mysqli_fetch_assoc($sql)){
?>
<tr>
    <td><?php echo $data['fruit_id'];?></td>
    <td><?php echo $data['fruit_name'];?></td>
    <td><?php echo $data['price'];?></td>
    <td><?php echo $data['status'];?></td>
    <td><?php echo $data['date'];?></td>
    <td> <a href="deletefruit.php?a=<?php echo $data['fruit_id'];?>"class="btn btn-succes btn-sn">delete</a>
      <a href="updatefruit.php?a=<?php echo $data['fruit_id'];?>"> update</a>

      </tr>
<?php
}
?>
        </table>
      </div>

</body>
</html>