<?php
if (isset($_COOKIE['user']))
	setcookie('user',,time()-3600);
else if (isset($_COOKIE['manager']))
	setcookie('manager',,time()-3600);
?>