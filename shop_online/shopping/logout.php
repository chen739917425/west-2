<?php
if (isset($_COOKIE['user']))
{
	setcookie('user',0,time()-3600);
	header('location:homepage.php');
}	
else if (isset($_COOKIE['manager']))
{
	setcookie('manager',0,time()-3600);
	header('location:homepage.php');
}
header('location:homepage.php');	
?>