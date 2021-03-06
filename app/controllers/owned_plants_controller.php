<?php

class OwnPlantController extends BaseController {

    public static function index() {
        self::check_logged_in();
        $user_logged_in = self::get_user_logged_in();
        $params = $_GET;
        $options = array('grower_id' => $user_logged_in->id);

        if (isset($params['search'])) {
            $options['search'] = $params['search'];
        }
        $plants = OwnedPlant::all($options);

//        $plants = OwnedPlant::all($_SESSION['user']);
        View::make('ownplant/list_ownplant.html', array('plants' => $plants));
    }

    public static function show($id) {
        self::check_logged_in();
        $plant = OwnedPlant::find($id);
        View::make('ownplant/caredescription.html', array('plant' => $plant));
    }

    public static function edit($id) {
        self::check_logged_in();
        $plant = OwnedPlant::find($id);
        View::make('ownplant/edit_ownplant.html', array('plant' => $plant));
    }

    public static function newPlant() {
        self::check_logged_in();
        $params = $_GET;
        $options = array();
        if (isset($params['search'])) {
            $options['search'] = $params['search'];
        }
        $plants = Plant::all($options);
        View::make('ownplant/add_own_plant.html', array('plants' => $plants));
    }

    public static function store() {
        self::check_logged_in();
        $params = $_POST;
        $attributes = array(
            'tradename' => $params['tradename'],
            'tradename2' => $params['tradename2'],
            'latin_name2' => $params['latin_name2'],
            'acquisition' => $params['acquisition'],
            'location' => $params['location'],
            'distance_window' => $params['distance_window'],
            'soil' => $params['soil'],
            'soil_description' => $params['soil_description'],
            'watering' => $params['watering'],
            'fertilizing' => $params['fertilizing'],
            'details' => $params['details']
        );
        if ($params['tradename2'] != '') {
            $attributes['tradename'] = $params['tradename2'];
            $attributes += array('latin_name' => $params['latin_name2']);
        } else {
            $latin_plant = Plant::findByName($params['tradename2']);
            if ($latin_plant != null) {
                $attributes['latin_name'] = $latin_plant->latin_name;
            }
        }

        $plant = new OwnedPlant($attributes);
        $errors = $plant->errors();
        $options = array();
        $plants = Plant::all($options);

        if (count($errors) == 0) {
            $plant->save();
            Redirect::to('/care/' . $plant->id, array('message' => 'Kasvi tallennettu!'));
        } else {
            View::make('ownplant/add_own_plant.html', array('errors' => $errors, 'attributes' => $attributes, 'plants' => $plants));
        }
    }

    public static function update($id) {
        self::check_logged_in();
        $params = $_POST;
        if (isset($_POST['status'])) {
            $params['status'] = 'kuollut';
        } else {
            $params['status'] = 'elossa';
        }

        $attributes = array(
            'id' => $id,
            'plant_id' => $params['plant_id'],
            'status' => $params['status'],
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
//        Kint::dump($params);

        $owned_plant = new OwnedPlant($attributes);
//        Kint::dump($owned_plant->details);
        $errors = $owned_plant->errors();

        if (count($errors) > 0) {
            View::make('ownplant/edit_ownplant.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $owned_plant->update();
            Redirect::to('/care/' . $id, array('message' => 'Kasvia on muokattu onnistuneesti!'));
        }
    }

    public static function destroy($id) {
        self::check_logged_in();
        $plant = OwnedPlant::find($id);
        $plant->destroy();
        Redirect::to('/list_o', array('message' => 'Kasvi on poistettu onnistuneesti!'));
    }

}
