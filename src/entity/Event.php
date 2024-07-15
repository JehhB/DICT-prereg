<?php

class Event
{
  public mixed $id;
  public string $event_name;
  public string $event_venue;

  public static function get_events(): array
  {
    $res = [];
    $events = execute('SELECT * FROM Event')->fetchAll();
    foreach ($events as $e) {
      $ev = new Event();
      $ev->id = $e['event_id'];
      $ev->event_name = $e['event_name'];
      $ev->event_venue = $e['event_venue'];
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
    return $ev;
  }
}
