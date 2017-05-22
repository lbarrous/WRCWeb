<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 19/05/2017
 * Time: 18:02
 */
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Cabecera -->
    @include('includes.head')


    @yield('head-plus')


</head>

<body class="homepage">

<div id="page-wrapper">
    <!-- Menu -->
    @include('includes.menuNav')
        <!-- Contenido -->
        @yield('contenido')


</div>


</body>


</html>
