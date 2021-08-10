
<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php
            foreach ($categories as $category) : ?>
                <li class="nav__item">
                    <a href="all-lots.php?category=<?= esc($category['category_name']) ?>"><?= esc($category['category_name']) ?></a>
                </li>
            <?php
            endforeach; ?>
        </ul>
    </nav>
    <form class="form container <?= count($formErrors) > 0 ? 'form--invalid' : '' ?>" action="register.php"
          method="post" autocomplete="off"> <!-- form--invalid -->
        <h2>Регистрация нового аккаунта</h2>
        <div class="form__item <?= isset($formErrors['user-email']) ? 'form__item--invalid' : '' ?>"> <!-- form__item--invalid -->
            <label for="user-email">E-mail <sup>*</sup></label>
            <input id="user-email" type="text" name="user-email" placeholder="Введите e-mail"
                   value= "<?= esc($submittedData['user-email'] ?? '') ?>" >
            <span class="form__error"><?= esc($formErrors['user-email'] ?? '') ?> </span>
        </div>
        <div class="form__item <?= isset($formErrors['user-password']) ? 'form__item--invalid' : '' ?>">
            <label for="user-password">Пароль <sup>*</sup></label>
            <input id="user-password" type="password" name="user-password" placeholder="Введите пароль"
                   value= "<?= esc($submittedData['user-password'] ?? '') ?>" >
            <span class="form__error"><?= esc($formErrors['user-password'] ?? '') ?></span>
        </div>
        <div class="form__item <?= isset($formErrors['user-name']) ? 'form__item--invalid' : '' ?>">
            <label for="user-name">Имя <sup>*</sup></label>
            <input id="user-name" type="text" name="user-name" placeholder="Введите имя"
                   value= "<?= esc($submittedData['user-name'] ?? '') ?>" >
            <span class="form__error"><?= esc($formErrors['user-name'] ?? '') ?></span>
        </div>
        <div class="form__item <?= isset($formErrors['user-message']) ? 'form__item--invalid' : '' ?>">
            <label for="user-message">Контактные данные <sup>*</sup></label>
            <textarea id="user-message" name="user-message" placeholder="Напишите как с вами связаться">
                <?= esc($submittedData['user-message'] ?? '') ?>
            </textarea>
            <span class="form__error"><?= esc($formErrors['user-message'] ?? '') ?></span>
        </div>
        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
        <span class="form__error form__error--bottom">
            <?= count($formErrors) > 0 ? 'Пожалуйста, исправьте ошибки в форме.' : '' ?>
        </span>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="login.php">Уже есть аккаунт</a>
    </form>
</main>


