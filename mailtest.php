<?php

var_dump(ini_get('sendmail_path'));

$to="root@localhost";
$subject='sorry, php-mailer';
$message="Just testing the php-mailer,\nsorry for that.\n\nend of mail";

$ret=mail($to, $subject, $message);
var_dump($ret);
if($ret===false){
	print_r(error_get_last());
}

?>
