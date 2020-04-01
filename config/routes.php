<?php defined('BASEPATH') || exit('No direct script access allowed');

$route[] = '';
Route::any('add_contato', 'contact/content/create');
Route::any('add_contato/(:num)', 'contact/content/create/$1');
Route::any('add_contato/(:num)/(:num)', 'contact/content/create/$1/$2');
Route::any('contatos', 'contact/content/index');
Route::any('contatos/(:num)', 'contact/content/index/$1');
Route::any('contato/(:any)', 'contact/content/profile/$1');
Route::any('contato/(:any)/(:any)', 'contact/content/profile/$1/$2');
Route::any('contato/(:any)/(:any)/(:any)', 'contact/content/profile/$1/$2/$3');
Route::any('group_related_contact', 'contact/group/contacts_related');
$route = Route::map($route);
