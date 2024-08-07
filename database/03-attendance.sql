CREATE TABLE `Attendances`(
    `attendance_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `registration_id` INT UNSIGNED NOT NULL,
    `is_walkin` BOOLEAN NOT NULL DEFAULT FALSE,
    `attendance_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `signature` LONGTEXT NOT NULL
);

ALTER TABLE
    `Attendances` ADD UNIQUE `attendances_registration_id`(`registration_id`);

ALTER TABLE
    `Attendances` ADD CONSTRAINT `attendances_registration_id_foreign` FOREIGN KEY(`registration_id`) REFERENCES `Registrations`(`registration_id`);

CREATE TABLE `ProcessedApplication`(
    `processed_application_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `booth_registration_id` INT UNSIGNED NOT NULL,
    `processed_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE
    `ProcessedApplication` ADD UNIQUE `processed_application_booth_registration_id`(`booth_registration_id`);
ALTER TABLE `ProcessedApplication` ADD COLUMN `skipped` BOOLEAN NOT NULL DEFAULT FALSE;

ALTER TABLE
    `ProcessedApplication` ADD CONSTRAINT `processed_application_booth_registrationg_id_foreign` FOREIGN KEY(`booth_registration_id`) REFERENCES `BoothRegistration`(`booth_registration_id`);
