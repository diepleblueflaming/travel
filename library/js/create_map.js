// JavaScript Document

	
      function initMap(latitude,lontitude,name) {
        var mapDiv =$('#map');
		var myLatLng={lat: latitude, lng: lontitude}
        var map = new google.maps.Map(mapDiv[0], {
            center: myLatLng,
            zoom: 16
        });
		
		var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: name
        });
	  }