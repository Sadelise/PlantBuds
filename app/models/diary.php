<?php

class Diary extends BaseModel {

    public $id, $grower_id, $title, $owned_id, $posted, $post, $tradename;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all($id) {
        $query = DB::connection()->prepare('SELECT * FROM Diary LEFT JOIN Owned_Plant ON Diary.owned_id = Owned_Plant.id LEFT JOIN Plant ON Owned_Plant.plant_id = Plant.id WHERE owned_id = :id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $diary = array();

        foreach ($rows as $row) {
            $diary[] = new Diary(array(
            'id' => $row['id'],
            'grower_id' => $row['grower_id'],
            'owned_id' => $row['owned_id'],
            'title' => $row['title'],
            'posted' => $row['posted'],
            'post' => $row['post'],
            'tradename' => $row['tradename']
            ));
        }

        return $diary;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Diary WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $diary = new Diary(array(
                'id' => $row['id'],
                'grower_id' => $row['grower_id'],
                'owned_id' => $row['owned_id'],
                'title' => $row['title'],
                'posted' => $row['posted'],
                'post' => $row['post']
            ));

            return $diary;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Diary (grower_id, owned_id, title, posted, post) VALUES (:grower_id, :owned_id, :title, NOW(), :post) RETURNING id');
        $query->execute(array('grower_id' => $this->grower_id,
            'owned_id' => $this->owned_id,
            'title' => $this->title,
            'post' => $this->post
        ));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

}
