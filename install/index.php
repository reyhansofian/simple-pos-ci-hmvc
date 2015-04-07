<?php

error_reporting(0); //Setting this to E_ALL showed that that cause of not redirecting were few blank lines added in some php files.

$db_config_path = '../application/config/database.php';

// Only load the classes in case the user submitted the form
if($_POST) {

	// Load the classes and create the new objects
	require_once('includes/core_class.php');
	require_once('includes/database_class.php');

	$core = new Core();
	$database = new Database();


	// Validate the post data
	if($core->validate_post($_POST) == true)
	{

		// First create the database, then create tables, then write config file
		if($database->create_database($_POST) == false) {
			$message = $core->show_message('error',"The database could not be created, please verify your settings.");
		} else if ($database->create_tables($_POST) == false) {
			$message = $core->show_message('error',"The database tables could not be created, please verify your settings.");
		} else if ($core->write_config($_POST) == false) {
			$message = $core->show_message('error',"The database configuration file could not be written, please chmod application/config/database.php file to 777");
		}

		// If no errors, redirect to registration page
		if(!isset($message)) {
		  $redir = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
		  $redir .= "://".$_SERVER['HTTP_HOST'];
		  $redir .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
		  $redir = str_replace('install/','',$redir); 
			header( 'Location: ' . $redir . 'auth' ) ;
		}

	}
	else {
		$message = $core->show_message('error','Not all fields have been filled in correctly. The host, username, password, and database name are required.');
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<title>Install | POS - Reyhan Sofian Haqqi</title>

		<link rel="icon" href="../ico/favicon.png" />
		<link rel="shortcut icon" href="../ico/favicon.png" />
		<link rel="stylesheet" href="../fonts/DroidSans/font-face.css" type="text/css" />
		<link rel="stylesheet" href="../fonts/UbuntuCondensed/font-face.css" type="text/css" />
		<link rel="stylesheet" href="../css/login.css" type="text/css" />
		<link rel="stylesheet" href="../css/messages.css" type="text/css" />
	</head>
	
	
	
	<body>
    <?php if(is_writable($db_config_path)){?>

		  <?php if(isset($message)) {echo '<p class="error">' . $message . '</p>';}?>

	     <div id="login-container">
			<div id="login-box">
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<div class="info">
						 <strong>Perhatian!!!</strong>
						 Jika Anda menggunakan program ini secara online, harap membuat user untuk database di cpanel hosting Anda terlebih dahulu
					</div>
					
					<h1>Install POS - Reyhan Sofian Haqqi</h1>
					<input type="text" value="localhost" placeholder="Hostname.. Ex : 'localhost'" name="hostname" autocomplete="off" />
					<input type="text" placeholder="Username.. Ex : 'sa', 'root'" name="username" />
					<input type="text" autocomplete="off" placeholder="Password host.." name="password" />
					<input type="text" autocomplete="off" placeholder="Nama database.." name="database" />
					<input type="submit" value="Install" />
				</form>
			</div>
		</div>

	  <?php } else { ?>
      <div class="error">Please make the application/config/database.php file writable. <strong>Example</strong>:<br /><br /><code>chmod 777 application/config/database.php</code></div>
	  <?php } ?>
	</body>
</html>