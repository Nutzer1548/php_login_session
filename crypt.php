<?php
// testfunction to generate and crypt() values

$pass=$_GET['word'];
$hash=password_hash($pass, PASSWORD_DEFAULT);
var_dump($hash);

?>
