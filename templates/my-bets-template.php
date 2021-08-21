<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php
            foreach ($categories as $category) : ?>
                <li class="nav__item <?= esc($category['category_name'] == $searchQuery ? 'nav__item--current' : ''); ?>">
                    <a href="/all-lots.php?category=<?= esc($category['category_name']) ?>"><?= esc($category['category_name']) ?></a>
                </li>
            <?php
            endforeach; ?>
        </ul>
    </nav>

    <section class="rates container">
        <?php if (count($lots) > 0): ?>
            <h2>Мои ставки</h2>
        <?php else: ?>
            <h2>Ничего не найдено</h2>
        <?php endif; ?>
        <table class="rates__list">
            <?php foreach ($lots as $lot) : ?>
                <?php $data = getDateDiff($lot['lot_end']);
                $remainingTime = (strtotime($lot['lot_end']) - time()) <= 0;
                $lotWinner = ($lot['lot_winner_id'] ?? 0) == $authUser['user_id'];
                $endTime = $remainingTime && !$lotWinner;
                $winBet = $remainingTime && $lotWinner;
                ?>
                <tr class="rates__item <?=  $endTime ? 'rates__item--end' : '' ?><?=  $winBet ? 'rates__item--win' : '' ?>">
                    <td class="rates__info">
                        <div class="rates__img">
                            <img src="<?= esc($lot['lot_img']) ?>" width="54" height="40"  alt="<?= esc($lot['lot_name']) ?>">
                        </div>
                        <div>
                            <h3 class="rates__title">
                                <a href="/lot.php?lot_id=<?= esc($lot['lot_id']) ?>">
                                    <?= esc($lot['lot_name']) ?>
                                </a>
                            </h3>
                            <?php if ($winBet) : ?>
                                <p><?= esc($lot['user_contact']); ?></p>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td class="rates__category">
                        <?= esc($lot['category_name']) ?>
                    </td>
                    <td class="rates__timer">
                        <?php if ($winBet) : ?>
                            <div class="timer timer--win">Ставка выиграла</div>
                        <?php elseif ($endTime) : ?>
                            <div class="timer timer--end">Торги окончены</div>
                        <?php else : ?>
                            <div class="timer <?= ($data['hours'] <= 0) ? 'timer--finishing' : ''; ?>">
                                <?= esc($data['hours']) . ':' . esc($data['minutes']) ?>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="rates__price">
                        <?= esc(getPrice($lot['lot_price'])) ?>
                    </td>
                    <td class="rates__time">
                        <?= esc(betDateFormat($lot['bet_date'])) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>
</main>
