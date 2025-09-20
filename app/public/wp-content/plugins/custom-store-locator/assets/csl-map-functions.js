var map,customZoom;
if (typeof cslMapDefaultZoom !== 'undefined' && cslMapDefaultZoom !== null)
{
customZoom = parseInt(cslMapDefaultZoom);
}
function cslinitMap(locations = allLocations) {
  var mapOptions = {
    mapTypeId: cslMaptype, 
    mapTypeControl: false,
  };
  var map = new google.maps.Map(document.getElementById('locations-near-you-map'), mapOptions);
  map.setTilt(45);
  var bounds = new google.maps.LatLngBounds();
  var markers = new Array();
  var infoWindowContent = new Array();
  locations.forEach(function(location) {   
    let locaddress = (location.address !== "") ? location.address + '<br /> ' : "";
    let loczip = (location.zip !== "") ? location.zip + '<br /> ' : "";
    let locphone = (location.phone !== "") ? location.phone + '<br /> ' : "";
    let locemail = (location.email !== "") ? location.email + '<br /> ' : "";
    let locfax = (location.fax !== "") ? location.fax + '<br /> ' : "";
    let locwebsite = (location.website !== "") ? location.website + '<br /> ' : "";
    let directionlink  = "https://www.google.com/maps/dir/?api=1&destination=" + location.lat + ", " + location.lng;
    infoWindowContent.push(['<div class="infoWindow"><h3>' + location.name + '</h3><p>' + 
      locaddress + 
      loczip + 
      locphone + 
      locemail +
      locfax +
      locwebsite + 
      '</p><a class="directionlink" href="' + directionlink + '" target="_blank">' + mapscript_object.get_direction + '</a><a class="streetviewlink directionlink" href="#1" onClick="streetviewfun(' + location.lat + ', ' + location.lng + ');">' + mapscript_object.street_view + '</a></div>']);
  });	    
  var infoWindow = new google.maps.InfoWindow(), marker, i, position;
  var markersC = [];
  for (i = 0; i < locations.length; i++) {
    var position = new google.maps.LatLng(locations[i]['lat'], locations[i]['lng']);
    bounds.extend(position);
    var caticon = locations[i]['caticon'];
    if(caticon !== "")
    {
      var myicon = {
        position:  new google.maps.LatLng(locations[i]['lat'], locations[i]['lng']),
        url: caticon,
        scaledSize: new google.maps.Size(30, 30),
      };
      marker = new google.maps.Marker({
        position:  new google.maps.LatLng(locations[i]['lat'], locations[i]['lng']),
        icon: myicon,
        map: map,
        title: locations[i]['name'],
        myid: i
      });
    }
    else if(clsIcon !== "")
    {
      var myicon = {
        position:  new google.maps.LatLng(locations[i]['lat'], locations[i]['lng']),
        url: clsIcon,
        scaledSize: new google.maps.Size(30, 30),
      };
      marker = new google.maps.Marker({
        position:  new google.maps.LatLng(locations[i]['lat'], locations[i]['lng']),
        icon: myicon,
        map: map,
        title: locations[i]['name'],
        myid: i
      });
    }
    else
    {
      marker = new google.maps.Marker({
        position:  new google.maps.LatLng(locations[i]['lat'], locations[i]['lng']),
        map: map,
        title: locations[i]['name'],
        myid: i
      });
    }
    // Add an infoWindow to each marker, and create a closure so that the current
    // marker is always associated with the correct click event listener
    google.maps.event.addListener(marker, 'click', (function(marker, i) {
      return function() {
          infoWindow.setContent(infoWindowContent[i][0]);
          infoWindow.setPosition(this.getPosition());
          infoWindow.open(map, marker);
    }
    })(marker, i));
	// Only use the bounds to zoom the map if there is more than 1 location shown
    if(locations.length > 1) {
      map.setOptions({maxZoom: 18});
      map.fitBounds(bounds);
      map.setOptions({maxZoom: customZoom});
    } else {
      var center = new google.maps.LatLng(locations[0].lat, locations[0].lng);
      map.setCenter(center);
      map.setZoom(15);
    }
    // Add marker to markers array
    markers.push(marker);
    markersC.push(marker);
  }
	 // Add a marker clusterer to manage the markers.
	 var options_markerclusterer = {
	  gridSize: 20,
	  maxZoom: 16,
	  zoomOnClick: true,
	  minimumClusterSize: 2,
	  imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
	};
  // the smooth zoom function
  function animateMapZoomTo(map, targetZoom) {
    var currentZoom = arguments[2] || map.getZoom();
    if (currentZoom != targetZoom) {
        google.maps.event.addListenerOnce(map, 'zoom_changed', function (event) {
            animateMapZoomTo(map, targetZoom, currentZoom + (targetZoom > currentZoom ? 1 : -1));
        });
        setTimeout(function(){ map.setZoom(currentZoom) }, 80);
    }
  }
  if(cslDisableClusterMarker != 'yes') {
	var markerCluster = new MarkerClusterer(map, markersC, options_markerclusterer);
  }
  jQuery(document).on('click', '.marker-link', function (e) {
    e.preventDefault();
    google.maps.event.trigger(markers[jQuery(this).attr('data-markerid')], 'click');
    document.getElementById("locations-near-you-map").style.display="block";
    document.getElementById("pano").style.display="none";
  });

// Listen for the bounds_changed event
google.maps.event.addListener(map, 'bounds_changed', function() {
  // Get the new bounds of the map
  var bounds = map.getBounds();
  var boundlocations = [];
  boundlocations.pop();
  
  // Loop through all the markers and check if they are within the bounds of the map
  for (var i = 0; i < markers.length; i++) {
    var marker = markers[i];
    if (bounds.contains(marker.getPosition())) {
      // Marker is visible on the map, show it
    //  marker.setVisible(true);
      boundlocations.push(locations[i]);
      var newchild = i+1;
      jQuery( "#locations-near-you div.csl-list-item:nth-child("+newchild+")" ).show();
    } else {
      // Marker is outside the bounds of the map, hide it
      var newchild = i+1;
      jQuery( "#locations-near-you div.csl-list-item:nth-child("+newchild+")" ).hide();
    }
  }

});
}

