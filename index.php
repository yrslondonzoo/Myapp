 <!DOCTYPE HTML>
 <head>
	 <title>um, xxcalendar thing</title>
	 <link rel="stylesheet" href="css/master.css" media="screen" title="no title" charset="utf-8">
   <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.css" />
   <script src="http://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.js"></script>
   <script src='https://api.tiles.mapbox.com/mapbox.js/v2.2.1/mapbox.js'></script>
   <link href='https://api.tiles.mapbox.com/mapbox.js/v2.2.1/mapbox.css' rel='stylesheet' />
   <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
   <script src='https://api.mapbox.com/mapbox.js/v2.2.1/mapbox.js'></script>
   <link href='https://api.mapbox.com/mapbox.js/v2.2.1/mapbox.css' rel='stylesheet' />
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
       $events = array(2 => array('Brad\'s meetup', 'Brad\'s secret den', '09:00', '15:00', '51.5', '-0.1'),
         4 => array('Festival of Code 2015', 'Birmingham', '12:00', '18:00','55.9410655','-3.2053836' ),
         21 => array('Nefarious Russian Hacker Meetup', 'Chernobyl', '15:00', '21:00','51.2752985','30.2218855'));
       if (isset($events[$d])) {
         return $events[$d];
       }
       return FALSE;
     }
   ?>
</head>
<body>
  <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.4";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<main>
  <div id="calenheader">
    <h1>Your Calendar!</h1>
  </div>
  <div id='calendardiv'>
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
        $evarr= hasevent($day, $month);
        if ($evarr !== FALSE) {
          $class = 'eventday';
          $p = '<a href="pullup.php?d='.$day.
          '&evname='.urlencode($evarr[0]).
          '&evloc='.urlencode($evarr[1]).
          '&evstart='.urlencode($evarr[2]).
          '&evend='.urlencode($evarr[3]).
          '&evlat='.urlencode($evarr[4]).
          '&evlong='.urlencode($evarr[5]).
          '">'.$day.'</a>';
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
  </div>
</main>

<!--<script>
  var map = L.map('map').setView([51.505, -0.09], 13);
  L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={pk.eyJ1IjoiYmlnYm95MTI3MSIsImEiOiJmZTQyMzc1OGQwNGUxYzcyNjZjODZkN2UwMTk4YjExOCJ9.3-tRVlFaxtt4KRQg0cu_IQ}', {
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
    maxZoom: 18,
    id: 'bigboy1271.d02976aa',
    accessToken: 'pk.eyJ1IjoiYmlnYm95MTI3MSIsImEiOiJmZTQyMzc1OGQwNGUxYzcyNjZjODZkN2UwMTk4YjExOCJ9.3-tRVlFaxtt4KRQg0cu_IQ'
}).addTo(map);
</script>-->
</body>