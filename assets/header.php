<header class="header">
    <div class="container">
        <div class="nav row">
            <div class="nav__logo row">
                <a href="/">
                    <img src="assets/img/logo-min.png" alt="logo">
                </a>
            </div>
            <div class="nav__text row">
                <div class="nav-text__auth col">
                    <h3>Авторизовано:</h3>
                    <p><?= $name; ?></p>
                </div>
                <div class="nav-text__card col" style="display: none;">
                    <h3>№ банковской карты:</h3>
                    <label for="view">
                        <p class="card_number"><?= $card_number ?></p>
                    </label>
                    <p>проводить операции Вы можете только с использованием этой карты</p>
                </div>
                <div class="nav-text__logout">
                    <a href="../actions/logout.php">Выйти</a>
                </div>
                <div class="nav-text__menu col">
                    <div data-da="header,1,767" id="nav" class="nav-text__nav">
                        <a href="/applications">Мои Залоговые билеты</a>
                        <a href="/settings">Настройки аккаунта</a>
                        <a href="/faq">Инструкция</a>
                        <?php if ($user->privileges == 1)
                            echo '<a href="/actions/register.php">Зарегистрировать пользователя</a>'
                        ?>
                        <?php if (count($tickets) != 0): ?>
                            <label for="support_view">
                                <a class="nav_support_link">Письмо Жёлудю</a>
                            </label>
                        <?php endif; ?>
                        <a href="/actions/logout.php">Выйти</a>
                    </div>
                    <a data-da="header,2,767" href="javascript:void(0);" class="icon" onclick="menuBtn()">
                        <div class="menu-button" onclick="BarChange(this)">
                            <div class="bar bar1"></div>
                            <div class="bar bar2"></div>
                            <div class="bar bar3"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<div>
    <input class="closed" type="radio" id="hidden" name="open">
    <input class="opened" type="radio" id="view" name="open">
    <div class="out-popup">
        <label for="hidden"></label>
        <div class="popup-window">
            <label for="hidden" class="lab-view close">
                <i class="fa fa-times" aria-hidden="true"></i>
            </label>
            <h2>Изменить номер карты</h2>
            <div class="popup-buttons row">
                <form action="../actions/changeCardNumber.php" method="post">
                    <input class="card-number-input" value="<?= ($card_number == 'Не указан' ? '' : $card_number) ?>" id="cardNumber" name="cardNumber" type="text">
                    <button type="submit" href="#" class="submit-btn">Изменить</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div>
    <input class="closed" type="radio" id="support_hidden" name="open">
    <input class="opened" type="radio" id="support_view" name="open">
    <div class="out-popup">
        <label for="support_hidden"></label>
        <div class="popup-window">
            <label for="support_hidden" class="lab-view close">
                <i class="fa fa-times" aria-hidden="true"></i>
            </label>
            <h2>Отправить сообщение Жёлудю</h2>
            <div class="popup-buttons row">
                <form id="email_form">
                    <textarea id="email_text" name="email_text" cols="10" rows="10"></textarea>
                    <button type="submit" href="#" class="submit-btn">Отправить</button>
                </form>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="/assets/header.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="/assets/main.js"></script>
