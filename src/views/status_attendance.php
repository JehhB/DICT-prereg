<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;

function createSpreadsheet($eventName, $pdo, $files = null)
{
  if (is_null($files)) {
    $files = [];
  }

  $templateFile = __DIR__ . '/template_attendance.xlsx';
  $spreadsheet = IOFactory::load($templateFile);
  $sheet = $spreadsheet->getActiveSheet();
  $sheet->setTitle('attendance');

  // Get event details
  $stmt = $pdo->prepare("SELECT event_venue FROM Event WHERE event_name = ?");
  $stmt->execute([$eventName]);
  $event = $stmt->fetch(PDO::FETCH_ASSOC);
  $eventVenue = $event['event_venue'] ?? '';

  // Add event details
  $sheet->setCellValue('C3', $eventName);
  $sheet->setCellValue('C4', $eventVenue);

  // Get attendances
  $sql = "SELECT a.attendance_id, r.name, r.sex, r.email, r.contact_number, r.affiliation, r.position, 
          a.attendance_date, a.signature
          FROM Attendances a
          JOIN Registrations r ON a.registration_id = r.registration_id
          JOIN Event e ON r.event_id = e.event_id
          WHERE e.event_name = ?
          ORDER BY a.attendance_date";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$eventName]);
  $attendances = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $sheet->getStyle('A6:I6')
    ->getBorders()
    ->getBottom()
    ->setBorderStyle(Border::BORDER_MEDIUM);

  // Add data rows
  $row = 7;
  foreach ($attendances as $index => $attendance) {
    $sheet->setCellValue('A' . $row, $index + 1);
    $sheet->setCellValue('B' . $row, $attendance['name']);
    $sheet->setCellValue('C' . $row, $attendance['sex']);
    $sheet->setCellValue('D' . $row, $attendance['email']);
    $sheet->setCellValue('E' . $row, $attendance['contact_number']);
    $sheet->setCellValue('F' . $row, truncate($attendance['affiliation'], 15));
    $sheet->setCellValue('G' . $row, truncate($attendance['position'], 10));

    $attendanceTime = new DateTime($attendance['attendance_date'], new DateTimeZone('UTC'));
    $attendanceTime->setTimezone(new DateTimeZone('Asia/Manila'));
    $sheet->setCellValue('H' . $row, $attendanceTime->format('h:i A'));

    // Process signature
    $signatureData = str_replace('data:image/jpeg;base64,', '', $attendance['signature']);
    $signatureImage = base64_decode($signatureData);

    if ($signatureImage !== false) {
      $tempFile = tempnam(sys_get_temp_dir(), 'signature');
      file_put_contents($tempFile, $signatureImage);

      $width = $sheet->getColumnDimension('I')->getWidth('px');

      $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
      $drawing->setName('Signature');
      $drawing->setDescription('Signature');
      $drawing->setPath($tempFile);
      $drawing->setCoordinates('I' . $row);
      $drawing->setOffsetY(1);
      $drawing->setHeight(42);

      $offsetX = (int)(($width - $drawing->getWidth()) / 2);
      $drawing->setOffsetX($offsetX);

      $drawing->setWorksheet($sheet);
      $files[] = $tempFile;
    }

    // Set row height and vertical alignment
    $sheet->getRowDimension($row)->setRowHeight(48, 'px');
    $sheet->getStyle('A' . $row . ':I' . $row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    $sheet->getStyle('A' . $row . ':I' . $row)
      ->getBorders()
      ->getBottom()
      ->setBorderStyle(Border::BORDER_THIN);

    $row++;
  }

  return $spreadsheet;
}

function truncate($string, $length)
{
  if (strlen($string) > $length) {
    return substr($string, 0, $length - 3) . '...';
  }
  return $string;
}


function toSnakeCase($string)
{
  $string = strtolower($string);
  $string = preg_replace('/[\s\-]+/', '_', $string);
  $string = preg_replace('/[^a-z0-9_]/', '_', $string);
  $string = preg_replace('/_+/', '_', $string);
  $string = trim($string, '_');

  return $string;
}

try {
  $eventName = $_GET['attendance'] ?? '';
  $files = [];
  $spreadsheet = createSpreadsheet($eventName, getDB(), $files);

  $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment; filename="attendance_' . toSnakeCase($eventName) . '.xlsx"');
  header('Cache-Control: max-age=0');

  $writer->save('php://output');

  foreach ($files as $file) {
    unlink($file);
  }
} catch (Exception $e) {
  echo $e->getMessage();
}
