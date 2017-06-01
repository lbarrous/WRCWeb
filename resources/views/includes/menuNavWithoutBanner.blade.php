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
<?php strpos(Request::url(), "/login") > -1 || strpos(Request::url(), "/register") > -1 || strpos(Request::url(), "/perfil") > -1 ? $class_usuario_activa = 'current' : $class_usuario_activa = ''?>

<!-- Nav -->
<nav id="nav">
    <ul>
        <li class="{{$class_home_activa}}"><a href="{{url("/home")}}">Home</a></li>
        <li class=""><a href="{{url("/home")}}">Rallys</a></li>
        <li class=""><a href="{{url("/home")}}">Pilotos</a></li>
        <li class=""><a href="{{url("/home")}}">Coches</a></li>
        <li class=""><a href="{{url("/home")}}">Resultados</a></li>
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