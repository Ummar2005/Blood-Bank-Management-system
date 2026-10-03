<?php 
require 'file/connection.php'; 
session_start();
  if(!isset($_SESSION['request_id']))
  {
  header('location:login.php');
  }
  else {
    $rid = $_SESSION['request_id'];
   $sql = "SELECT blood_request.*, hospitals.* 
        FROM blood_request 
        JOIN hospitals ON blood_request.hid = hospitals.hospital_id
        WHERE blood_request.request_id='$rid'";
    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<?php $title="Bloodbank | Sent Requests"; ?>
<?php require 'head.php'; ?>
<body>
	<?php require 'header.php'; ?>
	<div class="container cont">

		<?php require 'message.php'; ?>

	<table class="table table-responsive table-striped rounded mb-5">
		<tr><th colspan="8" class="title">Sent requests</th></tr>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Email</th>
			<th>City</th>
			<th>Phone</th>
			<th>Blood Group</th>
			<th>Status</th>
			<th>Action</th>
		</tr>

		    <div>
                <?php
                if ($result) {
                    $row =mysqli_num_rows( $result);
                    if ($row) { //echo "<b> Total ".$row." </b>";
                }else echo '<b style="color:white;background-color:red;padding:7px;border-radius: 15px 50px;">You have not requested yet. </b>';
            }
            ?>
            </div>

		<?php
		$counter = 0;
		 while($row = mysqli_fetch_array($result)) { ?>

		<tr>
			<td><?php echo ++$counter;?></td>
			<td><?php echo $row['hospital_name'];?></td>
			<td><?php echo $row['email'];?></td>
			<td><?php echo $row['address'];?></td>
			<td><?php echo $row['phone'];?></td>
			<td><?php echo $row['blood_group'];?></td>
			<td><?php echo $row['status'];?></td>
			<td><?php if($row['status'] == 'Accepted'){ ?>
			<?php }
			else{ ?>
				<a href="file/cancel.php?reqid=<?php echo $row['reqid'];?>" class="btn btn-danger">Cancel</a>
			<?php } ?>
			</td>
		</tr>
		<?php } ?>

	</table>
</div>
    <?php require 'footer.php'; ?>
</body>
</html>
<?php } ?>