CREATE TABLE Grower(
  id SERIAL PRIMARY KEY, 
  username varchar(50) NOT NULL, 
  password varchar(50) NOT NULL
);

CREATE TABLE Plant(
  id SERIAL PRIMARY KEY,
  tradename varchar NOT NULL,
  latin_name varchar
);

CREATE TABLE Plant_Description(
  id SERIAL PRIMARY KEY,
  plant_id INTEGER REFERENCES Plant(id),
  light varchar,
  water varchar,
  description varchar,
  edited DATE
);

CREATE TABLE Writer(
  grower_id INTEGER REFERENCES Grower(id),
  description_id INTEGER REFERENCES Plant_Description(id)
);

CREATE TABLE Owned_Plant(
  id SERIAL PRIMARY KEY,
  grower_id INTEGER REFERENCES Grower(id), 
  plant_id INTEGER REFERENCES Plant(id),
  acquisition date,
  status varchar NOT NULL,
  location varchar NOT NULL,
  distance_window decimal NOT NULL,
  soil varchar NOT NULL,
  soil_description varchar NOT NULL,
  watering varchar NOT NULL,
  fertilizing varchar NOT NULL,
  details varchar NOT NULL,
  added DATE NOT NULL
);

CREATE TABLE Diary(
  id SERIAL PRIMARY KEY,
  grower_id INTEGER REFERENCES Grower(id),
  owned_id INTEGER REFERENCES Owned_Plant(id),
  posted timestamp NOT NULL,
  post text NOT NULL 
);

