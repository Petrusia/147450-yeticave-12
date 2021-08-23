CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8mb4;

USE yeticave;


CREATE TABLE category
(
  category_id    INT AUTO_INCREMENT PRIMARY KEY,
  category_name  VARCHAR(128) NOT NULL UNIQUE,
  category_alias VARCHAR(128) NOT NULL UNIQUE
);

CREATE TABLE user
(
  user_id       INT AUTO_INCREMENT PRIMARY KEY,
  user_registered      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  user_email    VARCHAR(128) NOT NULL UNIQUE,
  user_name     VARCHAR(128) NOT NULL,
  user_password VARCHAR(128) NOT NULL,
  user_contact  VARCHAR(500)
);

drop table if exists lot cascade;
CREATE TABLE lot
(
  lot_id      INT AUTO_INCREMENT PRIMARY KEY,
  lot_name    VARCHAR(255) NOT NULL,
  lot_desc    TEXT NOT NULL,
  lot_img     VARCHAR(255),
  lot_price   INT UNSIGNED NOT NULL,
  lot_create  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  lot_end     DATE,
  lot_bet_step    INT UNSIGNED NOT NULL,
  lot_author_id   INT UNSIGNED,
  lot_winner_id   INT UNSIGNED,
  lot_category_id INT UNSIGNED
);

drop table if exists bet cascade;
CREATE TABLE bet
(
  bet_id    INT AUTO_INCREMENT PRIMARY KEY,
  bet_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  bet_price INT UNSIGNED NOT NULL,
  bet_author_id   INT UNSIGNED,
  bet_lot_id    INT UNSIGNED
);

CREATE INDEX lot_end ON lot (lot_end);
CREATE FULLTEXT INDEX search_by_lot ON lot(lot_name, lot_desc);
