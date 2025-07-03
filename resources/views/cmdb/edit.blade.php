@extends('template')

@section('title', 'Actualizar CMDB')

@push('css')
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

@section('content')
        <div class="container-fluid px-4">
            <h1 class="mt-4 text-center">Actualizar CMDB</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categorias</a></li>
                <li class="breadcrumb-item active">Actualizar CMDB</li>
            </ol>
        </div>

        <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
            @php
    $estado = collect($cmdbItems['cmdb'])->firstWhere('activado', 1) ? 0 : 1;
            @endphp
            @foreach ($cmdbItems['cmdb'] as $index => $items)
                    <div class="mb-4 p-3 border rounded">
                        <h5 class="mb-3">Registro {{ $index + 1 }}</h5>
                        <form action="{{ route('cmdb.update', ['categoryId' => $categoryId, 'id' => $items['identificador']]) }}"
                            method="POST" class="row g-3">
                            @csrf
                            @method('PUT')
                            @foreach ($items as $key => $item)
                                @if ($key == 'categoria_id' || $key == 'fecha_creacion' || $key == 'identificador')
                                    @continue
                                @elseif ($key == 'activado')
                                    <div class="col-md-6 mb-3">
                                        <label for="{{ strtolower($key) }}" class="form-label">Estado:</label>
                                        <select data-live-search="true" name="{{ strtolower($key) }}" id="{{ strtolower($key) }}"
                                            class="form-control selecpicker">
                                            <option value="1" {{ $item == 1 ? 'selected' : '' }}>Activo</option>
                                            <option value="0" {{ $item == 0 ? 'selected' : '' }}>Inactivo</option>
                                        </select>
                                        @error(strtolower($key))
                                            <small class="text-danger">{{ "*{$message}" }}</small>
                                        @enderror
                                    </div>
                                @else
                                    <div class="col-md-6 mb-3">
                                        <label for="{{ strtolower($key) }}" class="form-label">{{ ucfirst($key) }}:</label>
                                        <input type="text" name="{{ strtolower($key) }}" class="form-control" id="{{ strtolower($key) }}"
                                            value="{{ old($item, $item) }}">
                                        @error(strtolower($key))
                                            <small class="text-danger">{{ "*" . $message }}</small>
                                        @enderror
                                    </div>
                                @endif
                            @endforeach
                            <div class="col-12 text-center d-flex justify-content-center gap-2">
                                <button type="submit" class="btn btn-success">Actualizar</button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#confirmModal">Eliminar</button>
                        </form>
                    </div>
                    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">mensaje de confirmación</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que deseas eliminar este registro? Esta acción no se puede deshacer.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <form
                                        action=" {{route('cmdb.destroy', ['categoryId' => $categoryId, 'id' => $items['identificador']])}} "
                                        method="POST" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        <div class="col-md-12 text-center d-flex justify-content-center gap-2 mt-3">
            <form action="{{ route('categories.index') }}" method="GET" class="m-0">
                <button type="submit" class="btn btn-secondary">Volver</button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModalEstado">Cambiar
                    Estado</button>
            </form>

            <div class="modal fade" id="confirmModalEstado" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">mensaje de confirmación</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¿Estás seguro de que deseas cambiar el estado de todos los CMDB?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <form action=" {{route('cmdb.deactivate', ['categoryId' => $categoryId, 'estado' => $estado])}}"
                                method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-{{ $estado == 0 ? 'danger' : 'primary' }}">
                                    {{ $estado == 0 ? 'Desactivar Todo' : 'Activar Todo' }}
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

@endsection


@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script>
        $('select').selectpicker();
    </script>
@endpush
