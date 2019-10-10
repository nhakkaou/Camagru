<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar_register.php'; ?>
<div class="jumbotron jumbotron-flud text-center">
    <h1><?php echo $data['title'];?></h1>
    <p><?php echo $data['description'];?></p>
    <strong><?php echo $data['create'];?></strong>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>