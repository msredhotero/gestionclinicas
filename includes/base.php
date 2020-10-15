<?php

/**
 * @author Saupurein Marcos
 * @copyright 2018
 */
date_default_timezone_set('America/Mexico_City');

include ('funcionesNotificaciones.php');
$serviciosNoti = new ServiciosNotificaciones();

class BaseHTML extends ServiciosNotificaciones {

    function cargarArchivosCSS($altura,$ar = array()) {

        $arNuevo = array(0=>'<link href="'.$altura.'plugins/bootstrap/css/bootstrap.css" rel="stylesheet">',
                         1=>'<link href="'.$altura.'plugins/node-waves/waves.css" rel="stylesheet" />',
                         2=>'<link href="'.$altura.'plugins/animate-css/animate.css" rel="stylesheet" />',
                         3=>'<link href="'.$altura.'css/style.css" rel="stylesheet">',
                         4=>'<link href="'.$altura.'css/themes/all-themes.css" rel="stylesheet" />',
                         5=>'<link href="'.$altura.'plugins/sweetalert/sweetalert.css" rel="stylesheet" />',
                         6=>'<link href="'.$altura.'plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />',
                         7=>'<link href="'.$altura.'css/ventanaModal.css" rel="stylesheet" />',
                         8=>'<link href="https://fonts.googleapis.com/css2?family=Prata&display=swap" rel="stylesheet">',
                         9=>'<link href="'.$altura.'css/estilos.css" rel="stylesheet">'
                      );

        $cad = '';

        foreach($arNuevo as $var) {
            $cad .= $var.'<br>';
        }

        foreach($ar as $var) {
            $cad .= $var.'<br>';
        }

        echo $cad;
    }


    function cargarArchivosJS($altura ,$ar = array()) {

        $arNuevo = array(0=>'<script src="'.$altura.'plugins/jquery/jquery.min.js"></script>',
                         1=>'<script src="'.$altura.'plugins/bootstrap/js/bootstrap.js"></script>',
                         2=>'<script src="'.$altura.'plugins/bootstrap-select/js/bootstrap-select.js"></script>',
                         3=>'<script src="'.$altura.'plugins/jquery-slimscroll/jquery.slimscroll.js"></script>',
                         4=>'<script src="'.$altura.'plugins/node-waves/waves.js"></script>',
                         5=>'<script src="'.$altura.'js/admin.js"></script>',
                         6=>'<script src="'.$altura.'js/demo.js"></script>',
                         7=>'<script src="'.$altura.'plugins/bootstrap-notify/bootstrap-notify.js"></script>',
                         8=>'<script src="'.$altura.'js/pages/ui/notifications.js"></script>',
                         9=>'<script src="'.$altura.'plugins/jquery-validation/jquery.validate.js"></script>',
                         10=>'<script src="'.$altura.'plugins/jquery-steps/jquery.steps.js"></script>',
                         11=>'<script src="'.$altura.'plugins/sweetalert/sweetalert.min.js"></script>',
                         12=>'<script src="'.$altura.'js/pages/forms/form-validation.js"></script>',
                         13=>'<script src="'.$altura.'js/jquery.number.js"></script>');

        $cad = '';

        foreach($arNuevo as $var) {
            $cad .= $var.'<br>';
        }

        foreach($ar as $var) {
            $cad .= $var.'<br>';
        }

        echo $cad;
    }

