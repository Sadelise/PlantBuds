INSERT INTO Grower (username, password) VALUES ('Tiina', '1234');
INSERT INTO Grower (username, password) VALUES ('Pertti', '5678');

INSERT INTO Plant (tradename, latin_name) VALUES ('Jukkapalmu', 'Yucca elephantipes');
INSERT INTO Plant (tradename, latin_name) VALUES ('Liekkipuu', 'Delonix regia');
INSERT INTO Plant (tradename, latin_name) VALUES ('Limoviikuna', 'Ficus benjamina');

CREATE VIEW Jukan_id AS (SELECT id FROM Plant Where tradename = 'Jukkapalmu' LIMIT 1);
CREATE VIEW Kasvattajan_id AS (SELECT id FROM Grower Where username = 'Tiina' LIMIT 1);
CREATE VIEW Pertin_id AS (SELECT id FROM Grower Where username = 'Pertti' LIMIT 1);

INSERT INTO Plant_Description (plant_id, light, water, description, edited) VALUES ((SELECT * FROM Jukan_id) ,'Paljon', 'vähäinen', 'Paras kasvi', NOW());

CREATE VIEW D_id AS (SELECT id FROM Plant_Description WHERE plant_id = (SELECT * FROM Jukan_id));

INSERT INTO Writer (grower_id, description_id) VALUES ((SELECT * FROM Kasvattajan_id), (SELECT * FROM D_id));
INSERT INTO Writer (grower_id, description_id) VALUES ((SELECT * FROM Pertin_id), (SELECT * FROM D_id));

INSERT INTO Owned_Plant (grower_id, plant_id, acquisition, status, location, distance_window, soil, soil_description, watering, fertilizing, details, added) VALUES ((SELECT * FROM Kasvattajan_id), (SELECT * FROM Jukan_id), '2003-03-21', 'elossa', 'Pohjois-ikkuna', 0.5, 'kaupallinen', 'kekkilä', 'kerran viikossa', 'kerran kuukaudessa', 'Pistokkaasta kasvatettu', NOW() );
INSERT INTO Owned_Plant (grower_id, plant_id, acquisition, status, location, distance_window, soil, soil_description, watering, fertilizing, details, added) VALUES ((SELECT * FROM Pertin_id), (SELECT * FROM Jukan_id), '2003-03-21', 'elossa', 'Etelä-ikkuna', 1.0, 'kaupallinen', 'biolan', 'kerran kuukaudessa', 'ei koskaan', 'Plantagenista ostettu', NOW() );
INSERT INTO Owned_Plant (grower_id, plant_id, acquisition, status, location, distance_window, soil, soil_description, watering, fertilizing, details, added) VALUES ((SELECT * FROM Pertin_id), 2, '2003-03-21', 'elossa', 'Etelä-ikkuna', 0.5, 'sekoitus', 'Kookoskuitu+perliitti', 'kerran viikossa', 'kerran kahdessa viikossa', 'Siemenestä kasvatettu', NOW() );
INSERT INTO Owned_Plant (grower_id, plant_id, acquisition, status, location, distance_window, soil, soil_description, watering, fertilizing, details, added) VALUES ((SELECT * FROM Pertin_id), 3, '05.12.2007', 'elossa', 'Etelä-ikkuna', 1.0, 'kaupallinen', 'kekkilä', 'kerran kuukaudessa', 'kerran kahdessa viikossa', 'Raision kukkatalosta ostettu.', NOW() );

CREATE VIEW OP_id AS (SELECT id FROM Owned_Plant WHERE plant_id = (SELECT * FROM Jukan_id) LIMIT 1);

INSERT INTO Diary (grower_id, owned_id, posted, post) VALUES ((SELECT * FROM Kasvattajan_id),(SELECT * FROM OP_id), NOW(), 'Kasvi kasvanut sentin eilisestä.');