<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 24/05/2017
 * Time: 0:50
 */
?>


@extends('layouts.mainLayout')

@section('contenido')
    <div id="main-wrapper">
        <div id="main" class="container">
            <h2 class="major" style="margin: 0;"><span>Login de usuario</span></h2>
            <br>
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4">
                    @if(isset($msgError))
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                    <li style="text-align: center;"> {{ $msgError }} </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            {!! Form::open(['route' => 'login/user', 'class' => 'form']) !!}
                            <div class="form-group">
                                <label>Email</label>
                                {!! Form::email('email', '', ['class'=> 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                <label>Contraseña</label>
                                {!! Form::password('password', ['class'=> 'form-control']) !!}
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
