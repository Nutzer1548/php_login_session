Login Status: <?php
@require_once('session.php');
if(!$PLS['logged_in']){
	echo 'nicht eingelogged!<br/>';
	if($PLS['error']!==null) echo '<b>Fehler: '.$PLS['error'].'</b>';
	@include('login_form.php');
}else{
	//echo 'login-versuch unternommen für '.$PLS['logged_in'];
	echo 'eingelogged als '.$PLS['user_name'].'!<br/>';
	echo '<a href="?logout=logout">[ Abmelden ]</a>';
}
?>
