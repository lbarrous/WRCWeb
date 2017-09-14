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
            <h2 class="major" style="margin: 0;"><span>Lista de Coches</span></h2>
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

                    {{ Form::open(array('url' => 'nuevoCoche')) }}
                    <button style='float: right;' type="submit" id="add_pantalla_login" class="btn btn-md btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i> Nuevo Coche</button>
                    {{ Form::close() }}

                </div>

            </div>
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-12">
                    @if (isset($datos['coches']) && count($datos['coches']) > 0 )
                        <table id="pretabla" class="display responsive dtr-inline" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <!--<th>codPiloto</th>-->
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Cilindrada</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>


                            @foreach ($datos['coches'] as $coche)

                                <tr id="{{$coche->codCoche}}">

                                <!--<td>{{$coche->codCoche}}</td>-->
                                    <td>{{$coche->marca}}</td>
                                    <td>{{$coche->modelo}}</td>
                                    <td>{{$coche->cilindrada}}</td>

                                    <td width="15%" style="text-align: center;">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Opciones
                                                <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li style="cursor: pointer; font-size: 1.20em;"><a href="{{url("/editaCoche/".$coche->codCoche)}}"><i style='color: black;' class="icono_editar fa fa-pencil lapiz_plantilla" aria-hidden="true"></i> Editar Coche</a></li>
                                                <li style="cursor: pointer; font-size: 1.20em;"><a onclick="eliminarCoche('{{$coche->codCoche}}');"><i style='color: black;' class="icono_eliminar fa fa-trash papelera_plantilla" aria-hidden="true"></i> Eliminar Coche</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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