<?php
require 'file/connection.php';
session_start();
if(!isset($_SESSION['hid']))
{
  header('location:login.php');
}
else {
	if(isset($_SESSION['hid'])){
		$id=$_SESSION['hid'];
		$sql = "SELECT * FROM hospitals WHERE hospital_id='$id'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
	}
}
?>

<!DOCTYPE html>
<html>
<?php $title="Bloodbank | Receiver Profile"; ?>
<?php require 'head.php';?>
<body>
	<?php require 'header.php'; ?>

	<div class="container cont">

		<?php require 'message.php'; ?>

		<div class="row justify-content-center">
			<div class="col-lg-4 col-md-4 col-sm-6 mb-5">
				<div class="card">
					<div class="media justify-content-center mt-1">
						<img src="image/hospital.png" alt="profile" class="rounded-circle" width="70" height="60">
					</div>
					<div class="card-body">
					   <form action="file/updateprofile.php" method="post">
					   	<label class="text-muted font-weight-bold" class="text-muted font-weight-bold">Hospital Name</label>
						<input type="text" name="hospital_name" value="<?php echo $row['hospital_name']; ?>" class="form-control mb-3">
						<label class="text-muted font-weight-bold">Hospital Email</label>
						<input type="email" name="email" value="<?php echo $row['email']; ?>" class="form-control mb-3">
						<label class="text-muted font-weight-bold">Hospital Password</label>
						<input type="text" name="password" value="<?php echo $row['password']; ?>" class="form-control mb-3">
						<label class="text-muted font-weight-bold">Hospital Phone Number</label>
						<input type="text" name="phone" value="<?php echo $row['phone']; ?>" class="form-control mb-3">
						<label class="text-muted font-weight-bold">Hospital City</label>
						<input type="text" name="address" value="<?php echo $row['address']; ?>" class="form-control mb-3">
						<input type="submit" name="update" class="btn btn-block btn-primary" value="Update">
					   </form>
					</div>
					<a href="index.php" class="text-center">Cancel</a><br>
					<a href="hospital_dashboard.php" class="text-center">hospital</a>
				</div>
			</div>
		</div>
	</div>
	<?php require 'footer.php'; ?>
</body>
</html>