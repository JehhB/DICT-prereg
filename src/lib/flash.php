<?php

/**
 * function to add save one time read data
 */
function flash_set(string $bag, string $key, mixed $data)
{
  if (!isset($_SESSION[$bag])) $_SESSION[$bag] = [];
  $_SESSION[$bag][$key] = $data;
}

function safe_get_key(array $arr, ?string $key)
{
  if (is_null($key)) return $arr;
  if (!isset($arr[$key])) return false;
  return $arr[$key];
}

/**
 * function get and erase session data
 *
 * @return mixed
 */
function flash_get(string $bag, ?string $key = null)
{
  static $res = [];

  if (isset($res[$bag])) return safe_get_key($res[$bag], $key);
  if (!isset($_SESSION[$bag])) return safe_get_key([], $key);


  $res[$bag] = $_SESSION[$bag];
  unset($_SESSION[$bag]);

  return safe_get_key($res[$bag], $key);
}

/**
 * check whether a key exist on flash bag
 * @return bool
 */
function flash_has(string $bag, string $key)
{
  return flash_get($bag, $key) !== false;
}
