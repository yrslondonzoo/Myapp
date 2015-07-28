<?php
// Program to fetch a machine-readable programme listing
// from the BBC and format it human-readable but lightweight

// Number of days offset. 0 means today, 1 means tomorrow etc
$d = 0;
if (isset($_GET['d']) && is_numeric($_GET['d'])) {
  $d = $_GET['d'];
}

// Channel, see list below for possible values
$c = "none";
if (isset($_GET['c']) && preg_match('/^[a-zA-Z0-9]+$/', $_GET['c'])) {
  $c = $_GET['c'];
}

// http://www.bbc.co.uk/programmes/developers

// The channels plus a suitable outlet when needed for the URL
// Used to generate the HTML for the form too,
// though the headings are hard-coded below
$channellist = array(
  "radio2" => "",
  "radio3" => "",
  "radio4" => "fm/",
  "bbcone" => "london/",
  "bbctwo" => "england/",
  "bbcthree" => "",
  "bbcfour" => "",
  "FILMS" => "",
  "none" => "");

// Should check if really valid really...
$b = 'http://www.bbc.co.uk/'.$c.'/programmes/schedules/'.$channellist[$c];
if ($c == 'FILMS') {
  $b = 'http://www.bbc.co.uk/programmes/formats/films/schedules/';
}

// Flip to the next day at about 3am (time zone dependent)
$t = time() + ((($d * 24) - 3) * 60 * 60);

// eg http://www.bbc.co.uk/bbcfour/programmes/schedules/2013/09/30.json
$url = $b . date("Y/m/d", $t) . '.json';

// &t   -> test
// &t=1 -> test
// &t=0 -> not test
$test = 0;
if (isset($_GET['t']) && ($_GET['t'] == '' || $_GET['t'] > 0)) {
  $url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/bbctestpage.txt';
  echo $url;
  $test = 1;
}

if ($c == "none") {
  // Initial load of page
  // let user select the channel instead of defaulting for efficiency
  $page = '';
} else {
  // http://www.ietf.org/rfc/rfc4627.txt
  // JSON text SHALL be encoded in Unicode.  The default encoding is UTF-8.
  $page = file_get_contents($url, false, NULL, -1, 100000);
}
// escape backslashes -- one backslash becomes two
// This is reversed by the JavaScript quoting
$pageescaped = str_replace('\\', '\\\\', $page);
// escape quotes - quote -> backslash quote
// This is reversed by the JavaScript quoting
$pageescaped = str_replace('\'', '\\\'', $pageescaped);
// encode all non-ASCII characters  and ampersand with HTML escapes
// so that the served text is pure ASCII and no encoding need be set
// This is reversed when the pretty-printed text is set as innerHTML
// Also escape lt and gt just in case they are present
if (function_exists('mb_encode_numericentity')) {
  $pageescaped = mb_encode_numericentity($pageescaped,
   array(38,38,0,0xffff,60,60,0,0xffff,62,62,0,0xffff,0x80,0xffff,0,0xffff), 'UTF-8');
} else {
  // Leave double quotes and single quotes unchanged in the JSON
  $pageescaped = htmlspecialchars($pageescaped, ENT_NOQUOTES);
}

// Make it tolerate a leading byte order mark, as it is so hard to make
// a UTF-8 file without one on Windows
$pageescaped = preg_replace('/^&#65279;/', '', $pageescaped);
// On systems without mb_encode_numericentity
$pageescaped = preg_replace('/^﻿/', '', $pageescaped);

