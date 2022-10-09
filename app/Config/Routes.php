<?php

namespace Config;

use PharIo\Manifest\Author;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->post('/auth/login', 'AuthController::login');
$routes->get('/auth/user', 'AuthController::getUserData', ['authFilter']);

$routes->group('api',['namespace'=>'App\Controllers\API', 'filter' => 'authFilter'],function($routes){

    /*Routes Usuarios  */
    $routes->get('usuarios','Usuario::index');
    $routes->post('usuarios/create','Usuario::create');
    $routes->get('usuarios/(:num)','Usuario::edit/$1');
    $routes->put('usuarios/(:num)','Usuario::update/$1');
    $routes->delete('usuarios/(:num)','Usuario::delete/$1');

    /*Routes Tiendas*/
    $routes->get('tiendas','Tienda::index');
    $routes->post('tiendas/create','Tienda::create');
    $routes->get('tiendas/edit/(:num)','Tienda::edit/$1');
    $routes->put('tiendas/update/(:num)','Tienda::update/$1');
    $routes->delete('tiendas/delete/(:num)','Tienda::delete/$1');

    /*Routes Repartidores  */
    $routes->get('repartidores','Repartidor::index');
    $routes->post('repartidores/create','Repartidor::create');
    $routes->get('repartidores/edit/(:num)','Repartidor::edit/$1');
    $routes->put('repartidores/update/(:num)','Repartidor::update/$1');
    $routes->delete('repartidores/delete/(:num)','Repartidor::delete/$1');

    /*Routes CategoriaTiendas  */

    $routes->get('categorias-tiendas','CategoriaTienda::index');
    $routes->post('categorias-tiendas/create','CategoriaTienda::create');
    $routes->get('categorias-tiendas/edit/(:num)','CategoriaTienda::edit/$1');
    $routes->put('categorias-tiendas/update/(:num)','CategoriaTienda::update/$1');
    $routes->delete('categorias-tiendas/delete/(:num)','CategoriaTienda::delete/$1');

    /*Routes CategoriaProductos  */
    $routes->get('categorias-productos','CategoriaProducto::index');
    $routes->post('categorias-productos/create','CategoriaProducto::create');
    $routes->get('categorias-productos/edit/(:num)','CategoriaProducto::edit/$1');
    $routes->put('categorias-productos/update/(:num)','CategoriaProducto::update/$1');
    $routes->delete('categorias-productos/delete/(:num)','CategoriaProducto::delete/$1');

    /*Routes Productos  */
    $routes->get('productos','Producto::index');
    $routes->post('productos/create','Producto::create');
    $routes->get('productos/edit/(:num)','Producto::edit/$1');
    $routes->put('productos/update/(:num)','Producto::update/$1');
    $routes->delete('productos/delete/(:num)','Producto::delete/$1');
    
    /*Routes Productos  */
    $routes->get('pedidos','Producto::index');
    $routes->post('pedidos/create','Producto::create');
    $routes->get('pedidos/edit/(:num)','Producto::edit/$1');
    $routes->put('pedidos/update/(:num)','Producto::update/$1');
    $routes->delete('pedidos/delete/(:num)','Producto::delete/$1');


});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
