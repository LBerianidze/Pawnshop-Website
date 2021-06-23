<?php
header('Content-Type: application/json; charset=UTF-8');
include_once '../configs/db.php';
$data = array(
    'userName' => '',
    'password' => '',
    'orderId' => $orderId,
);
$payments = $db_users = selectAll('payments', '*','where status=0 and finished=0');
foreach ($payments as $payment)
{
    if ($payment->status == 2) continue;
    $data['orderId'] = $payment->token;
    $options = array(
        CURLOPT_RETURNTRANSFER => true, // return web page
        CURLOPT_HEADER => false, // don't return headers
        
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
            $order = getOrderById($orderNumber);
            if ($order->status == 2)
            {
                continue;
            }
            universalUpdate('payments', array(
                'end_date' => (new DateTime('now', new DateTimeZone('+5')))
                    ->format('Y-m-d H:i:s') ,
                'status' => 2
            ) , true, "`order_number`=$orderNumber");
            $amount = $order->amount;
            universalUpdate('tickets', array(
                'payed' => 'payed + ' . $amount,
				'last_operation_date' => "'".(new DateTime('now', new DateTimeZone('+5')))->format('Y-m-d H:i:s')."'"
            ) , false, "`ticket_id`='$order->ticket_id'");
        }
        else if ($result->orderStatus!=0)
		{
			 $orderNumber = $result->orderNumber;
			 $order = getOrderById($orderNumber);
			 universalUpdate('payments', array(
				 'finished' => 1
			 ) , true, "`order_number`=$orderNumber");
		}
    }
}

