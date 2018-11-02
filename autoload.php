<?php
	require_once 'constant.php';

	// Classes
	require_once 'classes/RegisterFormValidator.php';
	require_once 'classes/LoginFormValidator.php';
	require_once 'classes/SaveImage.php';
	require_once 'classes/User.php';
	require_once 'classes/DBJson.php';
	require_once 'classes/Auth.php';

  require_once 'classes/DBSQL.php';
	require_once 'classes/ChangePassword.php';

	$db = new DBJson('data/users.json');
	$dbSql = new DBSQL('customtrip_db');

	$dbSql->theLast($db);

	$auth = new Auth();
