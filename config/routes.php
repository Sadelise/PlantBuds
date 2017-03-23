<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/login', function() {
    HelloWorldController::login();
});

$routes->get('/description', function() {
    HelloWorldController::plantdescription();
});

$routes->get('/list_p', function() {
    HelloWorldController::list_plant();
});

$routes->get('/list_o', function() {
    HelloWorldController::list_ownplant();
});

$routes->get('/frontpage', function() {
    HelloWorldController::frontpage();
});

$routes->get('/edit_p', function() {
    HelloWorldController::edit_plant();
});

$routes->get('/edit_o', function() {
    HelloWorldController::edit_ownplant();
});

$routes->get('/care', function() {
    HelloWorldController::caredescription();
});
$routes->get('/diarylist', function() {
    HelloWorldController::diarylist();
});
$routes->get('/diarypost', function() {
    HelloWorldController::diarypost();
});
$routes->get('/edit_diary', function() {
    HelloWorldController::edit_diary();
});