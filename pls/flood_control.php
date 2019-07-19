<?php
/* flood control
*/

@require_once(__DIR__.'/db.php');

return (function(){
	global $sql;
	$ret=false;

	
	$ip=@$_SERVER['REMOTE_ADDR'];
	// settings
	$hits_per_minute_allowed=30;


	// get data
	$q='select 0 as hits, curtime() as time union select hits, time from flood_control where ip ="'.$sql->escape_string($ip).'";';
//echo "DB: query='$q'\n";
	$result=$sql->query($q);

	if(gettype($result)!='object') die('Database-Error!');
	$row=$result->fetch_assoc();
	$dt_now=$row['time']; // datetime now
	$dt_last=$dt_now; // init last datetime with 'now'
	$hits=0; // init hits with 0

	if($result->num_rows>1){// previous entry existed
		$row=$result->fetch_assoc();
		$dt_last=$row['time']; // update last datetime
		$hits=$row['hits']; // update hits
	}
	$result->free();

//	if(!$result) print_r($sql->error_list); // todo: <-- remove output for production
	$hits++;

	// Seconds since last interaction
	$dt_diff=(new DateTime($dt_now))->getTimeStamp()-(new DateTime($dt_last))->getTimestamp();


	$del_hits=0; // init hits to delete
	$hits_per_minute=1; // init hits per minute

	// modify only if a) more hits than alllowed per minut, or b) more than a minute has passed
	if($hits>$hits_per_minute_allowed || $dt_diff>60){
		$del_hits=intval($hits_per_minute_allowed*$dt_diff/60.0);
		$hits-=$del_hits;
		if($del_hits==0) $dt_now=$dt_last;
	}else{
		$dt_now=$dt_last;
	}



	// write
	$q='replace into flood_control (ip, hits,time) values("'.$sql->escape_string($ip).'",'.$hits.', "'.$dt_now.'");';
//echo "query='$q'\n";
	$result=$sql->query($q);
//if(!$result) print_r($sql->error_list);

	// evaluate
	if($hits>$hits_per_minute_allowed){
		if($hits>=2*$hits_per_minute_allowed) die('flood protection.');
		sleep(3);
		$ret=true;
	}

	return $ret;
})();

?>
