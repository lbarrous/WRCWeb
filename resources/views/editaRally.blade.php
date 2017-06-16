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

    <script>
        $(document).ready(function(){
            var date_input=$('input[name="fecha"]');
            var options={
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                autoclose: true,
            };
            date_input.datepicker(options);

            $(".datepicker").attr("autocomplete", "off");

            //populateCountries("paises");
        })
    </script>
@endsection

@section('contenido')
    <div id="main-wrapper">

        <div id="main" class="container">
            <h2 class="major" style="margin: 0;"><span>Edición de Rally</span></h2>
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

            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">

                        <div class="panel-body">
                            {!! Form::open(['id' => 'formRally', 'route' => 'saveCambiosRally', 'class' => 'form']) !!}
                            <?php isset($datos["rally"]->codRally) ? $codRally = $datos["rally"]->codRally : $codRally = ''?>
                                    <input id="codRally" name="codRally" style="display: none;" value="{{$codRally}}">
                                    <div class="form-group">
                                        <label>Nombre del Rally</label>
                                        {!! Form::input('text', 'nombre', isset($datos["rally"]) ? $datos["rally"]->nombre : '', ['class'=> 'form-control']) !!}
                                    </div>

                                    <!--<div class="form-group">
                                        <label>Pais de celebración</label>
                                        <select id="paises" name ="paises"></select>
                                    </div>-->

                                    <div class="form-group">
                                        <label>Pais</label>
                                        {!! Form::input('text', 'pais', isset($datos["rally"]) ? $datos["rally"]->pais : '', ['class'=> 'form-control']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label>Fecha del evento</label>
                                        <input class="form-control datepicker" id="fecha" name="fecha" type="text" autocomplete="off" value="{{isset($datos['rally']->fecha)?date('d-m-Y', strtotime($datos['rally']->fecha)):''}}"/>
                                    </div>

                            <div class="row" style="margin: auto;">
                                <div class="cold-md-6"><input onclick="postCambiosRally();" class="btn btn-info" type="button" value="Enviar"></div>

                                <div class="cold-md-6"><input style="background-color: #D01439" onclick="window.location.href = '{{url("listaRallies")}}'" class="btn btn-info" type="button" value="Atras"></div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection