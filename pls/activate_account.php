<?php
/* expects an activation-key in $_GET['key'] to verify the email-address in $_GET['email']
input:
	$_GET['email']: the email-address to verify
	$_GET['key']: the verification key
output/return-array:
	['ok']: true, if activated
	['error']: null, if no error occured. An error message otherwise.

todo: when it's realy important to contact the admin, perhaps contact the admin automatically per email.
*/

function activate_account(){
	$ret['ok']=false;
	$ret['error']=null;

	if(!isset($_GET['key'])) return $ret;
	if(!isset($_GET['email'])) return $ret;


	@require_once('db.php');

	$key=@$_GET['key'];
	$email=@$_GET['email'];

	//$result=$sql->query('select t.id as t_id, t.user_id, t.verify_string, u.id as u_id, u.login_email from task_activate_user as t join users as u on t.user_id=u.id where t.verify_string="'.$sql->escape_string($key).'" and u.login_email="'.$sql->escape_string($email).'" and u.flags&0x01=0;');
	$q='select t.id as t_id, t.user_id, t.verify_string, u.id as u_id, u.login_email from task_activate_user as t join users as u on t.user_id=u.id where t.verify_string="'.$sql->escape_string($key).'" and u.login_email="'.$sql->escape_string($email).'" and u.flags&0x01=0;';
	$result=$sql->query($q);

	if(!is_object($result)){
		$ret['error']='Unexpected database result: '.$sql->error;
		return $ret;
	}

	if($result->num_rows==0){
		$ret['error']='nothing to activate. possibillities: 1) already activated, 2) never registered.'.$result->num_rows.'<hr/>'.$q;
		return $ret;
	}

	if($result->num_rows!=1){
		$ret['error']='To many entries found. Please contact administrator.';
		return $ret;
	}

	$row=$result->fetch_assoc();
	if($row['verify_string']!==$key && $row['login_email']){// invalid key/email
		$ret['error']='Key or email doesn\'t match.';
		return $ret;
	}
	$result->free();

	// key and mail are valid
	// |- 1. activate account
	$result_user=$sql->query('update users set flags=flags|0x01 where id='.$row['u_id'].';');
	if($result_user===false){
		$ret['error']='Unable to verify account. This is a database problem, please contact admin.';
		return $ret;
	}
	$ret['ok']=true;
	// '- 2. delete task
	$result_task=$sql->query('delete from task_activate_user where id='.$row['t_id'].';');
	if($result_task===false){
		$ret['error']='Couldn\'t remove activation task. Please contact admin.';
	}
	
	
	


	return $ret;
}

return activate_account();





?>
