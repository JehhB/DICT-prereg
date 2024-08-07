<?php

class Event
{
  public mixed $id;
  public string $event_name;
  public string $event_venue;
  public string $prefix;
  public ?bool $available;


  public static function get_events(): array
  {
    $query = <<<SQL
              SELECT 
                  E.*,
                  CASE 
                      WHEN MAX(T.timestart) IS NULL OR DATE_ADD(MAX(T.timestart), INTERVAL 6 MINUTE) > ? THEN 1 
                      ELSE 0 
                  END AS available
              FROM Event E
              LEFT JOIN Timeslots T ON E.event_id = T.event_id
              GROUP BY E.event_id, E.event_name, E.event_venue, E.prefix
              SQL;

    $events = execute($query, [current_time()])->fetchAll();
    foreach ($events as $e) {
      $ev = new Event();
      $ev->id = $e['event_id'];
      $ev->event_name = $e['event_name'];
      $ev->event_venue = $e['event_venue'];
      $ev->prefix = $e['prefix'];
      $ev->available = boolval($e['available']);
      $res[] = $ev;
    }
    return $res;
  }

  public static function find(mixed $id): ?Event
  {
    $res = execute('SELECT * FROM Event WHERE event_id = ?', [$id])->fetch();
    if (!$res) return null;
    $ev = new Event();
    $ev->id = $res['event_id'];
    $ev->event_name = $res['event_name'];
    $ev->event_venue = $res['event_venue'];
    $ev->prefix = $res['prefix'];
    return $ev;
  }


  public static function findValid(mixed $id): ?Event
  {
    $query = <<<SQL
    SELECT DISTINCT E.*
    FROM Event E
    INNER JOIN Timeslots T ON E.event_id = T.event_id
    WHERE DATE_ADD(T.timestart, INTERVAL 6 MINUTE) > ?
    AND E.event_id = ?
    SQL;
    $res = execute($query, [current_time(), $id])->fetch();

    if (!$res) return null;
    $ev = new Event();
    $ev->id = $res['event_id'];
    $ev->event_name = $res['event_name'];
    $ev->event_venue = $res['event_venue'];
    $ev->prefix = $res['prefix'];
    return $ev;
  }
}
