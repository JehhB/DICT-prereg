<?php
require_once __DIR__ . '/src/setup.php';

header('Content-Type: application/json');
$count = BoothRegistration::count_summary();
$count['_MAX_SLOTS'] = MAX_SLOTS;
echo json_encode($count);
