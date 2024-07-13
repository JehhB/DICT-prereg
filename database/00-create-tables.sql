CREATE TABLE `BoothRegistration`(
  `booth_registration_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `registration_id` INTEGER UNSIGNED NOT NULL,
  `timeslot_id` INTEGER UNSIGNED NOT NULL,
  `booth_id` INTEGER UNSIGNED NOT NULL
);

-- Only one registration per table for a given timeslot
ALTER TABLE
  `BoothRegistration` ADD UNIQUE `boothregistration_registration_id_timeslot_id_booth_id_unique`(
    `registration_id`,
    `timeslot_id`,
    `booth_id`
  );

CREATE TABLE `Timeslots`(
  `timeslot_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `timestart` DATETIME NOT NULL,
  `timeend` DATETIME NOT NULL
);

CREATE TABLE `Registrations`(
  `registration_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `organization` VARCHAR(255) NOT NULL,
  `position` VARCHAR(255) NOT NULL
);

ALTER TABLE
  `Registrations` ADD UNIQUE `registrations_email_unique`(`email`);

CREATE TABLE `Booths`(
  `booth_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `topic` VARCHAR(255) NOT NULL,
  `presentor` VARCHAR(255) NOT NULL
);

ALTER TABLE
  `BoothRegistration` ADD CONSTRAINT `boothregistration_timeslot_id_foreign` FOREIGN KEY(`timeslot_id`) REFERENCES `Timeslots`(`timeslot_id`);
ALTER TABLE
  `BoothRegistration` ADD CONSTRAINT `boothregistration_booth_id_foreign` FOREIGN KEY(`booth_id`) REFERENCES `Booths`(`booth_id`);
ALTER TABLE
  `BoothRegistration` ADD CONSTRAINT `boothregistration_registration_id_foreign` FOREIGN KEY(`registration_id`) REFERENCES `Registrations`(`registration_id`);
