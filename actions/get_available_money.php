<?php
/**
 * Created by PhpStorm.
 * User: Luka
 * Date: 23.10.2020
 * Time: 11:48
 */
include_once 'check_auth.php';
require_once 'email.php';
if (!isset($_REQUEST['ticket_id']) || !isset($_REQUEST['availableamount']))
{
	 header('Location: /pay/?ticket_id=' . $ticket . '&err=4');
}
$ticket = $_REQUEST['ticket_id'];
$availableamount = $_REQUEST['availableamount'];
$hour = (new DateTime('now', new DateTimeZone('+5')))->format('H');
if ($hour >= 22)
{
	 header('Location: /pay/?ticket_id=' . $ticket . '&err=2');
	 exit();
}
$order_number = round(microtime(true) * 1000) . $user_id;
addPayment($user_id, $ticket, $order_number, '', $availableamount, 4, '');

if (strlen($ticket) < 14)
{
	 if ($availableamount % 500 == 0)
	 {
		  universalUpdate('tickets',
						  array(
							  'available'           => 'available - ' . $availableamount,
							  'last_operation_date' => "'" . (new DateTime('now', new DateTimeZone('+5')))->format('Y-m-d H:i:s') . "'"
						  ),
						  false,
						  "`ticket_id`='$ticket'");
		  $left = 0;
		  if ($ticket->payed < $ticket->percent)
		  {
			   $left = $ticket->percent;
		  }
		  universalUpdate('payments', array(
			  'end_date' => (new DateTime('now', new DateTimeZone('+5')))->format('Y-m-d H:i:s') ,
			  'status' => 2
		  ) , true, "`order_number`=$order_number");
		  
		  $html = "<html><body><p>Пользователь $name запросил(а) добор:</p><ul><li>Билет: $ticket</li><li>Сумма: $availableamount рублей</li><li>Процент: $left рублей</li><li>Карта: $card_number</li><li>Почта для связи: $email</li></ul></body></html>";
		  sendMail($admin_email, "Отчет о доборе", $html);
		  header('Location: /pay/?ticket_id=' . $ticket . '&err=1');
		  exit();
	 }
}
header('Location: /pay/?ticket_id=' . $ticket . '&err=3');
exit();