    function cargarArchivosJS2($altura ,$ar = array()) {

        $arNuevo = array(1=>'<script src="'.$altura.'plugins/bootstrap/js/bootstrap.js"></script>',
                         2=>'<script src="'.$altura.'plugins/bootstrap-select/js/bootstrap-select.js"></script>',
                         3=>'<script src="'.$altura.'plugins/jquery-slimscroll/jquery.slimscroll.js"></script>',
                         4=>'<script src="'.$altura.'plugins/node-waves/waves.js"></script>',
                         5=>'<script src="'.$altura.'js/admin.js"></script>',
                         6=>'<script src="'.$altura.'js/demo.js"></script>',
                         7=>'<script src="'.$altura.'plugins/bootstrap-notify/bootstrap-notify.js"></script>',
                         8=>'<script src="'.$altura.'js/pages/ui/notifications.js"></script>',
                         9=>'<script src="'.$altura.'plugins/jquery-validation/jquery.validate.js"></script>',
                         10=>'<script src="'.$altura.'plugins/jquery-steps/jquery.steps.js"></script>',
                         11=>'<script src="'.$altura.'plugins/sweetalert/sweetalert.min.js"></script>',
                         12=>'<script src="'.$altura.'js/pages/forms/form-validation.js"></script>',
                         13=>'<script src="'.$altura.'js/jquery.number.js"></script>');

        $cad = '';

        foreach($arNuevo as $var) {
            $cad .= $var.'<br>';
        }

        foreach($ar as $var) {
            $cad .= $var.'<br>';
        }

        echo $cad;
    }

    function cargarNotificaciones($datos = null, $altura = '') {

      if ($_SESSION['idroll_sahilices'] == 4) {
         $datos = $this->traerNotificacionesPorUsuarios('rlinares@asesorescrea.com');
      } else {
         $datos = $this->traerNotificacionesPorUsuarios($_SESSION['usua_sahilices']);
      }
        $cad = '<ul class="menu lstNotificaciones" data-altura="'.$altura.'">';

        while ($row = mysql_fetch_array($datos)) {
            $cad .= '<li>
                            <a class="itemNotificacion" href="javascript:void(0);" data-url="'.$altura.$row['url'].'" id="'.$row['idnotificacion'].'" data-altura="'.$altura.'">
                            <div class="icon-circle '.$row['estilo'].'">
                                <i class="material-icons">'.$row['icono'].'</i>
                            </div>
                            <div class="menu-info">
                                <h4>'.$row['mensaje'].'</h4>
                                <p>
                                    <i class="material-icons">access_time</i> '.$row['fecha'].'
                                </p>
                            </div>
                        </a>
                    </li>';
        }

        $cad .= '</ul>';
        //die(var_dump($cad));
        return $cad;
    }


   function cargarTareas($datos = null, $altura = '') {

      $cad = '<ul class="menu tasks">';

      while ($row = mysql_fetch_array($datos)) {
         $cad .= '<li>
            <a href="javascript:void(0);">
               <h4>
                  '.$row['titulo'].'
                  <small>'.$row['pocentaje'].'%</small>
               </h4>
               <div class="progress">
                  <div class="progress-bar '.$row['color'].'" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: '.$row['porcentaje'].'%">
                  </div>
               </div>
            </a>
         </li>';
      }

      $cad .= '</ul>';

      echo $cad;
   }

   function root_path(){
      $this_directory = dirname(__FILE__);
      $archivos = scandir($this_directory);
      $atras = "";
      $cuenta = 0;
      while (true) {
         foreach($archivos as $actual) {
            if ($actual == "root.path") {
               if ($cuenta == 0)
               return "./";
               return $atras;
            }
         }
         $cuenta++;
         $atras = $atras . "../";
         $archivos = scandir($atras);
      }
   }


