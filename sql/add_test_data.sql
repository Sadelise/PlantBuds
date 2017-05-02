INSERT INTO Grower (username, password) VALUES ('Tiina', '1234');
INSERT INTO Grower (username, password) VALUES ('Pertti', '5678');
INSERT INTO Grower (username, password) VALUES ('Vieras', '1234');

INSERT INTO Plant (tradename, latin_name, light, water, description, edited) VALUES ('Jukkapalmu', 'Yucca elephantipes','Paljon', 'vähäinen', 'Ei lainkaan palmu, vaan parsa.', NOW());
INSERT INTO Plant (tradename, latin_name, light, water, description, edited) VALUES ('Liekkipuu', 'Delonix regia','Paljon', 'Kauden mukaan', 'Kotoisin Madagaskarilta', NOW());
INSERT INTO Plant (tradename, latin_name, light, water, description, edited) VALUES ('Limoviikuna', 'Ficus benjamina','Paljon', 'Pintamullan kuivahdettua', 'Tiputtaa lehtiä liian vähässä valossa.', NOW());

CREATE VIEW Jukan_id AS (SELECT id FROM Plant Where tradename = 'Jukkapalmu' LIMIT 1);
CREATE VIEW Kasvattajan_id AS (SELECT id FROM Grower Where username = 'Tiina' LIMIT 1);
CREATE VIEW Pertin_id AS (SELECT id FROM Grower Where username = 'Pertti' LIMIT 1);
CREATE VIEW Vieraan_id AS (SELECT id FROM Grower Where username = 'Vieras' LIMIT 1);

INSERT INTO Writer (grower_id, plant_id) VALUES ((SELECT * FROM Kasvattajan_id), (SELECT * FROM jukan_id));
INSERT INTO Writer (grower_id, plant_id) VALUES ((SELECT * FROM Pertin_id), (SELECT * FROM jukan_id));
INSERT INTO Writer (grower_id, plant_id) VALUES ((SELECT * FROM Kasvattajan_id), (SELECT id FROM Plant Where tradename = 'Liekkipuu' LIMIT 1));

INSERT INTO Owned_Plant (grower_id, plant_id, acquisition, status, location, distance_window, soil, soil_description, watering, fertilizing, details, added) VALUES ((SELECT * FROM Kasvattajan_id), (SELECT * FROM Jukan_id), '2003-03-21', 'elossa', 'Pohjois-ikkuna', 0.5, 'kaupallinen', 'kekkilä', 'kerran viikossa', 'kerran kuukaudessa', 'Pistokkaasta kasvatettu', NOW() );
INSERT INTO Owned_Plant (grower_id, plant_id, acquisition, status, location, distance_window, soil, soil_description, watering, fertilizing, details, added) VALUES ((SELECT * FROM Pertin_id), (SELECT * FROM Jukan_id), '2003-03-21', 'elossa', 'Etelä-ikkuna', 1.0, 'kaupallinen', 'biolan', 'kerran kuukaudessa', 'ei koskaan', 'Plantagenista ostettu', NOW() );
INSERT INTO Owned_Plant (grower_id, plant_id, acquisition, status, location, distance_window, soil, soil_description, watering, fertilizing, details, added) VALUES ((SELECT * FROM Pertin_id), 2, '2003-03-21', 'elossa', 'Etelä-ikkuna', 0.5, 'sekoitus', 'Kookoskuitu+perliitti', 'kerran viikossa', 'kerran kahdessa viikossa', 'Siemenestä kasvatettu', NOW() );
INSERT INTO Owned_Plant (grower_id, plant_id, acquisition, status, location, distance_window, soil, soil_description, watering, fertilizing, details, added) VALUES ((SELECT * FROM Pertin_id), 3, '05.12.2007', 'elossa', 'Etelä-ikkuna', 1.0, 'kaupallinen', 'kekkilä', 'kerran kuukaudessa', 'kerran kahdessa viikossa', 'Raision kukkatalosta ostettu.', NOW() );
INSERT INTO Owned_Plant (grower_id, plant_id, acquisition, status, location, distance_window, soil, soil_description, watering, fertilizing, details, added) VALUES ((SELECT * FROM Vieraan_id), 2, '05.12.2007', 'elossa', 'Etelä-ikkuna', 1.0, 'kaupallinen', 'kekkilä', 'kerran kuukaudessa', 'kerran kahdessa viikossa', 'Raision kukkatalosta ostettu.', NOW() );
INSERT INTO Owned_Plant (grower_id, plant_id, acquisition, status, location, distance_window, soil, soil_description, watering, fertilizing, details, added) VALUES ((SELECT * FROM Vieraan_id), (SELECT * FROM Jukan_id), '2003-03-21', 'elossa', 'Pohjois-ikkuna', 0.5, 'kaupallinen', 'kekkilä', 'kerran viikossa', 'kerran kuukaudessa', 'Pistokkaasta kasvatettu', NOW() );
INSERT INTO Owned_Plant (grower_id, plant_id, acquisition, status, location, distance_window, soil, soil_description, watering, fertilizing, details, added) VALUES ((SELECT * FROM Vieraan_id), 3, '05.12.2007', 'elossa', 'Etelä-ikkuna', 1.0, 'kaupallinen', 'kekkilä', 'kerran kuukaudessa', 'kerran kahdessa viikossa', 'Raision kukkatalosta ostettu.', NOW() );

CREATE VIEW OP_id AS (SELECT id FROM Owned_Plant WHERE plant_id = (SELECT * FROM Jukan_id) LIMIT 1);

INSERT INTO Diary (grower_id, owned_id, title, posted, post) VALUES ((SELECT * FROM Kasvattajan_id),(SELECT * FROM OP_id), 'Kasvi kasvaa!', NOW(), 'Kasvi kasvanut sentin eilisestä.');
INSERT INTO Diary (grower_id, owned_id, title, posted, post) VALUES ((SELECT * FROM Vieraan_id), 5, 'Kasvi kasvaa!', NOW(), 'Kasvi kasvanut sentin eilisestä.');
