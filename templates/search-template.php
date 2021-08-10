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
    <div class="container">
        <section class="lots">
            <?php if (count($lots) > 0): ?>
                <h2>Результаты поиска по запросу «<span><?= esc($searchQuery) ?></span>»</h2>
            <?php else: ?>
                <h2>Ничего не найдено по вашему запросу «<span><?= esc($searchQuery) ?></span>»</h2>
            <?php endif; ?>
            <ul class="lots__list">
                <!--заполните этот список из массива с товарами-->
                <?php foreach ($lots as $lot) :?>
                    <?php $data = getDateDiff($lot['lot_end']); ?>

                    <li class="lots__item lot">
                        <div class="lot__image">
                            <img src="<?=esc($lot['lot_img']) ?>" width="350" height="260" alt="" style="object-fit: cover;">
                        </div>
                        <div class="lot__info">
                            <span class="lot__category"><?= esc($lot['category_name']) ?></span>
                            <h3 class="lot__title">
                                <a class="text-link" href="lot.php?lot_id=<?= esc($lot['lot_id']) ?>">
                                    <?= esc($lot['lot_name']) ?>
                                </a>
                            </h3>
                            <div class="lot__state">
                                <div class="lot__rate">
                                    <?php if ($lot['bet_count'] > 0) : ?>
                                        <span class="lot__amount"><?= $lot['bet_count'] .' '. get_noun_plural_form($lot['bet_count'], 'ставка', 'ставки', 'ставок');?></span>
                                    <?php else : ?>
                                        <span class="lot__amount">Стартовая цена</span>
                                    <?php endif; ?>
                                    <span class="lot__cost"><?= esc(getPrice($lot['lot_price'])) ?></span>
                                </div>
                                <div class="lot__timer timer <?= ($data['hours'] <= 0) ? 'timer--finishing' : ''; ?>">
                                    <?= esc($data['hours']) . ':' . esc($data['minutes']) ?>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php
                endforeach; ?>
            </ul>
        </section>
        <?php if ($lotsPagesCount > 1) : ?>
            <ul class="pagination-list">

                <li class="pagination-item pagination-item-prev">
                    <?php if ($currentPage > 1): ?>
                        <a href="search.php?search=<?= esc($searchQuery) ?>&page=<?= esc($currentPage - 1) ?>">Назад</a>
                    <?php else: ?>
                        <a class="disabled">Назад</a>
                    <?php endif; ?>
                </li>

                <?php foreach ($lotsPagesRange as $lotsPage): ?>
                    <li class="pagination-item <?= $lotsPage == $currentPage ? 'pagination-item-active' : ''  ?>">
                    <a href="search.php?search=<?= esc($searchQuery) ?>&page=<?= esc($lotsPage) ?>"><?= esc($lotsPage) ?></a>
                    </li>
                <?php endforeach; ?>

                <li class="pagination-item pagination-item-next">
                    <?php if ($currentPage < $lotsPagesCount) : ?>
                        <a href="search.php?search=<?= esc($searchQuery) ?>&page=<?= esc($currentPage + 1) ?>">Вперед</a>
                    <?php else: ?>
                        <a class="disabled">Вперед</a>
                    <?php endif; ?>

                </li>
            </ul>
        <?php endif; ?>
    </div>
</main>
