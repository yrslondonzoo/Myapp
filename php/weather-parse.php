<?php

  $n = 1438441200; // 10d
  $n = 1438462800; // 02n
  $n = 1438527600; // 03d
  $n = 1438462899; // 02n 99 seconds off
  $n = 1438236000; // 10d
  $n = 1438238000; // 10d 2000 seconds off
function parseweather($n){
  $url = 'http://api.openweathermap.org/data/2.5/forecast?lat=52.48&lon=-1.87';
  // For repetitive testing
  $url = 'C:/xampp/htdocs/Myapp/php/forecast.json';

  // http://www.ietf.org/rfc/rfc4627.txt
  // JSON text SHALL be encoded in Unicode.  The default encoding is UTF-8.
  // http://uk.php.net/manual/en/function.file-get-contents.php
  $page = file_get_contents($url, false, NULL, -1, 100000);

  preg_match_all('/"dt":(\d+),.*?"icon":"(\d+[dn])"/', $page, $matches);

  // print_r($matches);
  // var_dump($matches);

  $result = 'none';
  $first = 'none';

  // $matches[0] = all the parts that matched (not used)
  // $matches[1] = all the dt values in order
  // $matches[2] = all the icon values in the same order
  foreach ($matches[1] as $key => $value) {
    // within 1.5 hours
    if (abs($value - $n) < 90 * 60) {
      $result = $matches[2][$key];
    }
    if ($first == 'none') {
      $first = $matches[2][$key];
    }
  }
  if ($result == 'none') { return $first; }
  return $result;
}

$n = date_timestamp_get(date_create('2015-07-29T13:14:33'));
$n = time();
$icon = parseweather($n);
?>
<html>
<head>
<meta name="viewport" content="width=device-width" />
<style>body{font-family:Sans-Serif}.dayselector{text-align:center}</style>
<title>Weather parse test</title>
</head>
<body>
The weather at <?php echo date('r', $n) ?> will be [<?php if ($icon == 'none') {
  echo "No forecast";
}
else {
   echo $icon;
}
?>]!!

</body>
</html>
