<?php

class OwnedPlant extends BaseModel {

    public $id, $tradename, $latin_name, $grower_id, $plant_id, $acquisition, $status, $location, $distance_window, $soil, $soil_description, $watering, $fertilizing, $details, $added;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Plant LEFT JOIN Owned_Plant ON Plant.id = Owned_Plant.plant_id');
        $query->execute();
        $rows = $query->fetchAll();
        $plant = array();

        foreach ($rows as $row) {
            $plant[] = new ownedPlant(array(
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
                'watering' => $row['edited'],
                'fertilizing' => $row['fertilizing'],
                'details' => $row['details'],
                'added' => $row['added']
            ));
        }

        return $plant;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Plant LEFT JOIN Owned_Plant ON Plant.id = Owned_Plant.plant_id WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
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
                'watering' => $row['edited'],
                'fertilizing' => $row['fertilizing'],
                'details' => $row['details'],
                'added' => $row['added']
            ));

            return $plant;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Owned_Plant (grower_id, plant_id, acquisition, status, location, distance_window, soil, soil_description, watering, fertilizing, details, added) VALUES (:grower_id, :plant_id, :acquisition, :status, :location, :distance_window, :soil, :soil_description, :watering, :fertilizing, :details, NOW()) RETURNING id');
        $query->execute(array('grower_id' => $this->grower_id,
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
            'added' => $this->added
        ));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function update() {
        $query = DB::connection()->prepare('UPDATE Owned_Plant SET grower_id = :grower_id, plant_id = :plant_id, acquisition = :acquisition, status = :status, location = :location, distance_window = :distance_window, soil = :soil, soil_description = :soil_description, watering = :watering, fertilizing = :fertilizing, details = :details, added = NOW() WHERE id = :id');
        $query->execute(array( 'id' => $this->id,
            'grower_id' => $this->grower_id,
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
            'added' => $this->added
        ));
    }

       public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Owned_Plant WHERE id = :id');
        $query->execute(array(
        'id' => $this->id
        ));
    }
}
