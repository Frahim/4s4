var map,customZoom;
if (typeof cslMapDefaultZoom !== 'undefined' && cslMapDefaultZoom !== null)
{
customZoom = parseInt(cslMapDefaultZoom);
}
function cslinitMap(locations = allLocations) {
  var bounds = new google.maps.LatLngBounds();
  var mapOptions = {
    mapTypeId: cslMaptype, 
    mapTypeControl: false,
  };
  var map = new google.maps.Map(document.getElementById('fullwidh-locations-near-you-map'), mapOptions);
  map.setTilt(45);
  var markers = new Array();
  var infoWindowContent = new Array();
  // var markerclusterer = null;
  locations.forEach(function(location) {   
    let locaddress = (location.address !== "") ? location.address + '<br /> ' : "";
    let loczip = (location.zip !== "") ? location.zip + '<br /> ' : "";
    let locphone = (location.phone !== "") ? location.phone + '<br /> ' : "";
    let locemail = (location.email !== "") ? location.email + '<br /> ' : "";
    let locfax = (location.fax !== "") ? location.fax + '<br /> ' : "";
    let locwebsite = (location.website !== "") ? location.website + '<br /> ' : "";
	let lochours = (location.hours !== "") ? location.hours : "";
    let caticon = location.caticon;
    let directionlink  = "https://www.google.com/maps/dir/?api=1&destination=" + location.lat + ", " + location.lng;
    infoWindowContent.push(['<div class="infoWindow"><h3>' + location.name + '</h3><p>' + 
      locaddress + 
      loczip + 
      locphone + 
      locemail +
      locfax +
      locwebsite +
	  lochours +
      '</p><a class="directionlink" href="' + directionlink + '" target="_blank">' + mapscript_object.get_direction + '<a><a class="streetviewlink directionlink" href="#1" onClick="streetviewfun(' + location.lat + ', ' + location.lng + ');">' + mapscript_object.street_view + '</a></div>']);
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
  jQuery('select#locationslist').on('change', function (e) {
    e.preventDefault();
    var selectedlocation = jQuery(this).find('option:selected').val();
    if(selectedlocation !== "")
    {
      google.maps.event.trigger(markers[jQuery(this).find('option:selected').attr('data-markerid')], 'click');
    }
    else
    {
      cslinitMap();	
    }
    document.getElementById("fullwidh-locations-near-you-map").style.display="block";
    document.getElementById("pano").style.display="none";
  });
  jQuery('select#locationscat').on('change', function (e) {
    e.preventDefault();
    var selectedlocationcat = jQuery(this).find('option:selected').val();
   
    if(selectedlocationcat !== "")
    {
    var getValue = document.getElementById('locationscat').selectedOptions[0].value;
    data_filter = allLocations.filter(function (element) {
      return element.locationcat.indexOf(+selectedlocationcat) > -1;
  });
  if (data_filter.length > 0) {
      createListOfLocations(data_filter);
    }
    }
    else
    {
      cslinitMap();	
    }
    document.getElementById("fullwidh-locations-near-you-map").style.display="block";
    document.getElementById("pano").style.display="none";
  });
 
}
function flattenResults(list, selections) {
  return list.reduce(function (accumulator, current) {
    var res = current.items.filter(function(item){
      return (selections.indexOf(item.item_id) > -1 
              && checkIfAlreadyExist());
      function checkIfAlreadyExist () {
        return accumulator.every(function (k) {
          return k.item_id !== item.item_id;
        });
      }        
    });   
    return accumulator.concat(res);
  }, []);
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
  document.getElementById("fullwidh-locations-near-you-map").style.display="none";
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
      var searchResultsAlertMap = document.getElementById('locations-near-you-map');
      var userLatLng,filteredLocations;
      // Abort if there is no response for the address data
      if (data.status === "ZERO_RESULTS") {
        document.getElementById('csl-fullwidthmap-wrapper').setAttribute("class", 'csl-wrapper no-locations');
        document.getElementById('csl-fullwidthmap-wrapper').innerHTML = '';
        document.getElementById('csl-fullwidthmap-wrapper').innerHTML = '<h2 id="location-search-alert"><div class="nothing_found">' + mapscript_object.no_loc_in_area + '.</div></h2>';
        return;
      }
      userLatLng = new google.maps.LatLng(data.results[0].geometry.location.lat, data.results[0].geometry.location.lng);
      filteredLocations = allLocations.filter(isWithinRadius);
      if (filteredLocations.length > 0) {
      filteredLocations.forEach( function(location) {
        var distance = distanceBetween3(location);
        location.distance = parseFloat(distance).toFixed(2);
      });
      filteredLocations.sort((x, y) => x.distance - y.distance);
        createListOfLocations(filteredLocations);
      } else {
        document.getElementById('csl-wrapper').innerHTML = '';
    }
    function distanceBetween3(location) {
      var locationLatLng = new google.maps.LatLng(location.lat, location.lng);
      var distanceBetween = google.maps.geometry.spherical.computeDistanceBetween(locationLatLng, userLatLng);
      return convertMetersToMiles(distanceBetween);
    }
    function isWithinRadius(location) {
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
  console.log(cslDistanceunits);
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
var map = new google.maps.Map(document.getElementById('fullwidh-locations-near-you-map'), mapOptions);
map.setTilt(45);
const labels = "1234567890";
var i = 0;
var infoWindowsearch = new google.maps.InfoWindow();
locations.forEach( function(location) {
  var positiona = new google.maps.LatLng(locations[i]['lat'], locations[i]['lng']);
  boundsa.extend(positiona);
  var specificLocation = document.createElement('div');
  let locphone = (location.phone !== "") ? location.phone + '<br /> ' : "";
  let locemail = (location.fax !== "") ? location.email + '<br /> ' : "";
  let locfax = (location.fax !== "") ? location.fax + '<br /> ' : "";
  let locwebsite = (location.website !== "") ? location.website + '<br /> ' : "";
  let locaddress = (location.address !== "") ? location.address + '<br /> ' : "";
  let loczip = (location.zip !== "") ? location.zip + '<br /> ' : "";
  if(flag) { 
	  let locdistance = "";
  }else{
	  let locdistance = "<p class='distance'>" + location.distance + " " + unitmsg + "</p>";
  }
  let directionlink  = "https://www.google.com/maps/dir/?api=1&destination=" + locations[i]['lat'] + ", " + locations[i]['lng'];
  let lochours = (location.hours !== "") ? location.hours + ' ' : "";
  let caticon = location.caticon;
  infoWindowContentsearch.push(['<div class="infoWindow"><h3>' + location.name + 
  '</h3><p>' + 
  locaddress + 
  loczip + 
  locphone + 
  locemail +
  locfax + 
  locwebsite +
  lochours +
  '</p><a class="directionlink" href="' + directionlink + '" target="_blank">' + mapscript_object.get_direction + '<a><a class="streetviewlink directionlink" href="#1" onClick="streetviewfun(' + location.lat + ', ' + location.lng + ');">' + mapscript_object.street_view + '</a></div>']);
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
jQuery(document).on('click', ".currentloc", function(){
  initGeolocation();
});
jQuery(document).on('click', "#mapreset", function(){

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
            var filteredLocations = allLocations.filter(isWithinRadius3);
            if (filteredLocations.length > 0) {
            filteredLocations.forEach( function(location) {
              var distance = distanceBetween(location);
              location.distance = parseFloat(distance).toFixed(2);
            });
            filteredLocations.sort((x, y) => x.distance - y.distance);
            var filteredLocations2 = filteredLocations.slice(0, 5);
            createListOfLocations(filteredLocations2);
            }else{
            document.getElementById('csl-fullwidthmap-wrapper').setAttribute("class", 'csl-wrapper no-locations');
            document.getElementById('location-near-you-box').innerHTML = '';
            document.getElementById('fullwidh-locations-near-you-map').innerHTML = '<div class="nothing_found">' + mapscript_object.no_loc_in_area + '.</div>';
            }
          }
          function distanceBetween(location) {
            var locationLatLng = new google.maps.LatLng(location.lat, location.lng);
            var distanceBetween = google.maps.geometry.spherical.computeDistanceBetween(locationLatLng, userLatLng);
            return convertMetersToMiles(distanceBetween);
          }
          function isWithinRadius3(location) {
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