<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>
<body>
    <?php include ('reg-query.php');?>
    <?php include ('timeslot-query.php');?>
    <?php include('calculate-age.php');?>

    <div class= "container my-5">
        <div class= "card text-bg-light">
            <div class= "card-header p-4">
                <h3 class= "my-1">Admin Page</h3>
            </div>
            <div class= "card-body p-4">
                <!--Horizontal Layout Table-->
                <div class= "table-responsive">
                        <div class="dropdown mb-4">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Select Time Slot
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <?php foreach ($time_results as $index => $time): 
                                            $start = new DateTime($time['timestart']);
                                            $end = new DateTime($time['timeend']);
                                            $timeSlot = htmlspecialchars($start->format('g:i a') . ' - ' . $end->format('g:i a'));
                                        ?>
                                            <li><a class="dropdown-item" href="#"><?= $timeSlot ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                        </div>

                        <table class="table">
                            <thead class= "table-primary">
                                <tr>
                                <th scope="col">Registration Date</th>
                                <th scope="col">Name</th>
                                <th scope="col">Sex</th>
                                <th scope="col">Birthday</th>
                                <th scope="col">Age</th>
                                <th scope="col">Affiliation</th>
                                <th scope="col">Position</th>
                                <th scope="col">Type</th>
                                <th scope="col">Indigenous</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($reg_results)): ?>
                                    <?php foreach ($reg_results as $row): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['registration_date']) ?></td>
                                            <td><?= htmlspecialchars($row['name']) ?></td>
                                            <td><?= htmlspecialchars($row['sex']) ?></td>
                                            <td><?= htmlspecialchars($row['birthday']) ?></td>
                                            <td><?= calculate_age($row['birthday']) ?></td>
                                            <td><?= htmlspecialchars($row['affiliation']) ?></td>
                                            <td><?= htmlspecialchars($row['position']) ?></td>
                                            <td><?= htmlspecialchars($row['type']) ?></td>
                                            <td><?= htmlspecialchars($row['is_indigenous']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="10" class= "text-center">No results found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                </div>
                
            </div>
        </div>
    </div>
</body>
</html>