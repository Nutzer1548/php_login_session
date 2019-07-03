<?php
/* creates a conenction to the mysql server and leaves it open as $sql */
// TODO: in case of error: let noone see conenction details
@require_once('db_config.php');


// connect to mysql server
$sql=new mysqli($db_host, $db_user, $db_pass, $db_db);
if($sql->connect_error){
	die('connect error ('.$sql->connect_errno.') '.$sql->connect_error);
}


//echo 'success: '.$sql->host_info."\n\n";

/*
$result=$sql->query('SELECT id, login_email from users;');
if($result===false){
	echo '$result is false'."\n";
}elseif($result===true){
	echo '$result is true'."\n";
}else{
	echo 'query returned '.$result->num_rows." rows\n";
	while(null!==($row=$result->fetch_assoc())){
		print_r($row);
	}
	$result->close();
}

$uname='anton@localhost';
$upass='123456';
$result=$sql->query('UPDATE users set login_last_date=curdate() where login_email="'.$sql->escape_string($uname).'" and login_pass="'.$sql->escape_string($upass).'";');
echo 'num_rows='.$result->num_rows."\n";
var_dump($result);
if($result!==false && $result!==true) $result->close();

$sql->close();
*/

?>
