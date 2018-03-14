<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Info window with <code>maxWidth</code></title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        width : 500px;
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
    
  </head>
  <body>
    <div id="map"></div>
    <!-- 下面的callback不能少 -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAB33sPj43zCFPfevRtQj-FOaU25c53g2U&callback=initMap"></script>
    <script>

      // This example displays a marker at the center of Australia.
      // When the user clicks the marker, an info window opens.
      // The maximum width of the info window is set to 200 pixels.

      function initMap() {
        var uluru = {lat: -25.363, lng: 131.044};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 5,
          center: uluru
        });

        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h1 id="firstHeading" class="firstHeading">Uluru</h1>'+
            '<div id="bodyContent">'+
            '<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large ' +
            'Heritage Site.</p>'+
            '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">'+
            'https://en.wikipedia.org/w/index.php?title=Uluru</a> '+
            '(last visited June 22, 2009).</p>'+
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString,
          maxWidth: 200
        });

        var marker = new google.maps.Marker({
          position: uluru,
          map: map,
          title: 'Uluru (Ayers Rock)'
        });
        marker.addListener('click', function() {
          infowindow.open(map, marker);
        });




        
        var uluru1 = {lat: -30.363, lng: 138.044};
        var contentString1 = '<div id=""><p>名称：智园</p><p>地ddd址：智园XXXX</p><p>电话：XXXX-XXXX</p></div>';

        var infowindow1 = new google.maps.InfoWindow({
          content: contentString1,
          maxWidth: 200
        });

        var marker1 = new google.maps.Marker({
          position: uluru1,
          map: map,
          title: '智园'
        });
        marker1.addListener('click', function() {
          infowindow1.open(map, marker1);
          alert(456);
        });

        
      }

      function renderMap() {
	        var uluru = {lat: 29.425237, lng: 106.825951};
	        var map = new google.maps.Map(document.getElementById('map'), {
	          zoom: 5,
	          center: uluru
	        });

	        var contentString = '<div id=""><p>名称：重庆市</p><p>地址：中国重庆梁子坡</p><p>电话：XXXX-XXXX</p></div>';

	        var infowindow = new google.maps.InfoWindow({
	          content: contentString,
	          maxWidth: 200
	        });

	        var marker = new google.maps.Marker({
	          position: uluru,
	          map: map,
	          title: 'Uluru (Ayers Rock)'
	        });
	        marker.addListener('click', function() {
	          infowindow.open(map, marker);
	        });




	        
	        var uluru1 = {lat: 28.765647, lng: 115.619251};
	        var contentString1 = '<div id=""><p>名称：南昌</p><p>地址：安义县 中国江西省南昌市</p><p>电话：XXXX-XXXX</p></div>';

	        var infowindow1 = new google.maps.InfoWindow({
	          content: contentString1,
	          maxWidth: 200
	        });

	        var marker1 = new google.maps.Marker({
	          position: uluru1,
	          map: map,
	          title: '智园'
	        });
	        marker1.addListener('click', function() {
	          infowindow1.open(map, marker1);
	          alert(456);
	        });

	        
	      }
//       initMap();
    </script>
    <!-- <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAB33sPj43zCFPfevRtQj-FOaU25c53g2U&callback=initMap">
    </script> -->
    
    <p onclick="renderMap()">点击这里重新渲染地图</p>
  </body>
</html>