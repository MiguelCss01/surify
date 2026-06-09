@extends('layouts.app')

@section('title', 'Surify - Mapa Nacional')

@section('content')

<style>
    .surify-map-dashboard {
        position: relative;
        width: 100%;
        height: calc(100vh - 4rem); 
        overflow: hidden;
        background-color: #f8f9fa;
        margin-top: -2rem; /* Eliminada la palabra que rompia el compilador */
    }
    #mapa-container {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0; left: 0;
        z-index: 1; 
    }
    .ui-overlay {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        z-index: 30; 
        pointer-events: none;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 24px;
        box-sizing: border-box;
    }
    .interactuable { pointer-events: auto !important; }
    .light-panel {
        background: rgba(255,255,255,0.95) !important;
        backdrop-filter: blur(12px);
        border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        color: #1e293b !important;
    }
    .menu-list a { color: #475569 !important; font-weight: 600; font-size: 13px; text-decoration: none; display: flex; align-items: center; padding: 8px 12px; border-radius: 10px; transition: all 0.2s; }
    .menu-list a:hover { background-color: rgba(40,98,143,0.06) !important; color: #28628f !important; }
    .menu-list a.is-active-menu { background-color: rgba(40,98,143,0.1) !important; color: #28628f !important; font-weight: 700; }
    .custom-zoom-controls button {
        background: #fff; color: #475569;
        border: 1px solid rgba(0,0,0,0.08);
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        cursor: pointer; width: 40px; height: 40px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 6px; border-radius: 10px; transition: all 0.2s;
    }
    .custom-zoom-controls button:hover { background: #f8fafc; color: #28628f; border-color: #28628f; }
    .menu-label { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: #94a3b8; margin-bottom: 12px; padding-left: 4px; }
    .card-info { padding: 14px; }
    .card-info h2 { font-size: 16px; font-weight: 800; color: #0f172a; margin: 4px 0 12px; letter-spacing: -0.02em; }
    .card-info p { font-size: 10px; color: #e11d48; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; }
    .btn-ver { background: #28628f; color: #fff; border: none; width: 100%; padding: 10px; border-radius: 10px; font-weight: 700; cursor: pointer; font-size: 13px; transition: background 0.2s; }
    .btn-ver:hover { background: #1a4669; }
</style>

<div class="surify-map-dashboard -mx-4 sm:-mx-6 lg:-mx-8">
    <div id="mapa-container"></div>

    <div class="ui-overlay">
        <div style="display: flex; justify-content: space-between; width: 100%;">

            <div class="interactuable">
                <aside class="light-panel" style="border-radius: 16px; padding: 16px; width: 230px; max-height: 320px; overflow-y: auto;">
                    <p class="menu-label">Explorador</p>
                    <ul class="menu-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 4px;">
                        <li><a class="is-active-menu"><i class="fa-solid fa-compass" style="margin-right:10px; font-size: 14px;"></i> Destinos</a></li>
                        <li><a><i class="fa-solid fa-calendar-day" style="margin-right:10px; font-size: 14px;"></i> Festivales</a></li>
                        <li><a><i class="fa-solid fa-gas-pump" style="margin-right:10px; font-size: 14px;"></i> Estaciones</a></li>
                        <li><a><i class="fa-solid fa-utensils" style="margin-right:10px; font-size: 14px;"></i> Restaurantes</a></li>
                    </ul>
                </aside>
            </div>

            <div class="interactuable custom-zoom-controls" style="display: flex; flex-direction: column; padding-right: 4px;">
                <button onclick="mapaInstance.zoomIn()" title="Acercar"><i class="fa-solid fa-plus"></i></button>
                <button onclick="mapaInstance.zoomOut()" title="Alejar"><i class="fa-solid fa-minus"></i></button>
                <button onclick="centrarEnArgentina()" title="Recentrar"><i class="fa-solid fa-location-crosshairs"></i></button>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-start; width: 100%;">
            <div class="interactuable light-panel" style="border-radius: 16px; overflow: hidden; width: 230px;">
                <div style="position: relative;">
                    <img src="https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?q=80&w=400"
                         alt="Glaciar Perito Moreno"
                         style="width: 100%; height: 135px; object-fit: cover; display: block;">
                    <span style="position: absolute; top: 10px; right: 10px; background: #28628f; color: white; padding: 4px 8px; border-radius: 8px; font-size: 11px; font-weight: 800; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <i class="fa-solid fa-star" style="color: #fbbf24; margin-right: 2px;"></i> 4.9
                    </span>
                </div>
                <div class="card-info">
                    <p>Santa Cruz</p>
                    <h2>Glaciar Perito Moreno</h2>
                    <button class="btn-ver">Ver detalles</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var mapaInstance = null;

function inicializarMapa() {
    var contenedor = document.getElementById('mapa-container');
    if (!contenedor || mapaInstance !== null) return;

    if (contenedor.offsetWidth === 0 || contenedor.offsetHeight === 0) {
        setTimeout(inicializarMapa, 100);
        return;
    }

    mapaInstance = L.map('mapa-container', {
        zoomControl: false,
        minZoom: 4,
        maxZoom: 14,
        maxBounds: L.latLngBounds(L.latLng(-56.5, -76.0), L.latLng(-21.0, -53.0)),
        maxBoundsViscosity: 1.0
    }).setView([-38.416097, -63.616672], 4);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap, © CartoDB',
        subdomains: 'abcd',
        maxZoom: 20
    }).addTo(mapaInstance);

    L.marker([-50.5083, -73.0833]).addTo(mapaInstance).bindPopup(`
        <div style="font-family:sans-serif; font-size:13px; line-height:1.5;">
            <strong style="color:#28628f;">Glaciar Perito Moreno</strong><br>
            Provincia de Santa Cruz.<br><br>
            <a href="#" style="color:#28628f; font-weight:bold; text-decoration:none;">Explorar →</a>
        </div>
    `);

    setTimeout(function() {
        mapaInstance.invalidateSize(true);
    }, 300);
}

// Llamado inicial
inicializarMapa();

// Por si el contenedor tardó en tener dimensiones
setTimeout(inicializarMapa, 500);
</script>
@endsection