<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Statistics</title>
  <script type="aplication/json" id="registrationCountData">
    <?php
    $sql = <<<SQL
SELECT
    e.event_name,
    DATE_FORMAT(
        r.registration_date,
        '%Y-%m-%d %H:00:00'
    ) AS hour_bin,
    COUNT(*) AS hourly_registrations,
    SUM(COUNT(*)) OVER(
    PARTITION BY e.event_name
ORDER BY
    DATE_FORMAT(
        r.registration_date,
        '%Y-%m-%d %H:00:00'
    )
) AS cumulative_registrations
FROM Event
    e
JOIN Registrations r ON
    e.event_id = r.event_id
GROUP BY
    e.event_name,
    hour_bin
ORDER BY
    e.event_name,
    hour_bin;
SQL;
    $stmt = execute($sql);

    $registrationData = [];
    while ($hour = $stmt->fetch()) {
      if (!isset($registrationData[$hour['event_name']])) {
        $registrationData[$hour['event_name']] = [];
      }

      $registrationData[$hour['event_name']][] =  [
        'x' => (new DateTime($hour['hour_bin']))->format('Y-m-d\TH:i:s'),
        'y' => $hour['cumulative_registrations'],
      ];
    }

    $data = [
      'registrationData' => $registrationData
    ];

    echo json_encode($data);
    ?>
  </script>
  <script id="eventData" type="application/json">
    <?php

    $sexQuery = <<<SQL
        SELECT 
            e.event_name,
            r.sex,
            COUNT(*) as count
        FROM 
            Event e
            JOIN Registrations r ON e.event_id = r.event_id
        GROUP BY 
            e.event_id, e.event_name, r.sex
        ORDER BY 
            e.event_id, r.sex;
    SQL;

    $ageQuery = <<<SQL
        SELECT 
            e.event_name,
            CASE 
                WHEN TIMESTAMPDIFF(YEAR, r.birthday, CURDATE()) <= 21 THEN '21 and below'
                WHEN TIMESTAMPDIFF(YEAR, r.birthday, CURDATE()) BETWEEN 22 AND 30 THEN '22-30'
                WHEN TIMESTAMPDIFF(YEAR, r.birthday, CURDATE()) BETWEEN 31 AND 40 THEN '31-40'
                WHEN TIMESTAMPDIFF(YEAR, r.birthday, CURDATE()) BETWEEN 41 AND 50 THEN '41-50'
                WHEN TIMESTAMPDIFF(YEAR, r.birthday, CURDATE()) BETWEEN 51 AND 65 THEN '51-65'
                ELSE '65 and above'
            END AS age_group,
            COUNT(*) as count
        FROM 
            Event e
            JOIN Registrations r ON e.event_id = r.event_id
        GROUP BY 
            e.event_id, e.event_name, age_group
        ORDER BY 
            e.event_id, age_group;
    SQL;

    $indigenousQuery = <<<SQL
        SELECT 
            e.event_name,
            r.is_indigenous,
            COUNT(*) as count
        FROM 
            Event e
            JOIN Registrations r ON e.event_id = r.event_id
        GROUP BY 
            e.event_id, e.event_name, r.is_indigenous
        ORDER BY 
            e.event_id, r.is_indigenous;
    SQL;

    $typeQuery = <<<SQL
        SELECT 
            e.event_name,
            SUM(CASE WHEN LOWER(r.type) LIKE '%student%' THEN 1 ELSE 0 END) as student_count,
            SUM(CASE WHEN LOWER(r.type) LIKE '%job seeker%' THEN 1 ELSE 0 END) as job_seeker_count,
            SUM(CASE WHEN LOWER(r.type) LIKE '%fresh graduate%' THEN 1 ELSE 0 END) as fresh_graduate_count,
            SUM(CASE WHEN LOWER(r.type) LIKE '%out of school youth%' THEN 1 ELSE 0 END) as out_of_school_youth_count,
            COUNT(*) as total
        FROM 
            Event e
            JOIN Registrations r ON e.event_id = r.event_id
        GROUP BY 
            e.event_id, e.event_name
        ORDER BY 
            e.event_id;
    SQL;

    // Fetch data
    $sexData = execute($sexQuery)->fetchAll();
    $ageData = execute($ageQuery)->fetchAll();
    $indigenousData = execute($indigenousQuery)->fetchAll();
    $typeData = execute($typeQuery);

    // Process data into the required format
    $result = ['events' => []];

    foreach ($sexData as $row) {
      $eventName = $row['event_name'];
      if (!isset($result['events'][$eventName])) {
        $result['events'][$eventName] = [
          'sex_data' => [],
          'age_data' => [],
          'indigenous_data' => [],
          'description_data' => [
            'student' => 0,
            'jobSeeker' => 0,
            'freshGraduate' => 0,
            'outOfSchoolYouth' => 0,
            'total' => 0,
          ]
        ];
      }
      $result['events'][$eventName]['sex_data'][match ($row['sex']) {
        'M' => 'Male',
        'F' => 'Female',
        'OTHER' => 'Others',
        'BLANK' => 'Prefer not to mention',
      }] = intval($row['count']);
    }

    foreach ($ageData as $row) {
      $eventName = $row['event_name'];
      $result['events'][$eventName]['age_data'][$row['age_group']] = intval($row['count']);
    }

    foreach ($indigenousData as $row) {
      $eventName = $row['event_name'];
      $isIndigenous = $row['is_indigenous'] ? 'Yes' : 'No';
      $result['events'][$eventName]['indigenous_data'][$isIndigenous] = intval($row['count']);
    }

    foreach ($typeData as $row) {
      $eventName = $row['event_name'];
      $result['events'][$eventName]['description_data'] = [
        'Student' => intval($row['student_count']),
        'Job Seeker' => intval($row['job_seeker_count']),
        'Fresh Graduate' => intval($row['fresh_graduate_count']),
        'Out of School Youth' => intval($row['out_of_school_youth_count']),
        'Total' => intval($row['total'])
      ];
    }

    echo json_encode($result);
    ?>
  </script>
  <script id="affiliationData" type="application/json">
    <?php
    $sql = <<<SQL
