<?php
$user=getInfo('username');
LogOut($user);
unset($user);
die();
?>