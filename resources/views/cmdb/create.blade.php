@extends('template')

@section('title', 'Crear CMDB')

@push('css')

@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Crear CMDB - {{$category['nombre']}}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categorias</a></li>
            <li class="breadcrumb-item active">Crear CMDB</li>
        </ol>
    </div>

    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action=" {{ route('cmdb.store', ['categoryId' => $category['id']])}}" method="POST">
            @csrf

            @php
                $colCount = 0;
            @endphp
            @foreach ($category['campos_cmdb'] as $campo)
                @if ($campo != 'Categoría')
                    @if ($colCount % 2 == 0)
                        <div class="row">
                    @endif
                    <div class="col-md-6 mb-3">
                        <label for="{{ strtolower($campo) }}" class="form-label">{{ ucfirst($campo) }}:</label>
                        <input type="text" name="{{ strtolower($campo) }}" class="form-control" id="{{ strtolower($campo) }}" value="{{ old(strtolower($campo)) }}">
                        @error(strtolower($campo))
                            <small class="text-danger">{{ "*" . $message }}</small>
                        @enderror
                    </div>
                    @php $colCount++; @endphp
                    @if ($colCount % 2 == 0)
                        </div>
                    @endif
                @endif
            @endforeach
            @if ($colCount % 2 != 0)
                </div>
            @endif

            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>

@endsection


@push('js')

@endpush
