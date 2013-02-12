<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en" xml:lang="en">
<head>
<title><?php echo $title; ?></title>
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<base href="<?php echo $base; ?>" />
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="<?php echo $tpath; ?>/css/style.css" />
<style type="text/css">
<!--
body {
	background-image: url(<?php echo $tpath; ?>/images/hdrbg.jpg);
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-repeat: repeat-x;
}
-->
</style>

<script type="text/javascript" src="<?php echo $tpath; ?>/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo $tpath; ?>/js/custom.js"></script>
</head>
<body style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;margin-top:0;padding-top:0">
<div align='center'>


<table width="800" align="center" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td align="center" height="80px">
	
	<div style="float:right"><img src="<?php echo $tpath; ?>/images/apl.jpg" alt="Admin Panel" width="170" height="50" /></div></td>
  </tr>
<!--  <tr>
    <td height="30" align="center">&nbsp;</td>
  <tr>-->
    <td align="center" width="100%">		  
	 <table cellpadding="0" width="100%" cellspacing="0" align="center" border="0">
	   <tr>
	   <td align="center">
	   	   <h1><?php echo $title; ?> </h1>
	   </td>
	   </tr>
	   <tr>
	   <td>
	   	   

	   
       <?php if($showmenu): ?> 
	   <div id="tabsB">
           <ul>           
			<li><a href="index.php?c=home"><span>Home</span></a></li>
			<li><a href="index.php?c=gallery"><span>Gallery</span></a></li>
			<li><a href="index.php?c=albums"><span>Albums</span></a></li>			
			<li><a href="index.php?c=pictures"><span>Picture</span></a></li>
			<li><a href="index.php?c=settings"><span>Settings</span></a></li>
			<li><a href="index.php?c=users"><span>Account</span></a></li>
			<li><a href="index.php?c=login/logout"><span>Logout</span></a></li>
 			<li><a href="index.php?c=media"><span>Media Store <font color="red">(new)</font> </span></a></li>
           </ul>
	   </div>
	   <?php endif; ?>
	   </td></tr>
	   <tr><td style="padding-left:5px">
	   <?php echo $content;?> 		
	   </td></tr></table>
  </td>
  </tr>
  <tr><td align="right">
	
  </td>
  </tr>
</table>
</div>
</body>
</html>
