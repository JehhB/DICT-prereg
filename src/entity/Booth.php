<?php

class Booth
{
  public mixed $id;
  public string $topic;
  public string $presentor;
  public mixed $event_id;
  public string $email;
  public string $password_hash;

  public static function find_by_email(string $email): ?Booth
  {
    $r = execute('SELECT * FROM Booths WHERE email = ?', [$email])->fetch();
    if (!$r) return null;

    $booth = new Booth();
    $booth->id = $r['booth_id'];
    $booth->topic = $r['topic'];
    $booth->presentor = $r['presentor'];
    $booth->event_id = $r['event_id'];
    $booth->email = $r['email'];
    $booth->password_hash = $r['password'];

    return $booth;
  }

  public static function find(mixed $id): ?Booth
  {
    $r = execute('SELECT * FROM Booths WHERE booth_id = ?', [$id])->fetch();
    if (!$r) return null;

    $booth = new Booth();
    $booth->id = $r['booth_id'];
    $booth->topic = $r['topic'];
    $booth->presentor = $r['presentor'];
    $booth->event_id = $r['event_id'];
    $booth->email = $r['email'];
    $booth->password_hash = $r['password'];

    return $booth;
  }

  public function verify_password(string $password): bool
  {
    return password_verify($password, $this->password_hash);
  }

  public function get_booth_registrations(mixed $timeslot_id = null, $limit = 10, $offset = 0, $search = ''): array
  {
    $sql = 'SELECT r.*, t.timestart, t.timeend
          FROM BoothRegistration br
          JOIN Timeslots t ON br.timeslot_id = t.timeslot_id
          JOIN Registrations r ON r.registration_id = br.registration_id
          WHERE br.booth_id = ? AND LOWER(r.name) LIKE ?';
    $params = [[$this->id, PDO::PARAM_INT], '%' . strtolower($search) . '%'];

    if (!is_null($timeslot_id)) {
      $sql .= ' AND br.timeslot_id = ?';
      $params[] = [$timeslot_id, PDO::PARAM_INT];
    }

    $sql .= ' ORDER BY r.registration_date ASC LIMIT ? OFFSET ?';
    $params = array_merge($params, [[$limit, PDO::PARAM_INT], [$offset, PDO::PARAM_INT]]);

    $registrations = execute($sql, $params)->fetchAll();

    $output = [];
    foreach ($registrations as $r) {
      $reg = new Registration();
      $reg->registration_date = new DateTime($r['registration_date']);
      $reg->id = $r['registration_id'];
      $reg->email = $r['email'];
      $reg->name = $r['name'];
      $reg->position = $r['position'];
      $reg->sex = $r['sex'];
      $reg->birthday = $r['birthday'];
      $reg->contact_number = $r['contact_number'];
      $reg->affiliation = $r['affiliation'];
      $reg->type = $r['type'];
      $reg->event_id = $r['event_id'];
      $reg->is_indigenous = $r['is_indigenous'];
      $reg->slug = $r['slug'];
      $reg->email_sent = $r['email_sent'];
      $output[] = [$reg, [
        'start' => $r['timestart'],
        'end' => $r['timeend']
      ]];
    }

    return $output;
  }


  public function count_booth_registrations(mixed $timeslot_id = null, $search = ""): int
  {
    $sql = 'SELECT COUNT(*) as total
            FROM BoothRegistration br
            JOIN Registrations r ON r.registration_id = br.registration_id
            WHERE br.booth_id = ? AND LOWER(r.name) LIKE ?';
    $params = [$this->id, '%' . strtolower($search) . '%'];

    if (!is_null($timeslot_id)) {
      $sql .= ' AND br.timeslot_id = ?';
      $params[] = $timeslot_id;
    }
    return execute($sql, $params)->fetchColumn();
  }
}
