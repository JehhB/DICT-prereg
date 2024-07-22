CREATE TABLE `BoothRegistration`(
    `booth_registration_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `registration_id` INT UNSIGNED NOT NULL,
    `timeslot_id` INT UNSIGNED NOT NULL,
    `booth_id` INT UNSIGNED NOT NULL
);
ALTER TABLE
    `BoothRegistration` ADD UNIQUE `boothregistration_registration_id_timeslot_id_booth_id_unique`(
        `registration_id`,
        `timeslot_id`,
        `booth_id`
    );
CREATE TABLE `Timeslots`(
    `timeslot_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `timestart` DATETIME NOT NULL,
    `timeend` DATETIME NOT NULL,
    `event_id` INT UNSIGNED NOT NULL
);
CREATE TABLE `Registrations`(
    `registration_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `event_id` INT UNSIGNED NOT NULL,
    `registration_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `name` VARCHAR(255) NOT NULL,
    `sex` ENUM('M', 'F') NOT NULL,
    `birthday` DATE NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `contact_number` BIGINT NOT NULL,
    `affiliation` VARCHAR(255) NOT NULL,
    `position` VARCHAR(255) NOT NULL,
    `type` VARCHAR(255) NOT NULL,
    `is_indigenous` BOOLEAN NOT NULL,
    `slug` VARCHAR(64) NOT NULL,
    `email_sent` BOOLEAN NOT NULL DEFAULT FALSE
);
ALTER TABLE
    `Registrations` ADD UNIQUE `registrations_email_unique`(`email`);
CREATE TABLE `Booths`(
    `booth_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `topic` VARCHAR(255) NOT NULL,
    `presentor` VARCHAR(255) NOT NULL,
    `event_id` INT UNSIGNED NOT NULL
);
CREATE TABLE `Event`(
    `event_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `event_name` VARCHAR(255) NOT NULL,
    `event_venue` VARCHAR(255) NOT NULL,
    `prefix` VARCHAR(16) NOT NULL DEFAULT ''
);

ALTER TABLE
    `Booths` ADD CONSTRAINT `booths_event_id_foreign` FOREIGN KEY(`event_id`) REFERENCES `Event`(`event_id`);
ALTER TABLE
    `Registrations` ADD CONSTRAINT `registrations_event_id_foreign` FOREIGN KEY(`event_id`) REFERENCES `Event`(`event_id`);
ALTER TABLE
    `BoothRegistration` ADD CONSTRAINT `boothregistration_timeslot_id_foreign` FOREIGN KEY(`timeslot_id`) REFERENCES `Timeslots`(`timeslot_id`);
ALTER TABLE
    `BoothRegistration` ADD CONSTRAINT `boothregistration_booth_id_foreign` FOREIGN KEY(`booth_id`) REFERENCES `Booths`(`booth_id`);
ALTER TABLE
    `Timeslots` ADD CONSTRAINT `timeslots_event_id_foreign` FOREIGN KEY(`event_id`) REFERENCES `Event`(`event_id`);
ALTER TABLE
    `BoothRegistration` ADD CONSTRAINT `boothregistration_registration_id_foreign` FOREIGN KEY(`registration_id`) REFERENCES `Registrations`(`registration_id`);
