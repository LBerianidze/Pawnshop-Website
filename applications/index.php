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

    <!-- FAVICON -->

    <title>Залоговые билеты</title>
</head>

<body>

<?php include '../assets/header.php' ?>
<main class="main">
    <div class="container">
        <div class="table col">
            <h1>Мои залоговые билеты</h1>
            <div class="table-content col">
                <div class="table-content__table-header-line row">
                    <div class="table-col-1 table-col">№ ЗБ</div>
                    <div class="table-col-2 table-col">Имущество</div>
                    <div class="table-col-3 table-col">Срок возврата займа</div>
                    <div class="table-col-4 table-col">Дата реализации</div>
                    <div class="table-col-5 table-col">Сумма займа</div>
                    <div class="table-col-6 table-col">%</div>
                    <div class="table-col-7"></div>
                </div>
                <div class="table-list">
                    <?php
                    foreach ($tickets as $ticket)
                    {
                        ?>
                        <div class="table-content__table-line row">
                            <a href="#" class="line-link"></a>
                            <div class="table-line-wrapper row">
                                <div class="table-col-1 table-col"><?= $ticket->ticket_id ?></div>
                                <div class="table-col-2 table-col">
                                <?php
                                $items = json_decode($ticket->items);
                                foreach ($items as $item)
                                {
                                    echo $item->Вещь.' - '.$item->СуммаЗайма .' .₽<br>';
                                }
                                ?>
                                </div>
                                <div class="table-col-3 table-col"><?= $ticket->return_date ?></div>
                                <div class="table-col-4 table-col"><?= $ticket->realization_date ?></div>
                                <div class="table-col-5 table-col"><?=($ticket->payed - $ticket->percent_sum>0? $ticket->loan_sum - ($ticket->payed - $ticket->percent_sum):$ticket->loan_sum ) ?> ₽</div>
	                            <div class="table-col-6 table-col"><?=($ticket->percent_sum - $ticket->payed<=0 ? '&mdash;':($ticket->percent_sum - $ticket->payed).' ₽')?></div>
	                            <div class="table-col-7"><label for="view"><a class="button" href="/pay?ticket_id=<?= $ticket->ticket_id ?>">Оплатить</a></label></div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>


<script src="assets/scripts/main.js"></script>
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
