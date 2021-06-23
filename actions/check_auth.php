<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/configs/db.php';
if ($_SERVER['SCRIPT_NAME'] == '/login/index.php')
{
	 if (!isset($_COOKIE['usr']))
	 {
		  return;
	 }
	 $cookie = $_COOKIE['usr'];
	 $cookie = explode('&', $cookie);
	 if (count($cookie) != 2)
	 {
		  return;
	 }
	 $user = getUser($cookie[0]);
	 if ($user === false)
	 {
		  return;
	 }
	 else
	 {
		  if ($cookie[1] != $user->passwd)
		  {
			   $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
			   setcookie('usr', '', time() - 1, '/', $domain, false);
			   return;
		  }
		  else
		  {
			   header('Location: ' . '/applications/index.php');
		  }
	 }
}
else if (!isset($_COOKIE['usr']))
{
	 header('Location: ' . '/login/index.php');
	 exit();
}
else
{
	 $cookie = $_COOKIE['usr'];
	 $cookie = explode('&', $cookie);
	 if (count($cookie) != 2)
	 {
		  header('Location: ' . '/login/index.php');
		  exit();
	 }
	 $user = getUser($cookie[0]);
	 if ($user === false)
	 {
		  header('Location: ' . '/login/index.php');
		  exit();
	 }
	 else
	 {
		  if ($cookie[1] != $user->passwd)
		  {
			   $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
			   setcookie('usr', '', time() - 1, '/', $domain, false);
			   header('Location: ' . '/login/index.php');
			   exit();
		  }
		  else
		  {
			   $offline = universalSelect('settings', 'param=\'is_offline\'')->value;
			   if ($offline == 1)
			   {
					if ($_SERVER['SCRIPT_NAME'] != '/applications/offline.php')
					{
						 header('Location: ' . '/applications/offline.php');
						 exit();
					}
			   }
			   else
			   {
			   	    $has_card = $user->has_card;
					$email = $user->login;
					$user_id = $user->id;
					$user_import_id = $user->import_id;
					$name = $user->name;
					$card_number = $user->card_number;
					$tickets = getUserTickets($user->import_id);
					$password = $user->passwd;
					$admin_email = universalSelect('settings', 'param=\'admin_email\'')->value;
					universalUpdate('users', ['last_auth_time' => (new DateTime('now'))->format('Y-m-d H:i:s')], true, 'id=' . $user_id);
					if (isset($_GET['ticket_id']))
					{
						 $currentticket = getUserTicket($user->import_id, $_GET['ticket_id']);
						 if ($currentticket === false)
						 {
							  header('Location: ' . '/applications/');
							  exit();
						 }
						 //$adddate = universalSelect('all_tickets', "ticket_id='$currentticket->ticket_id'")->add_date;
						 $last_operation_date = new DateTime($currentticket->last_operation_date, new DateTimeZone('+5'));
						 $dtnow = new DateTime('now', new DateTimeZone('+5'));
						 $datetiff = ($dtnow->getTimestamp() + $dtnow->getOffset()) - ($last_operation_date->getTimestamp() + $last_operation_date->getOffset());
						 $days = round($datetiff / (60 * 60 * 24));
					}
					else if ($_SERVER['SCRIPT_NAME'] == '/pay/index.php')
					{
						 header('Location: ' . '/applications/');
						 exit();
					}
					if ($_SERVER['SCRIPT_NAME'] == '/index.php')
					{
						 header('Location: ' . '/applications/');
						 exit();
					}
					else if ($_SERVER['SCRIPT_NAME'] == '/applications/offline.php')
					{
						 header('Location: ' . '/applications/');
						 exit();
					}
			   }
		  }
	 }
}

