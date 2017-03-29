<?php

class Plant extends BaseModel {

    public $id, $tradename, $latin_name, $light, $water, $description, $edited;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Plant');
        $query->execute();
        $rows = $query->fetchAll();
        $plant = array();

        foreach ($rows as $row) {
            $plant[] = new Plant(array(
                'id' => $row['id'],
                'tradename' => $row['tradename'],
                'latin_name' => $row['latin_name'],
                'light' => $row['light'],
                'water' => $row['water'],
                'description' => $row['description'],
                'edited' => $row['edited']
            ));
        }

        return $plant;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Plant WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $plant = new Plant(array(
                'id' => $row['id'],
                'tradename' => $row['tradename'],
                'latin_name' => $row['latin_name'],
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
