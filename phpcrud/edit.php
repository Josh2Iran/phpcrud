<?php
// Database Connection
include('dbconnection.php');
$eid = intval($_GET['editid']);
if (isset($_POST['submit'])) {
    // Getting Post Values
    $fname  = $_POST['fname'];
    $lname  = $_POST['lname'];
    $contno = $_POST['contactno'];
    $email  = $_POST['email'];
    $add    = $_POST['address'];

    // Query for data updation (prepared statement)
    $stmt = mysqli_prepare($con, "UPDATE tblusers SET FirstName=?, LastName=?, MobileNumber=?, Email=?, Address=? WHERE ID=?");
    mysqli_stmt_bind_param($stmt, "sssssi", $fname, $lname, $contno, $email, $add, $eid);
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('You have successfully updated the data');</script>";
        echo "<script type='text/javascript'> document.location ='index.php';</script>";
    } else {
        echo "<script>alert('Something Went Wrong. Please try again');</script>";
    }
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
<title>PHP Crud Operation!!</title>
</head>
<body>
<div class="signup-form">
  <form method="POST">
<?php
$ret = mysqli_query($con, "SELECT * FROM tblusers WHERE ID=$eid");
while ($row = mysqli_fetch_array($ret)) {
?>
    <h2>Update</h2>
    <p class="hint-text">Update your info.</p>
    <div class="form-group">
      <div class="row">
        <div class="col"><input type="text" class="form-control" name="fname" value="<?php echo htmlspecialchars($row['FirstName']); ?>" required="true"></div>
        <div class="col"><input type="text" class="form-control" name="lname" value="<?php echo htmlspecialchars($row['LastName']); ?>" required="true"></div>
      </div>
    </div>
    <div class="form-group">
      <input type="text" class="form-control" name="contactno" value="<?php echo htmlspecialchars($row['MobileNumber']); ?>" required="true" maxlength="10" pattern="[0-9]+">
    </div>
    <div class="form-group">
      <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($row['Email']); ?>" required="true">
    </div>
    <div class="form-group">
      <textarea class="form-control" name="address" required="true"><?php echo htmlspecialchars($row['Address']); ?></textarea>
    </div>
<?php } ?>
    <div class="form-group">
      <button type="submit" class="btn btn-success btn-lg btn-block" name="submit">Update</button>
    </div>
  </form>
  <div class="text-center"><a href="index.php">Back to list</a></div>
</div>
</body>
</html>
