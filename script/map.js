/*crea la mappa e passa l'oggetto)*/
function initmap(lat, lon, zoom, obj)
{
var layerurl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
var	attr = 'Dati &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> sotto licenza ODBL';

var tile = new L.TileLayer(layerurl, {maxZoom: 18, attribution: attr});
var map= new L.Map('map', obj);

map.setView(new L.LatLng(lat, lon), zoom);
map.addLayer(tile);
return map;
}

function makeIcon(url)
{
return L.icon( {iconUrl: url, iconSize: [32, 37], iconAnchor: [16, 36], popupAnchor: [0, -36]});
}

/* funzione per creare un marker facilmente, oggetto mappa, tipo, coordinate e testo*/
function putMarker(map, type, lat, lon, text)
{
	var marker;

    if (type===null)
	marker = L.marker([lat, lon]);
	else
	{
	marker = L.marker([lat, lon], {icon: type});
	}
	/*marker = L.marker([lat, lon]);*/
	marker.bindPopup(text);
	map.addLayer(marker);
	return marker;
}

/*un semplice wrapper*/
function removeMarker(map, marker)
{
map.removeLayer(marker);
}

function setCenter(map,marker,zoom)
{
var latlng=marker.getLatLng();
map.setView(latlng, zoom);
}

function swap(arr)
{
return [arr[1],arr[0]];
}
