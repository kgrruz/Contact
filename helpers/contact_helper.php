<?php defined('BASEPATH') || exit('No direct script access allowed');


function contact_avatar($email = null, $size = 50, $class = 'img-fluid', $img = false ,$id = null){

  $size = empty($size) || is_object($size) || ! is_int($size) ? 48 : intval($size);

  // If email is empty, don't send an HTTP request to gravatar.com.
  if ($size <= 100) {
      $avatarURL = './uploads/users/thumbs/no_foto_avatar.png';
  } else{
           $avatarURL = './uploads/users/med/no_foto_avatar.png';
      }

  // Escape all of the attributes, except the src, width, and height.
  // Use an empty alt attribute if $alt is empty.
  $alt = empty($alt) ? '' : html_escape($alt);

  // These are the most commonly-required attributes for an image tag.
  $imageAttributes = array(
      "src='{$avatarURL}'",
      "width='{$size}'",
      "height='{$size}'",
      "alt='{$alt}'",
  );

  if (! empty($id)) {
      $imageAttributes[] = "id='" . html_escape($id) . "'";
  }

  if (! empty($class)) {
      $imageAttributes[] = "class='" . html_escape($class) . "'";
  }

  if (! empty($title)) {
      $imageAttributes[] = "title='" . html_escape($title) . "'";
  }

  if ( $img ) {
  return "<img " . implode(' ', $imageAttributes) . " />";
}else{
  return $avatarURL;
}

       }
