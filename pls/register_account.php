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
		$ret['errorr']='database error, please contact admin.';
		return $ret;
	}
	$num_rows=$result->num_rows;
	$result->free();
	if($num_rows!=0){
		$ret['error']='Email is already used. Cant create another account with it.';
		return $ret;
	}

	// banned?
	$result=$sql->query('select email from blocked_email where email="'.$email.'";')
	if(!is_object($result)){
		$ret['error']='database error, please contact admin';
		return $ret;
	}
	$num_rows=$result->num_rows;
	$result->free();
	if($num_rows!=0){
		$ret['error']='Email is banned. Can\'t create account with it!';
		return $ret;
	}

	// create user
	$result=$sql->query('insert into users (login_email, login_pass, register_data, flags) values \
		("'.$email.'", "'.$password.', curdate(), 0");');
	if($result!==true){
		$ret['error']='Couldn\'t create account. Try again later or contact admin.';
		return $ret;
	}
	$user_id=$sql->insert_id;

	// create activation task
	$verify_string=base64_encode(random_bytes(30));
	$verify_string=str_replace(array('+','/','='), array('-','_',''), $verify_string); // mask for url-usage
	$verify_string=$sql->escape_string($verify_string);
	$result=$sql->query('insert into task_aactivate_user (user_id, verify_string) values ('.$user_id.', "'.$verify_string.'")');
	if($result!==true){
		$ret['error']='Unable to create activation task. Please contact admin.';
		return $ret;
	}

	// succcessful regitered, waiting for activation
	$ret['ok']=true;

	// send email with activation-link+
	// todo: build a template for this.
	$to=$email; // <- is sql-escaped, but that's not bad. valid emails will not be altered by sql-escape// $_POST['email'];
	$subject='Welcom. Verify your account.';
if(empty($_SERVER['REQUEST_SCHEME'])) $_SERVER['REQUEST_SCHEME']='http';
$uri=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/';
$link_activate=$uri.'activate.php';
$link_ban=$uri.'ban.php';
	$message="Welcome user,\n\nThanks for registering. To use your newly created account, you have to activate it, just by clicking this link:\n\n".$link_activate."\n\nYou havn't registerd? You can either ignore this mail oder let us lacklist your email-adress, so that you will never receive any more emails from us, by clicking the following link:\n\n".$link_ban.'\n\n';

	if(false===mail($to, $subject, $message)){
		$ret['error']='Couldn\'t send activation email. Please contact admin.';
		return $ret;
	}





	return $ret;
}
return register_account();


?>
