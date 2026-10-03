<div class="row justify-content-center mb-3">
<?php
if(isset($_SESSION['msg'])){
    echo "<div style='background:green;color:white;padding:10px;margin:10px;border-radius:5px;'>
            ".$_SESSION['msg']."
          </div>";
    unset($_SESSION['msg']);
}
?>

<?php if(isset($_GET['msg'])) { ?>
<div class="col-5 alert alert-success"><?php echo $_GET['msg']; ?></div>
<?php } ?>

<?php if(isset($_GET['error'])) { ?>
<div class="col-5 alert alert-danger"><?php echo $_GET['error']; ?></div>
<?php } ?>
</div>