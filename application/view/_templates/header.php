<!DOCTYPE html>
<html lang="es">
<head>
    <title>Control Escolar</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../favicon.ico">
    <!-- CSS -->
    <link href="<?php echo Config::get('URL'); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>assets/css/material.min.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>assets/css/ripples.min.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>assets/css/roboto.min.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>assets/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>assets/css/fileinput.min.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>assets/css/icons.css" rel="stylesheet" >
    <link href="<?php echo Config::get('URL'); ?>assets/css/datepicker.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>assets/css/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>assets/css/calendar.css" rel="stylesheet" >
    <link href="<?php echo Config::get('URL'); ?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>assets/css/cards.css" rel="stylesheet">
    <?php  
        if(Registry::has('css')){
            Registry::get('css');
        }
    ?>
    <link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/style.css" />

</head>
<body>

<?php  if (Session::userIsLoggedIn()) { 
    $base_url = Config::get('URL'); 
    $user     = Session::get('user_name'); ?>
    <nav class="navbar navbar-naatik nav-main navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" 
                        class="navbar-toggle" 
                        data-toggle="collapse" 
                        data-target=".navbar-responsive-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="javascript:void(0)">
                    <img class="img-circle" 
                         src="../favicon.ico" 
                         alt="user"
                         width="35px"
                         height="35px">
                </a>
            </div>
            <div class="navbar-collapse collapse navbar-responsive-collapse">
                <ul class="nav navbar-nav main_menu">
                    <li <?php if (View::active($filename, "dashboard")) { echo ' class="active" '; } ?>>
                        <a href="<?= $base_url; ?>dashboard">Home</a>
                    </li>
                    <li class="dropdown <?= View::active($filename, 'alumnos') ? 'active': '';?>">
                        <a href="bootstrap-elements.html" 
                           data-target="#" 
                           class="dropdown-toggle" 
                           data-toggle="dropdown">
                                Alumnos<b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?= $base_url; ?>alumno">Alumnos</a></li>
                            <li><a href="<?= $base_url; ?>alumno/nuevo">Nuevo Alumno</a></li>
                            <li><a href="<?= $base_url; ?>alumno/becados">Becados</a></li>
                            <li><a href="<?= $base_url; ?>alumno/sep">Inscritos en la SEP</a></li>
                            <li><a href="<?= $base_url; ?>alumno/notas">Calificaciones</a></li>
                            <li><a href="<?= $base_url; ?>alumno/baja">De Baja</a></li>
                            <li><a href="<?= $base_url; ?>alumno/egresados">Egresados</a></li>
                        </ul>
                    </li>
                    <li <?= View::active($filename, 'cursos') ? ' class="active" ': '';?>>
                        <a href="<?= $base_url; ?>curso">Clases</a>
                    </li>
                    <li <?= View::active($filename, 'maestros') ? ' class="active" ': '';?>>
                        <a href="<?= $base_url; ?>maestro">Maestros</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">Pagos</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">Padrinos</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="javascript:void(0)">Link</a></li>
                    <li class="dropdown">
                        <a href="bootstrap-elements.html" 
                           data-target="#" 
                           class="dropdown-toggle" 
                           data-toggle="dropdown">
                            <?= $user; ?><b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?= $base_url; ?>user">Mi Perfil</a>
                            </li>
                            <li>
                                <a href="<?= $base_url; ?>user/editusername">Cambiar Usuario</a>
                            </li>
                            <li>
                                <a href="<?= $base_url; ?>user/changePassword">Cambiar Contraseña</a>
                            </li>
                            <li>
                                <a href="<?= $base_url; ?>user/editAvatar">Cambia Foto</a>
                            </li>
                            <li>
                                <a href="<?= $base_url; ?>profile/index">Usuarios</a>
                            </li>
                            <li>
                                <a href="<?= $base_url; ?>register/index">Nuevo Usuario</a>
                            </li>
                            <li>
                                <a href="<?= $base_url; ?>login/logout">Cerrar Sesión</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="avatar right">
        <img class="img-circle" 
             src="<?= Session::get('user_avatar_file'); ?>"
             alt="user">
    </div>
<?php } ?>
