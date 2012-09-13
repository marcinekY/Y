<?php
class_exists('Users');
if(!Users::isLogin()){
	if($loginpage = Site::getActual()->getPageByName('login')){

		//	var_dump(Page::$instancesBy);
		//	var_dump($loginpage);
		$loginpage->setAsActual();
		
		
		class_exists('Render');
		$render = new Render(Site::getActual(), $loginpage);
		$render->parser = $smarty;
		$render->render();
		
		//var_dump($loginpage);
	}
}

if(URL::getVar('logout')){
	require INCSPATH.'logout.php';
}