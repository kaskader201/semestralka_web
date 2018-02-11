#pro devel
CREATE DATABASE semestralka;
#pro produkci
CREATE DATABASE jelinda6;


CREATE TABLE USERS (
  id                INT(6)                AUTO_INCREMENT PRIMARY KEY,
  email             VARCHAR(255) NOT NULL UNIQUE,
  tel               VARCHAR(20)  NOT NULL UNIQUE,
  password          VARCHAR(280) NOT NULL,
  token             VARCHAR(255),
  permission        INT(6)       NOT NULL DEFAULT '1',
  firstname         VARCHAR(30)  NOT NULL,
  lastname          VARCHAR(30)  NOT NULL,
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
CREATE INDEX user_id
  ON USERS (active);

CREATE TABLE PERMISSION (
  id    INT(6) AUTO_INCREMENT PRIMARY KEY,
  name  VARCHAR(200) NOT NULL UNIQUE,
  value INT(6)       NOT NULL UNIQUE,
  CONSTRAINT Unique_Permission UNIQUE (name, value)
);

CREATE INDEX permission_value
  ON PERMISSION (value);

INSERT INTO `permission` (`id`, `name`, `value`) VALUES

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
INSERT INTO `menu` (`text`, `url`, `min_permisssion`, `order_no`, `parent_menu_id`) VALUES
  ('Hlavní strana', '', '1', '1', NULL),
  ('Uživatelé', 'users', '31', '2', NULL),
  ('Login', 'login', '1', '999', NULL);
