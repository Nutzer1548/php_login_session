<?php
@require_once('session.php');

return (function(){
	$ret=array();

	$ret['logged_in']=$_SESSION['logged_in'];
	
//	$ret['session.php:']=gettype(session);
	$ret['error']=$_SESSION['error'];
	

	return $ret;
})();


?>
