<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	
<style>
   .animation{
	margin-left: -15%;
	/* animation-name: call;
  animation-duration: 10s;
  animation-iteration-count: 100; */
  color:#fff;
   }
   @keyframes call {
  /* 0%   {background-color: red;}
  25%  {background-color: yellow;}
  50%  {background-color: blue;}
  100% {background-color: green;} 
  0%   {background-color: blue;}*/
}
.img{
	margin-left: -5%;
}

@media screen and (max-width:576px){
	.call{
width: 50% !important;
	}
}
</style>
</head>
<body>

	<div class="call">
		<h4 class="animation" style="background-color:blue;">For Booking Call Now </h4>
<a href="tel:+919834396919" target="_blank"><img src="phone.png" alt="" height="60px" class="img"></a>
<!-- <b><p class="p" style="position:fixed;top:94%;left:84%;z-index:2;color:#fff;width:15%;background-color:#000;height:8vh;text-align:center;border-radius:5px;cursor:pointer;" onclick="msgbox()" id="msgbox">Send Message</p></b>

<div class="msgbox p-3" id="box" style="display: none;background:#fff;width:30%;position:fixed;z-index:2;left:69%;top:13%;border-radius:5px;box-shadow:0 0 8px 0 rgba(0,0,0,0.3);">
				<div align="right">
			  <span style="width: 5px;cursor:pointer;" id="close" onclick="close();">X</span>
			  </div>
			   <h3 class="text-center">Send Message</h3> 
 <hr style="background-color:red;">
 <form action="send_mail.php" method="post">
				Name: <br><input type="text" name="name"  class="form-control">
				Email: <br><input type="email" name="email" class="form-control">
				Message:<br> <textarea name="message" id=""  rows="5" class="form-control"></textarea>
                Phone:<br><input type="tel" name="mobile" class="form-control">
				<button type="submit" class="btn btn-success mt-2 col-md-12">Submit <img src="message.png" alt="" height="18px" style="  filter: invert(100%);">
</button>
</form>
			  </div> -->
    </div>
	

              <script>
	function msgbox(){
		var msgbox=document.getElementById('msgbox');
	    document.getElementById('box').style.display="block";		
	}

	var close=document.getElementById('close');
	close.onclick=function(){
	document.getElementById('box').style.display="none";
	}
  </script>
  
</body>
</html>