<!DOCTYPE html>
<html>
<head>
    <title>Evaluación</title>
</head>
<body>
    <h1>Evaluación: {{ $evaluacion->eva_descripcion }}</h1>
    <form action="{{ route('evaluacion.submit') }}" method="POST">
        @csrf
        @foreach ($evaluacion->preguntas as $pregunta)
            <div>
                <label>{{ $pregunta->pre_descripcion }}</label>
                <input type="hidden" name="pregunta_ids[]" value="{{ $pregunta->id }}">
                <input type="text" name="respuestas[]" placeholder="Tu respuesta">
            </div>
        @endforeach
        <button type="submit">Enviar Evaluación</button>
    </form>
</body>
</html>
