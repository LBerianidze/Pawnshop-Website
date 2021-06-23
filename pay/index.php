<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/actions/check_auth.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="assets/styles/css/normalize.min.css">
	<link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/styles/css/style.css">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<title>Оплата</title>
</head>
<body>
<script type="text/javascript">
    var payed = <?=$currentticket->payed ?>;
    var percent = <?=$currentticket->percent_sum ?>;
    var loan = <?=$currentticket->loan_sum ?>;
    var card_number = '<?=$card_number ?>';
    var maxavailable = <?=floor($currentticket->available / 500) * 500 ?>;
    var has_card = <?=$has_card ?>;
    var err = <?=isset($_GET['err']) ? $_GET['err'] : -1 ?>;
</script>
<script src="assets/scripts/main.js"></script>
<?php include '../assets/header.php' ?>
<main class="main">
	<div class="container">
		<div class="table col">
			<h1>Оплата
				<script language="javascript" type="text/javascript">
                    var d = new Date();

                    var day = new Array("Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота");

                    var month = new Array("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");

                    document.write(day[d.getDay()] + " " + d.getDate() + " " + month[d.getMonth()] + " " + d.getFullYear() + " г.");
				</script>
			</h1>
			<div class="table-content col">
				<div class="table-content__table-header-line row">
					<div class="table-col-1 table-col">№ ЗБ</div>
					<div class="table-col-2 table-col">Имущество</div>
					<div class="table-col-3 table-col">Срок возврата займа</div>
					<div class="table-col-4 table-col">Дата реализации</div>
					<div class="table-col-5 table-col">Сумма займа</div>
					<div class="table-col-6 table-col">%</div>
				</div>
				<div class="table-content__table-line row">
					<div class="table-line-wrapper row">
						<div class="table-col-1 table-col"><?= $currentticket->ticket_id ?></div>
						<div class="table-col-2 table-col">
							 <?php
							 $items = json_decode($currentticket->items);
							 foreach ($items as $item)
							 {
								  echo $item->Вещь . ' - ' . $item->СуммаЗайма . ' .₽<br>';
							 }
							 ?></div>
						<div class="table-col-3 table-col"><?= $currentticket->return_date ?></div>
						<div class="table-col-4 table-col"><?= $currentticket->realization_date ?></div>
						<div class="table-col-5 table-col"><?= ($currentticket->payed - $currentticket->percent_sum > 0 ? $currentticket->loan_sum - ($currentticket->payed - $currentticket->percent_sum) : $currentticket->loan_sum) ?> ₽</div>
						<div class="table-col-6 table-col"><?= ($currentticket->percent_sum - $currentticket->payed <= 0 ? 0 : $currentticket->percent_sum - $currentticket->payed) ?> ₽</div>
					</div>
				</div>
			</div>
			 <? if ((new DateTime('now', new DateTimeZone('+5')))->format('Y-m-d') != $last_operation_date->format('Y-m-d')): ?>
				 <div class="pay-table">
					 <div class="pay-row row">
						 <input name="ticket_id" id="ticket_id" value="<?= $currentticket->ticket_id ?>" hidden>
						 <input name="percent_sum" id="percent_sum" value="<?= $currentticket->percent_sum ?>" hidden>
						 <div class="pay-row__text row">
							 <div class="pay-row__text__num col">1</div>
							 <div class="pay-row__text__content col">
								 <h3>Оплата %</h3>
								 <p>Оплата процентов по ЗБ № <?= $currentticket->ticket_id ?></p>
							 </div>
						 </div>
						 <div class="pay-text__price row">
							 <div class="pay-text__price-wrapper">
								 <h3>Итого</h3>
								 <p><?= ($currentticket->percent_sum - $currentticket->payed <= 0 ? 0 : $currentticket->percent_sum - $currentticket->payed) ?> ₽</p>
							 </div>
						 </div>
						 <div class="pay-text__button col">
							 <form method="POST" action="/sberapi/api.php">
								 <input name="ticket_id" id="ticket_id" value="<?= $currentticket->ticket_id ?>" hidden>
								 <input name="type" id="type" value="1" hidden>
								 <button type="submit" class="button" <?= ($currentticket->percent_sum - $currentticket->payed <= 0 ? 'disabled' : '') ?>>Оплатить</button>
							 </form>
						 </div>
					 </div>
					  <?php if ($days >= 20): ?><?
						   $itemsCount = count(json_decode($currentticket->items));
						   $min = 50 * $itemsCount;
						   if ($currentticket->loan_sum > $min):?>
							   <div class="pay-row row">
								   <div class="pay-row__text row">
									   <div class="pay-row__text__num col">2</div>
									   <div class="pay-row__text__content col">
										   <h3>Оплата % и части займа</h3>
										   <p>Оплата процентов по ЗБ № <?= $currentticket->ticket_id ?> и
											   <label class="number">
												   <input min="50" id="user-entered-sum" onkeyup="loanSumChange(this);" type="text" maxlength="6" value="50">
												   ₽
											   </label>
										      от займа
											   <img style="cursor: pointer;vertical-align: middle;margin-left:-2px" src="assets/img/question.png" onclick="showtip();"></img>
										   </p>
									   </div>
								   </div>
								   <div class="pay-text__price row">
									   <div class="pay-text__price-wrapper">
										   <h3>Итого</h3>
										   <label class="number">
											   <input id="totalSum" type="text" maxlength="6">
											   ₽
										   </label>
									   </div>
								   </div>
								   <div class="pay-text__button col">
									   <form method="POST" action="/sberapi/api.php">
										   <input name="ticket_id" id="ticket_id" value="<?= $currentticket->ticket_id ?>" hidden>
										   <input name="type" id="type" value="2" hidden>
										   <input name="enteredSum" type="0" maxlength="6" id="enteredSum" value="0" hidden>
										   <button type="submit" class="button" id="payPercentWithLoan">Оплатить</button>
									   </form>
								   </div>
							   </div>
						   <? endif; ?><? if (false): ?>
							  <div class="pay-row row">
								  <div class="pay-row__text row">
									  <div class="pay-row__text__num col">3</div>
									  <div class="pay-row__text__content col">
										  <h3>Выкуп изделия</h3>
										  <p>Оплата всей суммы по ЗБ № <?= $currentticket->ticket_id ?></p>
									  </div>
								  </div>
								  <div class="pay-text__price row">
									  <div class="pay-text__price-wrapper">
										  <h3>Итого</h3>
										  <p id="totalLeftSum">
											  <script>document.write(getTotalLeft() + ' ₽');</script>
										  </p>
									  </div>
								  </div>
								  <div class="pay-text__button col">
									  <form method="POST" action="/sberapi/api.php">
										  <input name="ticket_id" id="ticket_id" value="<?= $currentticket->ticket_id ?>" hidden>
										  <input name="type" id="type" value="3" hidden>
										  <button type="submit" class="button" id="payAll">Оплатить</button>
									  </form>
								  </div>
							  </div>
						   <? endif; ?><? else: ?>
						  <h2 style="text-align: center;margin-bottom: 15px">Другие операции по данному билету будут доступны через <?= (20 - $days) ?> дней</h2>
					  <? endif; ?>
					  <?php
					  $dindex = (new DateTime('now', new DateTimeZone('+5')))->format('N');
					  $hour = (new DateTime('now', new DateTimeZone('+5')))->format('H');
					  if ($hour < 22 &&
						  $hour >= 8 &&
						  $currentticket->available >= 3000 &&
						  $currentticket->available > ($currentticket->payed < $currentticket->percent_sum ? $currentticket->percent_sum : 0)):?>
					  <?if($has_card== true):?>
						  <div class="pay-row row">
							  <div class="pay-row__text row">
								  <div class="pay-row__text__num col">4</div>
								  <div class="pay-row__text__content col">
									  <h3>Добор</h3>
									  <div>
										  <span>Увеличить сумму займа на</span>
										  <div class='ctrl'>
											  <div class='ctrl__button ctrl__button--decrement'>&ndash;</div>
											  <div class='ctrl__counter'>
												  <input class='ctrl__counter-input' maxlength='10' type='text' value='3000'>
												  <div class='ctrl__counter-num'>3000</div>
											  </div>
											  <div class='ctrl__button ctrl__button--increment'>+</div>
										  </div>
										  <span>₽</span>
									  </div>
									  <span class="max-sum">(Минимально - 3000, Максимально <?= floor(($currentticket->available / 500)) * 500 ?> &#8381; с интервалом 500 р.)</span>
								  </div>
							  </div>
							  <div class="pay-text__price row">
								  <div class="pay-text__price-wrapper">
									  <h3>Итого
										  <img style="cursor: pointer;vertical-align: middle;margin-left:-2px" src="assets/img/question.png" onclick="showtip1();"></img>
									  </h3>
									  <label class="number">
										  <input id="totalAvailable" type="text" maxlength="6">
										  ₽
									  </label>
								  </div>
							  </div>
							  <div class="pay-text__button col">
								  <label for="">
									  <a class="button" onclick="showAvailablePopup();">Получить выплату</a>
								  </label>
							  </div>
						  </div>
					  <? endif; ?>
					  <? endif; ?>
				 </div>
			 <? elseif ((new DateTime('now', new DateTimeZone('+5')))->format('Y-m-d') == $last_operation_date->format('Y-m-d')): ?>
				 <h2>Сегодня оплата по данному залоговому билету Вами уже произведена</h2>
			 <? endif; ?>
		</div>
	</div>
</main>
<div>
	<input class="closed" type="radio" id="available_popup_hidden" name="open">
	<input class="opened" type="radio" id="available_popup_visible" name="open">
	<div class="out-popup">
		<label for="hidden"></label>
		<div class="popup-window">
			<label for="available_popup_hidden" class="lab-view close">
				<i class="fa fa-times" aria-hidden="true"></i>
			</label>
			<h2>Подтверждение добора</h2>
			<div class="popup-buttons row">
				<form id="get_available-form" action="/actions/get_available_money.php" method="post">
					<span id="availablesumpopuptext"></span>
					<input id="availableamount" name="availableamount" hidden>
					<input name="ticket_id" id="ticket_id" value="<?= $currentticket->ticket_id ?>" hidden>
					<button type="submit" href="#" class="submit-btn">Подтвердить</button>
				</form>
			</div>
		</div>
	</div>
</div>
<script src="assets/scripts/spinner.js"></script>
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(71357380, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/71357380" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
</body>
</html>
