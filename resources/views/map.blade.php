@extends('layouts.template')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    {{-- Leaflet Draw CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">

    <style>
        #map {
            height: 800px;
        }
    </style>
@endsection


@section('content')
    <div id="map"></div>

    <div class="modal" tabindex="-1" id="modalInputPoint">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Point</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('points.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Fill name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="geometry_point" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geometry_point" name="geometry_point" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input class="form-control" type="file" id="image-point" name="image">
                            <img id="preview-image-point" class="img-thumbnail" width="400">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="modalInputPolyline">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Polyline</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('polylines.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Fill name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="geometry_polyline" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geometry_polyline" name="geometry_polyline" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input class="form-control" type="file" id="image-polyline" name="image">
                            <img id="preview-image-polyline" class="img-thumbnail" width="400">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="modalInputPolygon">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Polygon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('polygons.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Fill name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="geometry_polygon" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geometry_polygon" name="geometry_polygon" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input class="form-control" type="file" id="image-polygon" name="image">
                            <img id="preview-image-polygon" class="img-thumbnail" width="400">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    {{-- Leaflet Draw JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

    {{-- Terraformer JS --}}
    <script src="https://unpkg.com/@terraformer/wkt"></script>

    {{-- JQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        var map = L.map('map').setView([-7.7956, 110.3695], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        /* Digitize Function */
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var drawControl = new L.Control.Draw({
            draw: {
                position: 'topleft',
                polyline: true,
                polygon: true,
                rectangle: true,
                circle: false,
                marker: true,
                circlemarker: false
            },
            edit: false
        });

        map.addControl(drawControl);

        map.on('draw:created', function(e) {
            var type = e.layerType,
                layer = e.layer;

            console.log(type);

            var drawnJSONObject = layer.toGeoJSON();
            var objectGeometry = Terraformer.geojsonToWKT(drawnJSONObject.geometry);

            console.log(drawnJSONObject);
            console.log(objectGeometry);

            if (type === 'polyline') {
                //Set value geometry to geometry_polyline
                $('#geometry_polyline').val(objectGeometry);
                console.log("Create " + type);

                $('#modalInputPolyline').modal('show');

                $('#modalInputPolyline').on('hidden.bs.modal', function() {
                    location.reload();
                });

                console.log("Create " + type);
            } else if (type === 'polygon' || type === 'rectangle') {
                //Set value geometry to geometry_polygon
                $('#geometry_polygon').val(objectGeometry);
                console.log("Create " + type);

                $('#modalInputPolygon').modal('show');

                $('#modalInputPolygon').on('hidden.bs.modal', function() {
                    location.reload();
                });
                console.log("Create " + type);

            } else if (type === 'marker') {

                //Set value geometry to geometry_point
                $('#geometry_point').val(objectGeometry);
                console.log("Create " + type);

                $('#modalInputPoint').modal('show');

                $('#modalInputPoint').on('hidden.bs.modal', function() {
                    location.reload();
                });

            } else {
                console.log('__undefined__');
            }

            drawnItems.addLayer(layer);
        });

        //Points Layer
        var points = L.geoJSON(null, {
        // Style

        // onEachFeature
        onEachFeature: function (feature, layer) {

            // route delete point
            var routedelete = "{{ route('points.delete', '__id__') }}";
            routedelete = routedelete.replace('__id__', feature.properties.id);

            // variable popup content
            var popup_content =
                "Nama: " + feature.properties.name + "<br>" +
                "Deskripsi: " + feature.properties.description + "<br>" +
                "Dibuat: " + feature.properties.created_at + "<br>";

            // kalau ada gambar
            if (feature.properties.image) {
            popup_content +=
                "<img " +
                "src='{{ asset('storage/images') }}/" + feature.properties.image + "' " +
                "alt='" + (feature.properties.name || 'image') + "' " +
                "class='img-thumbnail' width='400'>" +
                "<br><br>" +

                "<form action='" + routedelete + "' method='post'>" +
                '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                '<input type="hidden" name="_method" value="DELETE">' +

                "<button " +
                "type='submit' " +
                "class='btn btn-sm btn-danger' " +
                "title='Delete feature' " +
                "onclick=\"return confirm('Are you sure you want to delete this feature?')\">" +
                "<i class='fa-solid fa-trash-can'></i>" +
                "</button>" +
                "</form>";
        }

            // TAMBAHAN (kalau tidak ada gambar)
            if (!feature.properties.image) {
                popup_content +=
                    "<form action='" + routedelete + "' method='post'>" +
                    '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                    '<input type="hidden" name="_method" value="DELETE">' +

                    "<button " +
                    "type='submit' " +
                    "class='btn btn-sm btn-danger' " +
                    "title='Delete feature'>" +
                    "<i class='fa-solid fa-trash-can'></i>" +
                    "</button>" +
                    "</form>";
            }

            layer.bindPopup(popup_content, {
            maxWidth: 450
            });
        }
    });

        $.getJSON("{{ route('geojson.points') }}", function(data) {
            points.addData(data);
            map.addLayer(points);
        });

        //Polyline Layer
        var polylines = L.geoJSON(null, {
        onEachFeature: function(feature, layer) {

            // route delete polyline
            var routedelete = "{{ route('polylines.delete', '__id__') }}";
            routedelete = routedelete.replace('__id__', feature.properties.id);

            // popup content
            var popup_content =
                "Nama: " + feature.properties.name + "<br>" +
                "Deskripsi: " + feature.properties.description + "<br>" +
                "Dibuat: " + feature.properties.created_at + "<br>";

            // kalau ada gambar
            if (feature.properties.image) {
                popup_content +=
                    "<img src='{{ asset('storage/images') }}/" + feature.properties.image + "' " +
                    "class='img-thumbnail' width='400'><br><br>";
            }

            // tombol delete (SELALU ADA)
            popup_content +=
                "<form action='" + routedelete + "' method='post'>" +
                '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                '<input type="hidden" name="_method" value="DELETE">' +

                "<button type='submit' class='btn btn-sm btn-danger' " +
                "onclick=\"return confirm('Are you sure you want to delete this feature?')\">" +
                "<i class='fa-solid fa-trash-can'></i>" +
                "</button>" +
                "</form>";

            layer.bindPopup(popup_content, {
                maxWidth: 450
            });
        }
    });

        //Polygon Layer
        var polygons = L.geoJSON(null, {
        onEachFeature: function(feature, layer) {

            // route delete polygon
            var routedelete = "{{ route('polygons.delete', '__id__') }}";
            routedelete = routedelete.replace('__id__', feature.properties.id);

            // popup content
            var popup_content =
                "Nama: " + feature.properties.name + "<br>" +
                "Deskripsi: " + feature.properties.description + "<br>" +
                "Dibuat: " + feature.properties.created_at + "<br>";

            // kalau ada gambar
            if (feature.properties.image) {
                popup_content +=
                    "<img src='{{ asset('storage/images') }}/" + feature.properties.image + "' " +
                    "class='img-thumbnail' width='400'><br><br>";
            }

            // tombol delete (SELALU ADA)
            popup_content +=
                "<form action='" + routedelete + "' method='post'>" +
                '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                '<input type="hidden" name="_method" value="DELETE">' +

                "<button type='submit' class='btn btn-sm btn-danger' " +
                "onclick=\"return confirm('Are you sure you want to delete this feature?')\">" +
                "<i class='fa-solid fa-trash-can'></i>" +
                "</button>" +
                "</form>";

            layer.bindPopup(popup_content, {
                maxWidth: 450
            });
        }
    });

        $.getJSON("{{ route('geojson.polylines') }}", function(data) {
        console.log("POLYLINE:", data);

        polylines.addData(data);
        map.addLayer(polylines);
    });

        $.getJSON("{{ route('geojson.polygons') }}", function(data) {
            console.log("POLYGON:", data);

            polygons.addData(data);
            map.addLayer(polygons);
        });

        // Control Layer
        var baseMaps = {};

        var overlayMaps = {
            "Points": points,
            "Polyline": polylines,
            "Polygon": polygons,
        };

        L.control.layers(baseMaps, overlayMaps).addTo(map);
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const setups = [
                { input: 'image-point', preview: 'preview-image-point' },
                { input: 'image-polyline', preview: 'preview-image-polyline' },
                { input: 'image-polygon', preview: 'preview-image-polygon' }
            ];

            setups.forEach(item => {
                const inputEl = document.getElementById(item.input);
                const previewEl = document.getElementById(item.preview);

                if (inputEl && previewEl) {
                    inputEl.addEventListener('change', function (e) {
                        const file = e.target.files[0];
                        if (file) {
                            previewEl.src = URL.createObjectURL(file);
                        }
                    });
                }
            });

        });
    </script>
@endsection
