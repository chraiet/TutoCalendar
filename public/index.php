<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/calendar.css"/>
    <title></title>
  </head>
  <body>
    <nav class="navbar navbar-dark bg-primary mb-3">
      <a href="/index.php" class="navbar-brand">Mon calendrier</a>
    </nav>

    <?php
    require '../src/Date/Month.php';
    try {
      $month = new App\Date\Month($_GET['month'] ?? null, $_GET['year'] ?? null);
    } catch (\Exception $e) {
      $month = new App\Date\Month();
    }
    $start = $month->getStartingDay()->modify('last monday');
    ?>

    <div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
      <h2><?= $month->toString() ?></h2>
      <div>
        <a href="/index.php?month=<?= $month->previousMonth()->month ?>&year=<?= $month->previousMonth()->year ?>" class="btn btn-primary">&lt;</a>
        <a href="/index.php?month=<?= $month->nextMonth()->month ?>&year=<?= $month->nextMonth()->year ?>" class="btn btn-primary">&gt;</a>
      </div>
    </div>    

    <table class="calendar__table calendar__table--<?= $month->getWeeks() ?>weeks">
      <?php for ($i = 0; $i < $month->getWeeks(); $i++): ?>
        <tr>
          <?php foreach ($month->days as $k => $day): 
            $date = (clone $start)->modify("+" . ($k + $i * 7) . " days");
          ?>
            <td class="<?= $month->withinMonth($date) ? '' : 'calendar__othermonth' ?>">
              <?php if ($i === 0): ?>
                <div class="calendar__weekday"><?= $day ?></div>
              <?php endif; ?>
              <div class="calendar__day"><?= $date->format('d') ?></div>
            </td>
          <?php endforeach; ?>
        </tr>
      <?php endfor; ?>
    </table>
  </body>
</html>