function streetviewfun(latitude, longitude) {
  const fenway = { lat: latitude, lng: longitude };
  const map = new google.maps.Map(document.getElementById("pano"), {
    center: fenway,
    zoom: 14,
  });
  document.getElementById("togglemap").addEventListener("click", toggleStreetView);
  document.getElementById("floating-panel-map").style.display="block";
  const panorama = new google.maps.StreetViewPanorama(
    document.getElementById("pano"),
    {
      position: fenway,
      addressControlOptions: {
        position: google.maps.ControlPosition.BOTTOM_CENTER,
      },
      pov: {
        heading: 34,
        pitch: 10,
      },
      linksControl: false,
      panControl: false,
      enableCloseButton: false,
    }
  );
  map.setStreetView(panorama);
  document.getElementById("locations-near-you-map").style.display="none";
  document.getElementById("pano").style.display="block";
}
function toggleStreetView() {
  document.getElementById("locations-near-you-map").style.display="block";
  document.getElementById("pano").style.display="none";
  document.getElementById("floating-panel-map").style.display="none";
}

function filterLocations() {
jQuery(function($){
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  var userAddressparam = urlParams.get('userAddress');
  var searchByparam = urlParams.get('searchBy');
  var maxRadius = urlParams.get('maxRadius');
  var userLatLng;
  var geocoder = new google.maps.Geocoder();
  if(userAddressparam)
  {
   var myuserAddress = userAddressparam;
  }
  else
  {
    var myuserAddress = '';
  }
  if(searchByparam) {
	function getLocationsViaStorenameRequest(address) {
		address = address.toLowerCase();
		return allLocations.filter(storeloc => {
			const locname = storeloc.name.toLowerCase();
			return locname.includes(address);
		});
	}
	var storeFilteredLocations = getLocationsViaStorenameRequest(myuserAddress);
	if(storeFilteredLocations.length > 0) {
		userLatLng = new google.maps.LatLng(storeFilteredLocations[0].lat, storeFilteredLocations[0].lng);
		createListOfLocations(storeFilteredLocations, 1);
	}else{
		var searchResultsAlert = document.getElementById('location-search-alert');
		document.getElementById('csl-wrapper').setAttribute("class", 'no-locations');
		document.getElementById('csl-wrapper').innerHTML = '';
		searchResultsAlert.innerHTML = '<div class="nothing_found">' + mapscript_object.no_loc_in_area + '.</div>';
	}
  }else{
	  var maxRadius = parseInt(maxRadius, 10);
	  if (myuserAddress && maxRadius) {
		userLatLng = getLatLngViaHttpRequest(myuserAddress);
	  } 
  }
  function getLatLngViaHttpRequest(address) {
    // Set up a request to the Geocoding API
    // Supported address format is City, City + State, just a street address, or any combo
    var addressStripped = address.split(' ').join('+');
    var key = cslAPI;
    if(cslcountryrestrict != "")
    {
    var request = 'https://maps.googleapis.com/maps/api/geocode/json?address=' + addressStripped + '&components=country:' + cslcountryrestrict + '&key=' + key;
    }
    else
    {
    var request = 'https://maps.googleapis.com/maps/api/geocode/json?address=' + addressStripped + '&key=' + key;
    }
    // Call the Geocoding API using jQuery GET, passing in the request and a callback function 
    // which takes one argument "data" containing the response
    $.get( request, function( data ) {
      var searchResultsAlert = document.getElementById('location-search-alert');
      var searchResultsAlertMap = document.getElementById('locations-near-you-map');
      // Abort if there is no response for the address data
      
      if (data.status === "ZERO_RESULTS") {
        document.getElementById('csl-wrapper').setAttribute("class", 'csl-wrapper no-locations');
        document.getElementById('csl-wrapper').innerHTML = '';
        searchResultsAlert.innerHTML = '<div class="nothing_found">' + mapscript_object.no_loc_in_area + '.</div>';
        return;
        }
      var userLatLng = new google.maps.LatLng(data.results[0].geometry.location.lat, data.results[0].geometry.location.lng);
      var filteredLocations = allLocations.filter(isWithinRadius3);
      if (filteredLocations.length > 0) {
      filteredLocations.forEach( function(location) {
        var distance = distanceBetween3(location);
        location.distance = parseFloat(distance).toFixed(2);
      });
      filteredLocations.sort((x, y) => x.distance - y.distance);
        createListOfLocations(filteredLocations);
        searchResultsAlert.innerHTML = mapscript_object.loc_near_in + ' ' + address + ':';
      } else {
        console.log("nothing found!");
        console.log(address);
        document.getElementById('csl-wrapper').innerHTML = '';
        searchResultsAlert.innerHTML = mapscript_object.no_locations_in + ' ' + address + '.';
    }
    function distanceBetween3(location) {
      var locationLatLng = new google.maps.LatLng(location.lat, location.lng);
      var distanceBetween = google.maps.geometry.spherical.computeDistanceBetween(locationLatLng, userLatLng);
      return convertMetersToMiles(distanceBetween);
    }
    function isWithinRadius3(location) {
      var locationLatLng = new google.maps.LatLng(location.lat, location.lng);
      var distanceBetween = google.maps.geometry.spherical.computeDistanceBetween(locationLatLng, userLatLng);
      return convertMetersToMiles(distanceBetween) <= maxRadius;
    }
    });  
  }
});
}
function convertMetersToMiles(meters) {
var units = cslDistanceunits;
if(units == "km")
{
  return (meters * 0.001);
}
else
{  
  return (meters * 0.000621371);
}
}
function createListOfLocations(locations, flag=0) {
var boundsa = new google.maps.LatLngBounds();
var mapOptions = {
  mapTypeId: cslMaptype, 
  mapTypeControl: false,
};
var units = cslDistanceunits;
var unitmsg = '';
if(units == "km")
{
  unitmsg = mapscript_object.kms_away;
}
else
{  
  unitmsg = mapscript_object.miles_away;
}
var newmarkers = new Array();
var infoWindowContentsearch = new Array();
var map = new google.maps.Map(document.getElementById('locations-near-you-map'), mapOptions);
map.setTilt(45);
const labels = "1234567890";
var locationsListb = document.getElementsByClassName('location-near-you-box');
// Clear any existing locations from the previous search first
locationsListb[0].innerHTML = '';
var i = 0;
var infoWindowsearch = new google.maps.InfoWindow();
locations.forEach( function(location) {
  var positiona = new google.maps.LatLng(locations[i]['lat'], locations[i]['lng']);
  boundsa.extend(positiona);
  var specificLocation = document.createElement('div');
  let locphone = (location.phone !== "") ? location.phone + '<br /> ' : "";
  let locemail = (location.email !== "") ? location.email + '<br /> ' : "";
  let locfax = (location.fax !== "") ? location.fax + '<br /> ' : "";
  let locwebsite = (location.website !== "") ? location.website + '<br /> ' : "";
  let locaddress = (location.address !== "") ? location.address + '<br /> ' : "";
  let loczip = (location.zip !== "") ? location.zip + '<br /> ' : "";
  if(flag) { 
	  var locdistance = "";
  }else{
	  var locdistance = "<p class='distance'>" + location.distance + " " + unitmsg + "</p>";
  }
  let caticon = location.caticon;
  let directionlink  = "https://www.google.com/maps/dir/?api=1&destination=" + locations[i]['lat'] + ", " + locations[i]['lng'];
  let lochours = (location.hours !== "") ? location.hours : "";
  var locationInfo = '<div data-markerid="'+ i +'" href="#1" class="marker-link"><svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 167.77 225"><path d="M81.36,225a289.94,289.94,0,0,1-59.69-71.68C11.1,135.44,3.33,116.49.72,95.68-5.68,44.52,31.46,5.76,73.05.85A24.37,24.37,0,0,0,76.36,0h15c6.9,1.66,14,2.76,20.67,5.08,37.62,13.12,60.73,52.49,54.83,91.62-4.45,29.46-17.48,55-35.17,78.2-12.07,15.8-26.16,30.06-39.42,44.94A60.82,60.82,0,0,1,86.36,225Zm1.81-17.8c2-1.95,3.36-3,4.42-4.22C98.8,189.82,110.72,177.17,121,163.3c15.33-20.72,27-43.3,30.72-69.44C158.8,44,111,3.34,63,18.77,27.36,30.24,8.54,66.15,17.91,104.61c6.11,25.1,19,46.7,34.66,66.73C62.16,183.63,72.79,195.1,83.17,207.2Z"/><path d="M45.22,83.8A38.52,38.52,0,0,1,83.73,45c21.68,0,38.77,17.29,38.75,39.15A38.78,38.78,0,0,1,83.93,123C62.31,123,45.24,105.75,45.22,83.8Zm15.21,0a23.84,23.84,0,0,0,23.28,23.85c12.62.11,23.55-10.82,23.57-23.59S96.67,60.32,84,60.23,60.49,71,60.43,83.83Z"/></svg><h4>' + location.name + '</h4><p>' + location.address + '<br>' + location.zip + '</br> ' + 
  locphone +
  locemail +
  locfax + 
  locwebsite +
  lochours +
  '</p>' + locdistance  + '<a href="#1" class="viewmaplink"> ' + mapscript_object.view_on_map + '</a></div></div>';
  specificLocation.setAttribute("class", 'csl-list-item');
  specificLocation.innerHTML = locationInfo;
  locationsListb[0].appendChild(specificLocation);
  infoWindowContentsearch.push(['<div class="infoWindow"><h3>' + location.name + 
  '</h3><p>' + locaddress + '' + loczip + 
  locphone + 
  locemail + 
  locfax + 
  locwebsite + lochours + '</p><a class="directionlink" href="' + directionlink + '" target="_blank">' + mapscript_object.get_direction + '<a><a class="streetviewlink directionlink" href="#1" onClick="streetviewfun(' + location.lat + ', ' + location.lng + ');">' + mapscript_object.street_view + '</a></div>']);
  if(caticon !== "")
  {
    var myicon = {
      position:  new google.maps.LatLng(locations[i].lat, locations[i].lng),
      url: caticon,
      scaledSize: new google.maps.Size(30, 30),
    };
    markersearch = new google.maps.Marker({
      position:  new google.maps.LatLng(locations[i].lat, locations[i].lng),
      icon: myicon,
      map: map,
      title: location.name,
      myid: location.myid,
    });
  }
  else if(clsIcon !== "")
  {
  var myicon = {
    position:  new google.maps.LatLng(locations[i].lat, locations[i].lng),
    url: clsIcon,
    scaledSize: new google.maps.Size(30, 30),
  };
  markersearch = new google.maps.Marker({
    position:  new google.maps.LatLng(locations[i].lat, locations[i].lng),
    icon: myicon,
    map: map,
    title: location.name,
    myid: location.myid,
  });
  }
  else
  {
    markersearch = new google.maps.Marker({
      position:  new google.maps.LatLng(locations[i].lat, locations[i].lng),
      map: map,
      title: location.name,
      myid: location.myid,
      label: labels[i % labels.length]
    });
  }
  google.maps.event.addListener(markersearch, 'click', (function(markersearch, i) {
    return function() {
      infoWindowsearch.setContent(infoWindowContentsearch[i][0]);
      infoWindowsearch.setPosition(this.getPosition());
      infoWindowsearch.open(map, markersearch);
    }
  })(markersearch, i));
  if(locations.length > 1) {
    map.fitBounds(boundsa);
  } else {
    var center = new google.maps.LatLng(locations[i].lat, locations[i].lng);
    map.setCenter(center);
    map.setZoom(15);
  }
  newmarkers.push(markersearch);
  i++; });
  jQuery(document).on('click', '.marker-link', function () {
    google.maps.event.trigger(newmarkers[jQuery(this).attr('data-markerid')], 'click');
    document.getElementById("locations-near-you-map").style.display="block";
    document.getElementById("pano").style.display="none";
    document.getElementById("floating-panel-map").style.display="none";
   });
   let imagePathb = "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m";
  var clustermakera = new MarkerClusterer(map, newmarkers, {imagePath: imagePathb});
}
jQuery(function($){
	
	var searchBox = document.querySelector('.autocompleteenabled');
	if(searchBox)
	{
	  if(cslcountryrestrict != "")
	  {
		new google.maps.places.Autocomplete(searchBox, {
		  componentRestrictions: { country: ""+cslcountryrestrict+"" }
		});
	  }
	  else
	  {
		new google.maps.places.Autocomplete(searchBox);
	  }	  
	}
	
	$(document).on('change', '#searchBy', function () {
		const isChecked = jQuery(this).is(':checked');
		const input = document.getElementById('userAddress');
		if (isChecked) {
			input.placeholder = mapscript_object.store_name;
			$('.pac-container').addClass('hide');
		} else {
			input.placeholder = mapscript_object.usrAddPlaceholder;
			$('.pac-container').removeClass('hide');
		}
	});
	
var queryString = window.location.search;
var urlParams = new URLSearchParams(queryString);
var userAddressparam = urlParams.get('userAddress');
if(userAddressparam !== "" && userAddressparam !== null)
{
filterLocations();
}
else
{
if(typeof allLocations !== 'undefined')
{
cslinitMap();	
}
}
jQuery(document).on('click', '.currentloc', function(){
  initGeolocation();
});
jQuery(document).on('click', '#mapreset', function(){

window.location.replace(location.pathname);
});

});
function initGeolocation()
  {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
    } else {
        alert("Sorry, your browser does not support geolocation services.");
    }
  }
