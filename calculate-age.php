<?php
function calculate_age($birthday) {
    $birthDate = new DateTime($birthday);
    $currentDate = new DateTime();
    $age = $currentDate->diff($birthDate)->y;
    return $age;
}