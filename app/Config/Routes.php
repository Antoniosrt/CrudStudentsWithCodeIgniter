<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/auth/register','RegisterController::register');
$routes->post('/auth/login','LoginController::jwtLogin');
//$routes->get('/api/v1/user','UserApiController::index');
$routes->post('/api/students', 'StudentController::create');
$routes->get('/api/students', 'StudentController::index');
$routes->get('/api/students/(:num)', 'StudentController::show/$1');
$routes->post('/api/students/(:num)', 'StudentController::update/$1');
$routes->delete('/api/students/(:num)', 'StudentController::delete/$1');



service('auth')->routes($routes);
