<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar_log.php';?>
<?php if (!empty($_SESSION['user_name'])) echo '<script>window.location.replace("http://localhost/Camagru/Posts/index");</script>'; ?>
<body>
<div class="bbody"><br>
<h2>Camagru</h2><br><br><br>
         
    <form class="box2 col-md-6" action="<?php echo URLROOT; ?>/users/register" method="POST" style="margin: 0 auto;">
            
        <h1>Sign up</h1><br>

        <input type="text" placeholder="Username" id="name" name="User" class="form-control form-control-lg <?php echo(!empty($data['name_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name'];?>"/>
        <span class="invalid-feedback"><?php echo $data['name_error']; ?></span><br>
        <input type="password" placeholder="Password" id="passw" name="Pass" class="form-control form-control-lg <?php echo(!empty($data['pass_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['pass'];?>">
        <span class="invalid-feedback"><?php echo $data['pass_error']; ?></span><br>
        <input class="form-control form-control-lg <?php echo(!empty($data['email_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email'];?>" type="email" placeholder="Mail" id="mail" name="Mail" />
        <span class="invalid-feedback"><?php echo $data['email_error']; ?></span><br>
        <input class="form-control form-control-lg <?php echo(!empty($data['date_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['date'];?>" type="date" id="date" name="date" />
        <span class="invalid-feedback"><?php echo $data['date_error']; ?></span><br>
        <input type="submit" name="submit" value="Send"/>
        <a href="<?php echo URLROOT; ?>/users/login">Have an account? Login</a>
    </form>       

</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>