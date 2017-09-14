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
            <h2 class="major" style="margin: 0;"><span>Nuevo Resultado</span></h2>
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
                            {!! Form::open(['id' => 'formResultado', 'route' => 'saveCambiosResultados', 'class' => 'form']) !!}
                            <div class="form-group">
                                <label>Rally</label>
                                <select class="form-control" id="rally" name="rally">
                                    @foreach($datos["rallies"] as $rally)
                                        <option value="{{$rally->codRally}}">{{$rally->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Piloto</label>
                                <select class="form-control" id="piloto" name="piloto">
                                    @foreach($datos["pilotos"] as $piloto)
                                        <option value="{{$piloto->codPiloto}}">{{$piloto->nombreP}}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group">
                                <label>Posicion</label>
                                {!! Form::input('text', 'posicion', '', ['class'=> 'form-control']) !!}
                            </div>


                            <div class="row" style="margin: auto;">
                                <div class="cold-md-6"><input onclick="postCambiosResultado();" class="btn btn-info" type="button" value="Enviar"></div>

                                <div class="cold-md-6"><input style="background-color: #D01439" onclick="window.location.href = '{{url("listaResultados")}}'" class="btn btn-info" type="button" value="Atras"></div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection