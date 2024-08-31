<x-filament-panels::page>
    <h1 class="text-xl font-bold">{{ $evaluacion->eva_descripcion }}</h1>
    <form wire:submit.prevent="guardarRespuestas">
        @csrf
        @foreach ($preguntas as $pregunta)
            <div class="mb-4">
                <p class="font-semibold">{{ $pregunta->pre_descripcion }}</p>
                <!-- Campo de texto para respuestas -->
                <input type="text" wire:model.defer="respuestas.{{ $pregunta->id }}" id="response_{{ $pregunta->id }}" class="mt-2 p-2 border rounded w-full" placeholder="Escribe tu respuesta">
            </div>
        @endforeach
    
        <x-filament::button type="submit">Enviar Evaluación</x-filament::button>
    </form>
    
</x-filament-panels::page>
