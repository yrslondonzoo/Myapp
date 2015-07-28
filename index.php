 <!DOCTYPE HTML>
 <head>
	 <title>um, xxcalendar thing</title>
	 <link rel="stylesheet" href="css/master.css" media="screen" title="no title" charset="utf-8">
   <link rel="stylesheet" href="css/leaflet.css" />
   <script src="js/leaflet.js"></script>
   <script src='https://api.tiles.mapbox.com/mapbox.js/v2.2.1/mapbox.js'></script>
   <link href='https://api.tiles.mapbox.com/mapbox.js/v2.2.1/mapbox.css' rel='stylesheet' />
</head>
<body>
<main>
<section id = "sect1">
	<div id = "info">
		<span id="date">1st</span>
		<span id="title">Brad's Great Meetup</span>
		<span id="location">London Zoo</span>
	</div>
	<div id = "weather">
		<div id="weatherinfo">
			weather
		</div>
		<div id="weatherdata">
			<ul>
				<li class="weathertime">12:00   <img src ="images/clouds.png" height="42px" width="42px"></li>
				<li class="weathertime">15:00   <img src="images/Lightning.png" height ="42px" width="42px"</li>
			</ul>
		</div>
	</div>
</section>
<section id = "sect2">
	<div id="maps">
    MAP
    <div id="map">

    </div>
	</div>
	<div id = "share">
		share
	</div>
</section>
</main>
<script>
  var map = L.map('map').setView([51.505, -0.09], 13);
  L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={pk.eyJ1IjoiYmlnYm95MTI3MSIsImEiOiJmZTQyMzc1OGQwNGUxYzcyNjZjODZkN2UwMTk4YjExOCJ9.3-tRVlFaxtt4KRQg0cu_IQ}', {
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
    maxZoom: 18,
    id: 'bigboy1271.d02976aa',
    accessToken: 'pk.eyJ1IjoiYmlnYm95MTI3MSIsImEiOiJmZTQyMzc1OGQwNGUxYzcyNjZjODZkN2UwMTk4YjExOCJ9.3-tRVlFaxtt4KRQg0cu_IQ'
}).addTo(map);
</script>
</body>
