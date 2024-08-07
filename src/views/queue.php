<?php
define('PAGE_RANGE', 2);
define('PAGE_LIMIT', 25);

$booth = Booth::find($_SESSION['auth_admin']);
$search = $_GET['s'] ?? '';

$page = intval($_GET['p'] ?? 1);
$offset = ($page - 1) * PAGE_LIMIT;

$searchQuery = '%' . strtolower($search)  . '%';
$count =  execute(<<<SQL
SELECT COUNT(*) FROM Registrations r
JOIN BoothRegistration br ON r.registration_id = br.registration_id
LEFT JOIN Attendances a ON r.registration_id = a.registration_id
WHERE booth_id = :b 
  AND a.attendance_id IS NOT NULL
  AND (LOWER(name) LIKE :s OR email LIKE :s)
SQL, [':s' => $searchQuery, ':b' => $booth->id])->fetchColumn();
$num_page = ceil($count / floatval(PAGE_LIMIT));
$count_page = min($page * PAGE_LIMIT, intval($count));
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Page</title>
  <?php include __DIR__ . '/assets.php' ?>
  <script src="/assets/cdn/htmx.min.js" integrity="sha512-/POjPSnGjDaJfmt9O7LOTz1eGoCQNsVSJdgxYTVjhnWRDmuDFTvzwQrxIxipRrakLw7IYJfOsanDe7WuP40zxw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body class="bg-light-subtle">
  <div class="container my-5">
    <h1 class="mb-4">
      Application Queue
    </h1>

    <div class="card text-bg-light">
      <div class="card-header d-flex">
        <?= $booth->presentor ?><?= str_ends_with($booth->presentor, 's') ? "'" : "'s" ?> booth
        <a href="./queue.php?logout=logout" class="btn btn-sm btn-primary ms-auto">Logout</a>
      </div>
      <div class="card-body p-4">
        <div class="row mb-4">

          <em class="col-12 col-lg-auto">
            <?php if ($count == 0) {
              echo "Nothing to process";
            } else {
              echo "Showing " . strval($offset + 1) . '-' . strval($count_page) . " of " . $count . " applicants";
            } ?>
          </em>

          <div class="col col-lg-auto ms-auto">
            <form action="queue.php" method="get" class="input-group" hx-boost="true">
              <input class="form-control form-control-sm" type="text" placeholder="Search" name="s" value="<?= $search ?>">
              <button class="btn btn-sm btn-success">
                Search
              </button>
            </form>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table no-wrap">
            <thead class="table-primary">
              <tr>
                <th scope="col" style="width: 10ch">Status</th>
                <th scope="col">Name</th>
                <th scope="col" style="width: 30ch">Actions</th>
              </tr>
            </thead>
            <tbody
              hx-get="./queue.php?table=1&s=<?= urlencode($search) ?>&p=<?= $page ?>"
              hx-trigger="load, every 5s"></tbody>
          </table>
        </div>

        <?php if ($count > 0): ?>
          <div class="row mt-4">
            <nav class="mx-auto col-auto" hx-boost="true">
              <ul class="pagination pagination-sm">
                <?php if ($page > 1): ?>
                  <li class="page-item">
                    <a
                      class="page-link"
                      href="./queue.php?s=<?= urlencode($search) ?>&p=<?= $page - 1 ?>">
                      Previous
                    </a>
                  </li>
                <?php else:  ?>
                  <li class="page-item"><a class="page-link disabled" href="#">Previous</a></li>
                <?php endif; ?>


                <?php if ($page > PAGE_RANGE + 1): ?>
                  <li class="page-item">
                    <a
                      class="page-link"
                      href="./queue.php?s=<?= urlencode($search) ?>&p=1">
                      1
                    </a>
                  </li>

                  <?php if ($page > PAGE_RANGE + 2): ?>
                    <li class="page-item disabled">
                      <span class="page-link">&hellip;</span>
                    </li>
                  <?php endif ?>
                <?php endif ?>

                <?php for ($i = max(1, $page - PAGE_RANGE); $i <= min($num_page, $page + PAGE_RANGE); ++$i): ?>
                  <li class="page-item">
                    <a
                      class="page-link <?php if ($i == $page) echo 'active'; ?>"
                      href="./queue.php?s=<?= urlencode($search) ?>&p=<?= $i ?>">
                      <?= $i ?>
                    </a>
                  </li>
                <?php endfor; ?>

                <?php if ($page < $num_page - PAGE_RANGE): ?>
                  <?php if ($page < $num_page - PAGE_RANGE - 1): ?>
                    <li class="page-item disabled">
                      <span class="page-link">&hellip;</span>
                    </li>
                  <?php endif ?>
                  <li class="page-item">
                    <a class="page-link" href="./queue.php?s=<?= urlencode($search) ?>&p=<?= $num_page ?>"><?= $num_page ?></a>
                  </li>
                <?php endif ?>

                <?php if ($page < $num_page): ?>
                  <li class="page-item"><a class="page-link" href="./queue.php?s=<?= urlencode($search) ?>&p=<?= $page + 1 ?>">Next</a></li>
                <?php else:  ?>
                  <li class="page-item"><a class="page-link disabled" href="#">Next</a></li>
                <?php endif; ?>
              </ul>
            </nav>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>

</html>
