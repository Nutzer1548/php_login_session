<!doctype html>
<html><head><title>Account-aActivation</title>
<meta charset="UTF-8"/>
<link rel="stylesheet" type="text/css" href="main.css"/>
</head><body>

<h1>Account-Aktivierung</h1>

<div>
<?php
	$act=@require('pls/activate_account.php');
	if($act===false){
		die('ERROR in activation-script. Please contact admin.');
	}
	if($act['ok']===true){
		echo 'Congratulations! Your account is now activated and ready to use.!<br/>Please use the login-form and log in with your login data.';
	}else{
		if($act['error']!==null)
		echo 'Your account couldn\'t be activated.<br/><div class="warning"><span>ERROR:</span> '.$act['error'].'</div>';
	}
?>
</div>

<div id="pls_status">
<?php
@include("status.php");
?>
</div>

</body></html>
