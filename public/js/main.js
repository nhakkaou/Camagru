function like(event)
{
 if( !event ) event = window.event;
 var postid = (event.target && event.target.getAttribute('data-imgid'));
 var li = document.getElementById('like_'+postid);
 var userid = (event.target && event.target.getAttribute('data-userid'));
 var c = li.getAttribute('class');
 var user = document.getElementById('user');
 var sym = 0;
if (userid == "") {
   window.location.replace("http://localhost/Camagru/users/login");
   return ;
}

 var xhttp = new XMLHttpRequest();
 xhttp.open('POST', 'http://localhost/Camagru/Posts/add_like');

 if (event.target.className == "far fa-kiss-wink-heart")
 {
     event.target.className = "fas fa-kiss-wink-heart";
 }
 else if (event.target.className == "fas fa-kiss-wink-heart")
 {
     event.target.className = "far fa-kiss-wink-heart";
 }
 var params = "post_id=" + postid + "&c=" + c;
 xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 xhttp.send(params);
}