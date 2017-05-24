<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 24/05/2017
 * Time: 11:43
 */

?>

@extends('layouts.mainLayout')

@section('head-plus')

    <!-- Bootstrap Date-Picker Plugin -->
    <script type="text/javascript" src="{{ url('/assets/js/bootstrap-datepicker.min.js') }}"></script>
    <link rel="stylesheet" href="{{ url('/assets/css/bootstrap-datepicker3.min.css') }}"/>

    <script>
        $(document).ready(function(){
            var date_input=$('input[name="birth"]');
            var options={
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                autoclose: true,
            };
            date_input.datepicker(options);

            $(".datepicker").attr("autocomplete", "off");
        })
    </script>
@endsection

@section('contenido')
    <div id="main-wrapper">

        <div id="main" class="container">
            <h2 class="major" style="margin: 0;"><span>Perfil de usuario</span></h2>
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
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">Información del perfil</div>

                        <div class="panel-body">
                            {!! Form::open(['route' => 'perfil/actualizar', 'class' => 'form']) !!}

                            <div class="form-group">
                                <label>Nombre</label>
                                {!! Form::input('text', 'name', isset($datos['usuario']->name)?$datos['usuario']->name:'', ['class'=> 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                {!! Form::email('email', isset($datos['usuario']->email)?$datos['usuario']->email:'', ['class'=> 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                <label>Fecha de nacimiento</label>
                                <input class="form-control datepicker" id="birth" name="birth" type="text" autocomplete="off" value="{{isset($datos['usuario']->birth)?date('d-m-Y', strtotime($datos['usuario']->birth)):''}}"/>
                            </div>

                            <div>
                                {!! Form::submit('Enviar',['class' => 'btn btn-primary']) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection