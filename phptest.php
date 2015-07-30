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
      $evname = hasevent($day, $month);
      if ($evname !== FALSE) {
        $class = 'eventday';
        $p = '<a href="pullup.php?d='.$day.'&evname='.urlencode($evname).'">'.$day.'</a>';
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
