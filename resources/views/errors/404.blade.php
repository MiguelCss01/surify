<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surify - Página no encontrada</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center px-4" style="font-family: 'Outfit', sans-serif;">

    <div class="text-center max-w-lg">
        <div class="mb-8 relative">
            <p class="text-[120px] font-black text-slate-100 leading-none select-none" style="font-family: 'Inter', sans-serif;">404</p>
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="material-symbols-outlined text-[80px] text-[#28628f]" style="font-variation-settings: 'FILL' 1;">travel_explore</span>
            </div>
        </div>

        <h1 class="text-3xl font-black text-slate-800 tracking-tight mb-3" style="font-family: 'Inter', sans-serif;">
            ¡Destino no encontrado!
        </h1>
        <p class="text-slate-500 text-base leading-relaxed mb-8">
            Parece que este lugar no está en nuestro mapa. Puede que la página haya sido movida o simplemente no exista.
        </p>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ url('/') }}"
               class="bg-[#28628f] text-white px-6 py-3 rounded-xl font-bold hover:bg-[#1a4669] transition-all shadow-sm flex items-center justify-center gap-2 text-decoration-none">
                <span class="material-symbols-outlined text-[18px]">home</span>
                Volver al inicio
            </a>
            <a href="{{ url('/mapa') }}"
               class="border border-[#28628f] text-[#28628f] px-6 py-3 rounded-xl font-bold hover:bg-blue-50 transition-all flex items-center justify-center gap-2 text-decoration-none">
                <span class="material-symbols-outlined text-[18px]">map</span>
                Ver el mapa
            </a>
        </div>

        <p class="text-slate-300 text-xs mt-8">© {{ date('Y') }} Surify — Turismo Nacional</p>
    </div>

</body>
</html>