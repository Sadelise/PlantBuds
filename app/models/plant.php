<?php

class Plant extends BaseModel {

    public $id, $tradename, $latin_name, $light, $water, $description, $edited;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_tradename');
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

    public static function findByName($tradename) {
        $query = DB::connection()->prepare('SELECT * FROM Plant WHERE tradename = :tradename LIMIT 1');
        $query->execute(array('tradename' => $tradename));
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

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Plant (tradename, latin_name, light, water, description, edited) VALUES (:tradename, :latin_name, :light, :water, :description, NOW()) RETURNING id');
        $query->execute(array('tradename' => $this->tradename,
            'latin_name' => $this->latin_name,
            'water' => $this->water,
            'light' => $this->light,
            'description' => $this->description
        ));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Plant SET tradename = :tradename, latin_name = :latin_name, light = :light, water = :water, description = :description, edited = NOW() WHERE id = :id');
        $query->execute(array('tradename' => $this->tradename,
        'latin_name' => $this->latin_name,
        'water' => $this->water,
        'light' => $this->light,
        'description' => $this->description,
        'id' => $this->id
        ));
    }

       public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Plant WHERE id = :id');
        $query->execute(array(
        'id' => $this->id
        ));
    }
    
    public function validate_tradename() {
        $errors = array();
        if ($this->tradename == '' || $this->tradename == null) {
            $errors[] = 'Nimi ei saa olla tyhjä!';
        }
        if (strlen($this->tradename) < 3) {
            $errors[] = 'Nimen pituuden tulee olla vähintään kolme merkkiä!';
        }

        return $errors;
    }

}
