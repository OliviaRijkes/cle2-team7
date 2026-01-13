CREATE TABLE users
(
    id        INT AUTO_INCREMENT PRIMARY KEY,
    email     VARCHAR(100),
    password  VARCHAR(255),
    firstname VARCHAR(100),
    lastname  VARCHAR(100),
    is_admin  TINYINT(1)
);
