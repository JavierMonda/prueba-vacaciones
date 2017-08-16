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

        // SI PULSAMOS EL BOTON GENERAR XML
        if (isset($_POST["generarxml"])) {

            $sql = "SELECT DISTINCT * FROM Trabajador";
            $resultado = $mysqli -> query($sql);

            $numfilas = $resultado -> num_rows;

            if ($numfilas > 0) {
                
                $dom = new DOMDocument('1.0','utf-8');
                 // Se define el elemento
                 $trabajadores = $dom->createElement("trabajadores");
                 // Se crea el nodo del elemento
                 $dom->appendChild($trabajadores);

                 while ($fila = $resultado->fetch_assoc()) {
                     $DNI = $dom->createElement("DNI");
                     $trabajadores->appendChild($DNI);
                     $DNI = $dom->createTextNode($fila['DNI']);
                     $trabajadores->appendChild($DNI);

                     $Foto = $dom->createElement("Foto");
                     $trabajadores->appendChild($Foto);
                     $Foto = $dom->createTextNode($fila['Foto']);
                     $trabajadores->appendChild($Foto);

                     $nombreApellidos = $dom->createElement("nombreApellidos");
                     $trabajadores->appendChild($nombreApellidos);
                     $nombreApellidos = $dom->createTextNode($fila['nombreApellidos']);
                     $trabajadores->appendChild($nombreApellidos);

                     $FechaIni = $dom->createElement("FechaIni");
                     $trabajadores->appendChild($FechaIni);
                     $FechaIni = $dom->createTextNode($fila['FechaIni']);
                     $trabajadores->appendChild($FechaIni);

                     $FechaFin = $dom->createElement("FechaFin");
                     $trabajadores->appendChild($FechaFin);
                     $FechaFin = $dom->createTextNode($fila['FechaFin']);
                     $trabajadores->appendChild($FechaFin);

                     $Observaciones = $dom->createElement("Observaciones");
                     $trabajadores->appendChild($Observaciones);
                     $Observaciones = $dom->createTextNode($fila['Observaciones']);
                     $trabajadores->appendChild($Observaciones);

                     $tipoContrato = $dom->createElement("tipoContrato");
                     $trabajadores->appendChild($tipoContrato);
                     $tipoContrato = $dom->createTextNode($fila['tipoContrato']);
                     $trabajadores->appendChild($tipoContrato);
                }
                
                //header("content-type: text/xml");
                echo $dom->saveXML();
                //Finalmente, guardarlo en una ubicación
                $hoy = date("d-m-Y");
                $informe = '../../informes/trabajadores'.$hoy.'.xml';
                $dom->save($informe);
                echo '<script>alert("Guardado en carpeta Informes")</script>';

            } //CIERRE IF

        } //CIERRE ISSET GENERARXML

        // SI PULSAMOS GENERAR
        if (isset($_POST["generar"])) {
            $cabecera = "<span><b>Informe PDF</b></span>";
            $pie = "<span>Tabla Trabajadores. Fuerteventura Oasis Park</span>";
            $mpdf=new mPDF();
            $style=file_get_contents('../../vendor/bootstrap/css/bootstrap.min.css');
            $mpdf->WriteHTML($style, 1);
            $mpdf->SetHTMLHeader($cabecera);
            $mpdf->SetHTMLFooter($pie);

            $sql = "SELECT * FROM  Trabajador";                       
            $resultado = $mysqli -> query($sql);

            $mpdf->WriteHTML('<table class="table-hover table-responsive table-striped">
                <tr>
                    <th>DNI</th>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Inicio Contrato</th>
                    <th>Fin Contrato</th>
                    <th>Observaciones</th>
                    <th>Tipo de Contrato</th>
                    <th>Departamento</th>

                </tr>',2);
            while ($fila = $resultado -> fetch_assoc()){

                $mpdf->WriteHTML('<tr>
                                <td>' .$fila['DNI'] .'</td>
                                <td>' .$fila['Foto'] .'</td>
                                <td>' .$fila['nombreApellidos'] .'</td>
                                <td>' .$fila['FechaIni'] .'</td>
                                <td>' .$fila['FechaFin'] .'</td>
                                <td>' .$fila['Observaciones'] .'</td>
                                <td>' .$fila['tipoContrato'] .'</td>
                                <td>' .$fila['nombreDepartamentoTrabajador'] .'</td>
                            </tr>', 2);
            }
            $mpdf->WriteHTML('</table>',2);             
            $mpdf->Output('archivo_trabajadores.pdf','I');
            exit;

        } // CIERRE DE IF GENERAR

        // SI HACEMOS CLICK EN ALTA2
        if (isset($_POST["alta2"])){
            $DNI = $_POST["DNI"];
            $Foto = $_POST["Foto"];
            $nombreApellidos = $_POST["nombreApellidos"];
            $FechaIni = $_POST["FechaIni"];
            $FechaFin = $_POST["FechaFin"];
            $Observaciones = $_POST["Observaciones"];
            $tipoContrato = $_POST["tipoContrato"];
            $nombreDepartamentoTrabajador = $_POST["nombreDepartamentoTrabajador"];

            //Se describe la inserción de datos en SQL
            $sql = "INSERT INTO Trabajador(DNI,Foto,nombreApellidos,FechaIni,FechaFin,Observaciones,tipoContrato,nombreDepartamentoTrabajador)  
                    VALUES ('$DNI','$Foto', '$nombreApellidos', '$FechaIni', '$FechaFin', '$Observaciones', '$tipoContrato', '$nombreDepartamentoTrabajador');";
            
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
            <div class="col-lg-12">
                    <?php
                        // SI HACEMOS CLICK EN ALTA
                        if (isset($_POST["alta"])){
                            // FORMULARIO DE ALTA
                    ?>
                            <div class="form-group">
                                <fieldset>
                                    <legend><span>Alta de Trabajadores</span></legend>
                                    <form class="form" method="POST" enctype="multipart/form-data"
                                     action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                                        <label for="DNI">DNI del Trabajador </label><a name="DNI"></a> 
                                        <input class="form-control" tabindex="2" type="text" name="DNI" placeholder="DNI del Trabajador" required>

                                        <label for="Foto">Foto </label><a name="Foto"></a> 
                                        <input class="form-control" tabindex="2" type="file" name="Foto" placeholder="Ubicación de la foto (opcional)">

                                        <label for="nombreApellidos">Nombre completo </label><a name="nombreApellidos"></a> 
                                        <input class="form-control" tabindex="2" type="text" name="nombreApellidos" placeholder="John Doe" required>

                                        <label for="FechaIni">Inicio del contrato </label><a name="FechaIni"></a>
                                        <input class="form-control" tabindex="1" type="date" name="FechaIni" placeholder="Inicio del contrato" required>

                                        <label for="FechaFin">Fin del contrato </label><a name="FechaFin"></a>
                                        <input class="form-control" tabindex="1" type="date" name="FechaFin" placeholder="Fin del contrato" required>

                                        <label for="Observaciones">Observaciones </label><a name="Observaciones"></a>
                                        <input class="form-control" tabindex="1" type="text" name="Observaciones" placeholder="Observaciones">

                                        <label for="tipoContrato">Tipo de Contrato </label><a name="tipoContrato"></a>
                                        <input class="form-control" tabindex="1" type="text" name="tipoContrato" placeholder="Tipo de contrato" required>

                                        <label for="nombreDepartamentoTrabajador">Departamento </label><a name="nombreDepartamentoTrabajador"></a>
                                        <input class="form-control" tabindex="1" type="text" name="nombreDepartamentoTrabajador" placeholder="Departamento" required>

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
        </div>
        <div class="row">
            <!-- FORMULARIO --> 
            <div class="col-lg-12">                  
                <div class="form-group">
                    <fieldset>

                    <?php 
                        // LANZAMOS LA CONSULTA DE TODOS LOS DATOS DE LA TABLA MANUALES
                        // PARA MOSTRARLOS EN EL FORMULARIO
                        
                        $sql = "SELECT DISTINCT nombreDepartamentoTrabajador, nombreApellidos, Observaciones, vacaciones, DNI  FROM Trabajador ORDER BY nombreDepartamentoTrabajador";                       
                        $resultado = $mysqli -> query($sql);                        
                    ?>
                        <legend><span>Trabajadores ordenados por Departamento</span></legend> 

                        <form class="form" method="POST" enctype="multipart/form-data" 
                            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                            <table class="table table-responsive table-hover table-striped table-bordered">
                                <tr>
                                    <th class="text-center">Departamento</th>
                                    <th class="text-center">Nombre y Apellidos</th>
                                    <th class="text-center">Vacaciones pendientes</th>
                                    <th class="text-center"  colspan="4">Días de Ausencia</th>
                                    <th class="text-center">Ficha del Trabajador</th>
                                </tr>
                        <?php
                            $i = 0;
                            while ($fila = $resultado -> fetch_assoc()){
                                $vacas=$fila['DNI'];
                                //$sql2 = "SELECT DISTINCT count(idAusencia) from Ausencia where DNIAusencia = '$vacas'";
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
                                    <td class="text-center">' .$fila['nombreDepartamentoTrabajador'].'</td>
                                    <td class="vacaciones text-center">' .$fila['nombreApellidos'] .'</td>
                                    <td class="text-center">' .$pendientes['total'].' días totales y le quedan '.$pendientes['dias'].'</td>';
                                    if($estadoVacaciones['aus'] == TRUE) {
                                        echo 
                                            '<script>
                                                document.getElementsByClassName("vacaciones")['.$i.'].style.backgroundColor = "green";
                                                document.getElementsByClassName("vacaciones")['.$i.'].style.color = "white";
                                            </script>';
                                        $i++;
                                    } 
                                    else {
                                        echo 
                                            '<script>
                                                document.getElementsByClassName("vacaciones")['.$i.'].style.backgroundColor = "white";
                                                document.getElementsByClassName("vacaciones")['.$i.'].style.color = "black";
                                            </script>';
                                        $i++;
                                    }  
                                echo '
                                    <td class="text-center">'.$TipoAusencia['vacaciones'].' vacaciones</td> 
                                    <td class="text-center">'.$TipoAusencia['bajas'].' bajas</td>
                                    <td class="text-center">'.$TipoAusencia['permisos'].' permisos</td>
                                    <td class="text-center">'.$TipoAusencia['injustificadas'].' injustificadas</td>
                                    <td class="text-center">
                                        <a class="btn btn-default" href="ficha.php?trabajador='.$fila['nombreApellidos'].'"> Ver 
                                        </a>
                                    </td>
                                </tr>';
                                
                            }
                            echo '<tr class="text-center"><td colspan="2"><button type="submit" class="btn btn-default" name="generar"/>Generar PDF</button></td>';
                            echo '<td colspan="2"><button type="submit" name="generarxml" class="btn btn-default"/>Generar XML</button>
                                </a></td>';
                                echo '<td colspan="2"><button type="submit" name="alta" class="btn btn-default"/>Alta de nuevo trabajador</button>
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
    </div>
        
    <?php 
        $mysqli->close();
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
    <script src="../../scripts/sorting.js"></script>

</body>

</html>
