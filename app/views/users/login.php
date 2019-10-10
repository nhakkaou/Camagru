<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar_register.php'; ?>
<?php if (!empty($_SESSION['user_name'])) echo '<script>window.location.replace("http://localhost/Camagru/Posts/index");</script>' ?>
<div class="bbody"><br>
  <h2>Camagru</h2><br><br><br>
    <form class="box1 col-md-6" method="POST" action="<?php echo URLROOT; ?>/users/login" style="margin: 0 auto;">
        <?php flash('register_success'); ?>
        <h1>Login</h1>
        <input type="text" name="username" placeholder="Username" class="form-control form-control-lg <?php echo(!empty($data['name_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name'];?>"/>
          <span class="invalid-feedback"><?php echo $data['name_error']; ?></span>
        <input type="password" name="password" placeholder="password" class="form-control form-control-lg <?php echo(!empty($data['pass_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['pass'];?>"/>
          <span class="invalid-feedback"><?php echo $data['pass_error']; ?></span>
        <input type="submit" name="submit" value="login"/>
        <p>Inscrivez-vous pour voir les photos et vidéos de vos amis.<a href="<?php echo URLROOT; ?>/users/register">Sign up</a></p>
        <a href="<?php echo URLROOT;?>/users/forget_pass">compte oubliées ?</a>
    </form>

<?php require APPROOT . '/views/inc/footer.php'; ?>
<!--class="animated shake"-->