
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
    <form class="form container <?= !empty($errors) ? 'form--invalid' : '' ?>" action="login.php" method="post"> <!-- form
    --invalid -->
        <h2>Вход</h2>
        <div class="form__item <?= !empty($errors['user-email']) ? 'form__item--invalid' : '' ?>"> <!-- form__item--invalid -->
            <label for="user-email">E-mail <sup>*</sup></label>
            <input id="user-email" type="text" name="user-email" placeholder="Введите e-mail" value= "<?= $loginInput['user-email'] ?>" >
            <span class="form__error"><?= $errors['user-email'] ?? '' ?> </span>
        </div>
        <div class="form__item <?= !empty($errors['user-password']) ? 'form__item--invalid' : '' ?>">
            <label for="user-password">Пароль <sup>*</sup></label>
            <input id="user-password" type="password" name="user-password" placeholder="Введите пароль">
            <span class="form__error">Введите пароль<?= $errors['lot-name'] ?? '' ?></span>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Войти</button>
        <a class="text-link" href="register.php">Зарегистрироваться</a>
    </form>
</main>


