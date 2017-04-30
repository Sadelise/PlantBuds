<?php

class PlantController extends BaseController {

    public static function index() {
        $params = $_GET;

        $options = array();
        if (isset($params['search'])) {
            $options['search'] = $params['search'];
        }
        $plants = Plant::all($options);

        View::make('plant/list_plant.html', array('plants' => $plants));

//        Kint::dump($params);
//        Kint::dump($options);
    }

    public static function show($id) {
        $plant = Plant::find($id);
        $writers = Writer::findAllByPlant($id);
        View::make('plant/plantdescription.html', array('writers' => $writers, 'plant' => $plant));
//      Kint::dump($writers);
    }

    public static function edit($id) {
        self::check_logged_in();
        $plant = Plant::find($id);
        View::make('plant/edit_plant.html', array('plant' => $plant));
    }

    public static function newPlant() {
        self::check_logged_in();
        View::make('plant/add_plant.html');
    }

    public static function store() {
        self::check_logged_in();
        $params = $_POST;
        $attributes = array(
            'tradename' => $params['tradename'],
            'latin_name' => $params['latin_name'],
            'light' => $params['light'],
            'water' => $params['water'],
            'description' => $params['description']
        );

        $plant = new Plant($attributes);
        $errors = $plant->errors();

        if (count($errors) == 0) {
            $plant->save();
            Redirect::to('/description/' . $plant->id, array('message' => 'Kasvi tallennettu!'));
        } else {
            View::make('plant/add_plant.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function update($id) {
        self::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'tradename' => $params['tradename'],
            'latin_name' => $params['latin_name'],
            'light' => $params['light'],
            'water' => $params['water'],
            'description' => $params['description']
        );

        $plant = new Plant($attributes);
        $errors = $plant->errors();

        if (count($errors) > 0) {
            View::make('plant/edit_plant.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $plant->update();
            Writer::add($id);

            Redirect::to('/description/' . $plant->id, array('message' => 'Kuvausta on muokattu onnistuneesti!'));
        }
    }

    public static function destroy($id) {
        self::check_logged_in();
        $plant = new Plant(array('id' => $id));
        $plant->destroy();
        Redirect::to('/list_p', array('message' => 'Kasvi on poistettu onnistuneesti!'));
    }

}
