<?php
function generateStrongPassword($length = 16)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

for ($i = 0; $i < 10; $i++) {
  $password = generateStrongPassword();
  $passwordHash = password_hash($password, PASSWORD_DEFAULT);
  echo "$password,$passwordHash\n";
}
