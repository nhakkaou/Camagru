<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>
    
<section class="card col-md-6" style="margin:20px auto;" >
    <?php if (!empty($_SESSION['user_id'])) :?>
        <div class="editbar">
            <label>Choose what you want to edit</label>
            <form method="post" action="<?php echo URLROOT; ?>/users/edit"><br><br>
            <input class="form-control form-control-lg is-invalid" type="text" name="new_user" placeholder="Username"/>
            <span class="invalid-feedback"><?php echo $data['name_error']; ?></span><br><br>
            <input id="pass"type="password" class="form-control form-control-lg is-invalid" name="new_pass" placeholder="New Password"/>
            <span class="invalid-feedback"><?php echo $data['newpass_error']; ?></span><br><br>
            <input id="email" type="email" class="form-control form-control-lg is-invalid" name="new_email" Placeholder="Email"/>
            <span class="invalid-feedback"><?php echo $data['email_error']; ?></span><br><br>
            <input id="o_pass" type="password" class="form-control form-control-lg is-invalid" name="old_pass" placeholder="Current Password"/>
            <span class="invalid-feedback"><?php echo $data['oldpass_error']; ?></span><br><br>
            <input type="submit" class="btn btn-success" name="save" value="Save"/><br><br>
            <input type="checkbox" name="recieve" <?php if ($_SESSION['recieve'] == 1) echo "checked";?>/><label>  if you want to recieve notification in your mail.</label>
            </form>
    </div>
    <?php else :?>
    <?php echo '<script>window.location.replace("http://localhost/Camagru/users/login");</script>' ?>
    <?php endif;?>
</section>
<?php require APPROOT . '/views/inc/footer.php'; ?>