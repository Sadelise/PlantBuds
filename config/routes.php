<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/frontpage', function() {
    HelloWorldController::frontpage();
});

$routes->get('/edit_o', function() {
    HelloWorldController::edit_ownplant();
});

$routes->get('/edit_diary', function() {
    HelloWorldController::edit_diary();
});

$routes->get('/list_p', function() {
    PlantController::index();
});

$routes->get('/addPlant', function() {
    PlantController::newPlant();
});

$routes->post('/description/new', function() {
    PlantController::store();
});

$routes->post('/description/:id/destroy', function($id) {
    PlantController::destroy($id);
});

$routes->get('/description/:id', function($id) {
    PlantController::show($id);
});

$routes->get('/edit_p/:id', function($id) {
    PlantController::edit($id);
});

$routes->post('/edit_p/:id', function($id) {
    PlantController::update($id);
});

$routes->get('/list_o', function() {
    OwnPlantController::index();
});

$routes->get('/care/:id', function($id) {
    OwnPlantController::show($id);
});

$routes->get('/addDiary/:tradename', function($tradename) {
    DiaryController::newDiary($tradename);
});

$routes->get('/diarylist/:id', function($id) {
    DiaryController::index($id);
});

$routes->get('/diarypost/:id', function($id) {
    DiaryController::show($id);
});

//$routes->post('/newDiary', function() {
//    DiaryController::store();
//});

$routes->get('/addOwnPlant', function() {
    OwnPlantController::newPlant();
});

$routes->post('/newOwnPlant', function() {
    OwnPlantController::store();
});

$routes->get('/login', function() {
    // Kirjautumislomakkeen esittäminen
    UserController::login();
});

$routes->post('/login', function() {
    // Kirjautumisen käsittely
    UserController::handle_login();
});
