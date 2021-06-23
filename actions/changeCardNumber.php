<?php
	/**
	 * Created by PhpStorm.
	 * User: Luka
	 * Date: 23.10.2020
	 * Time: 2:45
	 */
	include_once 'check_auth.php';
	$new_card_number = $_REQUEST['cardNumber'];
	if ($new_card_number != $card_number)
	{
		$re = '/^[0-9\s]+$/m';
		$len = strlen($new_card_number);
		if (true/*preg_match($re, $new_card_number) != 0 && ($len == 16 || $len == 13 || $len == 19)*/)
		{
			universalUpdate('users', array('card_number' => $new_card_number),true, "`import_id`='$user_import_id'");
		}
		else
		{
			header('location: /applications?err=1');
			exit();
		}
	}
	header('location: /');