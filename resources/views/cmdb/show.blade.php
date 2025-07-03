@extends('template')

@section('title', 'Crear CMDB')

@push('css')

@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Ver CMDB</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categorias</a></li>
            <li class="breadcrumb-item active">Ver CMDB</li>
        </ol>
    </div>

    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
            @foreach ($cmdbItems['cmdb'] as $index => $items)
                <div class="mb-4 p-3 border rounded bg-light">
                    <h5 class="mb-3">Registro {{ $index + 1 }}</h5>
                    <div class="row">
                        @foreach ($items as $key => $item)
                            @if ($key == 'categoria_id')
                                @continue
                            @elseif ($key == 'fecha_creacion')
                                <div class="col-md-6 mb-3">
                                    <label for="{{ strtolower($key) }}_{{ $index }}" class="form-label">Fecha Creacion:</label>
                                    <input type="date" name="{{ strtolower($key) }}_{{ $index }}" class="form-control" id="{{ strtolower($key) }}_{{ $index }}"
                                        value="{{ \Carbon\Carbon::parse($item)->format('Y-m-d') }}" readonly>
                                </div>
                            @elseif ($key == 'activado')
                                <div class="col-md-6 mb-3">
                                    <label for="{{ strtolower($key) }}_{{ $index }}" class="form-label">Estado:</label>
                                    <select name="{{ strtolower($key) }}_{{ $index }}" id="{{ strtolower($key) }}_{{ $index }}" class="form-control" disabled>
                                        <option value="1" {{ $item == 1 ? 'selected' : '' }}>Activo</option>
                                        <option value="0" {{ $item == 0 ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                </div>
                            @else
                                <div class="col-md-6 mb-3">
                                    <label for="{{ strtolower($key) }}_{{ $index }}" class="form-label">{{ ucfirst($key) }}:</label>
                                    <input type="text" name="{{ strtolower($key) }}_{{ $index }}" class="form-control" id="{{ strtolower($key) }}_{{ $index }}"
                                        value="{{ $item }}" readonly>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
            <div class="col-md-12 text-center">
                <form action="{{ route('categories.index') }}" method="GET">
                    <button type="submit" class="btn btn-secondary">Volver</button>
                </form>
            </div>
    </div>

@endsection


@push('js')

@endpush
