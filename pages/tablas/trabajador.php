<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Trabajadores | Vacaciones - Aplicación de Oasis Park Fuerteventura</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">

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

        // SI PULSAMOS EL BOTON GENERAR XML
        if (isset($_POST["generarxml"])) {

            $sql = "SELECT * FROM Trabajador";
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

                     $nombreDepartamentoTrabajador = $dom->createElement("nombreDepartamentoTrabajador");
                     $trabajadores->appendChild($nombreDepartamentoTrabajador);
                     $nombreDepartamentoTrabajador = $dom->createTextNode($fila['nombreDepartamentoTrabajador']);
                     $trabajadores->appendChild($nombreDepartamentoTrabajador);
                }
                
                //header("content-type: text/xml");
                echo $dom->saveXML();
                //Finalmente, guardarlo en una ubicación
                $dom->save('../informes/departamentos.xml');

            } //CIERRE IF

        } //CIERRE ISSET GENERARXML

        // SI PULSAMOS GENERAR
        if (isset($_POST["generar"])) {
            $cabecera = "<span><b>Informe PDF</b></span>";
            $pie = "<span>Tabla Trabajadores. Fuerteventura Oasis Park</span>";
            $mpdf=new mPDF();
            $style=file_get_contents('../css/tabla.css');
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
            $seleccionar = $_POST["seleccionar"];
            $DNI = $_POST["DNI"];
            $Foto = $_POST["Foto"];
            $nombreApellidos = $_POST["nombreApellidos"];
            $FechaIni = $_POST["FechaIni"];
            $FechaFin = $_POST["FechaFin"];
            $Observaciones = $_POST["Observaciones"];
            $tipoContrato = $_POST["tipoContrato"];
            $nombreDepartamentoTrabajador = $_POST["nombreDepartamentoTrabajador"];

            //Se describe la inserción de datos en SQL
            $sql = "INSERT INTO Trabajador VALUES ('$DNI','$Foto', '$nombreApellidos', '$FechaIni', '$FechaFin', 
                    '$Observaciones', '$tipoContrato', '$nombreDepartamentoTrabajador');";
            
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

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../../index.html">Vacaciones APP</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> Perfil Usuario</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Ajustes</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Cierre</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="../../index.html"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="empresa.php"><i class="fa fa-edit fa-fw"></i> Empresas</a>
                        </li>
                        <li>
                            <a href="centro.php"><i class="fa fa-user fa-fw"></i> Centros</a>
                        </li>
                        <li>
                            <a href="departamento.php"><i class="fa fa-user fa-fw"></i> Departamentos</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-user fa-fw"></i> Trabajadores</a>
                        </li>
                        <li>
                            <a href="ausencia.php"><i class="fa fa-user fa-fw"></i> Ausencias</a>
                        </li>

                    </ul>
                </div>
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Panel de Administración<small> - Trabajadores</small></h1>
                </div>

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
                                        <input class="form-control" tabindex="2" type="file" name="Foto" placeholder="Ubicación de la foto">

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
                <div class="col-lg-12">
                    <!-- FORMULARIO -->
                    
                    <div class="form-group">
                        <fieldset>

                        <?php 
                            // LANZAMOS LA CONSULTA DE TODOS LOS DATOS DE LA TABLA MANUALES
                            // PARA MOSTRARLOS EN EL FORMULARIO
                            
                            $sql = "SELECT DISTINCT * FROM Trabajador";                       
                            $resultado = $mysqli -> query($sql);                        
                        ?>
                            <legend><span>Alta, baja y modificación de Trabajadores</span></legend> 

                            <form class="form" method="POST" enctype="multipart/form-data" 
                                action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                                <table class="table-hover table-responsive table-striped">
                                    <tr><td colspan="6">Dar de alta un nuevo Trabajador: </td></tr>
                                    <tr><td colspan="6"><button type="submit" name="alta" class="btn btn-default" />Alta</button></td></tr>
                                    <tr>
                                        <th>Seleccionar</th>
                                        <th>DNI</th>
                                        <th>Foto</th>
                                        <th>Nombre y Apellidos</th>
                                        <th>Inicio del contrato</th>
                                        <th>Fin del contrato</th>
                                        <th>Observaciones</th>
                                        <th>Tipo de Contrato</th>
                                        <th>Departamento</th>
                                    </tr>
                            <?php
                                while ($fila = $resultado -> fetch_assoc()){
                                    echo '
                                    <tr>
                                        <td><input type="checkbox" name="seleccionar[]" class="form-control" value="' .$fila['DNI'] .'"/></td>
                                        <td><input type="text" name="DNI[]" class="form-control" value="' .$fila['DNI'] .'" readonly></td>
                                        <td><input type="file" name="Foto[]" class="form-control" value="' .$fila['Foto'] .'"></td>
                                        <td><input type="text" name="nombreApellidos[]" class="form-control" value="' .$fila['nombreApellidos'] .'"></td>
                                        <td><input type="date" name="FechaIni[]" class="form-control" value="' .$fila['FechaIni'] .'"></td>
                                        <td><input type="date" name="FechaFin[]" class="form-control" value="' .$fila['FechaFin'] .'"></td>
                                        <td><input type="text" name="Observaciones[]" class="form-control" value="' .$fila['Observaciones'] .'"></td>
                                        <td><input type="text" name="tipoContrato[]" class="form-control" value="' .$fila['tipoContrato'] .'"></td>
                                        <td><input type="text" name="nombreDepartamentoTrabajador[]" class="form-control" value="' .$fila['nombreDepartamentoTrabajador'] .'"></td>
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

    </div>
    <!-- /#wrapper -->

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

</body>

</html>
