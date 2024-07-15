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

  public static function count_summary(): array
  {
    $query = "SELECT timeslot_id, booth_id, COUNT(*) as count 
                  FROM BoothRegistration 
                  GROUP BY timeslot_id, booth_id";

    $stmt = execute($query);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $counts = [];
    foreach ($results as $row) {
      $timeslot_id = $row['timeslot_id'];
      $booth_id = $row['booth_id'];
      $count = $row['count'];

      if (!isset($counts[$timeslot_id])) {
        $counts[$timeslot_id] = [];
      }
      $counts[$timeslot_id][$booth_id] = $count;
    }

    return $counts;
  }
}
