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
SET user_name     = 'Alex',
    user_email        = 'alex@nomail.ru',
    user_password     = 'secret',
    user_contact = 'Peter';
INSERT INTO user
SET user_name     = 'Petr',
    user_email        = 'petr@nomail.ru',
    user_password     = 'secret',
    user_contact= 'Vilnius';
INSERT INTO user
SET user_name     = 'John',
    user_email        = 'john@nomail.ru',
    user_password     = 'secret',
    user_contact = 'Kaunas';
INSERT INTO user
SET user_name     = 'Igor',
    user_email        = 'igor@nomail.ru',
    user_password     = 'secret',
    user_contact = 'Moscow';

INSERT INTO lot
SET lot_name    = '2014 Rossignol District Snowboard',
    lot_price   = 10999,
    lot_desc = 'orem ipsum dolor sit amet, consectetur adipiscing elit,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                reprehenderit in voluptate velit esse cillum dolore eu fugiat
                nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                sunt in culpa qui officia deserunt mollit anim id est laborum.',
    lot_img     = 'img/lot-1.jpg',
    lot_create   = '2021-05-01',
    lot_end     = '2021-08-20',
    lot_bet_step    = 1000,
    lot_author_id   = 1,
    lot_category_id = 1;
INSERT INTO lot
SET lot_name    = 'DC Ply Mens 2016/2017 Snowboard',
    lot_price   = 159999,
    lot_desc = 'orem ipsum dolor sit amet, consectetur adipiscing elit,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                reprehenderit in voluptate velit esse cillum dolore eu fugiat
                nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                sunt in culpa qui officia deserunt mollit anim id est laborum.',
    lot_img     = 'img/lot-2.jpg',
    lot_create   = '2021-05-01',
    lot_end     = '2021-08-20',
    lot_bet_step    = 1000,
    lot_author_id   = 2,
    lot_category_id = 1;
INSERT INTO lot
SET lot_name    = 'Крепления Union Contact Pro 2015 года размер L/XL',
    lot_price   = 8000,
    lot_desc = 'orem ipsum dolor sit amet, consectetur adipiscing elit,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                reprehenderit in voluptate velit esse cillum dolore eu fugiat
                nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                sunt in culpa qui officia deserunt mollit anim id est laborum.',
    lot_img     = 'img/lot-3.jpg',
    lot_create   = '2021-05-01',
    lot_end     = '2021-08-20',
    lot_bet_step    = 1120,
    lot_author_id   = 3,
    lot_category_id = 2;
INSERT INTO lot
SET lot_name    = 'Ботинки для сноуборда DC Mutiny Charocal',
    lot_price   = 10999,
    lot_desc = 'orem ipsum dolor sit amet, consectetur adipiscing elit,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                reprehenderit in voluptate velit esse cillum dolore eu fugiat
                nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                sunt in culpa qui officia deserunt mollit anim id est laborum.',
    lot_img     = 'img/lot-4.jpg',
    lot_create   = '2021-05-01',
    lot_end     = '2021-08-20',
    lot_bet_step    = 550,
    lot_author_id   = 4,
    lot_category_id = 3;
INSERT INTO lot
SET lot_name    = 'Куртка для сноуборда DC Mutiny Charocal',
    lot_price   = 7500,
    lot_desc = 'orem ipsum dolor sit amet, consectetur adipiscing elit,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                reprehenderit in voluptate velit esse cillum dolore eu fugiat
                nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                sunt in culpa qui officia deserunt mollit anim id est laborum.',
    lot_img     = 'img/lot-5.jpg',
    lot_create  = '2021-05-01',
    lot_end     = '2021-08-20',
    lot_bet_step    = 720,
    lot_author_id   = 1,
    lot_category_id = 4;
INSERT INTO lot
SET lot_name    = 'Маска Oakley Canopy',
    lot_price   = 5400,
    lot_desc = 'orem ipsum dolor sit amet, consectetur adipiscing elit,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                reprehenderit in voluptate velit esse cillum dolore eu fugiat
                nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                sunt in culpa qui officia deserunt mollit anim id est laborum.',
    lot_img     = 'img/lot-6.jpg',
    lot_create   = '2021-05-01',
    lot_end     = '2021-08-20',
    lot_bet_step    = 2020,
    lot_author_id   = 2,
    lot_category_id = 6;

INSERT INTO bet
SET bet_price = 11999,
    bet_date = '2020-05-01',
    bet_lot_id    = 1,
    bet_author_id   = 1;
INSERT INTO bet
SET bet_price = 12999,
    bet_date = '2020-05-01',
    bet_lot_id    = 1,
    bet_author_id   = 2;


SELECT *
FROM category;

SELECT lot_name, lot_price, lot_img, bet_price, category_name
FROM lot
         INNER JOIN bet ON lot.lot_id = bet.bet_id
         INNER JOIN category ON lot_category_id = category_id
WHERE lot_create < lot_end;

UPDATE lot
SET lot_name = '2019 Rossignol District Snowboard'
WHERE lot_id = '1';

SELECT lot.lot_id, lot_name, bet_id, bet_date, bet_price
FROM lot
         INNER JOIN bet ON lot.lot_id = bet.bet_id
WHERE lot_id = 1
ORDER BY lot_create ;

UPDATE lot
SET lot_desc = 'Легкий маневренный сноуборд, готовый дать жару в любом парке,
растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax,
уложенное в двух направлениях. '
WHERE lot_id = '1';
