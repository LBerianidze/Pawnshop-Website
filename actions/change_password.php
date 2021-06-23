<?php
	/**
	 * Created by PhpStorm.
	 * User: Luka
	 * Date: 23.10.2020
	 * Time: 2:45
	 */
	include_once 'check_auth.php';
	$oldpassword = $_REQUEST['old-password'];
	$newpassword = $_REQUEST['new-password'];
	$repeatpassword = $_REQUEST['repeat-password'];
	if (md5('kqcbj+J+vL9BRfeCVr39' . $oldpassword . '.2pH#)Vr.A2Rht6QlTV5') != $password)
	{
		header('location: /settings?err=1');
		exit();
	}
	if (strlen($newpassword) < 8 || strlen($newpassword) > 16)
	{
		header('location: /settings?err=3');
		exit();
	}
	if ($newpassword != $repeatpassword)
	{
		header('location: /settings?err=2');
		exit();
	}
	$newpassword = md5('kqcbj+J+vL9BRfeCVr39' . $newpassword . '.2pH#)Vr.A2Rht6QlTV5');
	universalUpdate('users', ['passwd' => $newpassword], true, "`import_id`='$user_import_id'");
	
	$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
	setcookie('usr', "$email&$newpassword", time() + 3600, '/', $domain, false);
	header('location: /settings?err=4');
	exit();
