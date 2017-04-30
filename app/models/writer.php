<?php

class Writer extends BaseModel {

    public $grower_id, $plant_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array();
    }

    public static function findAllByPlant($id) {
        $query = DB::connection()->prepare('SELECT * FROM Grower INNER JOIN Writer ON Writer.grower_id=Grower.id WHERE Writer.plant_id = :id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $writer = array();

        foreach ($rows as $row) {
            $writer[] = new User(array(
                'username' => $row['username'],
            ));
        }

        return $writer;
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Writer WHERE plant_id = :id');
        $query->execute(array(
            'id' => $this->plant_id
        ));
    }

    public static function add($plant_id) {
        if (self::find($plant_id) == null) {
            $query = DB::connection()->prepare('INSERT INTO Writer(grower_id, plant_id) VALUES (:grower_id, :plant_id)');
            $query->execute(array('grower_id' => $_SESSION['user'],
                'plant_id' => $plant_id));
        }
    }

    public static function find($plant_id) {
        $query = DB::connection()->prepare('SELECT * FROM Writer WHERE grower_id = :grower_id AND plant_id = :plant_id LIMIT 1');
        $query->execute(array('grower_id' => $_SESSION['user'],
            'plant_id' => $plant_id));
        $row = $query->fetch();

        if ($row) {
            $writer = new Writer(array(
                'grower_id' => $row['grower_id'],
                'plant_id' => $row['plant_id']
            ));

            return $writer;
        }

        return null;
    }

}
