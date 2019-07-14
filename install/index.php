<?php
	$step=@$_POST['step'];
	if(empty($step)) $step=0;
	if($step==999){
		header('Location: ../');
		exit;
	}
	require_once('../pls/db.php'); // <- maybe adjust this path, if you have moved this folder around.
?><!doctype html>
<html><head><title>pls db installation</title>
<meta charset="UTF-8"/>
<style>
	.monitor{
		width:500px;
		margin:auto;
	}
	.script{
		height:100px;
		overflow:auto;
		white-space:pre;
		margin:0px -6px;
		padding:5px;
		border:1px solid #666;
		font:monospace;
		font-size:12px;
	}
</style>
</head><body>

<h1>php_login_session - database installation</h1>

<div class="monitor">
<form method="post" action="">
<?php

	if($step==0){
		echo 'Step 0:<br/>
			Click the [OK] button below, to reinstall the <i>pls</i> database.<br/>
			<br/>
			You <i>really</i> should delete this installation-folder after doing so, to prevent others from resetting your database.
			<br><br/>
			<input type="hidden" name="step" value="1"/>
		';
	}else if($step==1){
		$script=file_get_contents('db_table.sql');
		$script_queries=explode($script,';'); $query_count=0;
		echo 'Step 1:<br/>
			Inserting data:<br><div class="script">'.$script.'</div>
			<br/><br/>
			Result:<br/>
			<div class="script">';
		if(!$sql->multi_query($script)){
			echo '<br/>ERROR executing script!<br/>';
			echo 'code: '.$sql->errno.'<br/>error: '.$sql->error;
			exit;
		}
		while($sql->more_results()){
			$result=$sql->store_result();
			if($result===true) echo 'true<br/>';
			else if($result===false){
				if(!$sql->errno) echo 'OK<br/>';
				else echo 'error (#'.$sql->errno.'): '.$sql->error.'<br/>';
			}else{
				echo $result->num_rows.' rows affected<br/>';
				$result->free();
			}
			$sql->next_result();
			$query_count++;
		}//while($mysql->next_result());
		if($sql->errno){
			echo '<br/>+++ ERROR executing script!<br/>';
			echo 'code: '.$sql->errno.'<br/>error: '.$sql->error;
			exit;
		}
		echo '</div><br/><br/>
			<input type="hidden" name="step" value="999"/>
		';
	}

?>
<input type="submit" name="submit" value="OK">
</form>
</div>

</body></html>
