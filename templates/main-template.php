<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и
            горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <!--заполните этот список из массива категорий-->
            <?php
            foreach ($categories as $category) : ?>
                <li class="promo__item promo__item--<?= $category['category_alias']; ?>">
                    <a class="promo__link" href="pages/all-lots.html"><?= htmlspecialchars($category['category_name']) ?></a>
                </li>
            <?php
            endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <!--заполните этот список из массива с товарами-->
            <?php
            foreach ($lots as $lot) :?>
                <?php
                $data = getDateDiff($lot['lot_end']) ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= htmlspecialchars($lot['lot_img']) ?>" width="350" height="260" alt="">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= htmlspecialchars($lot['category_name']) ?></span>
                        <h3 class="lot__title"><a class="text-link" href="lot.php?lot_id=<?= htmlspecialchars($lot['id']) ?>"><?= htmlspecialchars(
                                    $lot['lot_name']
                                ) ?></a>
                        </h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?= getPrice(htmlspecialchars($lot['lot_price'])) ?></span>
                            </div>
                            <div class="lot__timer timer <?= ($data['hours'] <= 0) ? 'timer--finishing' : ''; ?>">
                                <?= htmlspecialchars($data['hours']) . ':' . htmlspecialchars($data['minutes']) ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php
            endforeach; ?>
        </ul>
    </section>
</main>
