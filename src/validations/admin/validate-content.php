<?php

function validateContent($req)
{
  foreach ($req as $key => $value) {
    $req[$key] =  trim($req[$key]);
  }

  $req['administrator'] = !empty($req['administrator']) == 'on' ? true : false;

  if (isset($errors)) {
    return ['invalid' => $errors];
  }
  return $req;
}
