<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>
<?php if (empty($_SESSION['user_name'])) echo '<script>window.location.replace("http://localhost/Camagru/users/login");</script>' ?>
<div class="card">
    <div class="row">
        <div class="col">
            <img src="" id='img_s' style="display:none; position:absolute;width:15%;height:15%"/>
        <video id="video" height="480" width="600"></video>
        <button id="chiiz" type="button" class="btn-outline-dark" disabled>Take Picture</button>
            
        
        <canvas name="canva" id="canva" height="480" width="600"></canvas>

            <input type="file" id="up_img" name="file" class="btn-outline-dark">

        <button id="clear" type="button" class="btn-outline-dark">Clear</button>
        <button id='capture' type="button" onclick="capture_pic()" class="btn-outline-success">Save Image</button>
        
        
    </div>
    <fieldset class='col1'>
        
        <div class="form-check">  <img src="<?php echo URLROOT;?>/clip-arts/logo0.png"/><input name='s' class="form-check-input" onclick='stick_live()' type="radio"  value='<?php echo URLROOT;?>/clip-arts/logo0.png'/></div><br><br>
         <div class="form-check">  <img src="<?php echo URLROOT;?>/clip-arts/logo1.png"/><input name='s' class="form-check-input" onclick='stick_live()' type="radio" value='<?php echo URLROOT;?>/clip-arts/logo1.png'/></div><br><br>
         <div class="form-check">  <img src="<?php echo URLROOT;?>/clip-arts/logo2.png"/><input name='s' class="form-check-input" onclick='stick_live()' type="radio" value='<?php echo URLROOT;?>/clip-arts/logo2.png'/></div><br><br>
         <div class="form-check">  <img src="<?php echo URLROOT;?>/clip-arts/logo4.png"/><input name='s' class="form-check-input" onclick='stick_live()' type="radio" value='<?php echo URLROOT;?>/clip-arts/logo4.png'/></div><br><br>
         <div class="form-check">  <img src="<?php echo URLROOT;?>/clip-arts/logo5.png"/><input name='s' class="form-check-input" onclick='stick_live()' type="radio" value='<?php echo URLROOT;?>/clip-arts/logo5.png'/></div><br><br>
    </fieldset>
        <br><br>
        <div class='col'>
        <div class="gallery"  style="overflow-y: scroll; height:800px; width: 250px;">
                <?php if(!empty($data)) : ?>
                <?php foreach($data as $post) : ?>
                <div class="gallery-item" tabindex="0">
                <input type="hidden" name="image_id" value="<?php echo $post->id_img;?>"/>
                <img type="image" src="<?=$post->pic?>" class="image-fluid"/>
                 <div class="gallery-item-type">
                  <?php $t = str_replace("../", "", $post->pic);
                    echo "<i class = 'fab fa-twitter' style='font-size:22px; padding:10px;color:black;' data-url = 'https://twitter.com/share?url=URLENCODED&text=voir cette photo camagru de @".$_SESSION['user_name']." :  http://localhost/Camagru/".$t."' name ='sharet'></i>";?>
                    <i class="fas fa-trash" style="padding:5px; font-size:20px; color: black;" data-imgid="<?php echo $post->id_img; ?>" name="del_img"></i>
                </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
            </div>
        </div>
</div> <br><br><br><br>
        
<script>
var canvasdata;
var sym = 0;
var s = 0;
var up = 0;
var ele = document.getElementsByName('s');
var cm = 0;
(function(){
	var video = document.getElementById('video'),
	canvas = document.getElementById('canva'),
	h = canvas.height,
	w = canvas.width,
	context = canvas.getContext('2d');

	   navigator.getMedia =    navigator.getUserMedia ||
		navigator.webkitGetUserMedia ||
		navigator.mozGetUserMedia ||
		navigator.msGetUserMedia;
	navigator.getMedia({
		video: true,
		audio: false
	}, function(stream){
        try {
               video.src = window.URL.createObjectURL(stream);
           } catch (error) {
                video.srcObject = stream;
           }
		video.play();
        cm = 1;
	}, function(error){
	});
	document.getElementById('chiiz').addEventListener('click', function(){
      
        var t = 0;
        for(i = 0; i < ele.length; i++) { 
        if(ele[i].checked) 
        {
            var stick = ele[i].value;
             t = 1;}
        }if(i == ele.length && t == 0)
        {   alert('chose Sticker first');
        return;
        }
        context.drawImage(video, 0, 0, w, h);
        sym = 1;
    canvasdata = canvas.toDataURL("image/png");
	}); 
    document.getElementById('clear').addEventListener('click', function(){
		context.clearRect(0, 0, w, h);
        sym = 0;
	});
   
})();
  
function capture_pic(){
    for(i = 0; i < ele.length; i++) { 
				if(ele[i].checked) 
                {
                    var stick = ele[i].value;
                }
    }
    var params = "imgBase64="+canvasdata+'&stick='+stick;
    var xhttp = new XMLHttpRequest();
    xhttp.open('POST', 'http://localhost/Camagru/Posts/take_pic');
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    if (up == 1)
    {
        up = 0;
        xhttp.send(params);  
    }
    if (sym == 1 && cm == 1)
    {
        sym = 0;
        xhttp.send(params);
    }
    setInterval(function(){ window.location.reload(); }, 50);
}


var imageLoader = document.getElementById('up_img');
imageLoader.addEventListener('change', handleImage, false);
var canvas = document.getElementById('canva');
var ctx = canvas.getContext('2d');

function isImage(file)
{
  const validImageTypes = ['image/jpg', 'image/jpeg', 'image/png'];
  const fileType = file['type'];
  if (validImageTypes.indexOf(fileType))
      return true;
  else
      return false;
}
/****************/

    
    
function handleImage(e){
    var reader = new FileReader();
        reader.onload = function(event){
        var img = new Image();
        h = canvas.height,
	    w = canvas.width;
        img.onload = function(){
            if (img == ''){
                alert('Picture!');
                return;}
            ctx.drawImage(img,0, 0, w, h);
            canvasdata = canvas.toDataURL("image/png");
            up = 1;
        }
        if (event.target.result !== 'data:')
            img.src = event.target.result;
    }
    if (e.target.files[0] && isImage(e.target.files[0]))
    {
        reader.readAsDataURL(e.target.files[0]);
    }    
}
    //////****stick live****/
   
    function stick_live(){
        var sticker;
        for(i = 0; i < ele.length; i++) { 
            if(ele[i].checked) 
            {
                var sticker = ele[i].value;
                document.getElementById('chiiz').disabled = false;   
            }
        }
        document.getElementById('img_s').style.display = 'block';
        document.getElementById('img_s').src = sticker;
    }
/**************Delete************/
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
    /*************share****/
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