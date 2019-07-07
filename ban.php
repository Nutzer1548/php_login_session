<!doctype html>
<html><head><title>Ban-Email</title>
<meta charset="UTF-8"/>
<link rel="stylesheet" type="text/css" href="main.css"/>
</head><body>

<h1>Ban-Email</h1>

<div>
<?php
	$act=@require('pls/block_email.php');
	if($act===false){
		die('ERROR in block-script. Please contact admin.');
	}
	if($act['ok']===true){
		echo 'Ban successful! Your email adress is now block in our system. Sorry for the inconvenience you have experienced.';
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
