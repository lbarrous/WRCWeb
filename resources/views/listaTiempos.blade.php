<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 23/05/2017
 * Time: 1:38
 */

?>

@extends('layouts.mainLayout')

@section('head-plus')

    <!-- Bootstrap Date-Picker Plugin -->
    <script type="text/javascript" src="{{ url('/assets/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('/assets/js/countries.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" href="{{ url('/assets/css/bootstrap-datepicker3.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.css">

    <script type="text/javascript" src="{{ url('/assets/js/bootstrap-dialog.js') }}"></script>
    <link rel="stylesheet" href="{{ url('/assets/css/bootstrap-dialog.css') }}"/>

    <script>

        $(document).ready(function(){

            var opcionesdatatable = <?php echo $datos['opcionesDatatable']; ?>;
                    @foreach($datos["pilotos"] as $pilotocod)
            var dataTableGlobalObj{{$pilotocod}} = $('#{{$pilotocod}}').DataTable(opcionesdatatable);
            @endforeach
        })
    </script>
@endsection

@section('contenido')
    <div id="main-wrapper">

        <div id="main" class="container">
            <h2 class="major" style="margin: 0;"><span>Lista de Tiempos</span></h2>
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4">
                    @if(isset($msgsErroresValidator))
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                @foreach($msgsErroresValidator as $item)
                                    <li style="text-align: center;"> {{ $item }} </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">

                <div class="col-lg-12">

                    @if (!Auth::guest())
                    {{ Form::open(array('url' => 'nuevoTiempo')) }}
                    <button style='float: right;' type="submit" id="add_pantalla_login" class="btn btn-md btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i> Nuevo Tiempo</button>
                    {{ Form::close() }}
                        @endif

                </div>

            </div>
            {{ csrf_field() }}

            @if (isset($datos['tiempos']) && count($datos['tiempos']) > 0 )

                @foreach($datos['tiempos'] as $piloto)
                    <div class="row">
                        <div class="col-md-12">
                            <h4>{{$piloto["nombre"]}}</h4>
                            <table id="{{$piloto["codPiloto"]}}" class="table table-striped">
                                <thead>
                                <tr>
                                    <!--<th>codPiloto</th>-->
                                    <th>Tramo</th>
                                    <th>Tiempo</th>
                                    <th>Dificultad</th>
                                    <th>Kilometros totales</th>
                                    @if (!Auth::guest())
                                    <th></th>
                                        @endif
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($piloto["tiempos"] as $tiempo)

                                    <tr id="{{$tiempo->codPiloto}}{{$tiempo->codTramo}}">
                                        <td>{{$tiempo->codTramo}}</td>
                                        <td>{{$tiempo->tiempo}}</td>
                                        <td>{{$tiempo->dificultad}}</td>
                                        <td>{{$tiempo->totalKms}}</td>

                                        @if (!Auth::guest())
                                        <td width="15%" style="text-align: center;">
                                            <div class="dropdown">
                                                <button onclick="eliminarTiempo('{{$tiempo->codPiloto}}','{{$tiempo->codTramo}}');" class="btn btn-danger" type="button">Eliminar</button>

                                            </div>
                                        </td>
                                            @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach




            @else

                <div class="row">
                    <div class="col-lg-12">
                        <div id="contenedor_alertas" class="panel panel-default">
                            <br/>
                            <div class="alert alert-warning" role="alert">No hay Tiempos almacenados</div>
                        </div>
                    </div>
                </div>

            @endif
        </div>
    </div>
    </div>
    </div>

@endsection