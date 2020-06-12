	window.onload = function() {		
		var map_page = window.location.search;
		if (map_page == "?view=map_page") {
			//найти элемент и добавить строку поиска <input class="form-control" id="address" type="text"/>
			$("#nav_search").append("<li><form class=\"navbar-form navbar-left\" role=\"search\" onsubmit=\"return false;\"><div class=\"form-group\"><input id=\"address\" type=\"search\" class=\"form-control\" placeholder=\"Адрес для поиска\"> <button type=\"button\" id=\"search_btn\" class=\"btn btn-success \"><span class=\"glyphicon glyphicon-search\"></span></button></div></form></li>");			
			//$("#nav_search").append("<input class=\"form-control\" id=\"address\" type=\"text\"/>");
			/////////////////////
				document.getElementById('search_btn').addEventListener('click', function() {
					geocodeAddress(geocoder, map);
				});
				//Определяем значение для адреса при геокодировании
					function geocodeAddress(geocoder, resultsMap) {
						var address = document.getElementById('address').value;
						geocoder.geocode({'address': address}, function(results, status) {
							if (status === google.maps.GeocoderStatus.OK) {
								
								resultsMap.setCenter(results[0].geometry.location);
								geoCode_Marker.setPosition(results[0].geometry.location);
								geoCode_Markers.push(geoCode_Marker);
								/*
								var marker = new google.maps.Marker({
									map: resultsMap,
									position: results[0].geometry.location
								});
								*/

							} else {
							  alert('Geocode was not successful for the following reason: ' + status);
							}
						});
					} 
			$(function() {
				$("#address").autocomplete({
				  //Определяем значение для адреса при геокодировании
				  source: function(request, response) {
					geocoder.geocode( {'address': request.term}, function(results, status) {
					  response($.map(results, function(item) {
						return {
						  label:  item.formatted_address,
						  value: item.formatted_address,
							latitude: item.geometry.location.lat(),
							longitude: item.geometry.location.lng()
						}
					  }));
					})
				  },
				  //Выполняется при выборе конкретного адреса
				  select: function(event, ui) {
					//$("#latitude").val(ui.item.latitude);
					//$("#longitude").val(ui.item.longitude);
					var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
					geoCode_Marker.setPosition(location);
					geoCode_Markers.push(geoCode_Marker);
					map.setCenter(location);
				  }
				});
			});	
		}
	};