// remove all newlines so it can go in a JavaScript string
// not sure if the real data has newlines, but the test file does
$pageescaped = preg_replace('/[\\n\\r]/', '', $pageescaped);
?>
<html>
<head>
<meta name="viewport" content="width=device-width" />
<style>body{font-family:Sans-Serif}.dayselector{text-align:center}</style>
<title><?php echo $url; ?></title>
<script>
//<![CDATA[ http://en.wikipedia.org/wiki/CDATA
function doit() {
var jsonString = '<?php echo $pageescaped; ?>';

// Extract salient items
var thedata = JSON.parse(jsonString);
var outstring = "";
// undefined -> false, object -> true
if (thedata.broadcasts) {
  // film data
  var cwservicetitle = "";
  var mylist = thedata.broadcasts;
  for (var i in mylist) {
    var entry =  mylist[i];
    var london = false;
    var sid = entry.service.id; // also used later to display channel
    // Filter to list only films to be shown in London (BBC1) / England (BBC2)
    if (sid == "bbc_three" || sid == "bbc_four") {
      // these two channels have no outlet variations
      london = true;
    } else {
      for (var j in entry.service.outlets) {
        var id = entry.service.outlets[j].id;
        if (id == "bbc_one_london" || id == "bbc_two_england") { london = true; }
      }
    }
    if (london) {
      var dt = entry.programme.display_titles;
      // The conversion to Date and back is to add the day of the week
      outstring +=
          "<p><table><tr><td>Start:</td><td>" + new Date(entry.start).toString() + " [" + sid + "]</td></tr>\n"
        + "<tr><td>End:</td><td>" + new Date(entry.end).toString() + "</td></tr></table>\n"
        + "<b>" + dt.title + "</b> -- " + dt.subtitle + "\n"
        + entry.programme.short_synopsis + "</p>\n";
    }
  } // for
} // if
if (thedata.schedule) {
  // channel schedule
  var cwservicetitle = "-- " + thedata.schedule.service.title;
  var mylist = thedata.schedule.day.broadcasts;
  for (var i in mylist) {
    var entry =  mylist[i];
    var dt = entry.programme.display_titles;
    outstring +=
        "<p><table><tr><td>Start:</td><td>" + new Date(entry.start).toString() + "</td></tr>\n"
      + "<tr><td>End:</td><td>" + new Date(entry.end).toString() + "</td></tr></table>\n"
      + "<b>" + dt.title + "</b> -- <i>" + dt.subtitle + "</i>.\n"
      + entry.programme.short_synopsis + "</p>\n";
  } // for
} // if
document.getElementById("cwservicetitle").innerHTML = cwservicetitle;
document.getElementById("cwlisting").innerHTML = outstring;
// Add the raw data at the end in case I need more detail
document.getElementById("cwjson").innerHTML = JSON.stringify(thedata,null,2)
  .replace(/\n/g, '<br/>\n').replace(/  /g, ' &#160;');
}
//]]>
</script>
</head>
<body onload="doit()">

<form action="<?php echo $_SERVER["PHP_SELF"]; ?>">
<table border="1" class="dayselector">
<tr><td><label for="radradio2">Radio 2</label></td><td><label for="radradio3">Radio 3</label></td><td><label for="radradio4">Radio 4</label></td></tr>
<tr>
<?php
foreach (array_keys($channellist) as $value) {
    $sel = ($c == $value ? ' checked="checked"' : '');
    echo '<td><input type="radio" name="c" id="rad'.$value.'" value="'.$value.'"'.$sel.'/></td>'."\n";
    if ($value == "radio4") {
?>
</tr>
<tr><td><label for="radbbcone">BBC1</label></td><td><label for="radbbctwo">BBC2</label></td><td><label for="radbbcthree">BBC3</label></td><td><label for="radbbcfour">BBC4</label></td><td><label for="radFILMS">Films</label></td><td><label for="radnone">none</label></td></tr>
<tr>
<?php
    }
}
?>
</tr>
<tr><td colspan="9" bgcolor="FEF0DB"/></tr>
<tr>
<?php
for ($i = 0; $i <= 7; $i++) {
    echo '<td><label for="radd'.$i.'">'.date('D',time()+($i*24-3)*60*60).'</label></td>';
}
?>
</tr>
<tr>
<?php
for ($i = 0; $i <= 7; $i++) {
    $sel = ($d == $i ? ' checked="checked"' : '');
    echo '<td><input type="radio" name="d" id="radd'.$i.'" value="'.$i.'"'.$sel.'/></td>'."\n";
}
?>
</tr>
</table>
<input type="hidden" name="t" value="<?php echo $test; ?>"/>
<input type="Submit" value="Go"/>
</form>

<p><b><?php echo $c; ?></b> <span id="cwservicetitle"></span></p>

<div id="cwlisting">Output here</div>
<span id="cwjson" style="background-color:#dddddd; font-family:monospace">JSON here</span>

</body>
</html>
