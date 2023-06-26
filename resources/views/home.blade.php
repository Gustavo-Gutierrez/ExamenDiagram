@extends('adminlte::page')
@section('title', 'UML Software Home')

@section('content_header')
<div class="page">
        <div class="page-wrapper">
            <div class="container-xl">
                <!-- Page title -->
                <div class="page-header d-print-none">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <!-- Page pre-title -->
                            <div class="page-pretitle">
                                Inicio
                            </div>
                            <h2 class="page-title">
                                UML Software
                            </h2>
                        </div>
@stop

@section('content')
<div class="page">
        <div class="page-wrapper">
            <div class="container-xl">
                <!-- Page title -->
                <div class="page-header d-print-none">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <!-- Page pre-title -->
                            <div class="page-pretitle">
                                Inicio
                            </div>
                            <h2 class="page-title">
                                UML Software
                            </h2>
                        </div>
                        <!-- Page title actions -->
                        <div class="col-12 col-md-auto ms-auto d-print-none">
                            <div class="btn-list">

                                <a href="{{route('proyectos.index')}}" class="btn btn-white">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-layout-2" width="44" height="44"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="#597e8d" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <rect x="4" y="4" width="6" height="5"
                                            rx="2" />
                                        <rect x="4" y="13" width="6" height="7"
                                            rx="2" />
                                        <rect x="14" y="4" width="6" height="7"
                                            rx="2" />
                                        <rect x="14" y="15" width="6" height="5"
                                            rx="2" />
                                    </svg>
                                    Proyectos
                                </a>

                                <a href="{{route('profile.index')}}" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-settings" width="44" height="44"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    Mi cuenta
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-body">
                <div class="container-xl">
                    <div class="row row-cards mb-2">

                        <div class="col-lg-6">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Modelo UML</h3>
                                    </div>
                                    <div class="card-body">
                                        <div id="carousel-captions" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <div class="" style="border: 0">
                                                        <img class="d-block h-auto" alt=""
                                                            src="{{ asset('/assets/img/diaclases.png') }}">
                                                    </div>
                                                    <div class="carousel-caption-background d-none d-md-block"></div>
                                                    <div class="carousel-caption d-none d-md-block">
                                                        <h3>Diagrama de clases</h3>
                                                        <p>Diagrama elemental para el proyecto
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="carousel-item">
                                                    <div class="" style="border: 0">
                                                        <img class="d-block w-max" alt=""
                                                            src="{{ asset('/assets/img/diaclases1.png') }}">
                                                    </div>
                                                    <div class="carousel-caption-background d-none d-md-block"></div>
                                                    <div class="carousel-caption d-none d-md-block">
                                                        <h3>Tipos de clases</h3>
                                                        
                                                    </div>
                                                </div>
                                                <div class="carousel-item {{-- {{ ++$i == 1 ? 'active' : '' }} --}}">
                                                    <div class="" style="border: 0">
                                                        <img class="d-block w-max" alt=""
                                                            src="{{ asset('/assets/img/diaclases2.png') }}">
                                                    </div>
                                                    <div class="carousel-caption-background d-none d-md-block"></div>
                                                    <div class="carousel-caption d-none d-md-block">
                                                        <h3>Tipos de Asociaciones</h3>
                                                        
                                                    </div>
                                                </div>
                                                <div class="carousel-item {{-- {{ ++$i == 1 ? 'active' : '' }} --}}">
                                                    <div class="" style="border: 0">
                                                        <img class="d-block w-100" alt=""
                                                            src="{{ asset('/assets/img/diaclases3.png') }}">
                                                    </div>
                                                    <div class="carousel-caption-background d-none d-md-block"></div>
                                                    <div class="carousel-caption d-none d-md-block">
                                                        <h3>Asociociones</h3>
                                                        
                                                    </div>
                                                </div>
                                                {{-- @endforeach --}}
                                            </div>

                                            <a class="carousel-control-prev" href="#carousel-captions" role="button"
                                                data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carousel-captions" role="button"
                                                data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Proyectos Favoritos</h3>
                                </div>
                                <div class="card-body">
                                    @if (count($proyectos) > 0)
                                        <div class="row row-cards">
                                            @foreach ($proyectos as $proyecto)
                                                <div class="col-12">
                                                    <div class="card card-sm">
                                                        <div class="card-body">
                                                            <div class="row align-items-center">
                                                                <div class="col-2">
                                                                    @if ($proyecto->url)
                                                                        <img src="{{ asset('storage/' . $proyecto->url) }}"
                                                                            alt="Food Deliver UI dashboards"
                                                                            class="rounded">
                                                                    @else
                                                                        <img src="{{ asset('/assets/img/image-default.jpg') }}"
                                                                            alt="Food Deliver UI dashboards"
                                                                            class="rounded height-min">
                                                                    @endif
                                                                </div>

                                                                <div class="col">
                                                                    <div class="font-weight-medium">
                                                                        <a href="{{route('diagramas.index', $proyecto->id)}}" title="ver diagramas">
                                                                            {{ $proyecto->nombre }}
                                                                        </a>
                                                                    </div>
                                                                    <div class="text-muted">
                                                                        {{ $proyecto->calificacion }}
                                                                    </div>
                                                                </div>

                                                                <div class="col-auto">
                                                                    <div class="btn-action">
                                                                        <button class="switch-icon switch-icon-fade"
                                                                            data-bs-toggle="switch-icon" title="Favorito"
                                                                            onclick="favorito({{ $proyecto->id }})">
                                                                            @if ($proyecto->favorito == 1)
                                                                                <span class="switch-icon-a text-red mt-1">
                                                                                    <i class="fa-solid fa-heart text-pink"></i>
                                                                                </span>
                                                                                <span class="switch-icon-b text-muted mt-1">
                                                                                    <i
                                                                                        class="fa-regular fa-heart text-pink"></i>
                                                                                </span>
                                                                            @else
                                                                                <span class="switch-icon-a text-red mt-1">
                                                                                    <i
                                                                                        class="fa-regular fa-heart text-pink"></i>
                                                                                </span>
                                                                                <span class="switch-icon-b text-muted mt-1">
                                                                                    <i class="fa-solid fa-heart text-pink"></i>
                                                                                </span>
                                                                            @endif
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="card mt-1">
                                            <div class="card-body pb-0">
                                                <div class="pagination">
                                                    {{ $proyectos->links() }}
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <h6>No tienes Proyectos Favoritos</h6>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    @push('scripts')
    <script>
        function favorito(proyecto_id) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('proyectos/favorito') }}",
                    data: {
                        id: proyecto_id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'JSON',
                    success: function() {
                    },
                });
            };
    </script>
    @endpush
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
@section('title', 'UML Software Home')
<x-app-layout>

</x-app-layout>
