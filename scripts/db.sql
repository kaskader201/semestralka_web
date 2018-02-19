CREATE TABLE USERS (
  id                INT(6)                AUTO_INCREMENT PRIMARY KEY,
  email             VARCHAR(255) NOT NULL UNIQUE,
  tel               VARCHAR(20)  NOT NULL UNIQUE,
  password          VARCHAR(280) NOT NULL,
  token             VARCHAR(255),
  permission        INT(6)       NOT NULL DEFAULT '1',
  firstname         VARCHAR(30)  NOT NULL,
  lastname          VARCHAR(30)  NOT NULL,
  nickname          VARCHAR(30)  NOT NULL,
  reg_date          TIMESTAMP,
  verified          TINYINT(1),
  active            TINYINT(1)   NOT NULL DEFAULT '1',
  is_login          TINYINT(1)   NOT NULL DEFAULT '0',
  verification_code VARCHAR(255),
  CONSTRAINT Unique_User UNIQUE (email, firstname, lastname)

);
CREATE INDEX user_email
  ON USERS (email);
CREATE INDEX user_token
  ON USERS (token);
CREATE INDEX user_id
  ON USERS (id);
INSERT INTO `USERS` (`email`, `tel`, `password`, `token`, `permission`, `firstname`, `lastname`, nickname,`reg_date`, `verified`, `active`, `verification_code`) VALUES
  ('t@t.cz', '(+420) 545 454 546', '$2y$10$tB/aUcY1Cmk/8XP2nDvjO.AxwaqxoyaYcUb2EpITE7r9DnNE7vZJy', 's5a83682c106979.31836314', 2, 'Admin', 'Test', 'lolkar', '2018-01-13 22:35:24', 1, 1, NULL),
  ('t2@t.cz', '(+420) 122 112 313', '$2y$10$Vj6Ox.1vRnFScNC.TMJDN.diKw6sDmi.LVqdDwyELduJDiP6d9olS', 's5a84684d10db62.66778186', 3, 'Editor', 'Test', 'loktar', '2018-01-14 16:48:13', 1, 1, NULL);


CREATE TABLE PERMISSION (
  id    INT(6) AUTO_INCREMENT PRIMARY KEY,
  name  VARCHAR(200) NOT NULL UNIQUE,
  value INT(6)       NOT NULL UNIQUE,
  CONSTRAINT Unique_Permission UNIQUE (name, value)
);

CREATE INDEX permission_value
  ON PERMISSION (value);

INSERT INTO `PERMISSION` (`id`, `name`, `value`) VALUES

  (1, 'Guest', 1),
  (2, 'Administrator', 31),
  (3, 'Editor', 3);

CREATE TABLE MENU (
  id              INT(6) AUTO_INCREMENT PRIMARY KEY,
  text            VARCHAR(200) NOT NULL,
  url             VARCHAR(200) NOT NULL,
  min_permisssion INT(6)       NOT NULL,
  order_no        INT(3)       NOT NULL,
  parent_menu_id  INT(6)
);
ALTER TABLE `MENU` ADD `visible` TINYINT(1) NOT NULL DEFAULT '1' AFTER `parent_menu_id`;

INSERT INTO `MENU` (`id`, `text`, `url`, `min_permisssion`, `order_no`, `parent_menu_id`) VALUES
  (1, 'Hlavní strana', 'index', 0, 1, NULL),
  (2, 'Uživatelé', 'users', 31, 2, NULL),
  (3, 'Vytvoření nového uživatele', 'new', 31, 1, 2),
  (4, 'Přehled všech uživatelů', '', 31, 0, 2),
  (5, 'Login', 'login', '0', '999', NULL),
  (6, 'Produkty', 'products', '1', '3', NULL);

INSERT INTO `MENU` (`text`, `url`, `min_permisssion`, `order_no`, `parent_menu_id`, `visible`) VALUES ('Ajax', 'ajax', '2', '0', NULL, '0');
INSERT INTO `MENU` (`text`, `url`, `min_permisssion`, `order_no`, `parent_menu_id`, `visible`) VALUES ('error-404', 'error-404', '0', '998', NULL, '0');

CREATE TABLE PRODUCTS (
  id    INT(6) AUTO_INCREMENT PRIMARY KEY,
  name  VARCHAR(200) NOT NULL,
  price FLOAT(6)       NOT NULL
);