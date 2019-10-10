<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>
<?php if (empty($_SESSION['user_name'])) echo '<script>window.location.replace("http://localhost/Camagru/users/login");</script>' ?>
<br><br>
<div class="container-profile">
    <div class="profile">
        <div class="profile-image">
        <img src="<?php echo $_SESSION['user_profile']?>">
        </div>
        <div class="profile-user-settings">
            <h1 class="profile-user-name"><?php echo $_SESSION['user_name'];?></h1>
           
            <button onclick="location.href='<?php echo URLROOT;?>/users/edit' " class="btn btn-outline-light">Edit Profile</button><br>
             <form action="<?php echo URLROOT; ?>/users/change_profile_pic" method="post">
            <input type="file" name="file" class="btn btn-outline-light" style="width:50%;" accept="image/*"/>
            <button class="btn btn-outline-primary" type="submit" name="submit">Save</button>
            </form>
        </div>
        <div class="profile-stat-count">
        <ul>
            <li><span class="profile-stat-count"><?php echo $_SESSION['nb_post'];?></span> posts</li>    
        </ul>
        </div>
    </div>
</div>
<main>
<div class="container-profile">
<div class="gallery">
    
            <!------------here--->
               <?php if (!empty($data)) :?>
          <?php foreach($data as $post) : ?>
        <div class="gallery-item" tabindex="0">
            <img src="<?php echo $post->pic; ?>" class="image-fluid">
                <div class="gallery-item-type">
                  <?php $t = str_replace("../", "", $post->pic);
                    echo "<i class = 'fab fa-twitter' style='font-size:22px; padding:10px;color:black;' data-url = 'https://twitter.com/share?url=URLENCODED&text=voir cette photo camagru de @".$_SESSION['user_name']." :  http://localhost/Camagru/".$t."' name ='sharet'></i>";?>
                    <i class="fas fa-trash" style="padding:5px; font-size:20px; color: black;" data-imgid="<?php echo $post->id_img; ?>" name="del_img"></i>
                </div>
            </div><br>
            <?php endforeach; ?>
            <?php endif;?>
            <!------------End--->
            


</div>
</div>
</main>
<script>
   var dels = document.getElementsByName("del_img");
   for (var i=0; i < dels.length; i++) {
       dels[i].onclick = function (event) {
           var conf = confirm("Do you really want to delete this image");
           if (conf == true) {
               var imgid = (event.target && event.target.getAttribute('data-imgid'));
               var xhttp = new XMLHttpRequest();
               var params = "imgid=" + imgid;
               xhttp.open('POST', 'http://localhost/Camagru/Posts/delete');
               xhttp.withCredentials = true;
               xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
               xhttp.onreadystatechange = function () {
                   if (this.readyState == 4 && this.status == 200) {
                       location.reload();
                   }
               }
               xhttp.send(params);
           }
       }

   }
    
    var sharet = document.getElementsByName("sharet");
    for (var j= 0; j < sharet.length; j++)
   {
     sharet[j].onclick = function(event) {
         var url = event.target.getAttribute("data-url");
         window.open(url,'scrollbars=yes');
     }
   }
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>