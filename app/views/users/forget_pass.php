<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>
<?php if(empty($_SESSION['user_id'])):?>
<div class="fbody"><br><br><br><br><br><br><br><br><br><br><br><br>
<form class="box3 col-md-6" action="<?php echo URLROOT;?>/users/forget_pass" method="POST" >
    <div style="float:left;">Retrouvez votre compte</div>
    <hr width="100%" color="blue">
    <?php flash('register_success'); ?>
    <p>Veuillez saisir votre adresse e-mail pour rechercher votre compte.</p>
    <input name="email_recovery" type="email" class="form-control form-control-lg <?php echo(!empty($data['error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $_POST['email_recovery'];?>" placeholder="Email" />
    <span class="invalid-feedback"><?php echo $data['error']; ?></span><br>
    <div>
    <input type="submit" class="btn btn-primary" value="Recherche"/>
    <button type="button" onclick="location.href='<?php echo URLROOT;?>/users/login' " class="btn btn-secondary">Annuler</button>
    </div>
</form>
</div>
<?php endif;?>
<?php require APPROOT . '/views/inc/footer.php'; ?>