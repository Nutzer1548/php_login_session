<!doctype html>
<html><head><title>Registration</title>
<meta charset="UTF-8"/>
<link rel="stylesheet" type="text/css" href="main.css"/>
</head><body>

<h1>Account-Registration</h1>

<div>
<?php
	$reg=@require('pls/register_account.php');
	if($reg===false){
		die('ERROR in registration-script. Please contact admin.');
	}
	if($reg['ok']===true){
		echo 'Thank you for your registration! You have received an email from us, with an activation link for your new account.';
	}else{
		if($reg['error']!==null)
		echo 'Your Registration failed.<br/><div class="warning"><span>ERROR:</span> '.$reg['error'].'</div>';
	}
?>
</div>

<div id="pls_status">
<?php
@include("status.php");
?>
</div>

</body></html>
