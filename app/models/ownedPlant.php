<?php

class OwnedPlant extends BaseModel {

    public $id, $tradename, $latin_name, $grower_id, $plant_id, $acquisition, $status, $location, $distance_window, $soil, $soil_description, $watering, $fertilizing, $details, $added;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_tradename', 'validate_acuisition_date');
    }

    public static function all($id) {
        $query = DB::connection()->prepare('SELECT * FROM Plant LEFT JOIN Owned_Plant ON Plant.id = Owned_Plant.plant_id WHERE Owned_Plant.grower_id = :grower_id');
        $query->execute(array('grower_id' => $id));
        $rows = $query->fetchAll();
        $plant = array();

        foreach ($rows as $row) {
            $plant[] = new OwnedPlant(array(
                'id' => $row['id'], //plant id
                'tradename' => $row['tradename'],
                'latin_name' => $row['latin_name'],
                'grower_id' => $id,
                'plant_id' => $row['plant_id'],
                'acquisition' => $row['acquisition'],
                'status' => $row['status'],
                'location' => $row['location'],
                'distance_window' => $row['distance_window'],
                'soil' => $row['soil'],
                'soil_description' => $row['soil_description'],
                'watering' => $row['watering'],
                'fertilizing' => $row['fertilizing'],
                'details' => $row['details'],
                'added' => $row['added'],
            ));
        }

        return $plant;
    }
    
     public static function allByPlantId($id) {
        $query = DB::connection()->prepare('SELECT * FROM Owned_Plant WHERE plant_id = :plant_id');
        $query->execute(array('plant_id' => $id));
        $rows = $query->fetchAll();
        $plant = array();

        foreach ($rows as $row) {
            $plant[] = new OwnedPlant(array(
                'id' => $row['id'], 
                'grower_id' => $row['grower_id'],
                'plant_id' => $row['plant_id'],
                'acquisition' => $row['acquisition'],
                'status' => $row['status'],
                'location' => $row['location'],
                'distance_window' => $row['distance_window'],
                'soil' => $row['soil'],
                'soil_description' => $row['soil_description'],
                'watering' => $row['watering'],
                'fertilizing' => $row['fertilizing'],
                'details' => $row['details'],
                'added' => $row['added'],
            ));
        }

        return $plant;
    }
    
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Plant LEFT JOIN Owned_Plant ON Plant.id = Owned_Plant.plant_id WHERE Owned_Plant.id = :owned_id AND Owned_Plant.grower_id = :grower_id LIMIT 1 ');
        $query->execute(array('owned_id' => $id,
            'grower_id' => $_SESSION['user']));
        $row = $query->fetch();

        if ($row) {
            $plant = new ownedPlant(array(
                'id' => $row['id'],
                'tradename' => $row['tradename'],
                'latin_name' => $row['latin_name'],
                'grower_id' => $row['grower_id'],
                'plant_id' => $row['plant_id'],
                'acquisition' => $row['acquisition'],
                'status' => $row['status'],
                'location' => $row['location'],
                'distance_window' => $row['distance_window'],
                'soil' => $row['soil'],
                'soil_description' => $row['soil_description'],
                'watering' => $row['watering'],
                'fertilizing' => $row['fertilizing'],
                'details' => $row['details'],
                'added' => $row['added']
            ));

            return $plant;
        }

        return null;
    }

    public function save() {
        $plant = Plant::findByName($this->tradename);
        if ($plant == null) {
            $plant = new Plant(array(
                'tradename' => $this->tradename,
                'latin_name' => $this->latin_name,
                'light' => '',
                'water' => '',
                'description' => 'Tämä kuvaus on tyhjä. Muokkaa lisätäksesi kuvaus kasville.'
            ));
            $plant->save();
        }
        $query = DB::connection()->prepare('INSERT INTO Owned_Plant (grower_id, plant_id, acquisition, status, location, distance_window, soil, soil_description, watering, fertilizing, details, added) '
                . 'VALUES (:grower_id, :plant_id, :acquisition, :status, :location, :distance_window, :soil, :soil_description, :watering, :fertilizing, :details, NOW()) RETURNING id');
        $query->execute(array('plant_id' => $plant->id,
            'acquisition' => $this->acquisition,
            'status' => 'elossa',
            'location' => $this->location,
            'distance_window' => $this->distance_window,
            'soil' => $this->soil,
            'soil_description' => $this->soil_description,
            'watering' => $this->watering,
            'fertilizing' => $this->fertilizing,
            'details' => $this->details,
            'grower_id' => $_SESSION['user']
        ));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Owned_Plant SET grower_id = :grower_id, plant_id = :plant_id, acquisition = :acquisition, status = :status, location = :location, distance_window = :distance_window, soil = :soil, soil_description = :soil_description, watering = :watering, fertilizing = :fertilizing, details = :details WHERE id = :id');
        $query->execute(array('id' => $this->id,
            'plant_id' => $this->plant_id,
            'acquisition' => $this->acquisition,
            'status' => $this->status,
            'location' => $this->location,
            'distance_window' => $this->distance_window,
            'soil' => $this->soil,
            'soil_description' => $this->soil_description,
            'watering' => $this->watering,
            'fertilizing' => $this->fertilizing,
            'details' => $this->details,
            'grower_id' => $_SESSION['user']
        ));
    }

    public function destroy() {
        $query = DB::connection()->prepare('SELECT id FROM Owned_Plant WHERE id = :id');
        $query->execute(array('id' => $this->id));
        $row = $query->fetch();
        if ($row) {
            $query = DB::connection()->prepare('DELETE FROM Diary WHERE owned_id = :id');
            $query->execute(array('id' => $row['id']
            ));
        }

        $query = DB::connection()->prepare('DELETE FROM Owned_Plant WHERE id = :id');
        $query->execute(array(
            'id' => $this->id
        ));
    }

    public function validate_tradename() {
        return $this->validate_string_length($this->tradename, 3);
    }

    public function validate_acuisition_date() {
        $errors = array();
        if ($this->acquisition == '' || $this->acquisition == null) {
            $errors[] = 'Päivämäärä ei saa olla tyhjä!';
        }

        $test_date = $this->acquisition;
        $test_arr = explode('.', $test_date);
        if (count($test_arr) == 3) {
            if (!(checkdate($test_arr[1], $test_arr[0], $test_arr[2]))) {
                $errors[] = 'Anna päivämäärä muodossa pp.kk.vvvv';
            }
        } else {
            $errors[] = 'Anna päivämäärä muodossa pp.kk.vvvv';
        }
        return $errors;
    }

}
