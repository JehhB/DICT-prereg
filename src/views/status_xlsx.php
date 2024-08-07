<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

function createSpreadsheet($boothTopic, $pdo)
{
  $templateFile = __DIR__ . '/template.xlsx';
  $spreadsheet = IOFactory::load($templateFile);
  $templateSheet = $spreadsheet->getActiveSheet();

  $stmtBooth = $pdo->prepare("SELECT booth_id FROM Booths WHERE topic = ?");
  $stmtBooth->execute([$boothTopic]);
  $boothId = $stmtBooth->fetchAll(PDO::FETCH_COLUMN);

  if (count($boothId) == 0) {
    error_response(404, 'Not found');
  }

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

  $sheetIndex = 1;
  while ($timeslot = $stmtTimeslots->fetch(PDO::FETCH_ASSOC)) {
    $stmtRegistrations->execute(array_merge($boothId, [$timeslot['timeslot_id']]));
    $registrations = $stmtRegistrations->fetchAll(PDO::FETCH_ASSOC);

    $stmtBooth = $pdo->prepare("SELECT e.*
                                  FROM Timeslots t
                                  JOIN Event e ON e.event_id = t.event_id 
                                  WHERE t.timeslot_id = ?");
    $stmtBooth->execute([$timeslot['timeslot_id']]);
    $boothInfo = $stmtBooth->fetch(PDO::FETCH_ASSOC);

    $eventName = $boothInfo['event_name'];
    $eventVenue = $boothInfo['event_venue'];


    $batchCount = ceil(count($registrations) / 50);
    for ($batch = 0; $batch < $batchCount; $batch++) {
      $sheetName = date('m-d h.ia', strtotime($timeslot['timestart'])) .
        " " . date('h.ia', strtotime($timeslot['timeend']));
      if ($batchCount > 1) {
        $sheetName .= "(Batch " . ($batch + 1) . ")";
      }

      $batchRegistrations = array_slice($registrations, $batch * 50, 50);

      usort($batchRegistrations, function ($a, $b) {
        return strcmp(strtolower($a['name']), strtolower($b['name']));
      });

      $sheet = clone $templateSheet;
      $sheet->setTitle($sheetName);
      $spreadsheet->addSheet($sheet, $sheetIndex);

      // Update event information
      $sheet->setCellValue('C1', $eventName);
      $sheet->setCellValue('C2', $eventVenue);
      $sheet->setCellValue('C3', $boothTopic);
      $sheet->setCellValue('C4', date('Y-m-d h:ia', strtotime($timeslot['timestart'])) .
        ' - ' . date('h:ia', strtotime($timeslot['timeend'])));

      $sheet
        ->getStyle("A6:J6")
        ->getBorders()
        ->getBottom()
        ->setBorderStyle(Border::BORDER_MEDIUM);

      // Fill data
      $rowIndex = 7;  // Assuming the data starts at row 7 in the template
      foreach ($batchRegistrations as $registration) {
        $contact = strval($registration['contact_number']);
        if (str_starts_with($contact, '9')) $contact = '0' . $contact;

        $sheet->fromArray([
          $rowIndex - 6,
          html_entity_decode($registration['name']),
          match ($registration['sex']) {
            'M' => 'Male',
            'F' => 'Female',
            'OTHER' => 'Others',
            'BLANK' => 'Prefer not to mention',
          },
          $registration['birthday'],
          $registration['email'],
          $contact,
          html_entity_decode($registration['affiliation']),
          html_entity_decode($registration['position']),
          html_entity_decode($registration['type']),
          $registration['is_indigenous'] ? 'Yes' : 'No'
        ], NULL, 'A' . $rowIndex);

        $sheet->getRowDimension($rowIndex)->setRowHeight(24, 'pt');
        $sheet
          ->getStyle("A$rowIndex:J$rowIndex")
          ->getBorders()
          ->getBottom()
          ->setBorderStyle(Border::BORDER_THIN);
        $sheet
          ->getStyle("A$rowIndex:J$rowIndex")
          ->getAlignment()
          ->setVertical(Alignment::VERTICAL_TOP);

        $rowIndex++;
      }

      $sheetIndex++;
    }
  }

  $spreadsheet->removeSheetByIndex(0);
  $spreadsheet->setActiveSheetIndex(0);
  return $spreadsheet;
}

try {
  $boothTopic = $_GET['xlsx'] ?? '';
  $spreadsheet = createSpreadsheet($boothTopic, getDB());
  $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment; filename="registrations_' . str_replace(' ', '_', strtolower($boothTopic)) . '.xlsx"');
  header('Cache-Control: max-age=0');

  $writer->save('php://output');
} catch (Exception $e) {
  echo $e->getMessage();
}
