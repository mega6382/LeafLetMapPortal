<!DOCTYPE html>
<html>
 <head>
  <title>Add a company</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="css/leaflet.css" />
  <script src="js/leaflet.js"></script>
 </head>
 <body>
  <div id="map" style="width: 600px; height: 400px"></div>
  <form action="addcompanydb.php" method="post">
   <h1>Add a new company</h1>
   <table cellpadding="5" cellspacing="0" border="0">
    <tbody>
     <tr align="left" valign="top">
      <td align="left" valign="top">Company name</td>
      <td align="left" valign="top"><input type="text" name="company" /></td>
     </tr>
     <tr align="left" valign="top">
      <td align="left" valign="top">Description</td>
      <td align="left" valign="top"><textarea name="details"></textarea></td>
     </tr>
     <tr align="left" valign="top">
      <td align="left" valign="top">Latitude</td>
      <td align="left" valign="top"><input id="lat" type="text" name="latitude" /></td>
     </tr>
     <tr align="left" valign="top">
      <td align="left" valign="top">Longitude</td>
      <td align="left" valign="top"><input id="lng" type="text" name="longitude" /></td>
     </tr>
     <tr align="left" valign="top">
      <td align="left" valign="top">Telephone</td>
      <td align="left" valign="top"><input type="text" name="telephone" /></td>
    </tr>
	<tr align="left" valign="top">
	  <td align="left" valign="top">Keywords</td>
	  <td align="left" valign="top"><textarea name="keywords"></textarea></td>
	</tr>
    <tr align="left" valign="top">
     <td align="left" valign="top"></td>
     <td align="left" valign="top"><input type="submit" value="Save"></td>
    </tr>
   </tbody>
  </table>
 </form>
 <script>
  var map = L.map('map').setView([51.505, -0.09], 13);

  L.tileLayer( 'https://api.mapbox.com/styles/v1/mapbox/streets-v10/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWVnYTYzODIiLCJhIjoiY2ozbXpsZHgxMDAzNjJxbndweDQ4am5mZyJ9.uHEjtQhnIuva7f6pAfrdTw', {
   maxZoom: 18,
   attribution: 'Map data &copy; <a href="http://openstreetmap.org/"> OpenStreetMap </a> contributors, ' +
    '<a href="http://creativecommons.org/"> CC-BY-SA </a>, ' +
    'Imagery © <a href="http://mapbox.com">Mapbox</a>',
   id: 'examples.map-i875mjb7'
  }).addTo(map);
   
  function putDraggable() {
   /* create a draggable marker in the center of the map */
   draggableMarker = L.marker([ map.getCenter().lat, map.getCenter().lng], {draggable:true, zIndexOffset:900}).addTo(map);
   
   /* collect Lat,Lng values */
   draggableMarker.on('dragend', function(e) {
    $("#lat").val(this.getLatLng().lat);
    $("#lng").val(this.getLatLng().lng);
   });
  }
   
  $( document ).ready(function() {
   putDraggable();
  });
 </script>
 </body>
</html>