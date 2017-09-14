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
                    @foreach($datos["rallies"] as $rallycod)
                    var dataTableGlobalObj{{$rallycod}} = $('#{{$rallycod}}').DataTable(opcionesdatatable);
                    @endforeach
        })
    </script>
@endsection

@section('contenido')
    <div id="main-wrapper">

        <div id="main" class="container">
            <h2 class="major" style="margin: 0;"><span>Lista de Resultados</span></h2>
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
                    {{ Form::open(array('url' => 'nuevoResultado')) }}
                    <button style='float: right;' type="submit" id="add_pantalla_login" class="btn btn-md btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i> Nuevo Resultado</button>
                    {{ Form::close() }}
                        @endif

                </div>

            </div>
            {{ csrf_field() }}

                    @if (isset($datos['resultados']) && count($datos['resultados']) > 0 )
                        @foreach($datos['resultados'] as $rally)
                    <div class="row">
                        <div class="col-md-12">
                            <h4>{{$rally["nombre_rally"]}}</h4>
                            <table id="{{$rally["codRally"]}}" class="table table-striped">
                                <thead>
                                <tr>
                                    <!--<th>codPiloto</th>-->
                                    <th>Piloto</th>
                                    <th>Posicion</th>
                                    @if (!Auth::guest())
                                    <th></th>
                                        @endif
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($rally["posiciones"][0] as $posicion)

                                    <tr id="{{$rally["codRally"]}}{{$posicion->codPiloto}}">
                                        <td>{{$posicion->nombreP}}</td>
                                        <td>{{$posicion->posicion}}</td>

                                        @if (!Auth::guest())
                                        <td width="15%" style="text-align: center;">
                                            <div class="dropdown">
                                                <button onclick="eliminarResultado('{{$rally["codRally"]}}','{{$posicion->codPiloto}}');" class="btn btn-danger" type="button">Eliminar</button>

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
                                    <div class="alert alert-warning" role="alert">No hay Coches almacenados</div>
                                </div>
                            </div>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection