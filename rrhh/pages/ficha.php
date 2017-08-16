<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Listado de Trabajadores - Aplicación de Oasis Park Fuerteventura</title>

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
        require_once "../../scripts/functions.php";
    
        $mysqli = conectar();

        // SI HACEMOS CLICK EN ALTA2
        if (isset($_POST["alta2"])){
            $idAusencia = $_POST["idAusencia"];
            $fechaAusencia = $_POST["fechaAusencia"];
            $tipoAusencia = $_POST["tipoAusencia"];
            $descripcion = $_POST["descripcion"];
            $DNIAusencia = $_POST["DNIAusencia"];

            //Se describe la inserción de datos en SQL
            $sql = "INSERT INTO Ausencia (fechaAusencia, tipoAusencia, descripcion, DNIAusencia) VALUES ('$fechaAusencia','$tipoAusencia', '$descripcion', '$DNIAusencia');";
            
            if ($mysqli->query($sql)) {
                echo "Se ha insertado con éxito";
            } else {
                echo "Error: " .$sql ."<br>" .$mysqli->error;
            }
        } // CIERRE IF ALTA2
                // SI HACEMOS CLICK EN GUARDAR
        if (isset($_POST["guardar"])) {
            echo 'He pulsado guardar';
            $Foto = $_POST["Foto"];
            $nombreApellidos = $_POST["nombreApellidos"];
            $DNI = $_POST["DNI"];
            $FechaIni = $_POST["FechaIni"];
            $FechaFin = $_POST["FechaFin"];
            $tipoContrato = $_POST["tipoContrato"];
            $Observaciones = $_POST["Observaciones"];
 
            $sql = "UPDATE Trabajador SET Foto= '$Foto', nombreApellidos= '$nombreApellidos', FechaIni= '$FechaIni', FechaFin= '$FechaFin', 
                Observaciones= '$Observaciones', tipoContrato= '$tipoContrato'   
            WHERE DNI='$DNI'";
            if ($mysqli->query($sql)){
                echo "Registro " .$DNI ." modificado satisfactoriamente";
                echo '<script type="text/javascript">window.location="trabajadores.php";</script>';
            } else if (($sql != '') && (!$mysqli->query($sql))){
                echo "Error: " .$mysqli->error;
            }
                    
                
            
        } // CIERRE IF GUARDAR

        // SI HACEMOS CLICK EN ELIMINAR
        if (isset($_POST["eliminar"])) {
            $DNI = $_POST["DNI"];    
            
            $sql = "DELETE FROM Trabajador WHERE DNI='$DNI'";
            echo '<script type="text/javascript">window.location="trabajadores.php";</script>';  
                
            if ($sql!="" and (! $mysqli->query($sql)))
                echo "Error: " . $mysqli->error;                                    
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
                    <a class="navbar-brand" href="../index.php">APP Oasis Park</a>
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
                        <li><a href="trabajadores.php"><span class="glyphicon glyphicon-user"></span> Trabajadores</a></li>
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

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="jumbotron text-center">
                    <h2>App Vacaciones Oasis Park</h2>
                    <p>Listado de Trabajadores</p>
                </div>
            </div>
        </div>

        <div class="row">

        <?php
            // SI HACEMOS CLICK EN ALTA
            if (isset($_POST["alta"])){
                // FORMULARIO DE ALTA
                $url = 'ficha.php?trabajador='.$_GET['trabajador'];
        ?>
                <div class="form-group">
                    <fieldset>
                        <legend><span>Alta de Ausencias</span></legend>
                        <form class="form" method="POST" enctype="multipart/form-data"
                         action="<?php echo htmlspecialchars($url);?>">
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                    <label for="fechaAusencia">Fecha de la Ausencia </label><a name="fechaAusencia"></a> 
                                    <input class="form-control" tabindex="2" type="date" name="fechaAusencia" placeholder="Fecha" required>
                                
                                
                                    <label for="tipoAusencia">Tipo </label><a name="tipoAusencia"></a> 
                                    <input class="form-control" tabindex="2" type="text" name="tipoAusencia" placeholder="Baja, permiso, vacaciones o absentismo" required>
                                
                                
                                    <label for="descripcion">Descripción </label><a name="descripcion"></a> 
                                    <input class="form-control" tabindex="2" type="text" name="descripcion" placeholder="Descripción">
                                
                                
                                    <label for="DNIAusencia">DNI del trabajador </label><a name="DNIAusencia"></a>
                                    <input class="form-control" tabindex="1" type="text" name="DNIAusencia" placeholder="DNI del trabajador" required>

                                    <label for="alta2"></label><a name="alta2"></a>
                                    <button type="submit" name="alta2" class="btn btn-default"/>Alta</button>
                                
                            </div>
                            <div class="col-md-4"></div>
                        </div>

                        </form> 

                    </fieldset>                     
                    
                </div>

        <?php 
            } // CIERRE IF ALTA
                    
        ?>
    </div>
            <!-- FORMULARIO --> 
            <div class="col-lg-12">                  
                <div class="form-group">
                    <fieldset>

                    <?php 
                        // LANZAMOS LA CONSULTA DE TODOS LOS DATOS DE LA TABLA MANUALES
                        // PARA MOSTRARLOS EN EL FORMULARIO

                        $trabajador = $_GET['trabajador'];
                        $url = 'ficha.php?trabajador='.$trabajador;
                        $sql = "SELECT DISTINCT * FROM Trabajador WHERE nombreApellidos = '$trabajador'";                       
                        $resultado = $mysqli -> query($sql);                        
                    ?>
                        <legend><span>Trabajadores ordenados por Departamento</span></legend> 

                        <form class="form" method="POST" enctype="multipart/form-data" 
                            action="<?php echo htmlspecialchars($url);?>">
                            <table class="table table-responsive table-hover table-striped table-bordered">
                                <tr>
                                    <th class="text-center">Foto</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">DNI</th>
                                    <th class="text-center">Inicio del Contrato</th>
                                    <th class="text-center">Fin del Contrato</th>
                                    <th class="text-center">Tipo de Contrato</th>
                                    <th class="text-center">Observaciones</th>
                                    <th class="text-center">Vacaciones pendientes</th>
                                    <th class="text-center"  colspan="4">Días de Ausencia</th>
                                </tr>
                        <?php
                            $i = 0;
                            while ($fila = $resultado -> fetch_assoc()){
                                $vacas=$fila['DNI'];
                                $sql2 = "SELECT DISTINCT 
                                    (SELECT vacaciones FROM Trabajador WHERE DNI = '$vacas') as total, 
                                    ((SELECT vacaciones FROM Trabajador WHERE DNI = '$vacas') - count(idAusencia)) as dias from Ausencia where DNIAusencia = '$vacas' AND tipoAusencia = 'vacaciones'";
                                $resultado2 = 0;
                                $resultado2 = $mysqli -> query($sql2);
                                $pendientes = $resultado2 -> fetch_assoc();
                                $sql3 = "SELECT DISTINCT (fechaAusencia) AS aus FROM Ausencia WHERE DNIAusencia = '$vacas' AND tipoAusencia = 'vacaciones' AND fechaAusencia = CURDATE()";
                                $resultado3 = 0;
                                $resultado3 = $mysqli -> query($sql3);
                                $estadoVacaciones = $resultado3 -> fetch_assoc();
                                $sql4 ="SELECT 
                                    (SELECT count(idAusencia) FROM Ausencia WHERE tipoAusencia = 'vacaciones' AND DNIAusencia = '$vacas') as vacaciones, 
                                    (SELECT count(idAusencia) FROM Ausencia WHERE tipoAusencia = 'baja' AND DNIAusencia = '$vacas') as bajas, 
                                    (SELECT count(idAusencia) FROM Ausencia WHERE tipoAusencia = 'permiso' AND DNIAusencia = '$vacas') as permisos, 
                                    (SELECT count(idAusencia) FROM Ausencia WHERE tipoAusencia = 'absentismo' AND DNIAusencia = '$vacas') as injustificadas FROM Ausencia";
                                $resultado4 = $mysqli -> query($sql4);
                                $TipoAusencia = $resultado4 -> fetch_assoc();

                                echo '
                                <tr>
                                    <td class="text-center"><input type="file" name="Foto" class="form-control" value="' .$fila['Foto'] .'"></td>
                                    <td class="vacaciones text-center"><input type="text" name="nombreApellidos" class="form-control" value="' .$fila['nombreApellidos'] .'"></td>
                                    <td class="text-center"><input type="text" name="DNI" class="form-control" value="' .$fila['DNI'] .'" readonly></td>
                                    <td class="text-center"><input type="date" name="FechaIni" class="form-control" value="' .$fila['FechaIni'] .'"></td>
                                    <td class="text-center"><input type="date" name="FechaFin" class="form-control" value="' .$fila['FechaFin'] .'"></td>
                                    <td class="text-center"><input type="text" name="tipoContrato" class="form-control" value="' .$fila['tipoContrato'] .'"></td>
                                    <td class="text-center"><input type="text" name="Observaciones" class="form-control" value="' .$fila['Observaciones'] .'"></td>
                                    <td class="text-center">' .$pendientes['total'].' días totales y le quedan '.$pendientes['dias'].'</td>';
                                    if($estadoVacaciones['aus'] == TRUE) {
                                        echo 
                                            '<script>
                                                document.getElementsByClassName("vacaciones")['.$i.'].style.backgroundColor = "red";
                                                document.getElementsByClassName("vacaciones")['.$i.'].style.color = "white";
                                            </script>';
                                        $i++;
                                    } 
                                    else {
                                        echo 
                                            '<script>
                                                document.getElementsByClassName("vacaciones")['.$i.'].style.backgroundColor = "green";
                                                document.getElementsByClassName("vacaciones")['.$i.'].style.color = "white";
                                            </script>';
                                        $i++;
                                    }  
                                echo '
                                    <td class="text-center">'.$TipoAusencia['vacaciones'].' vacaciones</td> 
                                    <td class="text-center">'.$TipoAusencia['bajas'].' bajas</td>
                                    <td class="text-center">'.$TipoAusencia['permisos'].' permisos</td>
                                    <td class="text-center">'.$TipoAusencia['injustificadas'].' injustificadas</td>
                                    </td>
                                </tr>';
                                
                            }
                            echo '<tr class="text-center"><td colspan="2"><button type="submit" class="btn btn-default" name="guardar"/>Modificar</button></td>';
                            echo '<td colspan="2"><button type="submit" name="eliminar" class="btn btn-default"/>Eliminar</button>
                                </a></td>';
                            echo '<td colspan="2"><button type="submit" class="btn btn-default" name="alta"/>Alta de Ausencia</button></td>';
                            echo '<td colspan="2"><a class="btn btn-default" href="trabajadores.php"/>Volver</a></td></tr>';

                            
                            echo "</table>";
                            echo "</form>"
                        ?> 
                    
                    </fieldset>
                    <div id="error" class="" role="alert">
                    </div>
                </div>
            </div>
               <?php 
                    $mysqli->close();
                ?>

        </div>
    </div>

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
    <script src="../../scripts/sorting.js"></script>
</body>
</html>