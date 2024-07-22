<?php

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../lib/database.php';
require_once __DIR__ . '/../entity/Registration.php';

define('BASEURL', 'http://localhost:8080');

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use PHPMailer\PHPMailer\PHPMailer;

$env = parse_ini_file(__DIR__ . '/../.env');

function get_email()
{
  global $env;

  try {
    $mail = new PHPMailer(true);

    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $env['email'];
    $mail->Password = $env['app_password'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom($env['email'], $env['username']);

    return $mail;
  } catch (Exception $e) {
    echo $e->getMessage();
    exit();
  }
}

if (php_sapi_name() === 'cli') {
  $slug = $argv[1];

  $reg = Registration::find($slug);
  $reg_booths = $reg->get_registered_booths();

  $schedule = [];
  $first_start = null;
  $last_end = null;

  foreach ($reg_booths as $booth) {
    $start = new DateTime($booth['timestart']);
    $end = new DateTime($booth['timeend']);

    $schedule[] = [
      'start' => $start->format('g:i A'),
      'end' => $end->format('g:i A'),
      'topic' => $booth['topic'],
    ];

    if (is_null($first_start)) {
      $first_start = $start;
    }
    $last_end = $end;
  }

  $add_to_calendar = null;
  if (!is_null($first_start) and !is_null($last_end)) {
    $event_start = $first_start->format('Ymd\THis');
    $event_end = $last_end->format('Ymd\THis');
    $add_to_calendar = "https://calendar.google.com/calendar/render?action=TEMPLATE&text=DICT+HIMAP+Carreer+Roadshow+and+Job+Fair&dates={$event_start}/{$event_end}";
  }
  $name = $reg->name;
  $summary_link =  BASEURL . '/summary.php?s=' . $reg->slug;

  ob_start();
  include __DIR__ . '/../views/email.php';
  $email = ob_get_clean();

  ob_start();
  include __DIR__ . '/../views/email.raw.php';
  $raw = ob_get_clean();

  $qrOptions = new QROptions([
    'outputType' => QRCode::OUTPUT_IMAGE_PNG,
    'eccLevel' => QRCode::ECC_L,
    'scale' => 5,
    'imageBase64' => true,
  ]);

  $qrCode = (new QRCode($qrOptions))->render($summary_link);

  try {
    $mail = get_email();
    $mail->addAddress($reg->email, $reg->name);

    $mail->isHTML(true);
    $mail->Subject = 'DICT HIMAP Career Roadshow and Job Fair Registration';
    $mail->Body    = $email;
    $mail->AltBody = $raw;

    $mail->addStringEmbeddedImage(base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $qrCode)), "qrcode_cid", "qr_code.png", "base64", "image/png");
    $mail->send();

    $reg->mark_email_sent();
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}
