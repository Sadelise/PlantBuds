<?php

class DiaryController extends BaseController {

    public static function index($id) {
        self::check_logged_in();
        $diary = Diary::allByOwnedPlantId($id);
        $tradename = '';
        $plant_id = '';
        $ownplant_id = '';
        $ownplant = OwnedPlant::find($id);
        if ($ownplant != null) {
            $plant_id = $ownplant->plant_id;
            $plant = Plant::find($plant_id);
            if ($plant != null) {
                $tradename = $plant->tradename;
            }
        }

        View::make('diary/diarylist.html', array('diary' => $diary, 'tradename' => $tradename, 'id' => $ownplant->id));
    }

    public static function show($id, $owned_id) {
        self::check_logged_in();
        $diary = Diary::find($id);
        View::make('diary/diarypost.html', array('diary' => $diary, '$owned_id' => $owned_id));
    }

    public static function edit($id) {
        self::check_logged_in();
        $diary = Diary::find($id);
        View::make('diary/edit_diary.html', array('diary' => $diary));
    }

    public static function newDiary($tradename, $ownplant_id) {
        self::check_logged_in();
        $plant = Plant::findByName($tradename);
        View::make('diary/addDiary.html', array('plant' => $plant, 'ownplant_id' => $ownplant_id));
    }

    public static function store($tradename, $ownplant_id) {
        self::check_logged_in();
        $params = $_POST;
        $attributes = array(
            'title' => $params['title'],
            'owned_id' => $ownplant_id,
            'posted' => 'NOW()',
            'post' => $params['post']
        );

        $diary = new Diary($attributes);
        $errors = $diary->errors();

        if (count($errors) == 0) {
            $diary->save();
            Redirect::to('/diarypost/' . $diary->id, array('message' => 'Päiväkirjamerkintä tallennettu!'));
        } else {
            View::make('diary/addDiary.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function update($id) {
        self::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'title' => $params['title'],
            'owned_id' => $params['owned_id'],
            'posted' => $params['posted'],
            'post' => $params['post']
        );

        $diary = new Diary($attributes);
        $errors = $diary->errors();

        if (count($errors) > 0) {
            View::make('diary/edit_diary.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $diary->update();
            Redirect::to('/diarypost/' . $diary->id, array('message' => 'Merkintää on muokattu onnistuneesti!'));
        }
    }

    public static function destroy($id, $owned_id) {
        self::check_logged_in();
        $diary = new Diary(array('id' => $id));
        $diary->destroy();

        Redirect::to('/diarylist/' . $owned_id, array('message' => 'Merkintä on poistettu onnistuneesti!'));
    }

}
