<!DOCTYPE html>
<html lang="es">

<head>

     <?php include 'temple/header.html' ?>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="mystyle.css">
    
</head>

<body>
    <!-- <div class="breadcrumb clearfix padding20-0 hidden-xs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <a href="https://ingenieria.uncuyo.edu.ar/"> Inicio </a>
                        <i class="fa fa-angle-right"></i> <a href="https://ingenieria.uncuyo.edu.ar/investigacion"> Investigación </a>
                        <i class="fa fa-angle-right"></i> <a href="//localhost/fing/productos.php"> Productos </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div> -->
    <div class="titular">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <h1 class="titular_titulo">Productos </h1>

                </div>
            </div>
        </div>
    </div>
    <p class="myalert" id="alert2" style="margin-bottom: 0px;">Las siguientes estaciones no se encuentran en nuestra base de datos:
        <?php
        if (!empty($_GET["error"])) {
            if ($_GET["error"] == 2) {
                echo $_GET["est"];
            };
        };
        ?>
        <span class="closebtn">&times;</span>
    </p>
    <script>
        document.getElementById("alert2").style.display = "none"
    </script>
    <p class="myalert" id="alert1" style="margin-bottom: 0px;">No hay datos de las estaciones seleccionadas en el periodo seleccionado
        <span class="closebtn">&times;</span>
    </p>
    <script>
        document.getElementById("alert1").style.display = "none"
    </script>
    <?php
        if (!empty($_GET["error"])) {
            if ($_GET["error"] == 1) {
        ?>
                <script>
                    document.getElementById("alert1").style.display = "block"
                </script>
            <?php
            };
            if ($_GET["error"] == 2) {
            ?>
                <script>
                    document.getElementById("alert2").style.display = "block"
                </script>
        <?php

            };
        };

    ?>
    <script>
        var close = document.getElementsByClassName("closebtn");
        var i;

        for (i = 0; i < close.length; i++) {
            close[i].onclick = function() {
                var div = this.parentElement;
                div.style.opacity = "0";
                setTimeout(function() {
                    div.style.display = "none";
                }, 600);
            }
        }
    </script>
    <div class="container" id="marco">
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Buscador </th>
                        </tr>
                    </thead>
                    <tbody>
                        <form class="row" novalidate method="POST" action="data.php" id="Search" >
                            <tr>
                                <td scope="row">
                                    <div class='col-md-6'>
                                        <div class="form-group">
                                            <label for="Fecha1" class="form-label">Desde:</label>
                                            <div class='input-group date' id='datetimepicker6'>
                                                <input type='text' class="form-control" onmousedown=checkFecha() onkeyup=checkFecha() onblur=checkFecha() name="Fecha1" placeholder="YYYY-MM-DD HH" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar" onmousedown=checkFecha()></span>
                                                </span>
                                            </div>
                                            <small style="color:#FF0000" ;></small>
                                        </div>
                                    </div>
                                    <div class='col-md-6 '>
                                        <div class="form-group">
                                            <label for="Fecha2" class="form-label">Hasta:</label>
                                            <div class='input-group date' id='datetimepicker7'>
                                                <input type='text' class="form-control" onmousedown=checkFecha() onkeyup=checkFecha() onblur=checkFecha() name="Fecha2" placeholder="YYYY-MM-DD HH" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar" onmousedown=checkFecha()></span>
                                                </span>
                                            </div>
                                            <small style="color:#FF0000" ;></small>
                                        </div>
                                    </div>
                                    <div class='col-md-12'>
                                        <div class="row">
                                            <div class="col-md-4" style="float:none;margin:auto;">
                                                <button type="button" class="btn btn-info " id="Estacionbutton" style="width: 115px;">Estación/es: </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8" style="float:none;margin:auto;">
                                                <div id="demo" class="collapse">
                                                    <div class="form-group" id="Estaciondiv">
                                                        <label for="Estaciondiv" class="form-label">Estación:</label>
                                                        <input class="form-control" type="text" onkeyup=checkEstacion() onmousedown=checkEstacion() onblur=checkEstacion() name="Estacion" placeholder="Ingrese la estación (AAAA) o estaciones (AAAA,BBBB,ect)">
                                                    </div>
                                                    <small style="color:#FF0000" ;></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4" style="float:none;margin:auto;">
                                                <button type="button" class="btn btn-info " id="Rangobutton" style="width: 115px;">Rango:</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div id="demo1" class="collapse">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Latitud:</label>
                                                        <div class='input-group date'>
                                                            <input class="form-control" type="text" onkeyup=checkLN() name="LN" placeholder="Desde [-90;90]">
                                                            <span class="input-group-addon">
                                                                <span class="input-group-text">N</span>
                                                            </span>
                                                        </div>
                                                        <small style="color:#FF0000" ;></small>
                                                    </div>
                                                    <div class="col-md-6 " style="margin-top: 5px;">
                                                        <label class="form-label"> </label>
                                                        <div class='input-group date'>
                                                            <input class="form-control" type="text" onkeyup=checkLS() name="LS" placeholder="Hasta [-90;90] ">
                                                            <span class="input-group-addon">
                                                                <span class="input-group-text">S</span>
                                                            </span>
                                                        </div>
                                                        <small style="color:#FF0000" ;></small>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Longitud:</label>
                                                        <div class='input-group date'>
                                                            <input class="form-control" type="text" onkeyup=checkLO() name="LO" placeholder="Desde  [-180;180]">
                                                            <span class="input-group-addon">
                                                                <span class="input-group-text">O</span>
                                                            </span>
                                                        </div>
                                                        <small style="color:#FF0000" ;></small>
                                                    </div>
                                                    <div class="col-md-6 " style="margin-top: 5px;">
                                                        <label class="form-label"> </label>
                                                        <div class='input-group date'>
                                                            <input class="form-control" type="text" onkeyup=checkLE() name="LE" placeholder="Hasta [-180;180]">
                                                            <span class="input-group-addon">
                                                                <span class="input-group-text">E</span>
                                                            </span>
                                                        </div>
                                                        <small style="color:#FF0000" ;></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script type="text/javascript" src="validation.js"></script>
                                </td>
                            </tr>
                            <tr>
                                <td scope="row">
                                    <div class="row"  style="float:none;margin:auto;">
                                        <div class='col-md-3' id="hh">
                                            <div class="form-group">
                                                <input type="checkbox" name="Presion" id="Presion" value="1">
                                                <label for="Presion">
                                                    Presión
                                                </label>
                                            </div>
                                        </div>
                                        <div class='col-md-4'>
                                            <div class="form-group">
                                                <input type="checkbox" value="1" name="Temperatura" id="Temperatura">
                                                <label for="Temperatura">
                                                    Temperatura
                                                </label>
                                            </div>
                                        </div>
                                        <div class='col-md-2'>
                                            <div class="form-group">
                                                <input type="checkbox" value="1" name="IWV" id="IWV">
                                                <label for="IWV">
                                                    IWV
                                                </label>
                                            </div>
                                        </div>
                                        <div class='col-md-3'>
                                            <div class="form-group">
                                                <input type="checkbox" value="1" name="ZTD" id="ZTD">
                                                <label for="ZTD">
                                                    ZTD
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <small style="color:#FF0000; float:none;margin:auto;"></small>
                                </td>
                            </tr>
                            <tr>
                                <td scope="row">
                                    <div class="d-grid">
                                        <input type="hidden" name="oculto" value="1">
                                        <input type="submit" class="btn btn-primary" value="Buscar">
                                    </div>
                                </td>
                            </tr>
                        </form>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col-8">Estaciones SIRGAS de operación continua</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row">
                                <?php include 'SIRGAS.html' ?>
                            </td>
                        </tr>
                        <tr>
                            <td scope="row">
                            <i style=" font-size: small"> Información de referencia proporcionada por SIRGAS Analysis Centre at DGFI-TUM (Deutsches Geodätisches Forschungsinstitut, Technische Universität München), <a href="https://www.sirgas.org/">https://www.sirgas.org/</a> </i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- <div class="row">
            <div class="col">
                <form class="row" method="POST" id="Gradicos">
                    <table class="table" style="margin: auto; width: 50%;">
                        <thead>
                            <tr>
                                <th scope="col">Gráficos </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="row">
                                    <div class="slideshow-container">

                                        <div class="mySlides myfade">
                                            <div class="numbertext">1 / 3</div>
                                            <img id="photo1" src="mapas/1794/1/1.jpg" style="width:100%">
                                            <div class="mytext">Caption Text</div>
                                        </div>

                                        <div class="mySlides myfade">
                                            <div class="numbertext">2 / 3</div>
                                            <img src="mapas/1794/1/2.jpg" style="width:100%">
                                            <div class="mytext">Caption Two</div>
                                        </div>

                                        <div class="mySlides myfade">
                                            <div class="numbertext">3 / 3</div>
                                            <img src="mapas/1794/1/3.jpg" style="width:100%">
                                            <div class="mytext">Caption Three</div>
                                        </div>

                                        <a class="myprev" onclick=plusSlides(-1)>&#10094;</a>
                                        <a class="mynext" onclick=plusSlides(1)>&#10095;</a>
                                        <script>
                                            var slideIndex = 1;
                                            showSlides(slideIndex);

                                            function plusSlides(n) {
                                                showSlides(slideIndex += n);
                                            }

                                            function showSlides(n) {
                                                var i;
                                                var slides = document.getElementsByClassName("mySlides");

                                                if (n > slides.length) {
                                                    slideIndex = 1
                                                }
                                                if (n < 1) {
                                                    slideIndex = slides.length
                                                }
                                                for (i = 0; i < slides.length; i++) {
                                                    slides[i].style.display = "none";
                                                }
                                                slides[slideIndex - 1].style.display = "block";

                                            }
                                        </script>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td scope="row">
                                    <div class="range-wrap">
                                        <label for="customRange2" class="form-label">Día de la semana</label>
                                        <input type="range" class="form-range" min="1" max="7" id="customRange2" name="customRange2" value="0">
                                        <output class="bubble"></output>
                                    </div>
                                </td>
                            </tr>
                            <script>
                                const allRanges = document.querySelectorAll(".range-wrap");
                                allRanges.forEach(wrap => {
                                    const range = wrap.querySelector(".form-range");
                                    const bubble = wrap.querySelector(".bubble");

                                    range.addEventListener("input", () => {
                                        setBubble(range, bubble);
                                    });
                                    setBubble(range, bubble);
                                });

                                function setBubble(range, bubble) {
                                    const val = range.value;
                                    const min = range.min ? range.min : 0;
                                    const max = range.max ? range.max : 100;
                                    const newVal = Number(((val - min) * 100) / (max - min));
                                    bubble.innerHTML = val;

                                    // Sorta magic numbers based on size of the native UI thumb
                                    bubble.style.left = `calc(${newVal}% + (${8 - newVal * 0.15}px))`;
                                }
                            </script>
                            <script type="text/javascript">
                                $('#customRange2').on('change', function() {
                                    $.ajax({
                                        type: "POST",
                                        url: 'imagenes.php',
                                        data: {
                                            customRange2: this.value
                                        },
                                        success: function(response) {
                                            var jsonData = JSON.parse(response);

                                            // user is logged in successfully in the back-end
                                            // let's redirect
                                            if (jsonData.success == "1") {
                                                alert('Invalid Credentials!');
                                            } else {
                                                alert('Invalid Credentials!');
                                            }
                                        }
                                    });
                                    var img = document.getElementById('photo1');
                                    img.src = "";
                                    img.src = "mapas/1794/1/1.jpg";
                                });
                            </script>
                        </tbody>
                    </table>
                </form>
            </div>
        </div> -->
    </div>

</body>

</html>