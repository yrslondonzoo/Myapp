<?php

  // default is August
  $month = 8;
  // m parameter overrides the month
  if (isset($_GET["m"]) && is_numeric($_GET["m"])) {
    $month = $_GET["m"];
  }

  // timestamp of the beginning of the month, used in several places below
  $thismonth = strtotime("2015-$month-01");

  // phpinfo(); version 5.1.6 has no date_create or strptime.
  // Each row runs from Monday to Sunday on this calendar.
  // Calculate the effective day of the month on the Monday on or before
  // the first day of the month.
  // That is the first cell drawn.
  // If the first day of the month falls on a... the answer is...
  //   Mon = 1, Tues = 0, Wed = -1, ... Sun = -5
  // strftime('%w') and date('w') returns 0 = Sunday, 6 = Saturday
  // It takes some working out!
  // $day = 1 - (strftime('%w', $thismonth) + 6) % 7;
  $day = 1 - (date('w', $thismonth) + 6) % 7;

  // for ($weekday = 0; $weekday < 7; $weekday++) {
  //   $day = 1 - ($weekday + 6) % 7;
  //   echo "$weekday $day <br>\n";
  // }

  // Calculate the last day of the month, to get the number of rows
  // and to suppress printing beyond the end of the month.
  // Initial effort:
  //  //   $lastday = strftime("%d", strtotime('2015-'.($month+1).'-01') - (24 * 60 * 60));
  // but I discovered an easier way!
  $lastday = date('t', $thismonth);
  $rows = floor(($lastday - $day + 7) / 7);
  // echo $day.' '.$lastday.' '.$rows.' ';

  // for testing, we arbitrarily say there are events on the 2nd, 4th and 21st
  // of every month
  function hasevent($d, $m) {
    return in_array($d, array(2, 4, 21));
  }
?>
<html>
<head>
<meta name="viewport" content="width=device-width" />
<style>
body {font-family:Sans-Serif}
.eventday {background-color:#FEE}
</style>
<title>Calendar test</title>
<link rel="stylesheet" href="css/master.css" media="screen" title="no title" charset="utf-8">
</head>
<body>
<?php
  echo '<p class="calpreamble">'.PHP_EOL;
  if ($month > 1) {
    echo '<a href="'.$_SERVER["PHP_SELF"].'?m='.($month - 1).'">Previous</a>'.PHP_EOL;
  } else {
    echo 'Previous'.PHP_EOL;
  }
  // name of current month
  echo ' '.date('F', $thismonth).' 2015 ';
  if ($month < 12) {
    echo '<a href="'.$_SERVER["PHP_SELF"].'?m='.($month + 1).'">Next</a>'.PHP_EOL;
  } else {
    echo 'Next'.PHP_EOL;
  }
  echo '</p>'.PHP_EOL;

  echo '<table class="calendar" border="1">'.PHP_EOL;

  // Day names Mon, Tue .. Sun as column headers
  echo '<tr class="dayheader">'.PHP_EOL;
  for ($col = 0; $col < 7; $col++) {
    echo '<th>'.date('D', strtotime('2015-08-'.($col + 3))).'</th>'.PHP_EOL;
  }
  echo '</tr>'.PHP_EOL;

  for ($row = 0; $row < $rows; $row++) {
    echo '<tr>'.PHP_EOL;
    for ($col = 0; $col < 7; $col++) {
      if (hasevent($day, $month)) {
        $class = 'eventday';
        $p = '<a href="pullup.php?d='.$day.'">'.$day.'</a>';
      } else {
        $class = '';
        if ($day < 1 || $day > $lastday) {
          // off the start or end of the month
          $p = '';
        } else {
          // plain day
          $p = $day;
        }
      }
      echo '<td class="'.$class.'">'.$p.'</td>'.PHP_EOL;
      $day++;
    }
    echo '</tr>'.PHP_EOL;
  }

  echo '</table>'.PHP_EOL;
?>
</body>
</html>
