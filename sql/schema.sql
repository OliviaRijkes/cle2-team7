-- schema.sql
-- Importeren via phpMyAdmin nadat je eerst een database hebt aangemaakt

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS reservations;
DROP TABLE IF EXISTS rooms;
DROP TABLE IF EXISTS users;

SET FOREIGN_KEY_CHECKS = 1;


-- =========================
-- TABEL: users
-- =========================
CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       email VARCHAR(100),
                       password VARCHAR(255),
                       firstname VARCHAR(100),
                       lastname VARCHAR(100),

    -- 0 = medewerker
    -- 1 = admin
                       is_admin TINYINT(1) NOT NULL DEFAULT 0
);


-- =========================
-- TABEL: rooms
-- =========================
CREATE TABLE rooms (
    -- Unieke identifier per zaal
                       id INT AUTO_INCREMENT PRIMARY KEY,

    -- Naam van de zaal
                       name VARCHAR(100) NOT NULL,

    -- Aantal zitplaatsen (vereist door JS)
                       capacity INT NOT NULL DEFAULT 0,

    -- Kleur voor UI / agenda
                       color VARCHAR(20) NOT NULL DEFAULT '#1e90ff',

    -- 1 = actief, 0 = niet actief
                       is_active TINYINT(1) NOT NULL DEFAULT 1
);

-- Standaard zalen (met capacity)
INSERT INTO rooms (name, capacity, color, is_active) VALUES
                                                         ('Zaal 1', 20, '#1e90ff', 1),
                                                         ('Zaal 2', 12, '#28a745', 1),
                                                         ('Zaal 3', 8,  '#ffc107', 1),
                                                         ('Zaal 4', 30, '#dc3545', 1);


-- =========================
-- TABEL: reservations
-- =========================
CREATE TABLE reservations (
                              id INT AUTO_INCREMENT PRIMARY KEY,

    -- Verwijzing naar zaal
                              room_id INT NOT NULL,

    -- Verwijzing naar gebruiker (vereist door PHP)
                              user_id INT NOT NULL,

    -- Titel/omschrijving
                              title VARCHAR(255) NOT NULL,

    -- Start / eind
                              start_datetime DATETIME NOT NULL,
                              end_datetime DATETIME NOT NULL,

    -- Indexen
                              INDEX (room_id),
                              INDEX (user_id),

    -- Foreign keys
                              CONSTRAINT fk_reservations_room
                                  FOREIGN KEY (room_id)
                                      REFERENCES rooms(id)
                                      ON DELETE RESTRICT
                                      ON UPDATE CASCADE,

                              CONSTRAINT fk_reservations_user
                                  FOREIGN KEY (user_id)
                                      REFERENCES users(id)
                                      ON DELETE RESTRICT
                                      ON UPDATE CASCADE
);
