<?php
require 'connection.php';

if(isset($_GET['reqid'])){
    $id = $_GET['reqid'];
    $_SESSION['msg'] = "Request Rejected!";

    mysqli_query($conn, "UPDATE blood_request 
                         SET status='Rejected' 
                         WHERE hid='$id'");

    header("Location: ../blood_request.php?msg=Rejected");
}
?>
 Check request id
if(isset($_GET['reqid'])){

   $reqid = mysqli_real_escape_string($conn, $_GET['reqid']);

    // Update status to Rejected
    $sql = "UPDATE bloodrequest SET status='Rejected' WHERE reqid='$reqid'";
    if(mysqli_query($conn, $sql)){
        header("Location: ../blood_request.php?msg=Request Rejected Successfully");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

} else {
    echo "Invalid Request ID";
}
?>