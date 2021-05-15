
<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php
            foreach ($categories as $category) : ?>
                <li class="nav__item">
                    <a href="all-lots.html"><?= htmlspecialchars($category['category_name']) ?></a>
                </li>
            <?php
            endforeach; ?>
        </ul>
    </nav>
    <form class="form container <?= !empty($errors) ? 'form--invalid' : '' ?>" action="register.php" method="post" autocomplete="off"> <!-- form
    --invalid -->
        <h2>Регистрация нового аккаунта</h2>
        <div class="form__item <?= !empty($errors['user-email']) ? 'form__item--invalid' : '' ?>"> <!-- form__item--invalid -->
            <label for="user-email">E-mail <sup>*</sup></label>
            <input id="user-email" type="text" name="user-email" placeholder="Введите e-mail" value= "<?= $registerInput['user-email'] ?>" >
            <span class="form__error"><?= $errors['user-email'] ?? '' ?> </span>
        </div>
        <div class="form__item <?= !empty($errors['user-password']) ? 'form__item--invalid' : '' ?>">
            <label for="user-password">Пароль <sup>*</sup></label>
            <input id="user-password" type="password" name="user-password" placeholder="Введите пароль">
            <span class="form__error">Введите пароль<?= $errors['lot-name'] ?? '' ?></span>
        </div>
        <div class="form__item <?= !empty($errors['user-name']) ? 'form__item--invalid' : '' ?>">
            <label for="user-name">Имя <sup>*</sup></label>
            <input id="user-name" type="text" name="user-name" placeholder="Введите имя" value= "<?= $registerInput['user-name'] ?>" >
            <span class="form__error">Введите имя<?= $errors['user-name'] ?? '' ?></span>
        </div>
        <div class="form__item <?= !empty($errors['user-message']) ? 'form__item--invalid' : '' ?>">
            <label for="user-message">Контактные данные <sup>*</sup></label>
            <textarea id="user-message" name="user-message" placeholder="Напишите как с вами связаться"><?= $registerInput['user-message'] ?></textarea>
            <span class="form__error">Напишите как с вами связаться<?= $errors['user-message'] ?? '' ?></span>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="login.php">Уже есть аккаунт</a>
    </form>
</main>


