<?php

if (
  $_SERVER['REQUEST_METHOD'] == 'POST' &&  
  isset($_GET['p']) && 
  $_GET['p'] == 2
) {
  include __DIR__ . '/src/slots.php';
} else  {
  include __DIR__ . '/src/personal_info.php';
}
