<?php

class Description extends BaseModel {

    public $plant_id, $light, $water, $description, $edited;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Plant_Description');
        $query->execute();
        $rows = $query->fetchAll();
        $plant = array();

        foreach ($rows as $row) {
            $plant[] = new Plant(array(
                'plant_id' => $row['plant_id'],
                'light' => $row['light'],
                'water' => $row['water'],
                'description' => $row['description'],
                'edited' => $row['edited']
            ));
        }

        return $plant;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Plant_Description WHERE plant_id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $plant = new Plant(array(
                'plant_id' => $row['plant_id'],
                'light' => $row['light'],
                'water' => $row['water'],
                'description' => $row['description'],
                'edited' => $row['edited']
            ));

            return $plant;
        }

        return null;
    }

}
