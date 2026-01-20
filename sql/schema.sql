
-- Importeren via phpMyAdmin nadat je eerst een database hebt aangemaakt.


SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS reservations;
DROP TABLE IF EXISTS rooms;
DROP TABLE IF EXISTS users;

SET FOREIGN_KEY_CHECKS = 1;


CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       email VARCHAR(100),
                       password VARCHAR(255),
                       firstname VARCHAR(100),
                       lastname VARCHAR(100),

    -- Admin-flag:
    -- 0 = medewerker
    -- 1 = admin
                       is_admin TINYINT(1)
);



-- TABEL: rooms
-- Bevat alle zalen die gereserveerd kunnen worden
CREATE TABLE rooms (
    -- Unieke identifier per zaal
                       id INT AUTO_INCREMENT PRIMARY KEY,

    -- Naam van de zaal (bijv. Zaal 1)
                       name VARCHAR(100) NOT NULL,

    -- Kleurcode voor weergave in UI/agenda
                       color VARCHAR(20) NOT NULL DEFAULT '#1e90ff',

    -- Actieve status:
    -- 1 = zaal is beschikbaar
    -- 0 = zaal is uitgeschakeld (niet te reserveren)
                       is_active TINYINT(1) NOT NULL DEFAULT 1
);

-- Standaard zalen toevoegen
INSERT INTO rooms (name, color, is_active) VALUES
                                               ('Zaal 1', '#1e90ff', 1),
                                               ('Zaal 2', '#28a745', 1),
                                               ('Zaal 3', '#ffc107', 1),
                                               ('Zaal 4', '#dc3545', 1);



-- TABEL: reservations
-- Bevat alle reserveringen per zaal
CREATE TABLE reservations (
                              id INT AUTO_INCREMENT PRIMARY KEY,
    -- Verwijzing naar de zaal
                              room_id INT NOT NULL,
    -- Titel/omschrijving
                              title VARCHAR(255) NOT NULL,
    -- Startdatum en -tijd
                              start_datetime DATETIME NOT NULL,
    -- Einddatum en -tijd
                              end_datetime DATETIME NOT NULL,
    -- Index op room_id sneller queries
                              INDEX (room_id),
    -- Foreign key constraint(voorkomt reserveringen zonder geldige zaal):
                              CONSTRAINT fk_reservations_room
                                  FOREIGN KEY (room_id)
                                      REFERENCES rooms(id)
                                      ON DELETE RESTRICT   -- zaal kan niet verwijderd worden als er reserveringen zijn
                                      ON UPDATE CASCADE    -- bij wijziging van room.id wordt dit doorgevoerd
);
