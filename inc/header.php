<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?=htmlspecialchars($title)?></title>
    <link href="<?= WEB_ROOT . 'css/normalize.min.css' ?>" rel="stylesheet">
    <link href="<?= WEB_ROOT .'css/flatpickr.min.css'?>" rel="stylesheet">
    <link href="<?= WEB_ROOT . 'css/style.css' ?>" rel="stylesheet">
</head>
<body>
<div class="page-wrapper">

    <header class="main-header">
        <div class="main-header__container container">
            <h1 class="visually-hidden">YetiCave</h1>
            <a class="main-header__logo" <?= ($scriptName !== '/index.php') ? 'href="/"' : '' ;?>>
                <img src="img/logo.svg" width="160" height="39" alt="Логотип компании YetiCave">
            </a>
            <form class="main-header__search" method="get" action="https://echo.htmlacademy.ru" autocomplete="off">
                <input type="search" name="search" placeholder="Поиск лота">
                <input class="main-header__search-btn" type="submit" name="find" value="Найти">
            </form>
            <a class="main-header__add-lot button" href="add.php">Добавить лот</a>

            <nav class="user-menu">

                <!-- здесь должен быть PHP код для показа меню и данных пользователя -->
                <?php
                if ($isAuth) : ?>
                    <div class="user-menu__logged">
                        <p><?= htmlspecialchars($userName) ?></p>
                        <a class="user-menu__bets" href="pages/my-bets.html">Мои ставки</a>
                        <a class="user-menu__logout" href="#">Выход</a>
                    </div>
                <?php
                else : ?>
                    <ul class="user-menu__list">
                        <li class="user-menu__item">
                            <a href="register.php">Регистрация</a>
                        </li>
                        <li class="user-menu__item">
                            <a href="login.php">Вход</a>
                        </li>
                    </ul>
                <?php
                endif; ?>
            </nav>
        </div>
    </header>
