<?php
 require_once("db.php");
 $companies = connectToDB::getCompaniesList();
 $streets = connectToDB::getStreetsList();
 $areas = connectToDB::getAreasList();
?>
<!DOCTYPE html>
<html>
<head>
 <title>Leaflet basic example</title>
 <script src="js/jquery.min.js"></script>
 <link rel="stylesheet" href="css/leaflet.css" />
 <script src="js/leaflet.js"></script>
</head>
<body>
<input type="text" name="search" id="search" /> <input type="button" id="searchBtn" value="Search" />

 <div id="map" style="width: 600px; height: 400px"></div>
 <div id="searchresult"></div>

 <script>

  var map = L.map('map').setView([51.505, -0.09], 13);

  L.tileLayer( 'https://api.mapbox.com/styles/v1/mapbox/streets-v10/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWVnYTYzODIiLCJhIjoiY2ozbXpsZHgxMDAzNjJxbndweDQ4am5mZyJ9.uHEjtQhnIuva7f6pAfrdTw', {
   maxZoom: 18,
   attribution: 'Map data &copy; <a href="http://openstreetmap.org/"> OpenStreetMap </a> contributors, ' +
    '<a href="http://creativecommons.org/"> CC-BY-SA </a>, ' +
    'Imagery © <a href="http://mapbox.com">Mapbox</a>',
   id: 'examples.map-i875mjb7'
  }).addTo(map);
  
  $( document ).ready(function() {
	$('#searchBtn').click(function() {
	  $.ajax({
		type: "GET",
		url: "ajax.php?keyword="+$("#search").val()
	  }).done(function( data )
	  {
		var jsonData = JSON.parse(data);
		var jsonLength = jsonData.results.length;
		var html = "<ul>";
		for (var i = 0; i < jsonLength; i++) {
		  var result = jsonData.results[i];
		  html += '<li data-lat="' + result.latitude + '" data-lng="' + result.longitude + '" class="searchResultElement">' + result.name + '</li>';
		}
		html += '</ul>';
		$('#searchresult').html(html);  		
		$( 'li.searchResultElement' ).click( function() {
		  var lat = $(this).attr( "data-lat" );
		  var lng = $(this).attr( "data-lng" );
		  map.panTo( [lat,lng] );
		});
	  });
	});
   addCompanies();   
   addStreets();   
   addAreas();   
  });
  
  function addCompanies() {
   for(var i=0; i<companies.length; i++) {
    var marker = L.marker( [companies[i]['latitude'], companies[i]['longitude']]).addTo(map);
    marker.bindPopup( "<b>" + companies[i]['company']+"</b><br>Details:" + companies[i]['details'] + "<br />Telephone: " + companies[i]['telephone']);
   }
  }
  
  function stringToGeoPoints( geo ) {
   var linesPin = geo.split(",");

   var linesLat = new Array();
   var linesLng = new Array();

   for(i=0; i < linesPin.length; i++) {
    if(i % 2) {
     linesLat.push(linesPin[i]);
    }else{
     linesLng.push(linesPin[i]);
    }
   }

   var latLngLine = new Array();

   for(i=0; i<linesLng.length;i++) {
    latLngLine.push( L.latLng( linesLat[i], linesLng[i]));
   }
   
   return latLngLine;
  }
  
  function addAreas() {
   for(var i=0; i < areas.length; i++) {
	   console.log(areas[i]['geolocations']);
    var polygon = L.polygon( stringToGeoPoints(areas[i]['geolocations']), { color: 'blue'}).addTo(map);
    polygon.bindPopup( "<b>" + areas[i]['name']);   
   }
  }
  
  function addStreets() {
   for(var i=0; i < streets.length; i++) {
    var polyline = L.polyline( stringToGeoPoints(streets[i]['geolocations']), { color: 'red'}).addTo(map);
    polyline.bindPopup( "<b>" + streets[i]['name']);   
   }
  }
  
  var companies = JSON.parse( '<?php echo json_encode($companies) ?>' );
  var streets = JSON.parse( '<?php echo json_encode($streets) ?>' );
  var areas = JSON.parse( '<?php echo json_encode($areas) ?>' );
 </script>
</body>
</html>