<?php
include('dbconnection.php');
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
<title>Crud Operation Using PHP and MySQLi</title>
</head>
<body>
<div class="container-xl">
  <div class="table-responsive">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row">
          <div class="col-sm-8"><h2>User <b>Details</b></h2></div>
          <div class="col-sm-4 text-right"><a href="index.php" class="btn btn-info">Back</a></div>
        </div>
      </div>
      <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
        <tbody>
<?php
$vid = intval($_GET['viewid']);
$ret = mysqli_query($con, "SELECT * FROM tblusers WHERE ID=$vid");
while ($row = mysqli_fetch_array($ret)) {
?>
          <tr>
            <th>First Name</th>
            <td><?php echo htmlspecialchars($row['FirstName']); ?></td>
            <th>Last Name</th>
            <td><?php echo htmlspecialchars($row['LastName']); ?></td>
          </tr>
          <tr>
            <th>Email</th>
            <td><?php echo htmlspecialchars($row['Email']); ?></td>
            <th>Mobile Number</th>
            <td><?php echo htmlspecialchars($row['MobileNumber']); ?></td>
          </tr>
          <tr>
            <th>Address</th>
            <td><?php echo htmlspecialchars($row['Address']); ?></td>
            <th>Creation Date</th>
            <td><?php echo $row['CreationDate']; ?></td>
          </tr>
<?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
