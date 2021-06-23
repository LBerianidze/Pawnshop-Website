<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/configs/db.php';
	require_once '../vendor/autoload.php';
	$password = $_REQUEST['newPassword'];
	$repeatPassword = $_REQUEST['repeatPassword'];
	$hash = $_REQUEST['hash'];
	if ($password != $repeatPassword)
	{
		header('Location: /login/remember.php?p=1&hash=' . $hash, true);
		exit();
	}
	$passwordRequest = getUserRequest($hash);
	if ($passwordRequest !== false && $pwdRequest->status == 0)
	{
		$password = md5('kqcbj+J+vL9BRfeCVr39' . $password . '.2pH#)Vr.A2Rht6QlTV5');
		updatePassword($passwordRequest->user_id, $password);
		updateRememberRequestStatus($hash, 2);
		header('Location: /applications/', true);
	}
	else
	{
		header('Location: /login/remember.php?p=2&hash=' . $hash, true);
	}
