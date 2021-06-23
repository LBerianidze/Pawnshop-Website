<?php
	file_put_contents('payments.txt',var_export($_GET,true),FILE_APPEND);
	file_put_contents('payments.txt',var_export($_POST,true)."\n\n",FILE_APPEND);
	header('Content-Type: application/json; charset=UTF-8');
	$orderId = $_GET['orderId'];
	$data = array(
		'userName'    => '',
		'password'    => '',
		'orderId'  => $orderId,
	);
	$options = array(
		CURLOPT_RETURNTRANSFER => true,   // return web page
		CURLOPT_HEADER         => false,  // don't return headers
	);
	$ch = curl_init('https://securepayments.sberbank.ru/payment/rest/getOrderStatusExtended.do');
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt_array($ch, $options);
	$result = curl_exec($ch);
	curl_close($ch);
	$result = json_decode($result);
	if ($result->errorCode == 0)
	{
		if ($result->orderStatus == 2)
		{
			$orderNumber = $result->orderNumber;
			 include_once '../configs/db.php';
			$order = getOrderById($orderNumber);
			if($order->status ==2)
			{
				exit('already paid');
			}
			universalUpdate('payments', array(
				'end_date' => (new DateTime('now',new DateTimeZone('+5')))->format('Y-m-d H:i:s'),
				'status'   => 2
			),true, "`order_number`=$orderNumber");
			$amount = $order->amount;
			universalUpdate('tickets', array(
				'payed' => 'payed + '.$amount,
				'last_operation_date'=>"'".(new DateTime('now', new DateTimeZone('+5')))->format('Y-m-d H:i:s')."'"
			), false,"`ticket_id`='$order->ticket_id'");
			header('Location: /pay/?ticket_id='.$order->ticket_id);
		}
	}
	else
	{
		echo 'ups';
	}