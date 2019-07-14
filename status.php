<?php
	@require_once('pls/session.php');
if(!$_SESSION['logged_in']){
//	echo 'nicht eingelogged!<br/>';
	@include('login_form.php');
}else{
	//echo 'login-versuch unternommen für '.$_SESSION['logged_in'];
	echo 'eingelogged als '.$_SESSION['user_name'].'! [id: '.$_SESSION['user_id'].']<br/>';
	echo '<a href="?logout=logout">[ Abmelden ]</a>';
}
?>
