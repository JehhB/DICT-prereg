<?php

function async_send_email($slug)
{
  $exec_path = __DIR__ . DIRECTORY_SEPARATOR . "send-email.php";

  $slug = escapeshellarg($slug);
  $command = "php \"$exec_path\" $slug";

  if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    pclose(popen("start /B " . $command, "r"));
  } else {
    exec($command . " > /dev/null &");
  }
}
