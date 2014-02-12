<?php
	require_once("inc/hp.php");
	$hp=new hp;

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
  <?php echo $hp->header_get(); ?>
  <title>EIQI - <?php echo $hp->title_get(); ?> </title>
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
	<?php echo $hp->menu_get(); ?>
      </ul>
    </div><!--close menubar-->	
    
	<div id="site_content">	
	<div class="sidebar_container"> 	
	<?php echo $hp->sidebar_get(); ?>
       </div><!--close sidebar_container-->	 
	 
	<div id="content">
	        <div class="content_item">
			 <?php echo $hp->content_get(); ?> 
		</div><!--close content_item-->
      </div><!--close content-->   
	</div><!--close site_content--> 

  </div><!--close main-->
  	<div id="content_grey">
	<?php echo $hp->southbar_get(); ?>
    </div><!--close content_grey--> 
  <div id="footer">
	website template by <a href="http://www.araynordesign.co.uk">ARaynorDesign</a> | <?php echo $hp->footer_get(); ?>
	Copyright 2014 <a href="http://www.gnp-tec.net/">GNP-Tec.net</a>
  </div><!--close footer-->  
  
</body>
</html>
