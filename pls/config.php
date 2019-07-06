<?php
/* configuration for php_login_session.

Populates global array $PLS;

If you're paranoid (they know you are) set $PLS['homepage'] by yourself!
*/



$PLS['homepage']=(isset($_SERVER['REQUEST_SCHEME'])?$_SERVER['REQUEST_SCHEME']:(($_SERVER['SERVER_PORT']==443)?'https':'http')).'://'.$_SERVER['SERVER_NAME'].substr($_SERVER['SCRIPT_NAME'],0,strrpos($_SERVER['SCRIPT_NAME'],'/')+1);

$PLS['page']=array(
	'activate' => $PLS['homepage'].'activate.php',
	'ban'      => $PLS['homepage'].'ban.php',
	'register' => $PLS['homepage'].'register.php'
);

//print_r($_SERVER); print_r($PLS);

?>
