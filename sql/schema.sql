CREATE TABLE rooms (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       name VARCHAR(100),
                       color VARCHAR(20),
                       is_active TINYINT(1)
);

INSERT INTO rooms (name, color, is_active) VALUES
                                               ('Vergaderruimte', '#1e90ff', 5),