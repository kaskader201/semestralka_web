#pro devel
CREATE DATABASE semestralka;
#pro produkci
CREATE DATABASE jelinda6;



CREATE TABLE USERS (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(70) NOT NULL UNIQUE,
  password  VARCHAR(280) NOT NULL,
  salt  VARCHAR(280) NOT NULL,
  token  VARCHAR(255),
  permission  INT(6) NOT NULL DEFAULT '1',
  firstname VARCHAR(30) NOT NULL,
  lastname VARCHAR(30) NOT NULL,
  reg_date TIMESTAMP,
  verified TINYINT (1),
  verification_code VARCHAR(255),
  CONSTRAINT Unique_User UNIQUE (email,firstname,lastname)

);
CREATE INDEX user_email
  ON USERS (email);
CREATE INDEX user_token
  ON USERS (token);
CREATE INDEX user_id
  ON USERS (id);