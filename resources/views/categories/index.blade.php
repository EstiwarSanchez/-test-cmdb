@extends('template')

@section('title', 'Categorias')

@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@section('content')

    @if (session('success'))
        <script>
            let message = "{{ session('success') }}";
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: message
            });
        </script>
    @endif


        <div class="container-fluid px-4">
            <h1 class="mt-4 text-center">Categorias</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Categorias</li>
            </ol>

            <div class="mb-4">

            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Tabla Categorias
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Categoria Padre</th>
                                <th>Código</th>
                                <th>CMDB</th>
                                <th>Acciones</th>No hay categorías disponibles.
                            </tr>
                        </thead>
                        <tbody>

                            @if(isset($categories['categorias']) && is_array($categories['categorias']) && count($categories['categorias']) > 0)
                                @foreach ($categories['categorias'] as $key => $category)
                                    @php
                                        $category = (object) $category;
                                    @endphp
                                    <tr>
                                        <td>{{ $category->id ?? 'N/A'}}</td>
                                        <td>{{ $category->nombre ?? 'N/A'}}</td>
                                        <td>
                                            @if($category->categoria_padre_id == null)
                                                <span class="text-muted">Sin categoria padre</span>
                                            @else
                                                @php
                                                    $parent = collect($categories['categorias'])->firstWhere('id', $category->categoria_padre_id);
                                                @endphp
                                                {{ $parent['nombre'] ?? 'N/A' }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($category->codigo == null || $category->codigo == '')
                                                 <span class="text-muted">N/A</span>
                                            @else
                                                {{ $category->codigo }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (!empty($category->campos_cmdb) && is_array($category->campos_cmdb))
                                                <ul class="mb-0 ps-3">
                                                    @foreach ($category->campos_cmdb as $campo)
                                                        <li>{{ $campo }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <fieldset class="btn-group" aria-label="Acciones">
                                                <legend class="visually-hidden">Acciones</legend>
                                                <form action="{{ route('cmdb.create', ['categoryId' => $category->id]) }}" method="GET">
                                                    <button type="submit" class="btn btn-success btn-sm" title="Agregar nueva CMDB">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('cmdb.show', ['categoryId' => $category->id]) }}" method="GET">
                                                    <button type="submit" class="btn btn-info btn-sm" title="Ver CMDB">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('cmdb.edit', ['categoryId' => $category->id]) }}" method="GET">
                                                    <button type="submit" class="btn btn-primary btn-sm" title="Actualizar CMDB">
                                                        <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                                <form action=" {{ route('cmdb.export', ['categoryId' => $category->id]) }}" method="GET">
                                                    <button type="submit" class="btn btn-light btn-sm" title="Descargar Excel"><i class="fa fa-download" aria-hidden="true"></i></button>
                                                </form>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#fileModal" title="Subir Excel"><i class="fa fa-upload" aria-hidden="true"></i></button>
                                            </fieldset>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No hay categorías disponibles.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if (isset($category))
            <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Subida de Archivo</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('cmdb.import', ['categoryId' => $category->id]) }}" method="POST" enctype="multipart/form-data" id="importForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="fileInput" class="form-label">Selecciona un archivo Excel (.xlsx)</label>
                                    <input class="form-control" type="file" id="fileInput" name="file" accept=".xlsx" required>
                                </div>
                                <div class="alert alert-info py-2" role="alert">
                                    Solo se permiten archivos con extensión <strong>.xlsx</strong>.
                                </div>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-upload"></i> Subir archivo
                                </button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script src="{{ asset('js/datatables-simple-demo.js')}}"></script>
@endpush