function successFunction(position)
{
      var mylongitude = position.coords.longitude;
      var mylatitude = position.coords.latitude;
      var maxRadius = parseInt(maxRadius, 10);
      var key = cslAPI;
      var request = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + mylatitude + ',' + mylongitude + '&key=' + key;
      var userLatLng = new google.maps.LatLng(mylatitude, mylongitude);
          var filteredLocations = allLocations.filter(isWithinRadius);
          document.getElementById('csl-wrapper').classList.remove("no-locations");
          if (filteredLocations.length > 0) {	
            filteredLocations.forEach( function(location) {
              var distance = distanceBetween(location);
              location.distance = parseFloat(distance).toFixed(2);
            });
            filteredLocations.sort((x, y) => x.distance - y.distance);
            createListOfLocations(filteredLocations);
            var searchResultsAlert = document.getElementById('location-search-alert');
            searchResultsAlert.innerHTML = mapscript_object.loc_near_me;
          } else {
            var searchResultsAlert = document.getElementById('location-search-alert');
            searchResultsAlert.innerHTML = mapscript_object.loc_near_me;
            maxRadius = 5000;
            var filteredLocations = allLocations.filter(isWithinRadius);
            if (filteredLocations.length > 0) {
            filteredLocations.forEach( function(location) {
              var distance = distanceBetween(location);
              location.distance = parseFloat(distance).toFixed(2);
            });
            filteredLocations.sort((x, y) => x.distance - y.distance);
            var filteredLocations2 = filteredLocations.slice(0, 5);
            createListOfLocations(filteredLocations2);
            }else{
            document.getElementById('csl-wrapper').setAttribute("class", 'csl-wrapper no-locations');
            document.getElementById('location-near-you-box').innerHTML = '';
            document.getElementById('locations-near-you-map').innerHTML = '<div class="nothing_found">' + mapscript_object.no_loc_in_area + '.</div>';
            }
          }
          function distanceBetween(location) {
            var locationLatLng = new google.maps.LatLng(location.lat, location.lng);
            var distanceBetween = google.maps.geometry.spherical.computeDistanceBetween(locationLatLng, userLatLng);
            return convertMetersToMiles(distanceBetween);
          }
          function isWithinRadius(location) {
            var locationLatLng = new google.maps.LatLng(location.lat, location.lng);
            var distanceBetween = google.maps.geometry.spherical.computeDistanceBetween(locationLatLng, userLatLng);
            return convertMetersToMiles(distanceBetween) <= maxRadius;
          }
}
function errorFunction(err){
  console.warn(`ERROR(${err.code}): ${err.message}`);
}

jQuery(window).on('load', function() {
	jQuery('#searchBy').trigger('change');
});