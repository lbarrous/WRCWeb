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

<!-- Nav -->
<nav id="nav">
    <ul>
        <li class="current"><a href="index.html">Home</a></li>
        @if (Auth::guest())
            <li>
                <a href="#">Usuario</a>
                <ul>
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Registro</a></li>
                </ul>
            </li>
        @else
            <li>
                <a href="#">{{ Auth::user()->name }}</a>
                <ul>
                    <li><a href="{{ url('/perfil') }}">Perfil</a></li>
                    <li><a href="{{ url('/logout') }}">Logout</a></li>
                </ul>
            </li>
        @endif
    </ul>
</nav>

<!-- Banner -->
<div id="banner-wrapper">

</div>