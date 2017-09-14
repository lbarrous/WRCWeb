<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 19/05/2017
 * Time: 18:07
 */
?>

<!-- Header -->

<header id="header">
    <div class="logo container">
        <div>
            <h1><a href="index.html" id="logo">Rally UHU</a></h1>
            <p>Los últimos resultados del mundo del Rally</p>
        </div>
    </div>
</header>

<?php strpos(Request::url(), "/home") > -1 ? $class_home_activa = 'current' : $class_home_activa = ''?>
<?php strpos(Request::url(), "/listaRallies") > -1 ? $class_rally_activa = 'current' : $class_rally_activa = ''?>
<?php strpos(Request::url(), "/listaPilotos") > -1 ? $class_piloto_activa = 'current' : $class_piloto_activa = ''?>
<?php strpos(Request::url(), "/listaCoches") > -1 ? $class_coche_activa = 'current' : $class_coche_activa = ''?>
<?php strpos(Request::url(), "/listaResultados") > -1 ? $class_resultado_activa = 'current' : $class_resultado_activa = ''?>
<?php strpos(Request::url(), "/listaTiempos") > -1 ? $class_tiempo_activa = 'current' : $class_tiempo_activa = ''?>
<?php strpos(Request::url(), "/login") > -1 || strpos(Request::url(), "/register") > -1 || strpos(Request::url(), "/perfil") > -1 ? $class_usuario_activa = 'current' : $class_usuario_activa = ''?>

<!-- Nav -->
<nav id="nav">
    <ul>
        <li class="{{$class_home_activa}}"><a href="{{url("/home")}}">Home</a></li>
        <li class="{{$class_rally_activa}}"><a href="{{url("/listaRallies")}}">Rallys</a></li>
        <li class="{{$class_piloto_activa}}"><a href="{{url("/listaPilotos")}}">Pilotos</a></li>
        <li class="{{$class_coche_activa}}"><a href="{{url("/listaCoches")}}">Coches</a></li>
        <li class="{{$class_resultado_activa}}"><a href="{{url("/listaResultados")}}">Resultados</a></li>
        <li class="{{$class_tiempo_activa}}"><a href="{{url("/listaTiempos")}}">Tiempos</a></li>
        @if (Auth::guest())
            <li class="{{$class_usuario_activa}}">
                <a>Usuario</a>
                <ul>
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Registro</a></li>
                </ul>
            </li>
        @else
            <li class="{{$class_usuario_activa}}">
                <a href="#">{{ Auth::user()->name }}</a>
                <ul>
                    <li><a href="{{ url('/perfil') }}">Perfil</a></li>
                    <li><a href="{{ url('/logout') }}">Logout</a></li>
                </ul>
            </li>
        @endif
    </ul>
</nav>