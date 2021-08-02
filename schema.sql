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
  user_registered      DATETIME DEFAULT CURRENT_TIMESTAMP,
  user_email    VARCHAR(128) NOT NULL UNIQUE,
  user_name     VARCHAR(128) NOT NULL,
  user_password VARCHAR(128) NOT NULL,
  user_contact  TEXT,
  lot_id        INT,
  bet_id        INT
);


CREATE TABLE lot
(
  lot_id      INT AUTO_INCREMENT PRIMARY KEY,
  lot_name    VARCHAR(255) NOT NULL,
  lot_desc    TEXT NOT NULL,
  lot_img     VARCHAR(255),
  lot_price   INT UNSIGNED NOT NULL,
  lot_create  DATETIME DEFAULT CURRENT_TIMESTAMP,
  lot_end     DATE,
  lot_bet_step    INT UNSIGNED NOT NULL,
  lot_author_id   INT,
  lot_winner_id   INT,
  lot_category_id INT,

  FOREIGN KEY (lot_author_id) REFERENCES user (user_id),
  FOREIGN KEY (lot_winner_id) REFERENCES user (user_id),
  FOREIGN KEY (lot_category_id) REFERENCES category (category_id)

);


CREATE TABLE bet
(
  bet_id    INT AUTO_INCREMENT PRIMARY KEY,
  bet_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  bet_price INT UNSIGNED NOT NULL,
  bet_author_id   INT,
  bet_lot_id    INT,
  FOREIGN KEY (bet_author_id) REFERENCES user (user_id),
  FOREIGN KEY (bet_lot_id) REFERENCES lot (lot_id)
);


ALTER TABLE user
  ADD FOREIGN KEY (lot_id) REFERENCES lot (lot_id);
ALTER TABLE user
  ADD FOREIGN KEY (bet_id) REFERENCES bet (bet_id);

CREATE INDEX lot_name ON lot (lot_name);
CREATE INDEX lot_price ON lot (lot_price);

