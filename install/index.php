<?php
error_reporting(0);
// Configuration
@include('../config.php');
@include('../settings.php');

$settings['config_site_dir'] = str_replace("/install","",dirname($_SERVER['PHP_SELF']));	
$settings['config_site_url'] = "http://".$_SERVER['HTTP_HOST'].$settings['config_site_dir'];	
$settings['config_site_title'] = 'AjaxMint Gallery';
$config['hostname'] = 'localhost';
$config['username'] = 'root';
$config['database'] = 'ajgallery';	
$config['password'] = '';
$config['prefix'] = 'aj_';

function dbcheck($host,$user,$pass,$db) {
	$rt = false;
	$link = @mysql_connect($host,$user,$pass);
	if($link)
	   $rt = @mysql_select_db($db,$link);			

        return $rt;  

}	
if($_SERVER['REQUEST_METHOD'] == 'POST') {

	if(!is_writable('../config.php') || !is_writable('../settings.php'))  {
		$error = 'Please give writable permission for config.php & settings.php';
	}

	if($_POST['settings'] && $_POST['config'] && !$error) {
		$settings = $_POST['settings'];
		$config = $_POST['config'];				

		if(!dbcheck($config['hostname'],$config['username'],$config['password'],$config['database'])) {
			$error = 'Please Check the Databse Settings';
		} else {

			//Exectuing mysql
			include("execute.php");
			
			//writig config file
$configContent = '<?php
define("DB_DRIVER", "mysql");
define("DB_HOSTNAME", "'.$config['hostname'].'");
define("DB_USERNAME", "'.$config['username'].'");
define("DB_PASSWORD", "'.$config['password'].'");
define("DB_DATABASE", "'.$config['database'].'");
define("DB_PREFIX", "'.$config['prefix'].'");';

			$fp = fopen('../config.php', 'w');
			fwrite($fp, $configContent);		
			fclose($fp);
			//writing config file ends here			
			
			//inserting the setting fields to database
			foreach($settings as $key=>$value) {
				$result = mysql_query("UPDATE ".$config['prefix']."setting SET 
						value='".$value."'
						WHERE				
						flag='".$key."';							
					");
			}		
			/* update favicon and logo values*/
			mysql_query("UPDATE ".$config['prefix']."setting SET 
					    value='".$settings[config_site_url]."/pictures/logo.jpg'
						WHERE				
						flag='config_logo';							
					");					
			mysql_query("UPDATE ".$config['prefix']."setting SET 
						value='".$settings[config_site_url].'/pictures/favicon.ico'."'
						WHERE				
						flag='config_icon';							
					");			
			
			//writig settings file
			$result = mysql_query("SELECT * FROM 
					".$config['prefix']."setting
					");
					

			$content = "<?php \n ";					
			while($value=mysql_fetch_assoc($result)) {
			$content .= '
$settings["'.$value['flag'].'"]  = "'.$value['value'].'";';				
			}
			$fp = fopen('../settings.php', 'w');
			fwrite($fp, $content);		
			fclose($fp);			
//writig settings ends here 		
			header("location:?");		
			
			
		}
	}
	
}


if(defined('DB_DRIVER') || defined('DB_HOSTNAME')|| defined('DB_USERNAME')|| defined('DB_PASSWORD')|| defined('DB_DATABASE') ) {
	if(dbcheck(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE)) {	
		die("Installation Completed..Please rename the directory <a href='../'>click here to see the gallery</a>");	
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="" lang="en" xml:lang="en">
<head>
<title>AjaxMint Gallery Installation</title>
<meta name="description" content="descr" />
<style type="text/css">
<!--
body {
	background-image: url(images/hdrbg.jpg);
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-repeat: repeat-x;
}
.table{
	background-color:#000000;
}
.table td{
	background-color:#CCCCCC;
}	
-->
</style>

<script type="text/javascript" src="/gallery2/apanel/view/default///js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="/gallery2/apanel/view/default///js/custom.js"></script>
</head>

<body style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;margin-top:0;padding-top:0">
<div align='center'>
<div style="height:90px; margin-top:2px"><img src="../pictures/logo.jpg" border="0" /></div>
<form action="" method="post" >
<table border="0" cellpadding="5" cellspacing="1" class="table">
<tbody><tr><td colspan="6" class="admin" align="left">
		<b>AjaxMint Gallery Installation </b><br>
</td></tr>

<?php if($error): ?><tr><td align="center" colspan="2"><font color="#FF0000"><?php echo $error; ?></font></td></tr> <? endif; ?>

<tr><td align="left" colspan="2"><b>Database Settings</b></td></tr>

<tr><td width="300">Database Hostname:</td><td>
<input name="config[hostname]" id="hostname" value="<?php echo $config['hostname']; ?>" size="47" type="text">
</td></tr>

<tr><td width="300">Database Username:</td><td>
<input name="config[username]" id="username" value="<?php echo $config['username']; ?>" size="47" type="text">
</td></tr>
<tr><td width="300">Database Password:</td><td>
<input name="config[password]" id="password" value="<?php echo $config['password']; ?>" size="47" type="text">
</td></tr>
<tr><td width="300">Database Name:</td><td>
<input name="config[database]" id="database" value="<?php echo $config['database']; ?>" size="47" type="text">
</td></tr>
<tr><td width="300">Table Prefix:</td><td>
<input name="config[prefix]" id="prefix" value="<?php echo $config['prefix']; ?>" size="47" type="text">
</td></tr>

<tr><td align="left" colspan="2"><b>System Settings</b></td></tr>
<tr><td width="300">Website Title:</td><td>
<input name="settings[config_site_title]" id="config_site_title" value="<?php echo $settings['config_site_title']; ?>" size="47" type="text">
</td></tr>
<tr><td width="300">Website URL:</td><td>
<input name="settings[config_site_url]" id="config_site_host" value="<?php echo $settings['config_site_url']; ?>" size="47" type="text">
</td></tr>

<tr><td colspan="2" align="center"><input value="Install" class="button" type="submit"></td></tr>
</tbody>
</table>
</form>

</div>
</body>
</html>
