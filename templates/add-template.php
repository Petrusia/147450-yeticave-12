
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
    <form class="form form--add-lot container  <?= !empty($errors) ? 'form--invalid' : '' ?>"
          method="post" action="add.php" enctype="multipart/form-data"> <!-- form--invalid -->
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <div class="form__item   <?= !empty($errors['lot-name']) ? 'form__item--invalid' : '' ?> "> <!-- form__item--invalid -->
                <label for="lot-name">Наименование <sup>*</sup></label>
                <input id="lot-name" type="text" name="lot-name"
                       placeholder="Введите наименование лота" value= "<?= $lotInput['lot-name'] ?>">
                <span class="form__error"><?= $errors['lot-name'] ?? '' ?></span>
            </div>
            <div class="form__item <?= !empty($errors['lot-category']) ? 'form__item--invalid' : '' ?>">
                <label for="category">Категория <sup>*</sup></label>
                <select id="category" name="lot-category">
                    <option value="">Выберите категорию</option>
                    <?php
                    foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['id']); ?>"
                                <?php
                                if ($category['id'] == $lotInput['lot-category']) : ?>selected<?php
                        endif; ?>
                        ><?= htmlspecialchars($category['category_name']); ?></option>
                    <?php
                    endforeach; ?>
                </select>
                <span class="form__error"><?= $errors['lot-category'] ?? '' ?></span>
            </div>
        </div>
        <div class="form__item form__item--wide <?= !empty($errors['lot-message']) ? 'form__item--invalid' : '' ?>">
            <label for="message">Описание <sup>*</sup></label>
            <textarea id="message" name="lot-message" placeholder="Напишите описание лота"><?= $lotInput['lot-message'] ?></textarea>
            <span class="form__error"><?= $errors['lot-message'] ?? '' ?></span>
        </div>
        <div class="form__item form__item--file <?= !empty($errors['lot-img']) ? 'form__item--invalid' : '' ?>">
            <label>Изображение (png/jpg/jpeg)<sup>*</sup></label>
            <div class="form__input-file">
                <input class="visually-hidden" name="lot-img" type="file" id="lot-img" value="<?= $lotInput['lot-img'] ?>">
                <label for="lot-img">
                    Добавить
                </label>
            </div>
            <span class="form__error"><?= $errors['lot-img'] ?? '' ?></span>
        </div>
        <div class="form__container-three ">
            <div class="form__item form__item--small <?= !empty($errors['lot-rate']) ? 'form__item--invalid' : '' ?>">
                <label for="lot-rate">Начальная цена <sup>*</sup></label>
                <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value="<?= $lotInput['lot-rate'] ?>">
                <span class="form__error"><?= $errors['lot-rate'] ?? '' ?></span>
            </div>
            <div class="form__item form__item--small <?= !empty($errors['lot-step']) ? 'form__item--invalid' : '' ?>">
                <label for="lot-step">Шаг ставки <sup>*</sup></label>
                <input id="lot-step" type="text" name="lot-step" placeholder="0" value="<?= $lotInput['lot-step'] ?>">
                <span class="form__error"><?= $errors['lot-step'] ?? '' ?></span>
            </div>
            <div class="form__item <?= !empty($errors['lot-date']) ? 'form__item--invalid' : '' ?>">
                <label for="lot-date">Дата окончания торгов больше хотя бы на один день<sup>*</sup></label>
                <input class="form__input-date" id="lot-date" type="text" name="lot-date"
                       placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?= $lotInput['lot-date'] ?>">
                <span class="form__error"><?= $errors['lot-date'] ?? '' ?></span>
            </div>
        </div>
        <span class="form__error form__error--bottom">
            <?= !empty($errors) ? 'Пожалуйста, исправьте ошибки в форме.' : '' ?></span>
        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>