SELECT
    MIN(r.affiliation) AS affiliation,
    SUM(CASE WHEN r.event_id = 1 THEN 1 ELSE 0 END) AS tuguegarao_count,
	SUM(CASE WHEN r.event_id = 2 THEN 1 ELSE 0 END) AS cauayan_count
FROM Registrations r
GROUP BY LOWER(r.affiliation)
ORDER BY MIN(r.affiliation) ASC;
SQL;
    $result = execute($sql)->fetchAll();
    $result = array_map(function ($v) {
      return [
        'affiliation' => html_entity_decode($v['affiliation']),
        'tuguegarao_count' => intval($v['tuguegarao_count']),
        'cauayan_count' => intval($v['cauayan_count']),
      ];
    }, $result);
    echo json_encode($result);
    ?>
  </script>

  <?php include __DIR__ . '/assets.php' ?>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/moment@2.30.1/moment.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.1/dist/chartjs-adapter-moment.min.js" integrity="sha256-TKbdvBbEOMfezGDxb77pY503J3r2CTkPd5TrJymt21U=" crossorigin="anonymous"></script>
  <script defer>
    const colors = ['red', 'blue', 'gray', 'yellow', 'purple'];

    const data = JSON.parse(document.getElementById('registrationCountData').textContent);

    const datasets = Object.entries(data.registrationData).map(([eventName, eventData], index) => ({
      label: eventName,
      data: eventData,
      borderColor: colors[index % colors.length],
      fill: false
    }));

    const config = {
      type: 'line',
      data: {
        datasets
      },
      options: {
        responsive: true,
        title: {
          display: true,
          text: 'Total Registrations Over Time per Event (Hourly)'
        },
        scales: {
          x: {
            type: 'time',
            time: {
              unit: 'hour',
              displayFormats: {
                hour: 'MMM D, HH:mm'
              }
            },
            title: {
              display: true,
              text: 'Date and Time'
            }
          },
          y: {
            title: {
              display: true,
              text: 'Total Registrations'
            },
            beginAtZero: true
          }
        },
        plugins: {
          tooltip: {
            callbacks: {
              title: function(context) {
                return moment(context[0].parsed.x).format('MMM D, YYYY HH:mm');
              }
            }
          }
        }
      }
    };


    document.addEventListener("DOMContentLoaded", function() {
      const canvas = document.getElementById('registrationCount');
      new Chart(canvas, config);
    });
  </script>
  <script>
    function eventStats() {
      return {
        events: JSON.parse(document.getElementById('eventData').textContent).events,
        sections: [{
            title: 'Sex Distribution',
            dataKey: 'sex_data',
            type: 'pie'
          },
          {
            title: 'Age Distribution',
            dataKey: 'age_data',
            type: 'pie'
          },
          {
            title: 'Indigenous Status',
            dataKey: 'indigenous_data',
            type: 'pie'
          },
          {
            title: 'Participant Types',
            dataKey: 'description_data',
            type: 'bar'
          }
        ],
        createChart(canvas, type, title, data) {
          new Chart(canvas, {
            type: type,
            data: {
              labels: Object.keys(data),
              datasets: [{
                label: 'Count',
                data: Object.values(data),
                backgroundColor: [
                  '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
                ]
              }]
            },
            options: {
              responsive: true,
              plugins: {
                legend: {
                  position: type === 'pie' ? 'top' : 'none',
                },
                title: {
                  display: true,
                  text: title
                }
              },
              scales: type === 'bar' ? {
                y: {
                  beginAtZero: true
                }
              } : undefined
            }
          });
        }
      };
    }


    function affiliation() {
      const list = JSON.parse(document.getElementById('affiliationData').textContent);

      return {
        query: '',
        selected: '',

        init() {
          this.$watch('query', q => {
            if (q.length > 0) this.selected = '';
          })
        },

        get searchResult() {
          if (this.selected == 'csu') {
            return list.filter(v => {
              const lower = v.affiliation.toLowerCase();
              return lower.includes('cagayan state university') || lower.includes('csu');
            });
          }
          if (this.selected == 'isu') {
            return list.filter(v => {
              const lower = v.affiliation.toLowerCase();
              return lower.includes('isabela state university') || lower.includes('isu');
            });
          }

          return list.filter(v => v.affiliation.toLowerCase().includes(this.query.toLowerCase()));
        },

        get total() {
          return this.searchResult.reduce((prev, cur) => ({
            'tuguegarao_count': prev.tuguegarao_count + cur.tuguegarao_count,
            'cauayan_count': prev.cauayan_count + cur.cauayan_count,
          }), {
            tuguegarao_count: 0,
            cauayan_count: 0,
          });
        }
      };
    }

    document.addEventListener('alpine:init', () => {
      Alpine.data('eventStats', eventStats);
      Alpine.data('affiliation', affiliation);
    })
  </script>
  <style>
    canvas {
      max-height: 300px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="col col-md-11 col-lg-9 col-xl-8 col-xxl-7 mx-auto my-4" id="eventContainer" x-data="eventStats()">
      <div class="row">
        <h1>
          Registration Statistics
        </h1>
      </div>

      <div class="card mb-4 shadow-sm">
        <div class="card-header bg-secondary d-flex">
          Event statistics
          <?php
          $sql = "SELECT topic FROM Booths ORDER BY topic ASC LIMIT 1";
          $topic = execute($sql)->fetchColumn();
          ?>
          <a href="./status.php?report=<?= urlencode($topic) ?>" class="ms-auto col-auto btn btn-primary btn-sm">Generate Report</a>
          <a href="./status.php?logout=logout" class="ms-2 col-auto btn btn-secondary btn-sm">Logout</a>
        </div>
        <div class="card-body">
          <div class="row">
            <dl class="row mb-0 col-12 col-md-9 mb-3">
              <?php
              $sql = 'SELECT 
                          MIN(e.event_id) AS event_id,
                          e.event_name,
                          COUNT(r.registration_id) AS registration_count
                      FROM 
                          Event e
                      LEFT JOIN 
                          Registrations r ON e.event_id = r.event_id
                      GROUP BY 
                          e.event_name';

              $event_count = execute($sql)->fetchAll();

              $sql = 'SELECT 
                          MIN(e.event_id) as event_id,
                          e.event_name,
                          COUNT(b.booth_id) AS booth_count
                      FROM 
                          Event e
                      LEFT JOIN 
                          Booths b ON e.event_id = b.event_id
                      GROUP BY 
                          e.event_name';
              $temp = execute($sql)->fetchAll();
              $booth_count = [];
              foreach ($temp as $booth) {
                $booth_count[$booth['event_id']] = $booth['booth_count'];
              }

              foreach ($event_count as $c):
              ?>
                <dt class="col-8 col-sm-9"><?= htmlspecialchars($c['event_name']) ?></dt>
                <dd class="col-4 col-sm-3">
                  <?php
                  echo $c['registration_count'];
                  if (array_key_exists($c['event_id'], $booth_count)) {
                    echo "/" . strval($booth_count[$c['event_id']] * MAX_SLOTS);
                  } ?>
                </dd>
              <?php endforeach ?>
            </dl>
            <canvas id="registrationCount" width="600" height="400"></canvas>
          </div>
        </div>
      </div>

      <div class="card mb-4 shadow-sm" x-data="affiliation">
        <div class="card-header bg-secondary d-flex">
          Affilations
        </div>
        <div class="card-body" style="max-height: 500px; overflow-y: scroll;">
          <div class="row mb-3">
            <label for="affiliationFilter" class="col-auto">Filter</label>
            <input id="affiliationFilter" type="text" x-model.debounce.250ms="query" class="col" placeholder="e.g. CSU">
          </div>

          <div class="form-check">
            <input class="form-check-input" type="radio" value="csu" id="csu" name="filter" x-model="selected">
            <label class="form-check-label" for="csu">
              Cagayan State University
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="radio" value="isu" id="isu" name="filter" x-model="selected">
            <label class="form-check-label" for="isu">
              Isabela State University
            </label>
          </div>

          <button class="btn btn-sm btn-secondary mb-3" @click="selected='';query=''">Clear filter</button>

          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Affilation</td>
                  <th>Tuguegarao City</td>
                  <th>Cauayan City</td>
                </tr>
              </thead>

              <tbody>
                <template x-for="affiliation in searchResult" :key="affiliation.affiliation">
                  <tr>
                    <td x-text="affiliation.affiliation"></td>
                    <td x-text="affiliation.tuguegarao_count"></td>
                    <td x-text="affiliation.cauayan_count"></td>
                  </tr>
                </template>
              </tbody>
              <tfoot>
                <tr>
                  <td><strong>Total</strong></td>
                  <td><strong x-text="total.tuguegarao_count"></strong></td>
                  <td><strong x-text="total.cauayan_count"></strong></td>
                </tr>
              </tfoot>
            </table>
          </div>

        </div>
      </div>

      <template x-for="(eventData, eventName) in events" :key="eventName">
        <div class="card mb-4">
          <div class="card-header" x-text="eventName"></div>
          <div class="card-body">
            <template x-for="section in sections" :key="section.title">
              <div class="mb-4">
                <h3 class="mb-3" x-text="section.title"></h3>
                <div class="row">
                  <dl class="row mb-3">
                    <template x-for="(value, key) in eventData[section.dataKey]" :key="key">
                      <div class="d-flex">
                        <dt class="col-7 col-sm-8" x-text="key"></dt>
                        <dd class="col-5 col-sm-4" x-text="value"></dd>
                      </div>
                    </template>
                  </dl>
                  <canvas x-ref="chart" x-init="createChart($el, section.type, section.title, eventData[section.dataKey])"></canvas>
                </div>
              </div>
            </template>
          </div>
        </div>
      </template>


    </div>
  </div>
</body>

</html>
