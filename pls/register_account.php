<?php
/* creates an new (unactivated) account

input:
	$_POST['login_reg']: (needs to be set/existent)
	$_POST['email']: email-adress of new user
	$_POST['password']: unhashed password
output/return-array:
	['ok']: true if registered (still needs to be activated)
	['error']: null if everything is ok, otherwise an error-message

*/

@require_once('session.php');
@require_once('db.php');

function register_account(){
	global $sql;
	//require('config.php');
	global $PLS;
	$ret['ok']=false;
	$ret['error']=null;

	if(!isset($_POST['login_reg'])) return $ret;

	if(!isset($_POST['email']) || !isset($_POST['password'])){
		$ret['error']='email and password needed!';
		return $ret;
	}

	$email=$sql->escape_string($_POST['email']);
	$password=password_hash($_POST['password'], PASSWORD_DEFAULT);
	$password=$sql->escape_string($password);
	//$password=$sql->escape_string($_POST['password']);
	

	// already registered?
	$result=$sql->query('select id from users where login_email="'.$email.'";');
	if(!is_object($result)){
		$ret['errorr']=$PLS['error']['db_unexpected'];
		return $ret;
	}
	$num_rows=$result->num_rows;
	$result->free();
	if($num_rows!=0){
		$ret['error']=$PLS['error']['register_email_in_use'];
		return $ret;
	}

	// banned?
	$result=$sql->query('select email from blocked_email where email="'.$email.'";');
	if(!is_object($result)){
		$ret['error']=$PLS['error']['db_unexpected'];
		return $ret;
	}
	$num_rows=$result->num_rows;
	$result->free();
	if($num_rows!=0){
		$ret['error']=$PLS['error']['register_email_ban'];
		return $ret;
	}

	// create user
	$q='insert into users (login_email, login_pass, register_date, flags) values ("'.$email.'", "'.$password.'", curdate(), 0);';
	$result=$sql->query($q);
	if($result!==true){
		$ret['error']=$PLS['error']['register_cant_create'];
		return $ret;
	}
	$user_id=$sql->insert_id;

	// create activation task
	$verify_string=base64_encode(random_bytes(30));
	$verify_string=str_replace(array('+','/','='), array('-','_',''), $verify_string); // mask for url-usage
	$activate_key=$verify_string;
	$verify_string=$sql->escape_string($verify_string);
	$result=$sql->query('insert into task_activate_user (user_id, verify_string) values ('.$user_id.', "'.$verify_string.'")');
	if($result!==true){
		$ret['error']=$PLS['error']['register_cant_task'];
		return $ret;
	}

	// succcessful regitered, waiting for activation
	$ret['ok']=true;

	// send email with activation-link+
	// todo: build a template for this.
	//include('config.php');
include('config.php');
	$to=$email; // <- is sql-escaped, but that's not bad. valid emails will not be altered by sql-escape// $_POST['email'];
	$subject='Welcome. Verify your account.';

	$token='?key='.urlencode($activate_key).'&email='.urlencode($_POST['email']);
	$link_activate=$PLS['page']['activate'].$token;
	$link_ban=$PLS['page']['ban'].$token;

	$message=file_get_contents($PLS['mail_registration']);
	$message=str_replace(
		array('{link_activate}', '{link_ban}'),
		array( $link_activate,    $link_ban),
		$message);
	$pos=strpos($message,"\n");
	if($pos!==false){
		$subject=substr($message,0,$pos);
		$message=substr($message,$pos+1);
	}

	if(false===mail($to, $subject, $message)){
		$ret['error']=$PLS['error']['register_email_send'];
		return $ret;
	}





	return $ret;
}
return register_account();


?>
