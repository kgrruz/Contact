<?php defined('BASEPATH') || exit('No direct script access allowed');

$route[] = '';
Route::any('contato/(:any)', 'contact/profile/$1');
Route::any('contato/(:any)/(:any)', 'contact/profile/$1/$2');
Route::any('contato/(:any)/(:any)/(:any)', 'contact/profile/$1/$2/$3');
Route::any('group_related_contact', 'contact/group/contacts_related');
$route = Route::map($route);
