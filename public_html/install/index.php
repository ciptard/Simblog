<?php

DEFINE('IN_SITE',true);
include 'smarty/Smarty.class.php';
include '../../libs/Lite.php';

$smarty = new Smarty();
$smarty->setTemplateDir('templates');
$smarty->setCacheDir('templates_c');
$smarty->setCompileDir('templates_c');

if(!count($_POST)) {
	$smarty->assign('stage','stage1');
}
else {
	$port = ($_POST['port'] == "") ? '3306' : $_POST['port'];
	$db = mysql_connect($_POST['hostname'].':'.$port,$_POST['username'],$_POST['password']);
	$stage = 'success';
	if(!$db) {
		$stage = 'stage1';
		$smarty->assign("mysql_error",true);
		$smarty->assign("mysql_error_msg", "Could not connect to database server.");
	}
	else if(!mysql_select_db($_POST['database'])) {
		$stage = 'stage1';
		$smarty->assign("mysql_error",true);
		$smarty->assign("mysql_error_msg", mysql_error());
	}
	else {
		//TODO: execute SQL file
		/*It is very important that the sql file uses ';' as a delimiter
		  between statements. Other workaround would be to use shell exec.
		*/
		$sql = explode(';',file_get_contents("database.sql"));
		foreach ($sql as $query)
			mysql_query($query,$db);
	}
	
	if(is_writable(realpath(getcwd()."/../.."))) {
		$config_file = new Config_Lite(getcwd()."/../../global.conf");
		
		#General
		$config_file->set("General", "author_name", $_POST['author']);
		$config_file->set("General", "blog_title", $_POST['title']);
		$config_file->set("General", "email", $_POST['email']);
		$config_file->set("General", "install_plugin_default", isset($_POST['disabled_plugins']) ? "disabled" : "enabled");
		$config_file->set("General", "disable_plugins", false);
		
		#Database
		$config_file->set("Database", "host", $_POST['hostname']);
		$config_file->set("Database", "port", $port);
		$config_file->set("Database", "user", $_POST['username']);
		$config_file->set("Database", "password", $_POST['password']);
		$config_file->set("Database", "database", $_POST['database']);
	}
	else {
		$stage = 'stage1';
		$smarty->assign('not_writable',true);
	}
	if($stage=='success') 
		$config_file->save();
	$smarty->assign('stage',$stage);
}

$smarty->display('index.tpl');