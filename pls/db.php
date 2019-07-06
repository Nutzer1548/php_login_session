<?php
/* creates a conenction to the mysql server and leaves it open as $sql */
// TODO: in case of error: let noone see conenction details
@require_once('db_config.php');


// connect to mysql server
$sql=new mysqli($db_host, $db_user, $db_pass, $db_db);
if($sql===null) die('ERROR: no database');
if($sql->connect_error){
	die('connect error ('.$sql->connect_errno.') '.$sql->connect_error);
}

?>
