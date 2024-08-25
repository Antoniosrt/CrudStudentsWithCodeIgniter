<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('/auth/login','LoginController::jwtLogin');
//$routes->get('/api/v1/user','UserApiController::index');
$routes->group('api',function ($routes){
    $routes->resource('students',['controller'=>'StudentController']);
});

service('auth')->routes($routes);
