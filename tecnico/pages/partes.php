<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Departamento Técnico - Aplicación de Oasis Park Fuerteventura</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../../vendor/bootstrap/css/custom.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <?php
        
        require_once "../../scripts/conexion/conectari.php";
        require_once "../../mpdf/mpdf.php";
    
        $mysqli = conectar();


        // SI HACEMOS CLICK EN ALTA2
        if (isset($_POST["alta2"])){
            $seleccionar = $_POST["seleccionar"];
            $fechaTrabajos = $_POST["fechaTrabajos"];
            $horaIni = $_POST["horaIni"];
            $horaFin = $_POST["horaFin"];
            $zona = $_POST["zona"];
            $descripcionTrabajos = $_POST["descripcionTrabajos"];
            $DNITrabajos = $_POST["DNITrabajos"];
            $nombreTrabajador = $_POST["nombreTrabajador"];
            $horasExtras = $_POST["horasExtras"];

            //Se describe la inserción de datos en SQL
            $sql = "INSERT INTO Trabajos (fechaTrabajos,horaIni,horaFin,zona,descripcionTrabajos,DNITrabajos,nombreTrabajador,horasExtras) VALUES ('$fechaTrabajos','$horaIni', '$horaFin', '$zona', '$descripcionTrabajos', '88888888R', '$nombreTrabajador',$horasExtras);";
            
            if ($mysqli->query($sql)) {
                echo "Se ha insertado con éxito";
            } else {
                echo "Error: " .$sql ."<br>" .$mysqli->error;
            }
        } // CIERRE IF ALTA2

        // SI HACEMOS CLICK EN GUARDAR
        if (isset($_POST["guardar"]) && (isset($_POST["seleccionar"]))) {
            $seleccionar = $_POST["seleccionar"];
            $DNI = $_POST["DNI"];
            $Foto = $_POST["Foto"];
            $nombreApellidos = $_POST["nombreApellidos"];
            $FechaIni = $_POST["FechaIni"];
            $FechaFin = $_POST["FechaFin"];
            $Observaciones = $_POST["Observaciones"];
            $tipoContrato = $_POST["tipoContrato"];
            $nombreDepartamentoTrabajador = $_POST["nombreDepartamentoTrabajador"];
                            
            for ($i=0;$i < count($DNI);$i++) {
                $Foto[$i] = test_input($Foto[$i]);
                $nombreApellidos[$i] = test_input($nombreApellidos[$i]);
                $FechaIni[$i] = test_input($FechaIni[$i]);
                $FechaFin[$i] = test_input($FechaFin[$i]);
                $Observaciones[$i] = test_input($Observaciones[$i]);
                $tipoContrato[$i] = test_input($tipoContrato[$i]);
                $nombreDepartamentoTrabajador[$i] = test_input($nombreDepartamentoTrabajador[$i]);
                  
                $j = 0;
                $sql = ""; 
                while ($j < count($seleccionar)) { 
                    if ($seleccionar[$j ++] == $DNI[$i]){
                        $sql = "UPDATE Trabajador SET DNI= '$DNI[$i]', Foto= '$Foto[$i]', nombreApellidos= '$nombreApellidos[$i]', FechaIni= '$FechaIni[$i]', FechaFin= '$FechaFin[$i]', 
                            Observaciones= '$Observaciones[$i]', tipoContrato= '$tipoContrato[$i]', nombreDepartamentoTrabajador= '$nombreDepartamentoTrabajador[$i]'   
                        WHERE DNI='$DNI[$i]'";
                        if ($mysqli->query($sql)){
                            echo "Registro " .$DNI[$i] ." modificado satisfactoriamente";
                        } else if (($sql != '') && (!$mysqli->query($sql))){
                            echo "Error: " .$mysqli->error;
                        }
                    }
                }
            }
        } // CIERRE IF GUARDAR

        // SI HACEMOS CLICK EN ELIMINAR
        if ((isset($_POST["eliminar"])) && (isset($_POST["seleccionar"]))) {
            
            $seleccionar = $_POST["seleccionar"];
            $DNI = $_POST["DNI"];
            $Foto = $_POST["Foto"];
            $nombreApellidos = $_POST["nombreApellidos"];
            $FechaIni = $_POST["FechaIni"];
            $FechaFin = $_POST["FechaFin"];
            $Observaciones = $_POST["Observaciones"];
            $tipoContrato = $_POST["tipoContrato"];
            $nombreDepartamentoTrabajador = $_POST["nombreDepartamentoTrabajador"];

            for ($i=0;$i < count($DNI);$i++) {
                $Foto[$i] = test_input($Foto[$i]);
                $nombreApellidos[$i] = test_input($nombreApellidos[$i]);
                $FechaIni[$i] = test_input($FechaIni[$i]);
                $FechaFin[$i] = test_input($FechaFin[$i]);
                $Observaciones[$i] = test_input($Observaciones[$i]);
                $tipoContrato[$i] = test_input($tipoContrato[$i]);
                $nombreDepartamentoTrabajador[$i] = test_input($nombreDepartamentoTrabajador[$i]);
                  
                $j = 0;
                $sql = "";                  
                while ($j < count($seleccionar)){
                    if ($seleccionar[$j ++] == $DNI[$i]){
                        $sql = "DELETE FROM Trabajador WHERE DNI='$DNI[$i]'";
                    }
                }  
                if ($sql!="" and (! $mysqli->query($sql)))
                    echo "Error: " . $mysqli->error;                
            }
        } // CIERRE IF ELIMINAR
    ?>
    <header>

        <nav class="navbar navbar-default navbar-fixed-top" style="background-color: #DCDCDC">
            <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="../index.php">Oasis Park</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-briefcase"></span> Empresas <span class="caret"></span></a>
                            <?php
                                $sql = "SELECT nombreEmpresa FROM Empresa";                       
                                $resultado = $mysqli -> query($sql);                        
                            ?>
                            <ul class="dropdown-menu">
                            <?php
                                while ($fila = $resultado -> fetch_assoc()){
                                echo '
                                <li><a href="#">'.$fila['nombreEmpresa'].'</a></li>
                                ';
                                }
                            ?>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-record"></span> Centros <span class="caret"></span></a>

                            <?php   
                                $sql = "SELECT nombreCentro FROM Centro";                       
                                $resultado = $mysqli -> query($sql);                        
                            ?>
                            <ul class="dropdown-menu">                                
                            <?php
                                while ($fila = $resultado -> fetch_assoc()){
                                echo '
                                <li><a href="#">'.$fila['nombreCentro'].'</a></li>
                                ';
                                }
                            ?>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-folder-open"></span> Departamentos <span class="caret"></span></a>

                            <?php
                                $sql = "SELECT nombreDepartamento FROM Departamento";                       
                                $resultado = $mysqli -> query($sql);                        
                            ?>
                            <ul class="dropdown-menu">
                            <?php
                                while ($fila = $resultado -> fetch_assoc()){
                                echo '
                                <li><a href="#">'.$fila['nombreDepartamento'].'</a></li>
                                ';
                                }
                            ?>
                            </ul>
                        </li>
                        <li><a href="#"><span class="glyphicon glyphicon-user"></span> Trabajadores</a></li>
                    </ul>
                    <form class="navbar-form navbar-left">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#">Link</a></li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                          </ul>
                        </li>
                      </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </header>

    <div class="jumbotron text-center">
        <h2>App Oasis Park</h2>
        <p>Departamento Técnico</p>
    </div>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <?php
                    // SI HACEMOS CLICK EN ALTA
                    if (isset($_POST["alta"])){
                        // FORMULARIO DE ALTA
                ?>
                        <div class="form-group">
                            <fieldset>
                                <legend><span>Alta de Trabajos realizados</span></legend>
                                <form class="form" method="POST" enctype="multipart/form-data"
                                 action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                                    <label for="fechaTrabajos">Fecha </label><a name="fechaTrabajos"></a> 
                                    <input class="form-control" tabindex="2" type="date" name="fechaTrabajos" placeholder="Fecha" required>

                                    <label for="horaIni">Hora Inicio </label><a name="horaIni"></a> 
                                    <input class="form-control" tabindex="2" type="time" name="horaIni" placeholder="Hora de Inicio">

                                    <label for="horaFin">Hora Fin </label><a name="horaFin"></a> 
                                    <input class="form-control" tabindex="2" type="time" name="horaFin" placeholder="Hora de Finalización" required>

                                    <label for="zona">Zona </label><a name="zona"></a>
                                    <input class="form-control" tabindex="1" type="text" name="zona" placeholder="Zona" required>

                                    <label for="descripcionTrabajos">Trabajo realizado </label><a name="descripcionTrabajos"></a>
                                    <input class="form-control" tabindex="1" type="text" name="descripcionTrabajos" placeholder="Trabajo realizado" required>

                                    <label for="nombreTrabajador">Nombre del Trabajador </label><a name="nombreTrabajador"></a>
                                    <input class="form-control" tabindex="1" type="text" name="nombreTrabajador" placeholder="Nombre del Trabajador" required>

                                    <label for="horasExtras">¿Horas Extras? </label><a name="horasExtras"></a>
                                    <input class="form-control" tabindex="1" type="number" name="horasExtras" placeholder="Nº de horas">

                                    <label for="alta2"></label><a name="alta2"></a>
                                    <button type="submit" name="alta2" class="btn btn-default"/>Alta</button>

                                </form> 

                            </fieldset>                     
                            
                        </div>

                <?php 
                    } // CIERRE IF ALTA
                            
                ?>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-12">
                <!-- FORMULARIO -->
                
                <div class="form-group">
                    <fieldset>

                    <?php 
                        // LANZAMOS LA CONSULTA DE TODOS LOS DATOS DE LA TABLA MANUALES
                        // PARA MOSTRARLOS EN EL FORMULARIO
                        
                        $sql = "SELECT DISTINCT * FROM Trabajos";                       
                        $resultado = $mysqli -> query($sql);                        
                    ?>
                        <legend><span>Alta, baja y modificación de Trabajos Realizados</span></legend> 

                        <form class="form" method="POST" enctype="multipart/form-data" 
                            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                            <table class="table-hover table-responsive table-striped">
                                <tr><td colspan="6">Dar de alta un nuevo Trabajo: </td></tr>
                                <tr><td colspan="6"><button type="submit" name="alta" class="btn btn-default" />Alta</button></td></tr>
                                <tr>
                                    <th>Seleccionar</th>
                                    <th>Fecha</th>
                                    <th>Hora Inicio</th>
                                    <th>Hora Fin</th>
                                    <th>Zona</th>
                                    <th>Descripción</th>
                                    <th>Trabajador</th>
                                    <th>Nº Horas Extras</th>
                                </tr>
                        <?php
                            while ($fila = $resultado -> fetch_assoc()){
                                echo '
                                <tr>
                                    <td><input type="checkbox" name="seleccionar[]" class="form-control" value="' .$fila['idTrabajo'] .'"/></td>
                                    <td><input type="date" name="fechaTrabajos[]" class="form-control" value="' .$fila['fechaTrabajos'] .'"></td>
                                    <td><input type="time" name="horaIni[]" class="form-control" value="' .$fila['horaIni'] .'"></td>
                                    <td><input type="time" name="horaFin[]" class="form-control" value="' .$fila['horaFin'] .'"></td>
                                    <td><input type="text" name="zona[]" class="form-control" value="' .$fila['zona'] .'"></td>
                                    <td><input type="text" name="descripcionTrabajos[]" class="form-control" value="' .$fila['descripcionTrabajos'] .'"></td>
                                    <td><input type="text" name="nombreTrabajador[]" class="form-control" value="' .$fila['nombreTrabajador'] .'"></td>
                                    <td><input type="number" name="horasExtras[]" class="form-control" value="' .$fila['horasExtras'] .'"></td>
                                </tr>';
                                
                            }
                            echo '<tr><td colspan="2"><button type="submit" name="guardar" class="btn btn-default"/>Modificar</button></td>';
                            echo '<td colspan="2"><button type="submit" name="eliminar" class="btn btn-default"/>Eliminar</button></td>';
                            echo '<td colspan="2"><button type="submit" class="btn btn-default" name="generar"/>Generar PDF</button></td>';
                            echo '<td><a href="../informes/clientes.php">
                                    <button type="submit" name="generarxml" class="btn btn-default"/>Generar XML</button>
                                </a></td></tr>';

                            
                            echo "</table>";
                            echo "</form>"
                        ?> 
                    
                    </fieldset>
                    <div id="error" class="" role="alert">
                    </div>
                </div>

            </div>
        </div>
        <!-- /.row -->
        </div>
        
    </div>
    <!-- /#page-wrapper -->
    
    <?php 
        $mysqli -> close();
    ?>

    <!-- jQuery -->
    <script src="../../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../../vendor/raphael/raphael.min.js"></script>
    <script src="../../vendor/morrisjs/morris.min.js"></script>
    <script src="../../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>

</body>

</html>
