<?php

class PlantController extends BaseController {

    public static function index() {
        $plants = Plant::all();
        View::make('suunnitelmat/list_plant.html', array('plants' => $plants));
    }

    public static function show($id) {
        $plant = Plant::find($id);
        View::make('suunnitelmat/plantdescription.html', array('plant' => $plant));
    }

    public static function edit($id) {
        $plant = Plant::find($id);
        View::make('suunnitelmat/edit_plant.html', array('plant' => $plant));
    }

    public static function newPlant() {
        View::make('suunnitelmat/addPlant.html');
    }

    public static function store() {
        $params = $_POST;
        $plant = new Plant(array(
            'tradename' => $params['tradename'],
            'latin_name' => $params['latin_name'],
            'light' => $params['light'],
            'water' => $params['water'],
            'description' => $params['description']
        ));

        $plant->save();
        Redirect::to('/description/' . $plant->id, array('message' => 'Kasvi tallennettu!'));
    }

}