    function cargarNAV($breadCumbs, $notificaciones='', $tareas='', $altura = '', $lstTareas='') {
      $lblVerTodas = '';
      if ($notificaciones == '') {
         $notificaciones = $this->cargarNotificaciones('',($altura == '..' ? '' : '../'));

         if ($_SESSION['idroll_sahilices'] == 4) {
            $cantidadNotificacionesNoLeidas = $this->traerNotificacionesNoLeidaPorUsuarios('rlinares@asesorescrea.com');
         } else {
            $cantidadNotificacionesNoLeidas = $this->traerNotificacionesNoLeidaPorUsuarios($_SESSION['usua_sahilices']);
         }

         $lblVerTodas = 'btnVerNotificaciones';
      }

      if ($_SESSION['idroll_sahilices'] == 16) {
         $lblVerTodas = '';
      }
        $cad = '<nav class="navbar">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                            <a href="javascript:void(0);" class="bars"></a>
                            '.$breadCumbs.'
                        </div>
                        <div class="collapse navbar-collapse" id="navbar-collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <!-- Call Search -->
                                <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                                <!-- #END# Call Search -->
                                <!-- Notifications -->
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                                        <i class="material-icons">notifications</i>
                                        <span class="label-count notificaciones-cantidad">'.$cantidadNotificacionesNoLeidas.'</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="header">Notificaciones</li>
                                        <li class="body">
                                           '.$notificaciones.'
                                        </li>
                                        <li class="footer">
                                            <a href="javascript:void(0);" class="'.$lblVerTodas.'">Ver Todas</a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- #END# Notifications -->
                                <!-- Tasks -->
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                                        <i class="material-icons">flag</i>
                                        <span class="label-count tareas-cantidad">0</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="header">Tareas</li>
                                        <li class="body">
                                            <ul class="menu tasks">

                                            </ul>
                                        </li>
                                        <li class="footer">
                                            <a href="javascript:void(0);">Ver Todas</a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- #END# Tasks -->
                                <li class="pull-right"><a href="javascript:void(0);" class="maximizar"><i class="material-icons icomarcos">aspect_ratio</i></a></li>

                            </ul>
                        </div>
                    </div>
                </nav>

                <div class="btn-whatsapp">
               <a href="https://api.whatsapp.com/send?phone=525564528095&text=Hola!%20Quieres%20contactarte%20con%20nosotros!" target="_blank">
               <img src="http://s2.accesoperu.com/logos/btn_whatsapp.png" alt="">
               </a>
               </div>
    ';
        echo $cad;
    }

    function cargarSECTION($usuario, $email, $menu, $altura = '', $rightsidebar='') {
      $cadPerfil = '';

      if ($_SESSION['idroll_sahilices'] == 16) {
         $cadPerfil = '<li><a href="'.$altura.'dashboard/cuenta/index.php"><i class="material-icons">account_circle</i>Cuenta</a></li>';
      }
        $cad = '<section>
                <!-- Left Sidebar -->
                <div id="marcos">
                <aside id="leftsidebar" class="sidebar">
                    <!-- User Info -->
                    <div class="user-info">
                        <div class="image" style="height:48px;">

                        </div>
                        <div class="info-container">
                            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white !important;">'.$usuario.'</div>
                            <div class="email" style="color:white !important;">'.$email.'</div>
                            <div class="btn-group user-helper-dropdown">
                                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="color:white !important;">keyboard_arrow_down</i>
                                <ul class="dropdown-menu pull-right">
                                    '.$cadPerfil.'
                                    <li><a href="'.$altura.'logout.php"><i class="material-icons">input</i>Salir</a></li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- #User Info -->
                    <!-- Menu -->
                    <div class="menu">
                        <ul class="list">
                            <li class="header">MENU</li>
                            '.$menu.'
                        </ul>
                    </div>
                    <!-- #Menu -->

                </aside>
                </div>
                <!-- #END# Left Sidebar -->
                <!-- Right Sidebar -->
                <aside id="rightsidebar" class="right-sidebar">
                  '.$rightsidebar.'
                </aside>
                <!-- #END# Right Sidebar -->
            </section>';

        echo $cad;
    }

    function modalHTML($id,$titulo,$aceptar,$contenido,$form,$formulario='',$idTabla,$tabla,$accion) {
        $cad = '<div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-blue">
                        <h4 class="modal-title" id="largeModalLabel">'.$titulo.'</h4>
                    </div>

                    <form id="'.$form.'" method="POST">
                    <div class="modal-body">
                        <p>'.$contenido.'</p>

                        '.$formulario.'

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-link waves-effect" id="btn'.$id.'">'.$aceptar.'</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
                    </div>
                    <input type="hidden" ref="ref_'.$idTabla.'" :value="active'.ucwords($tabla).'.'.$idTabla.'" name="'.$idTabla.'" />
                    <input type="hidden" value="'.$accion.'" name="accion" id="accion" />
                    </form>

                </div>
            </div>
        </div>';

        echo $cad;
    }


}
