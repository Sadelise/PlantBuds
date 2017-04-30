<?php

class DiaryController extends BaseController {

    public static function index($owned_id) {
        self::check_logged_in();
        $diary = Diary::allByOwnedPlantId($owned_id);
        $tradename = '';
        $plant_id = '';
        $ownplant = OwnedPlant::find($owned_id);
        if ($ownplant != null) {
            $plant_id = $ownplant->plant_id;
            $tradename = $ownplant->tradename;
            $plant = Plant::find($plant_id);
        }
 
        View::make('diary/diarylist.html', array('diary' => $diary, 'tradename' => $tradename, 'ownplant_id' => $ownplant->id));
    }

    public static function show($post_id, $owned_id) {
        self::check_logged_in();
        $diary = Diary::find($post_id);
        View::make('diary/diarypost.html', array('diary' => $diary, 'owned_id' => $owned_id));
    }

    public static function edit($post_id) {
        self::check_logged_in();
        $diary = Diary::find($post_id);
//        Kint::dump($diary);
        View::make('diary/edit_diary.html', array('diary' => $diary));
    }

    public static function newDiary($tradename, $ownplant_id) {
        self::check_logged_in();
        $plant = Plant::findByName($tradename);
        View::make('diary/add_diary.html', array('tradename' => $plant->tradename, 'ownplant_id' => $ownplant_id, 'owned_id' => $ownplant_id));
    }

    public static function store($tradename) {
        self::check_logged_in();
        $params = $_POST;
        $attributes = array(
            'title' => $params['title'],
            'posted' => 'NOW()',
            'post' => $params['post'],
            'owned_id' => $params['owned_id']
        );

        $diary = new Diary($attributes);
        $errors = $diary->errors();

        if (count($errors) == 0) {
            $diary->save();
            Redirect::to('/diarypost/' . $diary->id . '/' . $params['owned_id'], array('message' => 'Päiväkirjamerkintä tallennettu!'));
        } else {
            View::make('diary/add_diary.html', array('errors' => $errors, 'diary' => $diary, 'tradename' => $tradename, 'owned_id' => $diary->owned_id));
        }
    }

    public static function update($diary_id) {
        self::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'id' => $diary_id,
            'title' => $params['title'],
            'post' => $params['post'],
            'owned_id' => $params['owned_id']
        );

        $diary = new Diary($attributes);
        $errors = $diary->errors();

        if (count($errors) > 0) {
            View::make('diary/edit_diary.html', array('errors' => $errors, 'diary' => $diary));
        } else {
            $diary->update();
            Redirect::to('/diarypost/' . $diary->id . '/' . $params['owned_id'], array('message' => 'Merkintää on muokattu onnistuneesti!'));
        }
    }

    public static function destroy($id, $owned_id) {
        self::check_logged_in();
        $diary = new Diary(array('id' => $id));
        $diary->destroy();

        Redirect::to('/diarylist/' . $owned_id, array('message' => 'Merkintä on poistettu onnistuneesti!'));
    }

}
