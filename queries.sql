INSERT INTO category
SET category_name  = 'Доски и лыжи',
    category_alias = 'boards';
INSERT INTO category
SET category_name  = 'Крепления',
    category_alias = 'attachment';
INSERT INTO category
SET category_name  = 'Ботинки',
    category_alias = 'boots';
INSERT INTO category
SET category_name  = 'Одежда',
    category_alias = 'clothing';
INSERT INTO category
SET category_name  = 'Инструменты',
    category_alias = 'tools';
INSERT INTO category
SET category_name  = 'Разное',
    category_alias = 'other';

INSERT INTO user
SET username     = 'Alex',
    email        = 'alex@nomail.ru',
    password     = 'secret',
    contact_info = 'Peter';
INSERT INTO user
SET username     = 'Petr',
    email        = 'petr@nomail.ru',
    password     = 'secret',
    contact_info = 'Vilnius';
INSERT INTO user
SET username     = 'John',
    email        = 'john@nomail.ru',
    password     = 'secret',
    contact_info = 'Kaunas';
INSERT INTO user
SET username     = 'Igor',
    email        = 'igor@nomail.ru',
    password     = 'secret',
    contact_info = 'Moscow';

INSERT INTO lot
SET lot_name    = '2014 Rossignol District Snowboard',
    lot_price   = 10999,
    lot_img     = 'img/lot-1.jpg',
    lot_start   = '2021-05-01',
    lot_end     = '2021-05-20',
    bet_step    = 1000,
    author_id   = 1,
    category_id = 1;
INSERT INTO lot
SET lot_name    = 'DC Ply Mens 2016/2017 Snowboard',
    lot_price   = 159999,
    lot_img     = 'img/lot-2.jpg',
    lot_start   = '2021-05-01',
    lot_end     = '2021-05-20',
    bet_step    = 1000,
    author_id   = 2,
    category_id = 1;
INSERT INTO lot
SET lot_name    = 'Крепления Union Contact Pro 2015 года размер L/XL',
    lot_price   = 8000,
    lot_img     = 'img/lot-3.jpg',
    lot_start   = '2021-05-01',
    lot_end     = '2021-05-20',
    bet_step    = 1120,
    author_id   = 3,
    category_id = 2;
INSERT INTO lot
SET lot_name    = 'Ботинки для сноуборда DC Mutiny Charocal',
    lot_price   = 10999,
    lot_img     = 'img/lot-4.jpg',
    lot_start   = '2021-05-01',
    lot_end     = '2021-05-20',
    bet_step    = 550,
    author_id   = 4,
    category_id = 3;
INSERT INTO lot
SET lot_name    = 'Куртка для сноуборда DC Mutiny Charocal',
    lot_price   = 7500,
    lot_img     = 'img/lot-5.jpg',
    lot_start   = '2021-05-01',
    lot_end     = '2021-05-20',
    bet_step    = 720,
    author_id   = 1,
    category_id = 4;
INSERT INTO lot
SET lot_name    = 'Маска Oakley Canopy',
    lot_price   = 5400,
    lot_img     = 'img/lot-6.jpg',
    lot_start   = '2021-05-01',
    lot_end     = '2021-05-20',
    bet_step    = 2020,
    author_id   = 2,
    category_id = 6;

INSERT INTO bet
SET bet_price = 11999,
    bet_start = '2020-05-01',
    lot_id    = 1,
    user_id   = 1;
INSERT INTO bet
SET bet_price = 12999,
    bet_start = '2020-05-01',
    lot_id    = 1,
    user_id   = 2;


SELECT *
FROM category;

SELECT lot_name, lot_price, lot_img, bet_price, category_name
FROM lot
         INNER JOIN bet ON lot.id = bet.id
         INNER JOIN category ON lot.category_id = category.id
WHERE lot.lot_start < lot.lot_end;

UPDATE lot
SET lot_name = '2019 Rossignol District Snowboard'
WHERE id = '1';

SELECT lot.id, lot_name, bet.id, bet_start, bet_price
FROM lot
         INNER JOIN bet ON lot.id = bet.id
WHERE lot.id = 1
ORDER BY lot_start ASC;
