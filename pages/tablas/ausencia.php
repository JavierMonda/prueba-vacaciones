<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ausencias | Vacaciones - Aplicación de Oasis Park Fuerteventura</title>

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

            $sql = "SELECT * FROM Ausencia";
            $resultado = $mysqli -> query($sql);

            $numfilas = $resultado -> num_rows;

            if ($numfilas > 0) {
                
                $dom = new DOMDocument('1.0','utf-8');
                 // Se define el elemento
                 $ausencias = $dom->createElement("ausencias");
                 // Se crea el nodo del elemento
                 $dom->appendChild($ausencias);

                 while ($fila = $resultado->fetch_assoc()) {
                     $idAusencia = $dom->createElement("idAusencia");
                     $ausencias->appendChild($idAusencia);
                     $idAusencia = $dom->createTextNode($fila['idAusencia']);
                     $ausencias->appendChild($idAusencia);

                     $fechaAusencia = $dom->createElement("fechaAusencia");
                     $ausencias->appendChild($fechaAusencia);
                     $fechaAusencia = $dom->createTextNode($fila['fechaAusencia']);
                     $ausencias->appendChild($fechaAusencia);

                     $tipoAusencia = $dom->createElement("tipoAusencia");
                     $ausencias->appendChild($tipoAusencia);
                     $tipoAusencia = $dom->createTextNode($fila['tipoAusencia']);
                     $ausencias->appendChild($tipoAusencia);

                     $descripcion = $dom->createElement("descripcion");
                     $ausencias->appendChild($descripcion);
                     $descripcion = $dom->createTextNode($fila['descripcion']);
                     $ausencias->appendChild($descripcion);

                     $DNIAusencia = $dom->createElement("DNIAusencia");
                     $ausencias->appendChild($DNIAusencia);
                     $DNIAusencia = $dom->createTextNode($fila['DNIAusencia']);
                     $ausencias->appendChild($DNIAusencia);
                }
                
                //header("content-type: text/xml");
                echo $dom->saveXML();
                //Finalmente, guardarlo en una ubicación
                $dom->save('../informes/ausencias.xml');

            } //CIERRE IF

        } //CIERRE ISSET GENERARXML

        // SI PULSAMOS GENERAR
        if (isset($_POST["generar"])) {
            $cabecera = "<span><b>Informe PDF</b></span>";
            $pie = "<span>Tabla Ausencias. Fuerteventura Oasis Park</span>";
            $mpdf=new mPDF();
            $style=file_get_contents('../css/tabla.css');
            $mpdf->WriteHTML($style, 1);
            $mpdf->SetHTMLHeader($cabecera);
            $mpdf->SetHTMLFooter($pie);

            $sql = "SELECT * FROM  Ausencia";                       
            $resultado = $mysqli -> query($sql);

            $mpdf->WriteHTML('<table class="table-hover table-responsive table-striped">
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>DNI del Trabajador</th>

                </tr>',2);
            while ($fila = $resultado -> fetch_assoc()){

                $mpdf->WriteHTML('<tr>
                                <td>' .$fila['idAusencia'] .'</td>
                                <td>' .$fila['fechaAusencia'] .'</td>
                                <td>' .$fila['tipoAusencia'] .'</td>
                                <td>' .$fila['descripcion'] .'</td>
                                <td>' .$fila['DNIAusencia'] .'</td>
                            </tr>', 2);
            }
            $mpdf->WriteHTML('</table>',2);             
            $mpdf->Output('archivo_ausencias.pdf','I');
            exit;

        } // CIERRE DE IF GENERAR

        // SI HACEMOS CLICK EN ALTA2
        if (isset($_POST["alta2"])){
            $seleccionar = $_POST["seleccionar"];
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
        if (isset($_POST["guardar"]) && (isset($_POST["seleccionar"]))) {
            $seleccionar = $_POST["seleccionar"];
            $idAusencia = $_POST["idAusencia"];
            $fechaAusencia = $_POST["fechaAusencia"];
            $tipoAusencia = $_POST["tipoAusencia"];
            $descripcion = $_POST["descripcion"];
            $DNIAusencia = $_POST["DNIAusencia"];
                            
            for ($i=0;$i < count($idAusencia);$i++) {
                $fechaAusencia[$i] = test_input($fechaAusencia[$i]);
                $tipoAusencia[$i] = test_input($tipoAusencia[$i]);
                $descripcion[$i] = test_input($descripcion[$i]);
                $DNIAusencia[$i] = test_input($DNIAusencia[$i]);
                  
                $j = 0;
                $sql = ""; 
                while ($j < count($seleccionar)) { 
                    if ($seleccionar[$j ++] == $idAusencia[$i]){
                        $sql = "UPDATE Ausencia SET fechaAusencia= '$fechaAusencia[$i]', tipoAusencia= '$tipoAusencia[$i]', descripcion= '$descripcion[$i]', DNIAusencia= '$DNIAusencia[$i]'  
                        WHERE idAusencia='$idAusencia[$i]'";
                        if ($mysqli->query($sql)){
                            echo "Registro " .$idAusencia[$i] ." modificado satisfactoriamente";
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
            $idAusencia = $_POST["idAusencia"];
            $fechaAusencia = $_POST["fechaAusencia"];
            $tipoAusencia = $_POST["tipoAusencia"];
            $descripcion = $_POST["descripcion"];
            $DNIAusencia = $_POST["DNIAusencia"];

            for ($i=0;$i < count($idAusencia);$i++) {
                $fechaAusencia[$i] = test_input($fechaAusencia[$i]);
                $tipoAusencia[$i] = test_input($tipoAusencia[$i]);
                $descripcion[$i] = test_input($descripcion[$i]);
                $DNIAusencia[$i] = test_input($DNIAusencia[$i]);
                  
                $j = 0;
                $sql = "";                  
                while ($j < count($seleccionar)){
                    if ($seleccionar[$j ++] == $idAusencia[$i]){
                        $sql = "DELETE FROM Ausencia WHERE idAusencia='$idAusencia[$i]'";
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
                            <a href="trabajador.php"><i class="fa fa-user fa-fw"></i> Trabajadores</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-user fa-fw"></i> Ausencias</a>
                        </li>

                    </ul>
                </div>
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Panel de Administración<small> - Ausencias</small></h1>
                </div>

                <div class="col-lg-12">
                    <?php
                        // SI HACEMOS CLICK EN ALTA
                        if (isset($_POST["alta"])){
                            // FORMULARIO DE ALTA
                    ?>
                            <div class="form-group">
                                <fieldset>
                                    <legend><span>Alta de Ausencias</span></legend>
                                    <form class="form" method="POST" enctype="multipart/form-data"
                                     action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

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
                            
                            $sql = "SELECT DISTINCT * FROM Ausencia";                       
                            $resultado = $mysqli -> query($sql);                        
                        ?>
                            <legend><span>Alta, baja y modificación de Ausencias</span></legend> 

                            <form class="form" method="POST" enctype="multipart/form-data" 
                                action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                                <table class="table-hover table-responsive table-striped">
                                    <tr><td colspan="6">Dar de alta una nueva Ausencia: </td></tr>
                                    <tr><td colspan="6"><button type="submit" name="alta" class="btn btn-default" />Alta</button></td></tr>
                                    <tr>
                                        <th>Seleccionar</th>
                                        <th>ID Ausencia</th>
                                        <th>Fecha</th>
                                        <th>Tipo</th>
                                        <th>Descripción</th>
                                        <th>DNI Trabajador</th>
                                    </tr>
                            <?php
                                while ($fila = $resultado -> fetch_assoc()){
                                    echo '
                                    <tr>
                                        <td><input type="checkbox" name="seleccionar[]" class="form-control" value="' .$fila['idAusencia'] .'"></td>
                                        <td><input type="text" name="idAusencia[]" class="form-control" value="' .$fila['idAusencia'] .'" readonly></td>
                                        <td><input type="date" name="fechaAusencia[]" class="form-control" value="' .$fila['fechaAusencia'] .'"></td>
                                        <td><input type="text" name="tipoAusencia[]" class="form-control" value="' .$fila['tipoAusencia'] .'"></td>
                                        <td><input type="text" name="descripcion[]" class="form-control" value="' .$fila['descripcion'] .'"></td>
                                        <td><input type="text" name="DNIAusencia[]" class="form-control" value="' .$fila['DNIAusencia'] .'"></td>
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
