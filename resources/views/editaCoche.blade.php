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
            <h2 class="major" style="margin: 0;"><span>Edición de Coche</span></h2>
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
                            {!! Form::open(['id' => 'formCoche', 'route' => 'saveCambiosCoche', 'class' => 'form']) !!}
                            <?php isset($datos["coche"]->codCoche) ? $codCoche = $datos["coche"]->codCoche : $codCoche = ''?>
                            <input id="codCoche" name="codCoche" style="display: none;" value="{{$codCoche}}">
                            <div class="form-group">
                                <label>Marca del coche</label>
                                {!! Form::input('text', 'marca', isset($datos["coche"]) ? $datos["coche"]->marca : '', ['class'=> 'form-control']) !!}
                            </div>


                            <div class="form-group">
                                <label>Modelo del coche</label>
                                {!! Form::input('text', 'modelo', isset($datos["coche"]) ? $datos["coche"]->modelo : '', ['class'=> 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                <label>Cilindrada</label>
                                {!! Form::input('text', 'modelo', isset($datos["coche"]) ? $datos["coche"]->cilindrada : '', ['class'=> 'form-control']) !!}
                            </div>


                            <div class="row" style="margin: auto;">
                                <div class="cold-md-6"><input onclick="postCambiosCoche();" class="btn btn-info" type="button" value="Enviar"></div>

                                <div class="cold-md-6"><input style="background-color: #D01439" onclick="window.location.href = '{{url("listaCoches")}}'" class="btn btn-info" type="button" value="Atras"></div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection