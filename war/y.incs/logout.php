<?php
//session_destroy();

if(class_exists('Redirect')) {
	if(class_exists('Users')) Users::logout();
	else session_destroy();
	Redirect::setUrl($_SERVER['PHP_SELF'],true);
}