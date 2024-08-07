<?php
define('PAGE_LIMIT', 25);

$booth = Booth::find($_SESSION['auth_admin']);
$search = $_GET['s'] ?? '';
$page = intval($_GET['p'] ?? 1);
$offset = ($page - 1) * PAGE_LIMIT;

$queue = Registration::get_queue_json($booth, $offset, PAGE_LIMIT, $search);

if (empty($queue)): ?>
  <tr>
    <td colspan="3" class="text-center">No results found</td>
  </tr>
  <?php else:
  foreach ($queue as $q): ?>
    <tr>
      <?php if ($q['status'] == 'done'): ?>
        <td class="bg-success-subtle" scope="col" style="width: 10ch">Done</td>
      <?php elseif ($q['status'] == 'skipped'): ?>
        <td class="bg-danger-subtle" scope="col" style="width: 10ch">Skipped</td>
      <?php elseif ($q['status'] == 'reserved'): ?>
        <td class="bg-secondary" scope="col" style="width: 10ch">Reserved</td>
      <?php elseif ($q['status'] == 'walkin'): ?>
        <td class="bg-info-subtle" scope="col" style="width: 10ch">Walk-in</td>
      <?php elseif ($q['status'] == 'waiting'): ?>
        <td class="bg-warning-subtle" scope="col" style="width: 10ch">Waiting</td>
      <?php else: ?>
        <td class="bg-secondary-subtle" scope="col" style="width: 10ch">Scheduled</td>
      <?php endif; ?>
      <td scope="col"><?= htmlspecialchars($q['name']) ?></td>
      <td scope="col" style="width: 30ch" hx-boost="true">
        <?php if ($q['status'] == 'done' || $q['status'] == 'skipped'): ?>
          <a href="./queue.php?undo=<?= $q['id'] ?>&p=<?= $page ?>&s=<?= $search ?>" class="btn btn-sm btn-warning">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2z" />
              <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466" />
            </svg>
            Undo
          </a>
        <?php elseif ($q['status'] == 'scheduled'): ?>
          Waiting for schedule
        <?php else: ?>
          <a href="./queue.php?done=<?= $q['id'] ?>&p=<?= $page ?>&s=<?= $search ?>" class="btn btn-sm btn-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
              <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z" />
            </svg>
            Done
          </a>
          <a href="./queue.php?skip=<?= $q['id'] ?>&p=<?= $page ?>&s=<?= $search ?>" class="btn btn-sm btn-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
              <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
            </svg>
            Skip
          </a>
        <?php endif ?>
      </td>
    </tr>
<?php endforeach;
endif; ?>
