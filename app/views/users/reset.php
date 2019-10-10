<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>

    <div class="bbody"><br><br><br><br><br><br><br><br><br><br><br><br>
    <form class="box2 col-md-6"  method="POST" style="margin: 0 auto;">
          <input type="password" name="new_mt" placeholder="New password" class="form-control form-control-lg <?php echo(!empty($data['new_error'])) ? 'is-invalid' : ''; ?>" />
        <span class="invalid-feedback"><?php echo $data['new_error']; ?></span><br>
            <input type="password" name="new_cnf" placeholder="Confirm password" class="form-control form-control-lg <?php echo(!empty($data['cnf_error'])) ? 'is-invalid' : ''; ?>" />
        <span class="invalid-feedback"><?php echo $data['cnf_error']; ?></span><br>
        <input type="submit" name="submit" value='submit'/>
        </form>

<?php require APPROOT . '/views/inc/footer.php'; ?>