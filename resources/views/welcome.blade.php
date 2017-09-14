@extends('layouts.mainLayout')

@section('contenido')
    <div id="main-wrapper"><br>
        <div class="container">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active">
                        <img src="https://image.redbull.com/rbcom/010/2015-12-04/1331763514926_2/0010/1/1500/1000/1/los-volkswagen-world-rally-car-dirt-rally-videojuego.jpg" alt="Los Angeles" style="width:100%;">
                    </div>

                    <div class="item">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/60/Chris_Atkinson_-_2008_Rally_d%27Italia_Sardegna.jpg/1200px-Chris_Atkinson_-_2008_Rally_d%27Italia_Sardegna.jpg" alt="Chicago" style="width:100%;">
                    </div>

                    <div class="item">
                        <img src="http://www.wrc.com/images//Calendar/2016/12_GB/9988_Wales-MSport-Ostberg-2016_2_896x504.jpg?1477579546" alt="New york" style="width:100%;">
                    </div>
                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
@endsection
