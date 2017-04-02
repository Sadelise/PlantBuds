<?php

class DiaryController extends BaseController {

    public static function index($id) {
        $diary = Diary::all($id);
        View::make('suunnitelmat/diarylist.html', array('diary' => $diary));
    }

    public static function show($id) {
        $diary = Diary::find($id);
        View::make('suunnitelmat/diarypost.html', array('diary' => $diary));
    }

    public static function edit($id) {
        $diary = Diary::find($id);
        View::make('suunnitelmat/edit_diary.html', array('diary' => $diary));
    }

    public static function newDiary($tradename) {
        $plant = Plant::findByName($tradename);
        View::make('suunnitelmat/addDiary.html', array('plant' => $plant));
    }

    public static function store() {
        $params = $_POST;
        $diary = new Diary(array(
            'title' => $params['title'],
            'grower_id' => $params['grower_id'],
            'owned_id' => $params['owned_id'],
            'posted' => $params['posted'],
            'post' => $params['post']
        ));

        $diary->save();
        Redirect::to('/diarypost/' . $diary->id, array('message' => 'Päiväkirjamerkintä tallennettu!'));
    }
    public static function update($id) {
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'title' => $params['title'],
            'grower_id' => $params['grower_id'],
            'owned_id' => $params['owned_id'],
            'posted' => $params['posted'],
            'post' => $params['post']
        );

        $diary = new Diary($attributes);
        $errors = $diary->errors();

        if (count($errors) > 0) {
            View::make('suunnitelmat/edit_diary.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $diary->update();

            Redirect::to('/diarypost/' . $diary->id, array('message' => 'Merkintää on muokattu onnistuneesti!'));
        }
    }

    public static function destroy($id) {
        $diary = new Diary(array('id' => $id));
        $diary->destroy();

        Redirect::to('/diarylist', array('message' => 'Merkintä on poistettu onnistuneesti!'));
    }
}
