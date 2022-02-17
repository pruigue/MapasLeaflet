<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Quick Start - Leaflet</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
              integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
              crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
                integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
                crossorigin=""></script>
        </head>
    <body>
        <div id="mapid" style="width: 800px; height: 600px;"></div>
        <script>
            var latlngs = [];

            var mymap = L.map('mapid').setView([37.456583470231, -3.9191633462906], 14);
            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                maxZoom: 25,
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                        '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1
            }).addTo(mymap);
            // esta variable la uso para poder borrar la polilínea más adelante
            var polyline = L.polyline(latlngs, {color: 'red'}).addTo(mymap);

            function onMapClick(e) {
                var marker = L.marker().on("click", function (e) {
                    borrar(e.latlng);//borramos el punto de la BBDD
                    latlngs.splice(latlngs.indexOf(e.latlng),1);//lo quitamos del vector de puntos
                    e.target.remove();//removemos el marcador
                    //eliminar(e.latlng.lat+' '+e.latlng.lng);//lo eliminamos del dcto, por corregir.....
                    mostrar(mymap);
                });

                marker.setLatLng(e.latlng).addTo(mymap);

                enviar(e.latlng);// lo insertamos en la BBDD
                latlngs.push(e.latlng);//lo metemos en el vector
                mostrar(mymap);
                agregarElemento(e.latlng);//lo añadimos al documento
            }

            mymap.on('click', onMapClick);

            function enviar(latLng) {
                xhttp = new XMLHttpRequest();
                xhttp.open("POST", "subir.php", true);
                xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                var final = JSON.stringify(latLng);
                xhttp.send("objeto=" + final);
            }

            function borrar(latLng) {
                xhttp = new XMLHttpRequest();
                xhttp.open("POST", "borrar.php", true);
                xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                var final = JSON.stringify(latLng);
                xhttp.send("objeto=" + final);
                // borrar de la vista

            }

            function mostrar(map){
                map.removeLayer(polyline);//eliminamos la polilínea anterior
                polyline = L.polyline(latlngs, {color: 'red'}).addTo(map);
            }

            function agregarElemento(data){
                  var lista=document.getElementById("ulListado");
                    var linew= document.createElement('li');
                    var contenido = document.createTextNode(data.lat+' '+data.lng);
                    lista.appendChild(linew);
                    linew.appendChild(contenido);
           }

            function eliminar(elemento){
                var id=elemento.parentNode.getAttribute(elemento);
                node=document.getElementById(id);
                node.parentNode.removeChild(node);

                var tempo;

            }



        </script>
        Listado
        <div id="ulListado"></div>
    </body>
</html>