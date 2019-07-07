<?php
/* expects an activation/verification-key in $_GET['key'] and the email-address to block in $_GET['email']
input:
	$_GET['key']: the verification key
	$_GET['email']: the email-address to block
output/return-array:
	['ok']: true, if banned
	['error']: null, if no error occured. An error message otherwise.

*/

@require_once('db.php');

function block_email(){
	global $sql;
	$ret['ok']=false;
	$ret['error']=null;

	if(!isset($_GET['key'])) return $ret;
	if(!isset($_GET['email'])) return $ret;



	$key=@$_GET['key'];
	$email=@$_GET['email'];

	$q='select t.id as t_id, t.user_id, t.verify_string, u.id as u_id, u.login_email from task_activate_user as t join users as u on t.user_id=u.id where t.verify_string="'.$sql->escape_string($key).'" and u.login_email="'.$sql->escape_string($email).'" and u.flags&0x01=0;';
	$result=$sql->query($q);

	if(!is_object($result)){
		$ret['error']='Unexpected database result. Please contact admin.';//.$sql->error;
		return $ret;
	}

	if($result->num_rows==0){
		$ret['error']='Nothing to ban. Possibillities: 1) already baned/activated, 2) never registered.';//.$result->num_rows.'<hr/>'.$q;
		$result->free();
		return $ret;
	}

	if($result->num_rows!=1){
		$ret['error']='To many entries found. Please contact administrator.';
		$result->free();
		return $ret;
	}

	$row=$result->fetch_assoc();
	$result->free();
	if($row['verify_string']!==$key && $row['login_email']){// invalid key/email
		$ret['error']='Key or email doesn\'t match.';
		return $ret;
	}

	// key and mail are valid
	// |- 1. block/ban email
	$result_user=$sql->query('insert into blocked_email (email, added_date) values ("'.$sql->escape_string($email).'", curdate());');
	if($result_user===false){
		$ret['error']='Unable to block account. This is a database problem, please contact admin.';
		return $ret;
	}
	$ret['ok']=true;
	// |- 2. delete account
	$result_user=$sql->query('delete from users where id='.$row['u_id'].';');
	if($result_user===false){
		$ret['error']='Unable to delete account. This is a database problem, please contact admin.';
		return $ret;
	}
	$ret['ok']=true;
	// '- 3. delete task
	$result_task=$sql->query('delete from task_activate_user where id='.$row['t_id'].';');
	if($result_task===false){
		$ret['error']='Couldn\'t remove activation task. Please contact admin.';
	}

	return $ret;
}// end #block_email()

return block_email();





?>
