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
            var dataTableGlobalObj = $('#pretabla').DataTable(opcionesdatatable);
        })
    </script>
@endsection

@section('contenido')
    <div id="main-wrapper">

        <div id="main" class="container">
            <h2 class="major" style="margin: 0;"><span>Lista de Pilotos</span></h2>
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
                    {{ Form::open(array('url' => 'nuevoPiloto')) }}
                    <button style='float: right;' type="submit" id="add_pantalla_login" class="btn btn-md btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i> Nuevo Piloto</button>
                    {{ Form::close() }}
                        @endif

                </div>

            </div>
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-12">
                    @if (isset($datos['pilotos']) && count($datos['pilotos']) > 0 )
                        <table id="pretabla" class="display responsive dtr-inline" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <!--<th>codPiloto</th>-->
                                <th>Nombre</th>
                                <th>Grupo Sanguíneo</th>
                                <th>RH</th>
                                <th>Copiloto</th>
                                <th>Coche</th>
                                @if (!Auth::guest())
                                <th>Opciones</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>


                            @foreach ($datos['pilotos'] as $piloto)

                                <tr id="{{$piloto->codPiloto}}">

                                    <!--<td>{{$piloto->codPiloto}}</td>-->
                                    <td>{{$piloto->nombreP}}</td>
                                    <td>{{$piloto->grupoS}}</td>
                                    <td>{{$piloto->rh}}</td>
                                    <td>{{$piloto->nombreCop}}</td>
                                    <td><a onclick="verCochePiloto('{{$piloto->coche}}');">Coche</a></td>

                                        @if (!Auth::guest())
                                    <td width="15%" style="text-align: center;">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Opciones
                                                <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li style="cursor: pointer; font-size: 1.20em;"><a href="{{url("/editaPiloto/".$piloto->codPiloto)}}"><i style='color: black;' class="icono_editar fa fa-pencil lapiz_plantilla" aria-hidden="true"></i> Editar Piloto</a></li>
                                                <li style="cursor: pointer; font-size: 1.20em;"><a onclick="eliminarPiloto('{{$piloto->codPiloto}}');"><i style='color: black;' class="icono_eliminar fa fa-trash papelera_plantilla" aria-hidden="true"></i> Eliminar Piloto</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                            @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else

                        <div class="row">
                            <div class="col-lg-12">
                                <div id="contenedor_alertas" class="panel panel-default">
                                    <br/>
                                    <div class="alert alert-warning" role="alert">No hay Pilotos almacenados</div>
                                </div>
                            </div>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection