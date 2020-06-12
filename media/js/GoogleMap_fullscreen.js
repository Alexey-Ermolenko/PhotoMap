/*

*/

	var geocoder;
	var geoCode_Markers = [];
	var geoCode_Marker;
	viewMap = 1;
	var map;
	var markers = []; //  маркер массив
	var seek_markers = []; //  маркер массив
	var markerCircles = [];
	var MarkerCircle;

	var PhotoMarker;
	var arrMarkers = [];
//	var infowindow;
	var arrInfoWindows = [];	
	
	var res_arr;
	
	var arrCount = 0;
	
	search_radius = 30;


	function CenterControl(controlDiv, map) {

	  // Set CSS for the control border.
	  var controlUI = document.createElement('div');
	  controlUI.style.backgroundColor = '#fff';
	  controlUI.style.border = '2px solid #fff';
	  controlUI.style.borderRadius = '3px';
	  controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
	  controlUI.style.cursor = 'pointer';
	  controlUI.style.marginBottom = '22px';
	  controlUI.style.textAlign = 'center';
	  controlUI.title = 'Click to search';
	  controlDiv.appendChild(controlUI);

	  // Set CSS for the control interior.
	  var controlText = document.createElement('div');
	  controlText.style.color = 'rgb(25,25,25)';
	  controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
	  controlText.style.fontSize = '16px';
	  controlText.innerHTML = '<button type="button" class="btn btn-info"><span class="glyphicon glyphicon-search"></span></button><button type="button" class="btn btn-info"><span class="glyphicon glyphicon-chevron-down"></span></button><div id="ext_menu"><hr></div>';
	  
		//<div class="checkbox"><label><input type="checkbox"> Check me out</label></div>
	  
	  
	  controlUI.appendChild(controlText);

	  // Setup the click event listeners: simply set the map to Chicago.
	  controlUI.addEventListener('click', function() {
		searchPhoto();
	  });

	}



	function initialize_map() {
		var grey_style = [{"elementType":"geometry","stylers":[{"hue":"#ff4400"},{"saturation":-68},{"lightness":-4},{"gamma":0.72}]},{"featureType":"road","elementType":"labels.icon"},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"hue":"#0077ff"},{"gamma":3.1}]},{"featureType":"water","stylers":[{"hue":"#00ccff"},{"gamma":0.44},{"saturation":-33}]},{"featureType":"poi.park","stylers":[{"hue":"#44ff00"},{"saturation":-23}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"hue":"#007fff"},{"gamma":0.77},{"saturation":65},{"lightness":99}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"gamma":0.11},{"weight":5.6},{"saturation":99},{"hue":"#0091ff"},{"lightness":-86}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"lightness":-48},{"hue":"#ff5e00"},{"gamma":1.2},{"saturation":-23}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"saturation":-64},{"hue":"#ff9100"},{"lightness":16},{"gamma":0.47},{"weight":2.7}]}];
		var san_andreas_style = [{"featureType":"road","elementType":"geometry.fill","stylers":[{"lightness":-100}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"lightness":-100},{"visibility":"off"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"lightness":100}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"visibility":"on"},{"saturation":100},{"hue":"#006eff"},{"lightness":-19}]},{"featureType":"landscape","elementType":"geometry.fill","stylers":[{"saturation":-100},{"lightness":-16}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"hue":"#2bff00"},{"lightness":-39},{"saturation":8}]},{"featureType":"poi.attraction","elementType":"geometry.fill","stylers":[{"lightness":100},{"saturation":-100}]},{"featureType":"poi.business","elementType":"geometry.fill","stylers":[{"saturation":-100},{"lightness":100}]},{"featureType":"poi.government","elementType":"geometry.fill","stylers":[{"lightness":100},{"saturation":-100}]},{"featureType":"poi.medical","elementType":"geometry.fill","stylers":[{"lightness":100},{"saturation":-100}]},{"featureType":"poi.place_of_worship","elementType":"geometry.fill","stylers":[{"lightness":100},{"saturation":-100}]},{"featureType":"poi.school","elementType":"geometry.fill","stylers":[{"saturation":-100},{"lightness":100}]},{"featureType":"poi.sports_complex","elementType":"geometry.fill","stylers":[{"saturation":-100},{"lightness":100}]}];
		var night_vision_style = [{"featureType":"all","elementType":"all","stylers":[{"invert_lightness":true},{"saturation":10},{"lightness":30},{"gamma":0.5},{"hue":"#435158"}]},{"featureType":"administrative.locality","elementType":"labels.icon","stylers":[{"visibility":"on"}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#262626"}]},{"featureType":"poi.attraction","elementType":"labels.text.fill","stylers":[{"lightness":"63"}]},{"featureType":"poi.attraction","elementType":"labels.icon","stylers":[{"visibility":"simplified"},{"lightness":"26"},{"hue":"#0045ff"}]},{"featureType":"poi.business","elementType":"labels.text.fill","stylers":[{"lightness":"100"}]},{"featureType":"poi.place_of_worship","elementType":"labels.text.fill","stylers":[{"lightness":"-8"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#2d7399"},{"lightness":"43"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.highway","elementType":"labels.icon","stylers":[{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#2d7399"},{"lightness":"-4"}]},{"featureType":"road.arterial","elementType":"labels.text","stylers":[{"lightness":"0"},{"color":"#ffffff"},{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"color":"#69707d"},{"lightness":"0"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"lightness":"66"}]},{"featureType":"transit.line","elementType":"geometry.fill","stylers":[{"lightness":"22"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#000000"}]}];
		var grey_style = new google.maps.StyledMapType(grey_style, {name: "Gray Map"});
		var san_andreas_style = new google.maps.StyledMapType(san_andreas_style, {name: "San Andreas Map"});
		var night_vision_style = new google.maps.StyledMapType(night_vision_style, {name: "Night vision Map"});
		//https://snazzymaps.com/style/94/san-andreas
		//https://snazzymaps.com/style/62/night-vision
		var mapOptions = {
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			//center: {lat: 55.000, lng: 82.840},
			zoom: 16,
			scaleControl: true,
			mapTypeControl: true,
			mapTypeControlOptions: {
			  style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
			  mapTypeIds: [google.maps.MapTypeId.ROADMAP,google.maps.MapTypeId.TERRAIN,google.maps.MapTypeId.SATELLITE, 'grey_style', 'san_andreas_style', 'night_vision_style', google.maps.MapTypeId.HYBRID]
			}
		};
		//Определение геокодера
		geocoder = new google.maps.Geocoder();
		map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

		map.mapTypes.set('san_andreas_style', san_andreas_style);
		map.mapTypes.set('night_vision_style', night_vision_style);
		map.mapTypes.set('grey_style', grey_style);
		
		//установка стиля карты
		//	map.setMapTypeId('san_andreas_style');		map.setMapTypeId('grey_style');	map.setMapTypeId('night_vision_style');
		var time = new Date();
		if ((time.getHours() > 18) || (time.getHours() < 7) ){
			map.setMapTypeId('night_vision_style');
		}
		
	
		getUserLoc();

		/*
		if (!!window.EventSource) {
			// После того, как инициализирована карта, вызываем нашу обертку, которая будет принимать данные с сервера
			eventSource();
		} else {
			alert('В этом браузере нет поддержки EventSource.');
		}
		*/
		
		function load_coords(event) {
			if (seek_location == false)	{
				//чистка карты
				clearMap();
				//маркер
				var Marker = new google.maps.Marker({
					position: event.latLng,
					map: map,
				//	icon: 'http://maps.google.com/mapfiles/ms/micons/green-dot.png',
				});
				//окружность
				var MarkerCircle = new google.maps.Circle({
					strokeColor: '#FF0000',
					strokeWeight: 2,
					fillColor: '#FF0000',
					map: map,
					center: event.latLng,
					radius: parseInt(search_radius)
				});
				markers.push(Marker);
				markerCircles.push(MarkerCircle);
				bounds = MarkerCircle.getBounds();
				//console.log("bounds = " + bounds);
				//координаты для запроса
				var myLatLng = event.latLng;
				latitude = myLatLng.lat();
				longitude = myLatLng.lng();
				//console.log("latitude : " + latitude + " longitude : " + longitude);
				google.maps.event.addListener(MarkerCircle, 'click', load_coords);
			} else {
				//console.log('load_coords = '+ seek_location);
			}	
		}	
		google.maps.event.addDomListener(map, 'click', load_coords);
		
		// Create the DIV to hold the control and call the CenterControl() constructor
		// passing in this DIV.
		var centerControlDiv = document.createElement('div');
		var centerControl = new CenterControl(centerControlDiv, map);
		centerControlDiv.index = 1;
		map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);	
	}
	google.maps.event.addDomListener(window, 'load', initialize_map);
	
	
	function watchPosition() {
		//console.info('watchPosition');
		var watchID = null;
		onDeviceReady();
	}

	function onDeviceReady() {
        // Throw an error if no update is received every 30 seconds
        var options = { timeout: 500, enableHighAccuracy: true, maximumAge: 1000};
        watchID = navigator.geolocation.watchPosition(onSuccess, onError, options);
		//console.info('onDeviceReady \n\n watchID= '+watchID);
    }
	
    function onSuccess(position) {
		latitude=position.coords.latitude;
		longitude=position.coords.longitude;
        MyPosition = new google.maps.LatLng(latitude, longitude);
		map.setCenter(MyPosition);
		initMarker(MyPosition);
		//console.log("onSuccess MyPosition = " + MyPosition);
		//$('#result').html('');
		//$('#result').append(MyPosition+"</br>");
		//запросы на отслеживание  местоположение
		searchPhoto();
    }	
	function onError(error) {    }
	
	function stopSeekPosition(){navigator.geolocation.clearWatch(watchID);}

	function searchPhoto() {
		if (seek_location)	{
			//отслеживание включено
			//в количестве 100 шт.
			//за последние 5 дней
			var now = new Date();
			var month = now.getMonth();
			month=month+1;
			var day = now.getDate()-5;
			var now_formated_date = now.getDate() + "." + month + "." + now.getFullYear() + " " + now.getHours() + ":" + now.getMinutes()+ ":" + now.getSeconds();
			var end_time = now_formated_date;
			var start_time = day + "." + month + "." + now.getFullYear() + " " + now.getHours() + ":" + now.getMinutes()+ ":" + now.getSeconds();
			var count = 100;
		} else {
			//отслеживание выключено
			var d = new Date();
			var month = d.getMonth();
			month=month+1;
			var formated_date = d.getDate() + "." + month + "." + d.getFullYear() + " " + d.getHours() + ":" + d.getMinutes()+ ":" + d.getSeconds();

			var end_time = ($("#end_time").val() != '') ? $("#end_time").val() : formated_date;
			var start_time = ($("#start_time").val() != '') ? $("#start_time").val() : '00.00.0000 00:00';
			
			var count = 200; //кол-во результатов выдачи
		}
		var radius = Number($("#search_radius").val());
		/*
			радиус поиска в метрах. 
			(работает очень приближенно, поэтому реальное расстояние до цели может отличаться от заданного). 
			Может принимать значения: 10, 100, 800, 6000, 50000 
			положительное число, по умолчанию 5000
		*/
		console.info('searchPhoto');
		console.info("end_time = " + end_time + " start_time = "+ start_time + " search_radius : " + radius + " latitude = " + latitude + " longitude = " + longitude+ " count = " + count);
		$.ajax({
			crossdomain: true,
			cache: false,
			type: "POST",
			data: "start_time="+start_time+"&end_time="+end_time+"&radius="+radius+"&bounds="+bounds+"&latitude="+latitude+"&longitude="+longitude+"&count="+count,
			url: "vk_json_res.php",
			success: function(data){
				viewHeadData(data);
				outputData(data);
				scrollUp();
				

			}
		});
	}

	function clearMap() {
		console.log('clearMap');	
		if (markers) {
			for (var i = 0; i < markers.length; i++) {
				markers[i].setMap(null);
			}
		}
		if (markerCircles) {
			for (var i = 0; i < markerCircles.length; i++) {
				markerCircles[i].setMap(null);
			}
		}

		deleteMarkers();
		/*
		if (geoCode_Markers) {
			console.log("geoCode_Markers " + geoCode_Markers + " geoCode_Markers.length " + geoCode_Markers.length);
			for (var i = 0; i < geoCode_Markers.length; i++) {
				geoCode_Markers[i].setMap(null);
			}
		}
		*/
	}

	
	function deleteMarkers() {
		for (var i = 0; i < seek_markers.length; i++) {
			seek_markers[i].setMap(null);
		}
		seek_markers = [];
	}
	function initMarker(latLng) {
		//чистка карты
		clearMap();
		if (seek_marker){
			seek_marker.setMap(null);
		}
		var seek_marker = new google.maps.Marker({
			position: latLng,
			map: map,
			//icon: 'http://maps.google.com/mapfiles/ms/micons/green-dot.png',
			//icon: 'images/map-marker.png',
		});

		//окружность
		var MarkerCircle = new google.maps.Circle({
			strokeColor: '#000000',
			strokeWeight: 1,
			fillColor: '#FF0000',
			map: map,
			center: latLng,
			radius: parseInt(search_radius)
		});
		markerCircles.push(MarkerCircle);
		bounds = MarkerCircle.getBounds();
		//console.log("bounds = " + bounds);
		
		seek_markers.push(seek_marker);
		seek_marker.setMap(map);
	}
// Создаем функцию обертку, чтобы позже ее вызвать
function eventSource() {
	console.log('eventSource');
	var event = new EventSource("location.php");
		// Начинаем слушать события сервера
		//event.onmessage = function (message) {
			// Пользовательские данные находятся в поле data.
			
			//console.info("onmessage  " + message.data);
			/*
			var latLng = JSON.parse(message.data);
			latLng.lat = parseFloat(latLng.lat);
			latLng.lng = parseFloat(latLng.lng);
			// Передаем долготу/широту методу, который создает метки
			MyPosition = new google.maps.LatLng(latLng.lat,  latLng.lng);
			console.info('eventSource MyPosition='+MyPosition);
			initMarker(latLng);
			*/
		//};
	event.addEventListener("ping", function(e) {	
		var obj = JSON.parse(e.data);
		console.info("ping at " + obj.time);
	}, false);
}
	

//Действие при нажатии на кнопку выбора качества
$(document).ready(function(){
	
	seek_location = false;
	$('#search_radius').change(function(){
		search_radius = $(this).val();
	});
	///////////////////////////////
	$("#seek_location_ok").change(function(){
        if( $(this).is(":checked") ){
			seek_location = true;
			console.log('seek_location_ok');
			
			watchPosition();
			//$('.speed_item').click()
        }
    });
	$("#seek_location_off").change(function(){
        if( $(this).is(":checked") ){
			seek_location = false;
			console.log('seek_location_off');
			
			stopSeekPosition();
        }
    });
	///////////////////////////////	
	


});

function getUserLoc(){
	var MyPosition;
	if (navigator.geolocation) {
		var watchOptions = {enableHighAccuracy: true, maximumAge: 10000000};
		navigator.geolocation.getCurrentPosition(onNewPosition, onPositionError, watchOptions);
		
	} else {
		$.ajax({
			type: "POST",
			url: "temperature.php", 
			success: function(data){
				arr = JSON.parse(data);
				res = {'lat': arr.coords.lat, 'lon': arr.coords.lon};
				MyPosition = new google.maps.LatLng(arr.coords.lat, arr.coords.lon);
				console.log("MyPosition = " + MyPosition);
				map.setCenter(MyPosition);
			},error: function(){
				alert("error");
			}
		});	
	}
	
	function onNewPosition(position) {
		MyPosition = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		var latitude = position.coords.latitude;
		var longitude = position.coords.longitude;	
		console.log("onNewPosition MyPosition = " + MyPosition);
		map.setCenter(MyPosition);
	}
	
	function onPositionError() {
		$.ajax({
			type: "POST",
			url: "temperature.php",
			success: function(data){
				arr = JSON.parse(data);	
				var res = {'lat': arr.coords.lat, 'lon': arr.coords.lon};	
				MyPosition = new google.maps.LatLng(arr.coords.lat, arr.coords.lon);	
				console.log("onPositionError MyPosition = " + MyPosition);
				map.setCenter(MyPosition);		
			},
			error: function(){
				alert("error");
			}
		});
	}
}


function parseData(data) {
	return array;
}

function viewHeadData(data){
	var json_obj = $.parseJSON(data);
}

function find(array, value) {
    if (array.indexOf) { // если метод существует
		return array.indexOf(value);
    }
    for (var i = 0; i < array.length; i++) {
		if (array[i] === value) return array[i];
    }
	return -1;
}

function searchIntersection(res_arr, json_obj){
	/*
		Ф-ция возвращет коллекцию объектов которые требуется оставить 
		при условии что новые найденные объекты идентичны среди множества 
		старых найденных объектов по атрибуту 'photo_id'
		
		//res_arr массив предыдущий 
		//json_obj массив новый 
	*/
	var res_arr_id = _.pluck(res_arr, 'photo_id');
	var json_obj_arr_id = _.pluck(json_obj, 'photo_id');

	var intersection_arr = new Object();	
	var intersection = _.intersection(res_arr_id, json_obj_arr_id);	//массив свойств объектов которые необходимо оставить в выдаче резултатов
	return intersection;
}

function searchDifference(res_arr, json_obj){
	var res_arr_id = _.pluck(res_arr, 'photo_id');
	var json_obj_arr_id = _.pluck(json_obj, 'photo_id');

	var difference_arr = new Object();	
	var difference = _.difference(res_arr_id, json_obj_arr_id); //массив свойств объектов которые необходимо удалить в выдаче резултатов
	return difference;
}

function searchAdd_arr(res_arr, json_obj){
	var res_arr_id = _.pluck(res_arr, 'photo_id');
	var json_obj_arr_id = _.pluck(json_obj, 'photo_id');

	var new_add_arr = new Object();	
	var new_add_arr = _.difference(json_obj_arr_id, res_arr_id); 
	return new_add_arr;
}

function outputData(data){
	var res_arr_object = new Object();
	var json_obj_object = new Object();

	var userid = [];
	var json_obj = $.parseJSON(data);

	if (!res_arr){
		var output = '<div id="headData" class="alert alert-info"><h3>Найдено <span class="label label-success" id="resCount">' + arrCount +'</span></h1></div>';
	} else {
		var output = '';
	}
	
	//res_arr массив предыдущий 

	var intersection = searchIntersection(res_arr, json_obj);
	var difference = searchDifference(res_arr, json_obj);
	var new_add_arr = searchAdd_arr(res_arr, json_obj);
	var total_arr = intersection.concat(new_add_arr);

	
	for (var i in json_obj)  {
		if (_.contains(intersection, json_obj[i].photo_id)) {

		//	console.info(i);
		//	console.info('json_obj=');
		//	console.info(json_obj[i]);
		//	console.info('photo_id=');
		//	console.info(json_obj[i].photo_id);
			continue;
		} else {
			//console.info('json_obj[i].photo_id=');
			//console.info(json_obj[i].photo_id);
			/////////////////////////////////////
			var big_photo =  (json_obj[i].photo_src.src_big != null) ? json_obj[i].photo_src.src_big : json_obj[i].photo_src.src;
			var desc = (json_obj[i].photo_desc == "") ? "" : "<div id='desc'>" + json_obj[i].photo_desc + "</div>";
			userid[i] = json_obj[i].user_id.toString();
	
			var user = (userid[i].charAt(0) == '-') ? 'public'+userid[i].slice(1) : 'id'+userid[i];
		
			output+="<div class='block' data-photo_id='"+json_obj[i].photo_id+"'>";
				output+="<a target=\"_blank\" href="+big_photo+">"+"<img class='imgPhoto' src="+json_obj[i].photo_src.src_small+">"+"</a>";
				output+="<div>";
					output+="<br>" + json_obj[i].numb;
					output+="<br>" + "<a target=\"_blank\" href='" + 'https://vk.com/' + user + "'>"+"Профиль"+"</a>";
			
					output+="<br>" + "lat:" + json_obj[i].photo_coords.lat;
					output+="<br>" + "long:" + json_obj[i].photo_coords.long;
					output+="<br>" + "Опубликовано: " + json_obj[i].photo_create_date;
					output+="<br>" + desc;

				output+="</div>";
			output+="</div>";
			//output+="<br>";

			//////////////////////markers
			outputMarkers(res_arr, json_obj, json_obj[i], user, arrMarkers, arrInfoWindows, i);
			//////////////////////markers


			/////////////////////////////////////
		}

	}//end for (var i in json_obj)	

	res_arr=null;
	res_arr=json_obj;

	if (arrMarkers) {
		for (var i = 0; i < arrMarkers.length; i++) {					
			var res = find(difference, Number(arrMarkers[i].markerID));
			if (res != -1){	
				//console.log(Number(arrMarkers[i].markerID)+i+"res: " + res);	
				arrMarkers[i].setMap(null);	
				arrInfoWindows[Number(arrMarkers[i].markerID)].setMap(null);
				//удаление <div> по data-photo_id если равен Number(arrMarkers[i].markerID)
				$('[data-photo_id="'+Number(arrMarkers[i].markerID)+'"]').remove();
				//console.log('block = '+$block.data('photo_id'));
				//style.css .block{marginBottom: 5px;} 205стр.
			}
		}
	}
	$('#result').append(output);
	
	arrCount = document.getElementsByClassName('block').length;
	arrCount=Number(arrCount)-2;
	console.info("arrCount="+arrCount);	
	$('#resCount').text(arrCount);
}

function outputMarkers(res_arr, json_obj, item, user, Markers, infoWinArr, i){
	// res_arr массив предыдущий
	// json_obj тек массив	
	// item тек элемент
	// user тек поле(профиль) элемета 
		// Markers 		массив маркеров определенных при поисковом запросе 
		// infoWinArr 	массив info-окон определенных при поисковом запросе 
	// i номер элемента массива найденных результатов
	
	//console.info('////////////////////////////////////////');
	//console.info('////////////////////////////////////////');
		var lat = item.photo_coords.lat;
		var lng = item.photo_coords.long;
		var image = new google.maps.MarkerImage(item.photo_src.src_small, new google.maps.Size(30, 30), new google.maps.Point(0,0), new google.maps.Point(0, 30));
		var shadow = new google.maps.MarkerImage('images/shadow.png',      
			new google.maps.Size(40, 40),
			new google.maps.Point(0,0),
			new google.maps.Point(0, 40)
		);
		var PhotoMarker = new google.maps.Marker({
			position: new google.maps.LatLng(lat, lng),
			icon: image,
			shadow: shadow,
			//icon: 'images/photo.png',
			map: map,
			title: "id=  "+ item.photo_id + " " + item.photo_create_date + " - " + lat + " " + lng,
			markerID: String(item.photo_id),
		});
		var html = "<p>" + item.photo_id + "</p><img  width=\"90%\" src=" + item.photo_src.src + "><br>"+"<a target=\"_blank\" href='" + "https://vk.com/" + user + "'>"+"Профиль"+"</a>";
		arrMarkers.push(PhotoMarker);
		var infowindow = new google.maps.InfoWindow({
			content: html,
			infowindowID: item.photo_id
		});
		/*var infowindow = new google.maps.InfoWindow({  
			content: html 
		});*/
		//arrInfoWindows[i].setMap(null);
		arrInfoWindows[item.photo_id] = infowindow;
		google.maps.event.addDomListener(PhotoMarker, 'click', function() {
			arrInfoWindows[this.markerID].open(map, this);
		});
}

