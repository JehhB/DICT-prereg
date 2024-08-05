<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function createSpreadsheet($boothTopic, $pdo)
{
  $spreadsheet = new Spreadsheet();

  $stmtBooth = $pdo->prepare("SELECT b.booth_id, b.topic, e.event_name, e.event_venue 
                              FROM Booths b 
                              JOIN Event e ON b.event_id = e.event_id 
                              WHERE b.topic = ?");
  $stmtBooth->execute([$boothTopic]);
  $boothInfo = $stmtBooth->fetch(PDO::FETCH_ASSOC);

  if (!$boothInfo) {
    error_response(404, 'Not found');
  }

  $boothId = [$boothInfo['booth_id']];
  $eventName = $boothInfo['event_name'];
  $eventVenue = $boothInfo['event_venue'];


  $stmtBooth = $pdo->prepare("SELECT booth_id FROM Booths WHERE topic = ?");
  $stmtBooth->execute([$boothTopic]);
  $boothId = $stmtBooth->fetchAll(PDO::FETCH_COLUMN);

  $placeholderBooth = placeholder($boothId);

  // Get timeslots for this booth
  $stmtTimeslots = $pdo->prepare("
        SELECT DISTINCT t.timeslot_id, t.timestart, t.timeend
        FROM Timeslots t
        JOIN BoothRegistration br ON t.timeslot_id = br.timeslot_id
        WHERE br.booth_id IN ($placeholderBooth)
        ORDER BY t.timestart
    ");
  $stmtTimeslots->execute($boothId);

  // Prepare the registration query
  $stmtRegistrations = $pdo->prepare("
        SELECT r.*, br.timeslot_id
        FROM Registrations r
        JOIN BoothRegistration br ON r.registration_id = br.registration_id
        WHERE br.booth_id IN ($placeholderBooth) AND br.timeslot_id = ?
        ORDER BY r.registration_date
    ");

  $sheetIndex = 0;
  while ($timeslot = $stmtTimeslots->fetch(PDO::FETCH_ASSOC)) {
    $stmtRegistrations->execute(array_merge($boothId, [$timeslot['timeslot_id']]));
    $registrations = $stmtRegistrations->fetchAll(PDO::FETCH_ASSOC);

    $batchCount = ceil(count($registrations) / 50);
    for ($batch = 0; $batch < $batchCount; $batch++) {
      $sheetName = date('Y-m-d H.i', strtotime($timeslot['timestart'])) .
        " " . date('H.i', strtotime($timeslot['timeend']));
      if ($batchCount > 1) {
        $sheetName .= "(Batch " . ($batch + 1) . ")";
      }

      $sheet = ($sheetIndex === 0) ? $spreadsheet->getActiveSheet() : $spreadsheet->createSheet();
      $sheet->setTitle($sheetName);

      // Add event information headers
      $sheet->setCellValue('A1', 'Event Name:');
      $sheet->setCellValue('B1', $eventName);
      $sheet->setCellValue('A2', 'Event Venue:');
      $sheet->setCellValue('B2', $eventVenue);
      $sheet->setCellValue('A3', 'Booth Topic:');
      $sheet->setCellValue('B3', $boothTopic);
      $sheet->setCellValue('A4', 'Timeslot:');
      $sheet->setCellValue('B4', date('Y-m-d H:i', strtotime($timeslot['timestart'])) .
        ' - ' . date('H:i', strtotime($timeslot['timeend'])));

      // Set headers for registration data
      $headers = [
        'Name',
        'Sex',
        'Birthday',
        'Email',
        'Contact Number',
        'Affiliation',
        'Position',
        'Type',
        'Is Indigenous',
        'QR Code'
      ];
      $sheet->fromArray($headers, NULL, 'A6');

      // Fill data
      $rowIndex = 7;
      for ($i = $batch * 50; $i < min(($batch + 1) * 50, count($registrations)); $i++) {
        $registration = $registrations[$i];
        $sheet->fromArray([
          $registration['name'],
          $registration['sex'],
          $registration['birthday'],
          $registration['email'],
          $registration['contact_number'],
          $registration['affiliation'],
          $registration['position'],
          $registration['type'],
          $registration['is_indigenous'] ? 'Yes' : 'No'
        ], NULL, 'A' . $rowIndex);

        // Generate QR code URL
        $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" .
          urlencode("https://dtechsideprojects.online/summary.php?s=" . $registration['slug']);

        // Add QR code using IMAGE() function
        $sheet->setCellValue('J' . $rowIndex, '=IMAGE("' . $qrCodeUrl . '")');

        $rowIndex++;
      }

      // Auto-size columns
      foreach (range('A', 'J') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
      }

      $sheetIndex++;
    }
  }

  return $spreadsheet;
}

try {
  $boothTopic = $_GET['xlsx'] ?? '';
  $spreadsheet = createSpreadsheet($boothTopic, getDB());
  $tempFile = tempnam(sys_get_temp_dir(), 'excel_');
  $writer = new Xlsx($spreadsheet);
  $writer->save($tempFile);

  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment; filename="registrations_' . str_replace(' ', '_', $boothTopic) . '.xlsx"');
  header('Cache-Control: max-age=0');

  readfile($tempFile);
  unlink($tempFile);
} catch (Exception $e) {
  echo $e->getMessage();
}
