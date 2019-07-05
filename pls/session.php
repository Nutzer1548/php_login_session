<?php
/* initiates the session and logs user in and out. Should be the included first, bevor any output happend;

input:
	$_GET['logout']: if set, destroys the session and the session cookies; redirects to PHP_SELF without $_GET

return: populates $_SESSION with these fields:
	['logged_in']: true, if a user is logged in. false otherwise.
	['error']: null, if no error occured. An error message otherwise.
	['user_id']: the id (from table 'users') of the logged in user.
	['login_last_date']: date of last login as YYYY-MM-DD


*/
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);


//@require_once('db_config.php');
@require_once('db.php');

class Session{
	public static function instance(){
		static $inst=null;
		if($inst===null) $inst=new self;
		return $inst;
	}
	protected static $data;
	private function __construct(){
		$session_options=[
			'name' => 'pls_session',
		//	'cookie_lifetime' => 3600*24,
			'cookie_httponly' => true,
			'use_trans_sid' => false
		];
		self::$data['start']=@session_start($session_options);
	}
	private function __clone(){}

	public function get($key, $default=null){
		if(!isset(self::$data[$key])) return $default;
		return self::$data[$key];
	}

	public function close(){
		session_write_close();
	}

	
}// end Session */


// start session
$s=Session::instance();

// if $_GET['logout'], destroy session
if(isset($_GET['logout'])){
	$_SESSION=array();
	if(ini_get('session.use_cookies')){
		$params=session_get_cookie_params();
		setcookie(session_name(), '', time()-43200, $params['path'],
			$params['domain'], $params['secure'], $params['httponly']);
	}
	session_destroy();
	if(empty($_SERVER['REQUEST_SCHEME'])) $_SERVER['REQUEST_SCHEME']='http';
	$uri=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

	header('Location: '.$uri);// redirect
	exit;
}

// die if not successful
if($s->get('start',false)===false) die('ERROR: session not startet!');

$_SESSION['logged_in']=false;
$_SESSION['error']=null;

if(isset($_SESSION['user_id'])){
	$_SESSION['logged_in']=true;
	$_SESSION['user_name']=$_SESSION['user_name'];
}else if(isset($_POST['login_check'])){
	// todo check user-data or login-data
	$user_name=@$_POST['login_name'];
	$user_pass=@$_POST['login_pass'];
	//$user_pass=password_hash($user_pas);
	
	$result=$sql->query('select id, login_email, login_pass, login_last_date from users where login_email="'.$sql->escape_string($user_name).'";');
	if($result===false) $_SESSION['error']='ERROR in db query ... please contact admin.';
	else if($result===true) $_SESSION['error']='ERROR, db shows unexpected behavier ... please contact admin.';
	else{
		$row=$result->fetch_assoc();
		//if($result->num_rows!=1){
		if($row===null){
			$password_ok=password_verify($user_pass, @$row['login_pass']); // to prevent timing attac to find $user_name
			$_SESSION['error']='login fehlgeschlagen';
		}else{
			$password_ok=password_verify($user_pass, @$row['login_pass']); // to prevent timing attac to find $user_name
			if(!$password_ok){
				$_SESSION['error']='login fehlgeschlagen';
			}else{
				$_SESSION['logged_in']=true;
				$_SESSION['user_name']=$row['login_email'];
				$_SESSION['login_last_date']=$row['login_last_date'];
				$_SESSION['user_id']=$row['id'];
				$sql->query('update users set login_last_date=curdate() where id='.$_SESSION['user_id'].';');
			}
		}
	}
}


// toto: do session stuf

// close session
$s->close();
unset($s);
?>
