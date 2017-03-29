<?php

class OwnPlantController extends BaseController {

    public static function index() {
        $plants = OwnedPlant::all();
        View::make('suunnitelmat/list_ownplant.html', array('plants' => $plants));
    }

//ei vielä muokattu
    public static function show($id) {
        $plant = Plant::find($id);
        View::make('suunnitelmat/caredescription.html', array('plant' => $plant));
    }

    public static function edit($id) {
        $plant = Plant::find($id);
        View::make('suunnitelmat/edit_ownplant.html', array('plant' => $plant));
    }

    public static function newPlant($id) {
        $info = array('id' => $id);
        View::make('suunnitelmat/addOwnPlant.html', array('info' => $info));
    }

    public static function store() {
        $params = $_POST;
        $plant = new Plant(array(
            'tradename' => $params['tradename'],
            'latin_name' => $params['latin_name'],
            'grower_id' => $params['grower_id'],
            'plant_id' => $params['plant_id'],
            'acquisition' => $params['acquisition'],
            'status' => $params['status'],
            'location' => $params['location'],
            'distance_window' => $params['distance_window'],
            'soil' => $params['soil'],
            'soil_description' => $params['soil_description'],
            'watering' => $params['edited'],
            'fertilizing' => $params['fertilizing'],
            'details' => $params['details'],
            'added' => $params['added']
        ));

        $plant->save();
        Redirect::to('/care/' . $plant->id, array('message' => 'Kasvi tallennettu!'));
    }

}
