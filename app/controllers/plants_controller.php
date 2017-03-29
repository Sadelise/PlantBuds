<?php

class PlantController extends BaseController {

    public static function index() {
        $plants = Plant::all();
        View::make('suunnitelmat/list_plant.html', array('plants' => $plants));
    }
    public static function show($id) {
        $plant = Plant::find($id);
        View::make('suunnitelmat/plantdescription.html',  array('plant' => $plant));
    }
}
