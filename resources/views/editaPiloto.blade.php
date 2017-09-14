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
    <script type="text/javascript" src="{{ url('/assets/js/bootstrap-dialog.js') }}"></script>
    <link rel="stylesheet" href="{{ url('/assets/css/bootstrap-datepicker3.min.css') }}"/>
    <link rel="stylesheet" href="{{ url('/assets/css/bootstrap-dialog.css') }}"/>

@endsection

@section('contenido')
    <div id="main-wrapper">

        <div id="main" class="container">
            <h2 class="major" style="margin: 0;"><span>Edición de Piloto</span></h2>
            <br>
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
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">

                        <div class="panel-body">
                            {!! Form::open(['id' => 'formPiloto', 'route' => 'saveCambiosPiloto', 'class' => 'form']) !!}
                            <?php isset($datos["piloto"]->codPiloto) ? $codPiloto = $datos["piloto"]->codPiloto : $codPiloto = ''?>
                                    <input id="codPiloto" name="codPiloto" style="display: none;" value="{{$codPiloto}}">
                                    <div class="form-group">
                                        <label>Nombre del Piloto</label>
                                        {!! Form::input('text', 'nombre', isset($datos["piloto"]) ? $datos["piloto"]->nombreP : '', ['class'=> 'form-control']) !!}
                                    </div>

                                    <!--<div class="form-group">
                                        <label>Pais de celebración</label>
                                        <select id="paises" name ="paises"></select>
                                    </div>-->

                                    <div class="form-group">
                                        <label>Grupo Sanguíneo</label>
                                        <select class="form-control" id="grupoS" name="grupoS">
                                            <option <?php isset($datos["piloto"]) && $datos["piloto"]->grupoS == "0" ? 'selected="selected"' : ''?> value="0">0</option>
                                            <option <?php isset($datos["piloto"]) && $datos["piloto"]->grupoS == "A" ? 'selected="selected"' : ''?> value="A">A</option>
                                            <option <?php isset($datos["piloto"]) && $datos["piloto"]->grupoS == "B" ? 'selected="selected"' : ''?> value="B">B</option>
                                            <option <?php isset($datos["piloto"]) && $datos["piloto"]->grupoS == "AB" ? 'selected="selected"' : ''?> value="AB">AB</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>RH</label>
                                        <select class="form-control" id="rh" name="rh">
                                            <option <?php isset($datos["piloto"]) && $datos["piloto"]->rh == "+" ? 'selected="selected"' : ''?> value="+">+</option>
                                            <option <?php isset($datos["piloto"]) && $datos["piloto"]->rh == "-" ? 'selected="selected"' : ''?> value="-">-</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Nombre del Copiloto</label>
                                        {!! Form::input('text', 'nombreCop', isset($datos["piloto"]) ? $datos["piloto"]->nombreCop : '', ['class'=> 'form-control']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label>Coche</label>
                                        <select class="form-control" id="coche" name="coche">
                                            @if(isset($datos["piloto"]->coche) && $datos["piloto"]->coche != null && $datos["piloto"]->coche != "")
                                                <option value="{{$datos["piloto"]->coche}}">{{$datos["piloto"]->marca." ".$datos["piloto"]->modelo}}</option>
                                            @endif
                                            @if(isset($datos))
                                            @foreach($datos["coches_libres"] as $coche)
                                                <option value="{{$coche->codCoche}}">{{$coche->marca." ".$coche->modelo}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>


                            <div class="row" style="margin: auto;">
                                <div class="cold-md-6"><input onclick="postCambiosPiloto();" class="btn btn-info" type="button" value="Enviar"></div>

                                <div class="cold-md-6"><input style="background-color: #D01439" onclick="window.location.href = '{{url("listaPilotos")}}'" class="btn btn-info" type="button" value="Atras"></div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection