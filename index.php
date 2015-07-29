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
  <div>
    <h1 id="calenheader">Your Calendar!</h1>
  </div>
    <div id="calendiv">
      <div id="calenpadl">
        <h2>ERRO</h2>
      </div>
      <div id="calendardiv">
        <h2>GUDBYE</h2>
      </div>
      <div id="calenpadr">
        <h2>JKLOL</h2>
      </div>
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