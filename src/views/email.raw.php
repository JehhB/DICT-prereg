# You are successfully registered

View or modify you schedule at <?= $summary_link ?? '#' ?>

## Add you schedule

<?php foreach ($schedule as $timeslot): ?>
  <?= $timeslot['start'] ?>-<?= $timeslot['end'] ?><?= "\t" ?><?= $timeslot['topic'] ?><?= "\n" ?>
<?php endforeach; ?>

-----------------------------------------------------------

Add to you google calendar using: <?= $add_to_calendar ?? '#' ?>
