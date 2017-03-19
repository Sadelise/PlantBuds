<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('/suunnitelmat/frontpage.html');
//        echo 'Tämä on etusivu!';
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
//      echo 'Hello World!';
        View::make('helloworld.html');
    }

    public static function edit_ownplant() {
        View::make('suunnitelmat/edit_ownplant.html');
    }

    public static function edit_plant() {
        View::make('suunnitelmat/edit_plant.html');
    }

    public static function frontpage() {
        View::make('suunnitelmat/frontpage.html');
    }

    public static function list_ownplant() {
        View::make('suunnitelmat/list_ownplant.html');
    }

    public static function list_plant() {
        View::make('suunnitelmat/list_plant.html');
    }

    public static function plantdescription() {
        View::make('suunnitelmat/plantdescription.html');
    }

    public static function login() {
        View::make('suunnitelmat/login.html');
    }
    public static function caredescription() {
        View::make('suunnitelmat/caredescription.html');
    }
}
