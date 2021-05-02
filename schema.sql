CREATE TABLE category
(
    id             INT AUTO_INCREMENT PRIMARY KEY,
    category_name  VARCHAR(128) NOT NULL UNIQUE,
    category_alias VARCHAR(128) NOT NULL UNIQUE
);


CREATE TABLE user
(
    id           INT AUTO_INCREMENT PRIMARY KEY,
    reg_date     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email        VARCHAR(128) NOT NULL UNIQUE,
    username     VARCHAR(128) NOT NULL UNIQUE,
    password     VARCHAR(128) NOT NULL,
    contact_info TEXT,
    lot_id       INT,
    bet_id       INT

);


CREATE TABLE lot
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    lot_name    VARCHAR(255)           NOT NULL,
    lot_desc    TEXT,
    lot_img     VARCHAR(255),
    lot_price   DECIMAL(10, 2) UNSIGNED NOT NULL,
    lot_start   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    lot_end     DATETIME,
    bet_step    INT UNSIGNED           NOT NULL,
    author_id   INT,
    winner_id   INT,
    category_id INT,
    FOREIGN KEY (author_id) REFERENCES user (id),
    FOREIGN KEY (winner_id) REFERENCES user (id),
    FOREIGN KEY (category_id) REFERENCES category (id)
);


CREATE TABLE bet
(
    id        INT AUTO_INCREMENT PRIMARY KEY,
    bet_start DATETIME,
    bet_price DECIMAL(10, 2) NOT NULL,
    user_id   INT,
    lot_id    INT,
    FOREIGN KEY (user_id) REFERENCES user (id),
    FOREIGN KEY (lot_id) REFERENCES lot (id)
);


ALTER TABLE user
    ADD FOREIGN KEY (lot_id) REFERENCES lot (id);
ALTER TABLE user
    ADD FOREIGN KEY (bet_id) REFERENCES bet (id);

CREATE INDEX lot_name ON lot (lot_name);
CREATE INDEX lot_price ON lot (lot_price);

