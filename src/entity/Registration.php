<?php

define('MAX_SLOTS', 3);

class Registration
{
  public mixed $id;
  public DateTime $registration_date;
  public string $email;
  public string $name;
  public string $position;
  public string $sex;
  public string $birthday;
  public string $contact_number;
  public string $affiliation;
  public string $type;
  public int $event_id;
  public bool $is_indigenous;
  public string $slug;

  static function email_exist(string $email): bool
  {
    $stmt = execute('SELECT * FROM Registrations WHERE email = ?', [$email]);
    return $stmt->fetch() !== false;
  }

  static function insert(
    $name,
    $email,
    $position,
    $sex,
    $birthday,
    $contact_number,
    $affiliation,
    $type,
    $event_id,
    $is_indigenous
  ): Registration {
    $event = Event::find($event_id);

    $slug = uniqid('', true);
    $slug = substr($slug, -17);
    $slug = $event->prefix . '-' . str_replace('.', '-', $slug);

    execute(
      "INSERT INTO Registrations (
                    name, email, position, sex, birthday, contact_number, affiliation, type, event_id, is_indigenous, slug
                ) VALUES (
                    :name, :email, :position, :sex, :birthday, :contact_number, :affiliation, :type, :event_id, :is_indigenous, :slug
                )",
      [
        ':name' => $name,
        ':email' => $email,
        ':position' => $position,
        ':sex' => $sex,
        ':birthday' => $birthday,
        ':contact_number' => $contact_number,
        ':affiliation' => $affiliation,
        ':type' => $type,
        ':event_id' => $event_id,
        ':is_indigenous' => [$is_indigenous, PDO::PARAM_BOOL],
        ':slug' => $slug,
      ]
    );

    $reg = new Registration();
    $reg->id = getDB()->lastInsertId();
    $reg->registration_date = new DateTime();
    $reg->email = $email;
    $reg->name = $name;
    $reg->position = $position;
    $reg->sex = $sex;
    $reg->birthday = $birthday;
    $reg->contact_number = $contact_number;
    $reg->affiliation = $affiliation;
    $reg->type = $type;
    $reg->event_id = $event_id;
    $reg->is_indigenous = $is_indigenous;
    $reg->slug = $slug;

    return $reg;
  }

  public static function get_registrations()
  {
    $res = [];
    $regs = execute("SELECT * FROM Registrations")->fetchAll();
    foreach ($regs as $r) {
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
      $res[] = $reg;
    }
    return $res;
  }

  public static function find(string $slug): ?Registration
  {
    $r = execute("SELECT * FROM Registrations WHERE slug = ?", [$slug])->fetch();
    if (!$r) return null;

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

    return $reg;
  }

  public function get_age(): int
  {
    $birthDate = new DateTime($this->birthday);
    $currentDate = new DateTime();
    $age = $currentDate->diff($birthDate)->y;
    return $age;
  }

  public function register_booths(array $booths)
  {
    $count = BoothRegistration::count($booths);

    $has_errors = false;
    foreach ($booths as $timeslot_id => $booth_id) {
      if ($count[$timeslot_id] < MAX_SLOTS) {
        BoothRegistration::insert($this->id, $timeslot_id, $booth_id);
      } else {
        flash_set('errors', $timeslot_id, 'Please choose another booth, no slots left');
        unset($_SESSION['register_booths'][$timeslot_id]);
        $has_errors = true;
      }
    }

    if ($has_errors) {
      getDB()->rollBack();
      unset($_SESSION['_PASSED_2']);
      redirect_response("./?p=2");
    }
  }

  public function get_registered_booths(): array
  {
    $sql = 'SELECT br.booth_registration_id, t.timeslot_id, t.timestart, t.timeend, b.booth_id, b.topic, b.presentor
          FROM BoothRegistration br
          JOIN Timeslots t ON br.timeslot_id = t.timeslot_id
          JOIN Booths b ON br.booth_id = b.booth_id
          WHERE br.registration_id = ?
          ORDER BY t.timestart ASC';
    return execute($sql, [$this->id])->fetchAll();
  }
}
