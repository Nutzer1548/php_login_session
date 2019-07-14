<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<?php $plsi=@require_once('pls/interface.php'); ?>
<!doctype html>
<html><head><title>PhP-Login-Session</title>
<meta charset="UTF-8"/>
<link rel="stylesheet" type="text/css" href="main.css"/>
</head><body>

<h1>PhP-Login-Session</h1>



<div id="pls_status"><?php @include('status.php'); ?></div>
<?php
	if($_SESSION['error']!==null) echo '<div class="warning"><span>Error:</span> '.$_SESSION['error'].'</div>';
?>


</body></html>
