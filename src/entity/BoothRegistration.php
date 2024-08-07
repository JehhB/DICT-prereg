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

  public static function count_summary(mixed $exclude = null): array
  {
    if (is_null($exclude)) {
      $query = "SELECT timeslot_id, booth_id, COUNT(*) as count 
                  FROM BoothRegistration 
                  GROUP BY timeslot_id, booth_id";

      $stmt = execute($query);
    } else {
      $query = "SELECT timeslot_id, booth_id, COUNT(*) as count 
                  FROM BoothRegistration 
                  WHERE registration_id <> ?
                  GROUP BY timeslot_id, booth_id";

      $stmt = execute($query, [$exclude]);
    }

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $counts = [];
    foreach ($results as $row) {
      $timeslot_id = $row['timeslot_id'];
      $booth_id = $row['booth_id'];
      $count = $row['count'];

      if (!isset($counts[$timeslot_id])) {
        $counts[$timeslot_id] = [];
      }
      $counts[(int)$timeslot_id][(int)$booth_id] = (int)$count;
    }

    return $counts;
  }

  private static function mark_processed(int $boothRegistrationId, int $skipped): bool
  {

    $db = getDB();
    try {
      $db->beginTransaction();

      $query = "
                INSERT INTO ProcessedApplication (booth_registration_id, processed_date, skipped)
                VALUES (?, CURRENT_TIMESTAMP, ?)
                ON DUPLICATE KEY UPDATE processed_date = CURRENT_TIMESTAMP, skipped = ?
            ";

      $result = execute($query, [$boothRegistrationId, $skipped, $skipped]);

      if (!$result) {
        throw new Exception("Failed to insert or update ProcessedApplication record");
      }

      $db->commit();
      return true;
    } catch (Exception $e) {
      $db->rollBack();
      echo ("Error in markProcessed: " . $e->getMessage());
      return false;
    }
  }

  public static function mark_done(int $boothRegistrationId): bool
  {
    return self::mark_processed($boothRegistrationId, 0);
  }

  public static function mark_skipped(int $boothRegistrationId): bool
  {
    return self::mark_processed($boothRegistrationId, 1);
  }

  public static function undo(int $boothRegistrationId): bool
  {
    $db = getDB();
    try {
      $db->beginTransaction();

      $query = "
                DELETE FROM ProcessedApplication
                WHERE booth_registration_id = ?
            ";

      $result = execute($query, [$boothRegistrationId]);

      if (!$result) {
        throw new Exception("Failed to delete ProcessedApplication record");
      }

      $db->commit();
      return true;
    } catch (Exception $e) {
      $db->rollBack();
      echo ("Error in undo: " . $e->getMessage());
      return false;
    }
  }
}
