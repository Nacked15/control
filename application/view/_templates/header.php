<!DOCTYPE html>
<html lang="es">
<head>
    <title>Control Escolar</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo Config::get('URL'); ?>favicon.ico">
    <!-- CSS -->
    <link href="<?php echo Config::get('URL'); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>assets/css/snackbar.min.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>assets/css/material.min.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>assets/css/ripples.min.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>assets/css/roboto.min.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>assets/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>assets/css/fileinput.min.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>assets/css/datepicker.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>assets/css/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>assets/css/calendar.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>assets/css/icons.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>assets/css/cards.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>assets/css/style.css" rel="stylesheet">
    <?php  
        if(Registry::has('css')){
            Registry::get('css');
        }
    ?>
</head>
<body>

<?php  if (Session::userIsLoggedIn()) { 
    $base_url = Config::get('URL'); 
    $user     = Session::get('user_name'); 
    $usr_type = (int)Session::get('user_type');?>
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
                         src="<?php echo Config::get('URL'); ?>favicon.ico" 
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
                        <a href="#" 
                           data-target="#" 
                           class="dropdown-toggle" 
                           data-toggle="dropdown">
                                Alumnos<b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?= $base_url; ?>alumno">Alumnos</a>
                            </li>
                            <?php if ($usr_type === 1 || $usr_type === 2): ?>
                                <li><a href="<?= $base_url; ?>alumno/nuevo">Nuevo Alumno</a></li>
                                <li><a href="<?= $base_url; ?>alumno/becados">Becados</a></li>
                            <?php endif ?>
                            <li><a href="<?= $base_url; ?>alumno/sep">Inscritos en la SEP</a></li>
                            <li><a href="<?= $base_url; ?>alumno/notas">Calificaciones</a></li>
                            <?php if ($usr_type === 1 || $usr_type === 2): ?>
                                <li><a href="<?= $base_url; ?>alumno/baja">De Baja</a></li>
                                <li><a href="<?= $base_url; ?>alumno/egresados">Egresados</a></li>
                            <?php endif ?>
                        </ul>
                    </li>
                    <li <?= View::active($filename, 'cursos') ? ' class="active" ': '';?>>
                        <a href="<?= $base_url; ?>curso">Clases</a>
                    </li>
                    <?php if ($usr_type === 1 || $usr_type === 2): ?>
                    <li <?= View::active($filename, 'maestros') ? ' class="active" ': '';?>>
                        <a href="<?= $base_url; ?>maestro">Maestros</a>
                    </li>
                     <?php endif ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" 
                           data-target="#" 
                           class="dropdown-toggle" 
                           data-toggle="dropdown">
                            <?= $user; ?><b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?= $base_url; ?>user">Mi Perfil</a>
                            </li>
                            <?php if ($usr_type === 1 || $usr_type === 2): ?>
                            <li>
                                <a href="<?= $base_url; ?>profile/index">Usuarios</a>
                            </li>
                            <li>
                                <a href="<?= $base_url; ?>register/index">Nuevo Usuario</a>
                            </li>
                            <?php endif ?>
                            <li>
                                <a href="<?= $base_url; ?>login/logout">Cerrar Sesión</a>
                            </li>
                        </ul>
                        <li>
                            <a href="javascript:void(0)">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                        </li>
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
