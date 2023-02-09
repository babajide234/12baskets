// ( function ( $ ) {
//   'use strict';

const createMap = ({ lat, lng }) => {
  return new google.maps.Map(document.getElementById('map'), {
    center: { lat, lng },
    zoom: 15
  });
};

// const createMarker = ({ map, position }) => {
//   return new google.maps.Marker({ map, position });
// };
const createMarkers = ({ map, positions }) => {
  let markers = [];
  if( !Array.isArray(positions) ) positions = [positions]; // convert to array if not (for single marker case)

  positions.forEach(position => { 
    markers.push(new google.maps.Marker({ map, position,})
  );
  });
  return markers;
};

const trackLocation = ({ onSuccess, onError = () => { } }) => {

  console.log("trackLocation");
  if ('geolocation' in navigator === false) {
    return onError(new Error('Geolocation is not supported by your browser.'));
  }
  
  return navigator.geolocation.watchPosition(onSuccess, onError, {
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 0
  });
};


const getPositionErrorMessage = code => {
  switch (code) {
    case 1:
    return 'Permission denied.';
    case 2:
    return 'Position unavailable.';
    case 3:
    return 'Timeout reached.';
  }
}

const updateLocationDB = ({lat, lng}) => {
  
  const url = path+"/ajax.php?pg=updategps";

  let form = new FormData();
  form.append('lat', lat);
  form.append('lng', lng);
  fetch(url, {
    method: 'POST',
    body: form
  })
  .then(response => response.json())
  .then(data => {
    console.log(data);
  })
  .catch(error => {
    console.error(error);
  });
  //

  // $.post(url, form, function(puerto){
  //   console.log(puerto);
  // });
}


// console.log("user id",user_id);
// console.log("user level",level);

 function getLocations(id){
  const url = path+"/ajax.php?pg=getgps";
  let form = new FormData();

  form.append('id', id);

  fetch(url, {
    method: 'POST',
    body: form
  })
  .then(response => {
      // console.log(response);
      response.json()
  })
  .then(data => {
    data = data.data;
    console.log('From db',data);
  })
  .catch(error => {
    console.log(error);
  });
}

function setLocations(location){
  let positions = location.map(item => {
    return { lat: item.tck_lat, lng: item.tck_lng };
  });
  const initialPosition = { lat: 59.32, lng: 17.84 };
  const markers = createMarkers({ map, position: initialPosition });
  const map = createMap(initialPosition);
  let infoWindow = new google.maps.InfoWindow();

  for (let i = 0; i < markers.length; i++) {
    markers[i].setPosition(positions[i]);
  }
  map.panTo(markers[0]);

  console.log("setLocations: ",positions);
}


function GetRiderMap(id){

  var location = getLocations(id);
  location.then(data => {
    console.log("GetRiderMap: ",data);
  });
  // const initialPosition = { lat: 59.32, lng: 17.84 };
  // const map = createMap(initialPosition);
  // const markers = createMarkers({ map, position: initialPosition });
  // const $info = document.getElementById('info');
  
}
function init() {
  const initialPosition = { lat: 59.32, lng: 17.84 };
  const map = createMap(initialPosition);
  const markers = createMarkers({ map, position: initialPosition });
  const $info = document.getElementById('info');
  if(level != 4){

  }else{
    console.log("init: ",user_id);
    trackLocation({
      onSuccess: ({ coords: { latitude: lat, longitude: lng } }) => {
        console.log("init: ",lat,lng);
        updateLocationDB({lat, lng});
      },
      onError: err => {
        console.log(err);
      }
    });
  }
}
// })( jQuery );