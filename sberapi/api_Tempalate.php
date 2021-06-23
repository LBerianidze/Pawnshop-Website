<?php
	include_once '../actions/check_auth.php';
	header('Content-Type: application/json; charset=UTF-8');
	if (isset($_REQUEST['type']) && isset($_REQUEST['ticket_id']))
	{
		$type = $_REQUEST['type'];
		$ticket_id = $_REQUEST['ticket_id'];
		$ticket = getUserTicket($user_import_id, $ticket_id);
		$order_number = round(microtime(true) * 1000) . $user_id;
		$data = array(
			'userName' => '',
			'password' => '',
			'orderNumber' => $order_number,
			'returnUrl' => 'https://kabinet.lombard-2020.ru/sberapi/return.php'
		);
		$cart = [
			[
				'positionId' => $user_id,
				//'name'       => 'Оплата % по билету ' . $ticket_id,
				'quantity'   => ['value' => 1, 'measure' => 'билет'],
				'itemCode'=>$order_number,
				//'itemPrice'=>$data['amount']
			]
		];
		if ($type == 1)
		{
			if ($ticket->payed < $ticket->percent_sum)
			{
				$data['amount'] = $ticket->percent_sum;
				$cart[0]['name'] = 'Оплата % по билету ' . $ticket_id;
			}
			else
			{
				exit('ups...');
			}
		}
		else if ($type == 2)
		{
			$amount = $_REQUEST['enteredSum'];
			if ($amount <= $ticket->loan_sum + $ticket->percent_sum - $ticket->payed)
			{
				$data['amount'] = $amount;
				$cart[0]['name'] = 'Оплата % и части суммы займа по билету ' . $ticket_id;
			}
			else
			{
				exit('ups...');
			}
		}
		else if ($type == 3)
		{
			$data['amount'] = $ticket->loan_sum + $ticket->percent_sum - $ticket->payed;
			$cart[0]['name'] = 'Оплата полной суммы билета ' . $ticket_id;
		}
		else
		{
			exit('ups...');
		}
		$options = array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER         => false,
		);
		$amount = $data['amount'];
		$data['amount'] = $data['amount'] * 100;
		$cart[0]['itemPrice'] =round($data['amount']);
		
		$data['orderBundle'] = json_encode(['cartItems'=>['items'=>$cart]],JSON_UNESCAPED_UNICODE);
		$ch = curl_init('https://securepayments.sberbank.ru/payment/rest/register.do');
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		curl_close($ch);
		$result = json_decode($result);
		if (isset($result->formUrl))
		{
			$url = $result->formUrl;
			addPayment($user_id, $ticket_id, $order_number, $result->orderId, $amount, $type, '');
			header('Location: ' . $url);
		}
	}
	else
	{
		header('Location: /applications');
	}