CREATE TABLE Grower(
  id SERIAL PRIMARY KEY, 
  username varchar(50) NOT NULL, 
  password varchar(50) NOT NULL
);

CREATE TABLE Plant(
  id SERIAL PRIMARY KEY,
  tradename varchar NOT NULL,
  latin_name varchar,
  light varchar,
  water varchar,
  description varchar,
  edited DATE
);

CREATE TABLE Writer(
  grower_id INTEGER REFERENCES Grower(id),
  plant_id INTEGER REFERENCES Plant(id)
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
  title varchar(50),
  posted DATE NOT NULL,
  post text NOT NULL 
);

