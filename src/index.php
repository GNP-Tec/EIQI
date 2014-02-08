<?php
	require_once("inc/hs_core.php"); //Include Core-File for basic
	$hs=New hs_core;
	$hs->init();
	if($hs->is_auth()) {
		if(isset($_GET['logout'])) {
			$hs->logout();
		}
	} else {
		if(isset($_POST["username"])) {
			if($hs->login($_POST["username"],$_POST["password"])) {
				echo "<script type=text/javascript>alert(\"User and Password combination is wrong!\")</script>";
			}
		}
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
  <title>Enhanced Integrated QEMU Interface</title>
  <meta name="description" content="EIQI" />
  <meta name="keywords" content="gnp;net;tec;eiqi;qemu;php;mysql" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/image_slide.js"></script>
</head>

<body>
  <div id="main">
    <div id="header">
	  <div id="banner">
	    <div id="welcome">
	      <h1>E-i-Q-i</h1>
	    </div><!--close welcome-->
	    <div id="welcome_slogan">
	      <h1>Enhanced integrated QEMU (Web)interface</h1>
	    </div><!--close welcome_slogan-->
	  </div><!--close banner-->
    </div><!--close header-->

	<div id="menubar">
      <ul id="menu">
	
        <li <?php if(!isset($_POST['p']) || $_POST['p']="") { echo "class=\"current\""; } ?>><a href="index.php">Home</a></li>
      </ul>
    </div><!--close menubar-->	
    
	<div id="site_content">	
	<div class="sidebar_container"> 	
	<?php
	if($hs->is_auth()) {
	?>
		<div class="sidebar">
          <div class="sidebar_item">
            <h2>Welcome!</h2>
	<?php
		echo "Hello, ".$hs->get_title()." ".$hs->get_first_name()." ".$hs->get_last_name()."!<br>Login Time: ".$hs->get_last_login()."<br>";
	?>
	<a href="index.php?logout">Logout</a>
		  </div><!--close sidebar_item--> 
        </div><!--close sidebar--> 
	<div class="sidebar">
          <div class="sidebar_item">
            <h2>Latest Events</h2>
            <h3>VM-Started</h3>
            <p>Test-VM started</p>         
		  </div><!--close sidebar_item--> 
        </div><!--close sidebar--> 		
	<?php
	} else {
	?>
	<div class="sidebar">
        <div class="sidebar_item">
        <h2>Login</h2>
	<form action="index.php" method="post">
	Username: <input type="text" name="username" /><br>
	Password: <input type="password" name="password" /><br>
	<input type="submit" value="Login!"/>
	</form>
	</div><!--close sidebar_item--> 
        </div><!--close sidebar-->
	<?php
	}
	?>
       </div><!--close sidebar_container-->	
	
      <!--<ul class="slideshow">
        <li class="show"><img width="680" height="250" src="images/home_1.jpg" alt="&quot;Enter your caption here&quot;" /></li>
        <li><img width="680" height="250" src="images/home_2.jpg" alt="&quot;Enter your caption here&quot;" /></li>
      </ul> -->   	 
	 
	  <div id="content">
        <div class="content_item">
		  <h1>Welcome To Your Website</h1> 
	      <p>This standards compliant, simple, fixed width website template is released as an 'open source' design (under the Creative Commons Attribution 3.0 Licence), which means that you are free to download and use it for anything you want (including modifying and amending it). If you wish to remove the &lsquo;ARaynorDesign&rsquo; link in the footer of the template, please contact me first, but other than that...</p>
		  
		  <div class="content_image">
		    <img src="images/content_image1.jpg" alt="image1"/>
	      </div>
		  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque cursus tempor enim. Aliquam facilisis neque non nunc posuere eget volutpat metus tincidunt.</p>
		  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque cursus tempor enim.</p>
		  <br style="clear:both"/>
		  
		  <div class="content_container">
		    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque cursus tempor enim. Aliquam facilisis neque non nunc posuere eget volutpat metus tincidunt.</p>
		  	<div class="button_small">
		      <a href="#">Read more</a>
		    </div><!--close button_small-->
		  </div><!--close content_container-->
          <div class="content_container">
		    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque cursus tempor enim. Aliquam facilisis neque non nunc posuere eget volutpat metus tincidunt.</p>          
		  	<div class="button_small">
		      <a href="#">Read more</a>
		    </div><!--close button_small-->		  
		  </div><!--close content_container-->			  
		</div><!--close content_item-->
      </div><!--close content-->   
	</div><!--close site_content--> 
    
	<div id="content_grey">
	  <div class="content_grey_container_box">
		<h4>Latest Blog Post</h4>
	    <p> Phasellus laoreet feugiat risus. Ut tincidunt, ante vel fermentum iaculis.</p>
		<div class="readmore">
		  <a href="#">Read more</a>
		</div><!--close readmore-->
	  </div><!--close content_grey_container_box-->
      <div class="content_grey_container_box">
       <h4>Latest News</h4>
	    <p> Phasellus laoreet feugiat risus. Ut tincidunt, ante vel fermentum iaculis.</p>
	    <div class="readmore">
		  <a href="#">Read more</a>
		</div><!--close readmore-->
	  </div><!--close content_grey_container_box-->
      <div class="content_grey_container_boxl">
		<h4>Latest Projects</h4>
	    <p> Phasellus laoreet feugiat risus. Ut tincidunt, ante vel fermentum iaculis.</p>
	    <div class="readmore">
		  <a href="#">Read more</a>
		</div><!--close readmore-->	  
	  </div><!--close content_grey_container_box1-->      
	  <br style="clear:both"/>
    </div><!--close content_grey-->   
 
  </div><!--close main-->
  
  <div id="footer">
	  <a href="http://validator.w3.org/check?uri=referer">Valid XHTML</a> | <a href="http://fotogrph.com/">Images</a> | website template by <a href="http://www.araynordesign.co.uk">ARaynorDesign</a> | <?php $hs->end(); //Disconnects from DB, unloads values ?>
  </div><!--close footer-->  
  
</body>
</html>
