<?php

class Diary extends BaseModel {

    public $id, $grower_id, $title, $owned_id, $posted, $post, $tradename;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all($id) {
        $query = DB::connection()->prepare('SELECT * FROM Diary LEFT JOIN Owned_Plant ON Diary.owned_id = Owned_Plant.id LEFT JOIN Plant ON Owned_Plant.plant_id = Plant.id WHERE Diary.owned_id = :id AND Diary.grower_id = :grower_id');
        $query->execute(array('id' => $id,
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
        $query->execute(array('grower_id' => $_SESSION['user'],
            'owned_id' => $this->owned_id,
            'title' => $this->title,
            'post' => $this->post
        ));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Diary SET grower_id = :grower_id, owned_id = :owned_id, title = :title, posted = NOW(), post = :post WHERE id = :id');
        $query->execute(array('id' => $this->id,
            'grower_id' => $_SESSION['user'],
            'owned_id' => $this->owned_id,
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

}
