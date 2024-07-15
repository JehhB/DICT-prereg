<?php

define('MAX_SLOTS', 3);

class Registration
{
  public mixed $id;
  public string $email;
  public string $name;
  public string $organization;
  public string $position;


  static function email_exist(string $email): bool
  {
    $stmt = execute('SELECT * FROM Registrations WHERE email = ?', [$email]);
    return $stmt->fetch() !== false;
  }

  static function insert($name, $email, $organization, $position): Registration
  {
    execute(
      "INSERT INTO Registrations (name, email, organization, position) VALUES (?, ?, ?, ?)",
      [$name, $email, $organization, $position]
    );

    $reg = new Registration();
    $reg->id = getDB()->lastInsertId();
    $reg->email = $email;
    $reg->name = $name;
    $reg->organization = $organization;
    $reg->position = $position;

    return $reg;
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
}
