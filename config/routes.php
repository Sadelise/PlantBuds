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

$routes->post('/edit_diary/:post_id', function($post_id) {
    DiaryController::update($post_id);
});

$routes->get('/edit_diary/:post_id', function($post_id) {
    DiaryController::edit($post_id);
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

$routes->post('/care/:id/destroy', function($id) {
OwnPlantController::destroy($id);
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

$routes->post('/edit_o/:id', function($id) {
OwnPlantController::update($id);
});

$routes->get('/edit_o/:id', function($id) {
OwnPlantController::edit($id);
});

$routes->get('/list_o', function() {
OwnPlantController::index();
});

$routes->get('/care/:id', function($id) {
OwnPlantController::show($id);
});

$routes->get('/addDiary/:tradename/:id', function($tradename, $id) {
DiaryController::newDiary($tradename, $id);
});

$routes->get('/diarylist/:owned_id', function($owned_id) {
DiaryController::index($owned_id);
});

$routes->get('/diarypost/:post_id/:owned_id', function($post_id, $owned_id) {
DiaryController::show($post_id, $owned_id);
});

$routes->post('/newDiary/:tradename', function($tradename) {
DiaryController::store($tradename);
});

$routes->post('/diary/:id/destroy/:owned_id', function($id, $owned_id) {
DiaryController::destroy($id, $owned_id);
});

$routes->get('/addOwnPlant', function() {
OwnPlantController::newPlant();
});

$routes->post('/newOwnPlant', function() {
OwnPlantController::store();
});

$routes->post('/logout', function() {
UserController::logout();
});

$routes->get('/login', function() {
// Kirjautumislomakkeen esittäminen
UserController::login();
});

$routes->post('/login', function() {
// Kirjautumisen käsittely
UserController::handle_login();
});


