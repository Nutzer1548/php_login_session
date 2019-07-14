<?php
/* configuration for php_login_session.

Populates global array $PLS;

If you're paranoid (they know you are) set $PLS['homepage'] by yourself!
*/


// 'homepage' => url of your mainpage
$PLS['homepage']=(isset($_SERVER['REQUEST_SCHEME'])?$_SERVER['REQUEST_SCHEME']:(($_SERVER['SERVER_PORT']==443)?'https':'http')).'://'.$_SERVER['SERVER_NAME'].substr($_SERVER['SCRIPT_NAME'],0,strrpos($_SERVER['SCRIPT_NAME'],'/')+1);

// 'page' => pages to redirect to. used in the registration mail
$PLS['page']=array(
	'activate' => $PLS['homepage'].'activate.php',
	'ban'      => $PLS['homepage'].'ban.php'
);

// 'mail_registration' => the file you may want to edit, to change
$PLS['mail_registration']=__DIR__.'/registration.mail';

// 'error' => error-messages the system may output and you may want to replace to match your language
$PLS['error']=array(
	'query' => 'Failed database query! Please contact the webmaster to fix this problem.',
	'db_unexpected' =>'Database shows unexpected behavier. Please contact the webmaster to fix this problem.',

	'login_failed' =>'Login attempt failed!',
	'login_not_activated' => 'Your account still needs to be activated. Please check your inbox or your spamfolder, you should have received an activation link.',

	'activation_nodo' => 'Nothing to activate. Possibly already activated or never registered.',
	'activation_keymail' => 'Key and/or email doesn\'t match.',
	'activation_verify' => 'Unable to verify account. This is a database problem, please contact the webmaster to fix this problem.',
	'activation_task' => 'Couldn\'t remove activation task. Please contact the webmaster to fix this problem.',

	'register_data_missing' => 'Email and password missing.',
	'register_email_in_use' => 'Email is already used. Can\'t create another account with it.',
	'register_email_ban' => 'Email is banned. Can\'t create account with it!',
	'register_email_send' => 'Couldn\'t send activation email. Please contact the webmaster to fix this problem.',
	'register_cant_create' => 'Couldn\'t create account. Try again later or contact the webmaster.',
	'register_cant_task' => 'Unable to create activation task. Please contact the webmaster to fix this problem.',

	'ban_nodo' => 'Nothing to ban. Possibly already banned or never registered.',
	'ban_keymail' => 'Key and/or email doesn\'t match.',
	'ban_verify' => 'Unable to ban email. This is a database problem, please contact the webmaster to fix this problem.',
	'ban_delete' => 'Unable to delete account. This is a database problem, please contact admin.',
	'ban_task' => 'Couldn\'t remove activation task. Please contact the webmaster to fix this problem.',

	'dummy' => null
);

//print_r($_SERVER); print_r($PLS);

?>
