<?php
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

	header('Location: '.$uri);
	exit;
}

// die if not successful
if($s->get('start',false)===false) die('ERROR: session not startet!');

//if(false===$session['ok']) die('ERROR: session not startet!');

$PLS=[];
$PLS['logged_in']=false;
$PLS['error']=null;
$PLS['user_id']=-1;

if(isset($_SESSION['user_id'])){
	$PLS['logged_in']=true;
	$PLS['user_name']=$_SESSION['user_name'];
}else if(isset($_POST['login_check'])){
	// todo check user-data or login-data
	$user_name=@$_POST['login_name'];
	$user_pass=@$_POST['login_pass'];
	//$user_pass=password_hash($user_pas);
	
	$result=$sql->query('select id, login_email, login_pass, login_last_date from users where login_email="'.$sql->escape_string($user_name).'";');
	if($result===false) $PLS['error']='ERROR in db query ... please contact admin.';
	else if($result===true) $PLS['error']='ERROR, db shows unexpected behavier ... please contact admin.';
	else{
		$row=$result->fetch_assoc();
		//if($result->num_rows!=1){
		if($row===null){
			$password_ok=password_verify($user_pass, @$row['login_pass']); // to prevent timing attac to find $user_name
			$PLS['error']='login fehlgeschlagen';
		}else{
			$password_ok=password_verify($user_pass, @$row['login_pass']); // to prevent timing attac to find $user_name
			if(!$password_ok){
				$PLS['error']='login fehlgeschlagen';
			}else{
				$PLS['logged_in']=true;
				$PLS['user_name']=$row['login_email'];
				$PLS['login_last_date']=$row['login_last_date'];
				$PLS['user_id']=$row['id'];
				$sql->query('update users set login_last_date=curdate() where id='.$PLS['user_id'].';');
				$_SESSION['user_id']=$PLS['user_id'];
				$_SESSION['user_name']=$PLS['user_name'];
				$_SESSION['login_last_date']=$PLS['login_last_date'];
			}
		}
	}
}


// toto: do session stuf

// close session
$s->close();
unset($s);
?>
