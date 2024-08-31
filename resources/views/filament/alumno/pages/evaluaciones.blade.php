<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($evaluaciones as $evaluacion)
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold">{{ $evaluacion->eva_descripcion }}</h2>
                <p>Duración: {{ $evaluacion->eva_duracion }} minutos</p>
                <p>Fecha de inicio: {{ $evaluacion->eva_fecha_inicio->format('d/m/Y H:i') }}</p>
                <p>Fecha de fin: {{ $evaluacion->eva_fecha_fin->format('d/m/Y H:i') }}</p>
                <a wire:click="redirectToEvaluacion({{ $evaluacion->id }})">
                    <x-filament::button>
                        Rendir Evaluación
                    </x-filament::button>
                </a>
            </div>
        @endforeach
    </div>
</x-filament-panels::page>
