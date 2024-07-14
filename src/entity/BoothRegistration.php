<?php

class BoothRegistration
{
  public mixed $id;
  public mixed $registration_id;
  public mixed $timeslot_id;
  public mixed $booth_id;



  public static function count(array $booths): array
  {
    $counts = [];
    $db = getDB();
    $stmt = $db->prepare(
      "SELECT COUNT(*) as count 
            FROM BoothRegistration 
            WHERE timeslot_id = ? AND booth_id = ?",
    );
    foreach ($booths as $timeslot_id => $booth_id) {
      $stmt->execute([$timeslot_id, $booth_id]);
      $counts[$timeslot_id] = $stmt->fetchColumn();
    }
    return $counts;
  }

  public static function insert($registration_id, $timeslot_id, $booth_id): BoothRegistration
  {
    execute(
      "INSERT INTO BoothRegistration (registration_id, timeslot_id, booth_id) VALUES (?, ?, ?)",
      [$registration_id, $timeslot_id, $booth_id]
    );
    $boothReg = new BoothRegistration();
    $boothReg->id = getDB()->lastInsertId();
    $boothReg->registration_id = $registration_id;
    $boothReg->timeslot_id = $timeslot_id;
    $boothReg->booth_id = $booth_id;
    return $boothReg;
  }
}
