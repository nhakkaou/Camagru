<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>


        <div class="col-md-6" style="margin:0 auto;">
        <div class="col-md-6" style="margin:20px auto;">
        <button type="button" class="btn btn-outline-dark" style="width: 80%;height: 100%;" onclick='location.href="<?php echo URLROOT;?>/users/take_pic";'>Add Post</a>
        </button>
        <br>
    
        </div><br>
            <br><br>
        <?php if (is_array($data['posts'])) : ?>
        <?php foreach($data['posts'] as $post): ?>
        <div class="postes card">
            <div class="compte">
                <div class="row">
                <div class="col">
                    <img src="<?php echo $post->profilepic; ?>"/>
                </div>
                <div class="col">
                    <label class="_name"><?php echo $post->name; ?></label>
                </div>
                <div class="col">
                    <label class="time"><?php echo $post->date_creat; ?></label>
                </div>
                </div>
            </div>
            <img src="<? echo $post->pic; ?>"/>
            <div class="cmnt_like">
               <? if (!empty($data['likes'])) : ?>
               <?php $l = false; foreach ($data['likes'] as $like) : ?>
                <?php if($like->img_id == $post->id_img && $like->user_id == $_SESSION['user_id']) : $l = TRUE;?>
                
                 <i class="fas fa-kiss-wink-heart" onclick="like(event)" name="kiss" style="cursor: pointer;" id="like_<?php echo $post->id_img;?>" data-imgid='<?php echo $post->id_img;?>' data-userid='<?php echo $_SESSION['user_id'];?>'></i>Like
                
                   
                <?php endif;?>
               <?php endforeach; ?>
                <?php endif;?>
                <?php if ($l == false):?>
               
                <i class="far fa-kiss-wink-heart" onclick="like(event)" name="kiss" style="cursor: pointer;" id="like_<?php echo $post->id_img;?>" data-imgid='<?php echo $post->id_img;?>' data-userid='<?php echo $_SESSION['user_id'];?>'></i>Like
                
                <?php endif;?>

               
                <i class="far fa-comments" onclick="add_div_cmnt()"></i>Comment
               
                <div id="cmnt" class="animated">
                    <div class="overflow-auto" style="height:40px;">
                <?php foreach($data['cmnts'] as $cmnt): ?>
                    <?php if($cmnt->img_id == $post->id_img) :?>
                
                        <strong><label class="cmnt_user"><?php echo $cmnt->cmt_name;?>:</label></strong>
                    <label class='comment'>
                        <?php echo htmlspecialchars($cmnt->Comment);?>
                    </label><br>
                
                    
                    <?php endif;?>
                <?php endforeach;?></div>
                <form action="<?php echo URLROOT; ?>/Posts/add_cmnt" method="POST">
                <input type="hidden" name="img_id" value="<?php echo $post->id_img;?>">
                <input type="hidden" name="page" value="<?php echo $_GET['page'];?>">
                <input  type="text" name="aj_cmnt" placeholder="Ajouter un commentaire.."/>
                <input type="submit" name='submit' class="my_btn" value='Add'>
                </form>
            </div>
            </div>
            
        </div><br><br><br><br><br><br>
            <?php endforeach; ?>
            <?php  else: ?>
            <? endif;?>
        <br><br>
    <div class="row">
        <div class="col"></div>
         <div class="col">
        <ul class="pagination pagination-lg">
            <?php for($i = 1; $i <= $data['total']; $i++) :?>
            <li class="page-item <?php echo($_GET['page'] == $i) ? 'disabled' : ''; ?>">
            <a class="page-link" href="<?php echo URLROOT.'/posts/home?page='.$i;?>"><?php echo $i;?></a>
            </li>
            <?php endfor;?>
        </ul>
            </div>
           <div class="col"></div>
    </div>
    </div>


<?php require APPROOT . '/views/inc/footer.php'; ?>