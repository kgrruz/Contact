<?php defined('BASEPATH') || exit('No direct script access allowed');


function contact_avatar($email = null, $size = 50, $class = 'img-fluid', $img = false ,$id = null){

      return gravatar_link($email, $size, $email, $email,$class,$img, $id);

       }
