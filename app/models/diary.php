<?php

class Diary extends BaseModel {

    public $id, $grower_id, $title, $owned_id, $posted, $post;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_title', 'validate_post');
    }
    
        public static function all() {
        $query = DB::connection()->prepare('SELECT *, to_char(posted, \'DD.MM.YYYY\') FROM Diary');
        $query->execute();
        $rows = $query->fetchAll();
        $diary = array();

        foreach ($rows as $row) {
            $diary[] = new Diary(array(
                'id' => $row['id'],
                'grower_id' => $row['grower_id'],
                'owned_id' => $row['owned_id'],
                'title' => $row['title'],
                'posted' => $row['to_char'],
                'post' => $row['post'],
            ));
        }

        return $diary;
    }

    public static function allByOwnedPlantId($owned_plant_id) {
        $query = DB::connection()->prepare(''
                . 'SELECT to_char(posted, \'DD.MM.YYYY\'), Diary.id AS id, Diary.grower_id, Diary.owned_id, title, posted, post, Owned_plant.plant_id '
                . 'FROM Diary LEFT JOIN Owned_Plant ON Diary.owned_id = Owned_Plant.id '
                . 'LEFT JOIN Plant ON Owned_Plant.plant_id = Plant.id '
                . 'WHERE Diary.owned_id = :id AND Diary.grower_id = :grower_id');
        $query->execute(array('id' => $owned_plant_id,
            'grower_id' => $_SESSION['user']
        ));
        
        $rows = $query->fetchAll();
        $diary = array();
        
        foreach ($rows as $row) {
            $diary[] = new Diary(array(
                'id' => $row['id'],
                'grower_id' => $row['grower_id'],
                'owned_id' => $row['owned_id'],
                'title' => $row['title'],
                'posted' => $row['to_char'],
                'post' => $row['post'],
                'plant_id' => $row['plant_id']
            ));
        }
        return $diary;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT *, to_char(posted, \'DD.MM.YYYY\') FROM Diary WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $diary = new Diary(array(
                'id' => $row['id'],
                'grower_id' => $row['grower_id'],
                'owned_id' => $row['owned_id'],
                'title' => $row['title'],
                'posted' => $row['to_char'],
                'post' => $row['post']
            ));

            return $diary;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Diary (grower_id, owned_id, title, posted, post) VALUES (:grower_id, :owned_id, :title, NOW(), :post) RETURNING id');
        $query->execute(array('grower_id' => $_SESSION['user'],
            'owned_id' => $this->owned_id,
            'title' => $this->title,
            'post' => $this->post
        ));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Diary SET title = :title, post = :post WHERE id = :id');
        $query->execute(array('id' => $this->id,
            'title' => $this->title,
            'post' => $this->post
        ));
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Diary WHERE id = :id');
        $query->execute(array(
            'id' => $this->id
        ));
    }

    public function validate_title() {
        return $this->validate_string_length($this->title, 3, 'Otsikko');
    }

    public function validate_post() {
        return $this->validate_string_length($this->post, 5, 'Viesti');
    }

}
