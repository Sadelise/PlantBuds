<?php

class OwnPlantController extends BaseController {

    public static function index() {
        $plants = OwnedPlant::all();
        View::make('suunnitelmat/list_ownplant.html', array('plants' => $plants));
    }

    public static function show($id) {
        $plant = OwnedPlant::find($id);
        View::make('suunnitelmat/caredescription.html', array('plant' => $plant));
    }

    public static function edit($id) {
        $plant = OwnedPlant::find($id);
        View::make('suunnitelmat/edit_ownplant.html', array('plant' => $plant));
    }

    public static function newPlant() {
        View::make('suunnitelmat/addOwnPlant.html');
    }

    public static function store() {
        $params = $_POST;
        $attributes = array(
            'tradename' => $params['tradename'],
            'latin_name' => $params['latin_name'],
            'acquisition' => $params['acquisition'],
            'location' => $params['location'],
            'distance_window' => $params['distance_window'],
            'soil' => $params['soil'],
            'soil_description' => $params['soil_description'],
            'watering' => $params['watering'],
            'fertilizing' => $params['fertilizing'],
            'details' => $params['details']
        );
        $plant = new OwnedPlant($attributes);
        $errors = $plant->errors();

        if (count($errors) == 0) {
            $plant->save();
            Redirect::to('/care/' . $plant->id, array('message' => 'Kasvi tallennettu!'));
        } else {
            View::make('suunnitelmat/addOwnPlant.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function update($id) {
        $params = $_POST;
        
        $attributes = array(
            'tradename' => $params['tradename'],
            'latin_name' => $params['latin_name'],
            'acquisition' => $params['acquisition'],
            'location' => $params['location'],
            'distance_window' => $params['distance_window'],
            'soil' => $params['soil'],
            'soil_description' => $params['soil_description'],
            'watering' => $params['watering'],
            'fertilizing' => $params['fertilizing'],
            'details' => $params['details']
        );

        $plant = new OwnedPlant($attributes);
        $errors = $plant->errors();

        if (count($errors) > 0) {
            View::make('suunnitelmat/edit_ownplant.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $plant->update();
            Redirect::to('/care/' . $id, array('message' => 'Kasvia on muokattu onnistuneesti!'));
        }
    }

    public static function destroy($id) {
        $plant = new OwnedPlant(array('id' => $id));
        $plant->destroy();

        Redirect::to('/list_o', array('message' => 'Kasvi on poistettu onnistuneesti!'));
    }

}
