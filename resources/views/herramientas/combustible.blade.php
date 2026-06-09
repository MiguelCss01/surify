@extends('layouts.app')

@section('title', 'Surify - Calculadora de Combustible')

@section('content')

<div class="mb-8">
    <h1 class="text-4xl font-black text-slate-900 tracking-tight" style="font-family: 'Inter', sans-serif;">Resumen de Viaje</h1>
    <p class="text-slate-500 mt-1 text-lg">Calculadora de ruta, costos y logística para tu aventura en Argentina.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

    <!-- Columna Izquierda -->
    <div class="lg:col-span-7 flex flex-col gap-6">

        <!-- Ruta Principal -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-xl font-bold text-slate-800 mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-[#28628f]">route</span>
                Ruta Principal
            </h2>
            <div class="flex flex-col gap-3 relative">
                <!-- Origen -->
                <div class="flex items-center bg-slate-50 rounded-lg p-3 border border-slate-200 focus-within:border-[#28628f] transition-colors">
                    <span class="material-symbols-outlined text-slate-400 mr-3">trip_origin</span>
                    <div class="flex-grow">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-0.5">Origen</label>
                        <input id="input-origen" type="text" placeholder="Ej: Formosa, Formosa"
                            class="w-full bg-transparent border-none p-0 focus:ring-0 text-base text-slate-800 font-medium placeholder:text-slate-300">
                    </div>
                </div>
                <!-- Línea conectora -->
                <div class="absolute left-[26px] top-[52px] bottom-[52px] w-[2px] bg-slate-200 rounded-full z-0"></div>
                <!-- Destino -->
                <div class="flex items-center bg-slate-50 rounded-lg p-3 border border-slate-200 focus-within:border-[#28628f] transition-colors z-10 relative">
                    <span class="material-symbols-outlined text-rose-400 mr-3">location_on</span>
                    <div class="flex-grow">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-0.5">Destino</label>
                        <input id="input-destino" type="text" placeholder="Ej: Cataratas del Iguazú, Misiones"
                            class="w-full bg-transparent border-none p-0 focus:ring-0 text-base text-slate-800 font-medium placeholder:text-slate-300">
                    </div>
                </div>
            </div>

            <!-- Distancia manual (hasta que llegue la API de Maps) -->
            <div class="mt-4 flex items-center bg-slate-50 rounded-lg p-3 border border-slate-200 gap-3">
                <span class="material-symbols-outlined text-slate-400">straighten</span>
                <div class="flex-grow">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-0.5">Distancia (km)</label>
                    <input id="input-distancia" type="number" min="1" placeholder="Ej: 715"
                        class="w-full bg-transparent border-none p-0 focus:ring-0 text-base text-slate-800 font-medium placeholder:text-slate-300">
                </div>
            </div>

            <div id="ruta-resumen" class="mt-4 hidden items-center justify-between p-3 bg-slate-50 rounded-lg border border-slate-100">
                <div class="flex flex-col">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wide">Ruta ingresada</span>
                    <span id="ruta-texto" class="text-sm text-slate-700 font-medium mt-0.5"></span>
                </div>
                <div class="text-right">
                    <span id="ruta-km" class="block text-xl font-black text-[#28628f]"></span>
                    <span class="text-xs font-bold text-slate-400">distancia</span>
                </div>
            </div>
        </div>

        <!-- Calculadora de Consumo + Nota Regional -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Calculadora -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-amber-500">local_gas_station</span>
                    Calculadora de Consumo
                </h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Tipo de Vehículo</label>
                        <select id="select-vehiculo" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 focus:ring-[#28628f] focus:border-[#28628f]">
                            <option value="sedan">Sedán</option>
                            <option value="suv">SUV</option>
                            <option value="camioneta">Camioneta</option>
                            <option value="moto">Moto</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Tipo de Combustible</label>
                        <select id="select-combustible" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 focus:ring-[#28628f] focus:border-[#28628f]">
                            <option>Nafta Súper</option>
                            <option>Nafta Premium</option>
                            <option>Diesel</option>
                            <option>GNC</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Consumo (L/100km)</label>
                        <input id="input-consumo" type="number" value="9" min="1" max="50"
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 focus:ring-[#28628f] focus:border-[#28628f]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Precio del combustible ($/L)</label>
                        <input id="input-precio" type="number" placeholder="Ej: 1200" min="1"
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 focus:ring-[#28628f] focus:border-[#28628f]">
                    </div>
                </div>

                <div class="mt-5 pt-4 border-t border-slate-100 space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-500">Litros (solo ida)</span>
                        <span id="resultado-litros-ida" class="text-lg font-bold text-slate-700">—</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-500">Litros (ida y vuelta)</span>
                        <span id="resultado-litros-total" class="text-lg font-bold text-[#28628f]">—</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-slate-100">
                        <span class="text-sm font-bold text-slate-600">Costo estimado (i/v)</span>
                        <span id="resultado-costo" class="text-lg font-black text-[#28628f]">—</span>
                    </div>
                </div>

                <button id="btn-calcular"
                    class="w-full mt-4 bg-[#28628f] hover:bg-[#1a4669] text-white text-sm font-bold py-2.5 rounded-full transition-all shadow-sm active:scale-95">
                    Calcular
                </button>
            </div>

            <!-- Nota Regional -->
            <div class="bg-[#28628f] text-white rounded-xl shadow-sm p-6 flex flex-col justify-between relative overflow-hidden">
                <div class="absolute -right-6 -top-6 opacity-10">
                    <span class="material-symbols-outlined text-[120px]">price_change</span>
                </div>
                <div class="relative z-10">
                    <span class="text-xs font-bold uppercase tracking-widest text-blue-200 block mb-2">Nota Regional</span>
                    <h3 class="text-lg font-bold mb-3">Precios de Combustible</h3>
                    <p class="text-sm text-blue-100 leading-relaxed">Misiones y Corrientes suelen tener precios más altos que Formosa. Se recomienda cargar combustible antes de ingresar a las zonas de la RN12.</p>
                </div>
                <div class="relative z-10 mt-6 bg-white/10 rounded-lg p-3 border border-white/20">
                    <span class="text-xs font-bold text-blue-200 uppercase tracking-wide block mb-1">⚠️ Antes de salir</span>
                    <p class="text-xs text-blue-100">Verificá los precios actuales en tu estación de servicio local.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Columna Derecha -->
    <div class="lg:col-span-5 flex flex-col gap-6">

        <!-- Mapa (placeholder hasta que llegue la API) -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden h-[280px] relative flex items-center justify-center">
            <div class="text-center text-slate-300 select-none">
                <span class="material-symbols-outlined text-[64px] block mb-2">map</span>
                <p class="text-sm font-semibold">Mapa de ruta</p>
                <p class="text-xs">Próximamente con Google Maps API</p>
            </div>
            <div class="absolute bottom-4 left-4 right-4">
                <div class="bg-white/80 backdrop-blur-sm rounded-lg px-3 py-2 border border-slate-100 inline-flex items-center gap-2">
                    <span class="material-symbols-outlined text-[16px] text-slate-400">info</span>
                    <span class="text-xs text-slate-500 font-medium">La visualización del mapa se habilitará con la API</span>
                </div>
            </div>
        </div>

        <!-- Requisitos y Consejos -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Requisitos y Consejos</h3>
            <ul class="flex flex-col gap-3">
                <li class="flex items-start gap-3 p-3 bg-slate-50 rounded-lg">
                    <span class="material-symbols-outlined text-rose-400 mt-0.5" style="font-variation-settings: 'FILL' 1;">description</span>
                    <div>
                        <h4 class="text-sm font-bold text-slate-700">Documentación Obligatoria</h4>
                        <p class="text-xs text-slate-500 mt-1">DNI, cédula del vehículo y seguro vigente. Si cruzás a Brasil o Paraguay, llevá también la Carta Verde.</p>
                    </div>
                </li>
                <li class="flex items-start gap-3 p-3 bg-slate-50 rounded-lg">
                    <span class="material-symbols-outlined text-amber-500 mt-0.5" style="font-variation-settings: 'FILL' 1;">car_repair</span>
                    <div>
                        <h4 class="text-sm font-bold text-slate-700">Mantenimiento Vehicular</h4>
                        <p class="text-xs text-slate-500 mt-1">Revisá frenos y refrigeración si vas hacia Misiones — las pendientes de la RN12 son exigentes.</p>
                    </div>
                </li>
                <li class="flex items-start gap-3 p-3 bg-slate-50 rounded-lg">
                    <span class="material-symbols-outlined text-slate-400 mt-0.5" style="font-variation-settings: 'FILL' 1;">toll</span>
                    <div>
                        <h4 class="text-sm font-bold text-slate-700">Peajes en Ruta</h4>
                        <p class="text-xs text-slate-500 mt-1">Hay varios peajes en la RN12 por Corrientes y Misiones. Llevá efectivo o tené el telepeaje activo.</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnCalcular = document.getElementById('btn-calcular');
    const inputDistancia = document.getElementById('input-distancia');
    const inputConsumo = document.getElementById('input-consumo');
    const inputPrecio = document.getElementById('input-precio');
    const inputOrigen = document.getElementById('input-origen');
    const inputDestino = document.getElementById('input-destino');

    const resLitrosIda = document.getElementById('resultado-litros-ida');
    const resLitrosTotal = document.getElementById('resultado-litros-total');
    const resCosto = document.getElementById('resultado-costo');
    const rutaResumen = document.getElementById('ruta-resumen');
    const rutaTexto = document.getElementById('ruta-texto');
    const rutaKm = document.getElementById('ruta-km');

    btnCalcular.addEventListener('click', function () {
        const distancia = parseFloat(inputDistancia.value);
        const consumo = parseFloat(inputConsumo.value);
        const precio = parseFloat(inputPrecio.value);
        const origen = inputOrigen.value.trim();
        const destino = inputDestino.value.trim();

        if (!distancia || !consumo) {
            alert('Ingresá al menos la distancia y el consumo del vehículo.');
            return;
        }

        const litrosIda = (distancia * consumo) / 100;
        const litrosTotal = litrosIda * 2;

        resLitrosIda.textContent = `~${litrosIda.toFixed(1)} L`;
        resLitrosTotal.textContent = `~${litrosTotal.toFixed(1)} L`;

        if (precio) {
            const costoTotal = litrosTotal * precio;
            resCosto.textContent = `$${costoTotal.toLocaleString('es-AR', { maximumFractionDigits: 0 })}`;
        } else {
            resCosto.textContent = 'Ingresá precio/L';
        }

        if (origen && destino) {
            rutaTexto.textContent = `${origen} → ${destino}`;
            rutaKm.textContent = `${distancia} km`;
            rutaResumen.classList.remove('hidden');
            rutaResumen.classList.add('flex');
        }
    });
});
</script>

@endsection