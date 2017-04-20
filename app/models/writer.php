<?php

class Writer extends BaseModel {

    public $grower_id, $plant_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array();
    }

    public static function findAllByPlant($id) {
        $query = DB::connection()->prepare('SELECT * FROM Writer WHERE plant_id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $writer = array();

        foreach ($rows as $row) {
            $writer[] = new Writer(array(
                'grower_id' => $row['grower_id'],
                'plant_id' => $row['plant_id'],
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
}
