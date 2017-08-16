<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Recursos Humanos - Aplicación de Oasis Park Fuerteventura</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../vendor/bootstrap/css/custom.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <?php
        
        require_once "../scripts/conexion/conectari.php";
        require_once "../mpdf/mpdf.php";
    
        $mysqli = conectar();
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
                    <a class="navbar-brand" href="#"><img  id="logo-oasis" alt="App Vacaciones" src="../vendor/img/logo-oasis.png" ></a>
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
                        <li><a href="pages/trabajadores.php"><span class="glyphicon glyphicon-user"></span> Trabajadores</a></li>
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
        <h2>App Vacaciones Oasis Park</h2>
        <p>Página principal</p>
    </div>

    <div class="row text-center">
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img class="img-thumbnail img-muestra" src="../vendor/img/trabajadores.png" alt="trabajadores">
                <div class="caption">
                    <h3>Trabajadores</h3>
                    <p>Ver y administrar los trabajadores</p>
                    <p>
                        <a href="pages/trabajadores.php" class="btn btn-primary" role="button">Administrar</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img class="img-thumbnail img-muestra" src="../vendor/img/departamentos.jpg" alt="departamentos">
                <div class="caption">
                    <h3>Departamentos</h3>
                    <p>(Sección en construcción)</p>
                    <p>
                        <a href="#" class="btn btn-primary" role="button">Consultar</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img class="img-thumbnail img-muestra" src="../vendor/img/estadisticas.png" alt="estadisticas">
                <div class="caption">
                    <h3>Estadísticas</h3>
                    <p>(Sección en construcción)</p>
                    <p>
                        <a href="#" class="btn btn-primary" role="button">Consultar</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <?php 
        $mysqli -> close();
    ?>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
