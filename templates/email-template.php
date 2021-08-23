<h1>Поздравляем с победой</h1>
<p>Здравствуйте, <?= esc($winnerLot['user_name']); ?></p>
<p>Ваша ставка для лота <a
        href="https://yeticave.local/lot.php?id=<?= esc($winnerLot['lot_id']); ?>"><?= esc($winnerLot['lot_name']); ?></a>> победила.</p>
<p>Перейдите по ссылке <a href="https://yeticave.local/my_bets.php">мои ставки</a>,
    чтобы связаться с автором объявления</p>
<small>Интернет-Аукцион "YetiCave"</small>

