<?php
// Database connection file
include('dbconnection.php');

// Code for deletion
if (isset($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    $sql = mysqli_query($con, "DELETE FROM tblusers WHERE ID=$rid");
    echo "<script>alert('Data deleted');</script>";
    echo "<script>window.location.href = 'index.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
<title>Bootstrap Elegant Table Design</title>
</head>
<body>
<div class="container-xl">
  <div class="table-responsive">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row">
          <div class="col-sm-8"><h2>User <b>Details</b></h2></div>
          <div class="col-sm-4 text-right">
            <a href="insert.php" class="btn btn-info"><i class="fa fa-plus"></i> Add New</a>
          </div>
        </div>
      </div>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Mobile Number</th>
            <th>Address</th>
            <th>Creation Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
<?php
$ret = mysqli_query($con, "SELECT * FROM tblusers");
$cnt = 1;
$num = mysqli_num_rows($ret);
if ($num > 0) {
    while ($row = mysqli_fetch_array($ret)) {
?>
          <tr>
            <td><?php echo $cnt; ?></td>
            <td><?php echo htmlspecialchars($row['FirstName']); ?></td>
            <td><?php echo htmlspecialchars($row['LastName']); ?></td>
            <td><?php echo htmlspecialchars($row['Email']); ?></td>
            <td><?php echo htmlspecialchars($row['MobileNumber']); ?></td>
            <td><?php echo htmlspecialchars($row['Address']); ?></td>
            <td><?php echo $row['CreationDate']; ?></td>
            <td>
              <a href="read.php?viewid=<?php echo $row['ID']; ?>" class="view" title="View"><i class="fa fa-eye"></i></a>
              <a href="edit.php?editid=<?php echo $row['ID']; ?>" class="edit" title="Edit"><i class="fa fa-pencil"></i></a>
              <a href="index.php?delid=<?php echo $row['ID']; ?>" class="delete" title="Delete" onclick="return confirm('Do you really want to delete this record?');"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
<?php
        $cnt = $cnt + 1;
    }
} else {
?>
          <tr><td colspan="8" class="text-center">No records found</td></tr>
<?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
