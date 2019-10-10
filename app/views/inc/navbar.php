<header>
<table style="width: 100%">
    <tr>
        <td> <label class="masthead">Camagru</label><a href="<?php echo URLROOT; ?>/posts/index"><i class="fas fa-camera-retro"></i></a></td>
        <?php if (isset($_SESSION[user_id])) : ?>
            <td><a href="<?php echo URLROOT; ?>/users/profile" ><i class="fas fa-user"></i></a></td>
            <td><label id='user' class="user_name"><?php echo $_SESSION['user_name'];?></label><a href="<?php echo URLROOT;?>/users/logout?token=<?php echo $_SESSION['token']?>"><i  class="fas fa-sign-out-alt"></i></a></td>
        <?php else : ?>
        <td></td>
        <td><label id='user' class="user_name"><?php echo $_SESSION['user_name'];?></label><a href="<?php echo URLROOT; ?>/users/login">sign in</a></td>
        <?php endif; ?>
    </tr>
</table>
</header>