<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Generador de Ajax y Includes</title>
</head>

<body>
<?php
function query($sql,$accion) {

	require_once 'appconfig.php';

	$appconfig	= new appconfig();
	$datos		= $appconfig->conexion();
	$hostname	= $datos['hostname'];
	$database	= $datos['database'];
	$username	= $datos['username'];
	$password	= $datos['password'];


	$conex = mysql_connect($hostname,$username,$password) or die ("no se puede conectar".mysql_error());

	mysql_select_db($database);

	$result = mysql_query($sql,$conex);
	if ($accion && $result) {
		$result = mysql_insert_id();
	}
	mysql_close($conex);
	return $result;

}




$tablasAr	= array('rolhogar' => 'tbrolhogar',
							'tipopromotores' => 'tbtipopromotores',
							'promotorestados' => 'tbpromotorestados',
							'estadocivil' => 'tbestadocivil',
							'entidadnacimiento' => 'tbentidadnacimiento',
							'entidades' => 'tbentidades',
							'promotores' => 'dbpromotores',
							'sucursales' => 'dbsucursales',
							'clientes' => 'dbclientes',
							'tipoclientes' => 'tbtipoclientes',
							'solicitudes' => 'dbsolicitudes',
							'tiposolicitudes' => 'tbtiposolicitudes',
							'estadosolicitudes' => 'tbestadosolicitudes',
							'tipoingreso' => 'tbtipoingreso',
							'documentaciones' => 'dbdocumentaciones',
							'documentacionsolicitudes' => 'dbdocumentacionsolicitudes',
							'asesores' => 'dbasesores',
							'documentacionasesores' => 'dbdocumentacionasesores',
							'postulantes' => 'dbpostulantes',
							'estadopostulantes' => 'tbestadopostulantes',
							'estadodocumentaciones' => 'tbestadodocumentaciones',
							'tipodocumentaciones' => 'tbtipodocumentaciones',
							'entrevistas' => 'dbentrevistas',
							'estadoentrevistas' => 'tbestadoentrevistas',
							'preguntas' => 'dbpreguntas',
							'ip' => 'tbip',
							'correoselectronicos' => 'dbcorreoselectronicos',
							'entrevistasucursales' => 'tbentrevistasucursales',
							'respuestadetalles' => 'dbrespuestadetalles',
							'segurosempresas' => 'tbsegurosempresas',
							'postulanteseguros' => 'dbpostulanteseguros',
							'contactos' => 'dbcontactos',
							'productos' => 'tbproductos',
							'contactoproductos' => 'dbcontactoproductos',
							'esquemadocumentosestados' => 'dbesquemadocumentosestados',
							'guias' => 'dbguias',
							'seguimientos' => 'dbseguimientos',
							'reclutadorasores' => 'dbreclutadorasores',
							'oportunidades' => 'dboportunidades',
							'entrevistaoportunidades' => 'dbentrevistaoportunidades',
							'referentes' => 'tbreferentes',
							'estadooportunidad' => 'tbestadooportunidad',
							'motivorechazos' => 'tbmotivorechazos',
							'asociados' => 'dbasociados',
							'tipopersonas' => 'tbtipopersonas',
							'tiposeguimientos' => 'tbtiposeguimientos',
							'alertas' => 'dbalertas',
							'cotizaciones' => 'dbcotizaciones',
							'estadocotizaciones' => 'tbestadocotizaciones',
							'reasignaciones' => 'dbreasignaciones',
							'estadoasociado' => 'tbestadoasociado',
							'tipoasociados' => 'tbtipoasociado',
							'estadoasesor' => 'tbestadoasesor',
							'documentacioncotizaciones' => 'dbdocumentacioncotizaciones',
							'directorioasesores' => 'dbdirectorioasesores',
							'clientesasesores' => 'dbclientesasesores',
							'domicilios' => 'dbdomicilios',
							'estadogeneraloportunidad' => 'dbestadogeneraloportunidad',
							'socios' => 'tbsocios',
							'perfilasesores' => 'dbperfilasesores',
							'perfilasesoresespecialidades' => 'dbperfilasesoresespecialidades',
							'tipofigura' => 'tbtipofigura',
							'especialidades' => 'tbespecialidades',
							'comisiones' => 'dbcomisiones',
							'tabla' => 'tbtabla',
							'constancias' => 'dbconstancias',
							'bonogestion' => 'tbbonogestion',
							'constanciasseguimiento' => 'dbconstanciasseguimiento',
							'clientescartera' => 'dbclientescartera',
							'estadopago' => 'tbestadopago',
							'tipocobranza' => 'tbtipocobranza',
							'tipoperiodicidad' => 'tbtipoperiodicidad',
							'estadoventa' => 'tbestadoventa',
							'periodicidadventaspagos' => 'dbperiodicidadventaspagos',
							'periodicidadventasdetalle' => 'dbperiodicidadventasdetalle',
							'periodicidadventas' => 'dbperiodicidadventas',
							'tipoproductorama' => 'tbtipoproductorama',
							'tipoproducto' => 'tbtipoproducto',
							'aseguradora' => 'tbaseguradora',
							'mensajes' => 'dbmensajes',
							'cuestionarios' => 'dbcuestionarios',
							'tiporespuesta' => 'tbtiporespuesta',
							'preguntascuestionario' => 'dbpreguntascuestionario',
							'respuestascuestionario' => 'dbrespuestascuestionario',
							'cuestionariodetalle' => 'dbcuestionariodetalle',
							'procesocotizacion' => 'tbprocesocotizacion',
							'productosexclusivos' => 'dbproductosexclusivos',
							'comerciofin' => 'dbcomerciofin',
							'comercioinicio' => 'dbcomercioinicio',
							'afiliados' => 'tbafiliados',
							'origencomercio' => 'tborigencomercio',
							'estadotransaccion' => 'tbestadotransaccion',
							'ordenpago' => 'dbordenpago',
							'mejorarcondiciones' => 'dbmejorarcondiciones',
							'mejorarcondicionesarchivos' => 'dbmejorarcondicionesarchivos',
							'tipoparentesco' => 'tbtipoparentesco',
							'tbproductosweb' => 'tbproductosweb',
							'autologin' => 'autologin',
							'motivorechazocotizaciones' => 'tbmotivorechazocotizaciones',
							'valoredad' => 'dbvaloredad',
							'paquetes' => 'dbpaquetes',
							'paquetedetalles' => 'dbpaquetedetalles',
							'tipofirma' => 'tbtipofirma',
							'tokens' => 'dbtokens',
							'firmarcontratos' => 'dbfirmarcontratos',
							'metodopago' => 'dbmetodopago',
							'pagos' => 'dbpagos'
							);


function recursiveTablas($ar, $tabla, $aliasTablaMadre) {

	$tablasArAux2	= array('rolhogar' => 'tbrolhogar',
								'tipopromotores' => 'tbtipopromotores',
								'promotorestados' => 'tbpromotorestados',
								'estadocivil' => 'tbestadocivil',
								'entidadnacimiento' => 'tbentidadnacimiento',
								'entidades' => 'tbentidades',
								'promotores' => 'dbpromotores',
								'sucursales' => 'dbsucursales',
								'clientes' => 'dbclientes',
								'tipoclientes' => 'tbtipoclientes',
								'solicitudes' => 'dbsolicitudes',
								'tiposolicitudes' => 'tbtiposolicitudes',
								'estadosolicitudes' => 'tbestadosolicitudes',
								'tipoingreso' => 'tbtipoingreso',
								'documentaciones' => 'dbdocumentaciones',
								'documentacionsolicitudes' => 'dbdocumentacionsolicitudes',
								'asesores' => 'dbasesores',
								'documentacionasesores' => 'dbdocumentacionasesores',
								'postulantes' => 'dbpostulantes',
								'estadopostulantes' => 'tbestadopostulantes',
								'estadodocumentaciones' => 'tbestadodocumentaciones',
								'tipodocumentaciones' => 'tbtipodocumentaciones',
								'entrevistas' => 'dbentrevistas',
								'estadoentrevistas' => 'tbestadoentrevistas',
								'preguntas' => 'dbpreguntas',
								'ip' => 'tbip',
								'correoselectronicos' => 'dbcorreoselectronicos',
								'entrevistasucursales' => 'tbentrevistasucursales',
								'respuestadetalles' => 'dbrespuestadetalles',
								'segurosempresas' => 'tbsegurosempresas',
								'postulanteseguros' => 'dbpostulanteseguros',
								'contactos' => 'dbcontactos',
								'productos' => 'tbproductos',
								'contactoproductos' => 'dbcontactoproductos',
								'esquemadocumentosestados' => 'dbesquemadocumentosestados',
								'guias' => 'dbguias',
								'seguimientos' => 'dbseguimientos',
								'reclutadorasores' => 'dbreclutadorasores',
								'oportunidades' => 'dboportunidades',
								'entrevistaoportunidades' => 'dbentrevistaoportunidades',
								'referentes' => 'tbreferentes',
								'estadooportunidad' => 'tbestadooportunidad',
								'motivorechazos' => 'tbmotivorechazos',
								'asociados' => 'dbasociados',
								'tipopersonas' => 'tbtipopersonas',
								'tiposeguimientos' => 'tbtiposeguimientos',
								'alertas' => 'dbalertas',
								'cotizaciones' => 'dbcotizaciones',
								'estadocotizaciones' => 'tbestadocotizaciones',
								'reasignaciones' => 'dbreasignaciones',
								'estadoasociado' => 'tbestadoasociado',
								'tipoasociados' => 'tbtipoasociado',
								'estadoasesor' => 'tbestadoasesor',
								'documentacioncotizaciones' => 'dbdocumentacioncotizaciones',
								'directorioasesores' => 'dbdirectorioasesores',
								'clientesasesores' => 'dbclientesasesores',
								'domicilios' => 'dbdomicilios',
								'estadogeneraloportunidad' => 'dbestadogeneraloportunidad',
								'socios' => 'tbsocios',
								'perfilasesores' => 'dbperfilasesores',
								'perfilasesoresespecialidades' => 'dbperfilasesoresespecialidades',
								'tipofigura' => 'tbtipofigura',
								'especialidades' => 'tbespecialidades',
								'comisiones' => 'dbcomisiones',
								'tabla' => 'tbtabla',
								'constancias' => 'dbconstancias',
								'bonogestion' => 'tbbonogestion',
								'constanciasseguimiento' => 'dbconstanciasseguimiento',
								'clientescartera' => 'dbclientescartera',
								'estadopago' => 'tbestadopago',
								'tipocobranza' => 'tbtipocobranza',
								'tipoperiodicidad' => 'tbtipoperiodicidad',
								'estadoventa' => 'tbestadoventa',
								'periodicidadventaspagos' => 'dbperiodicidadventaspagos',
								'periodicidadventasdetalle' => 'dbperiodicidadventasdetalle',
								'periodicidadventas' => 'dbperiodicidadventas',
								'tipoproductorama' => 'tbtipoproductorama',
								'tipoproducto' => 'tbtipoproducto',
								'aseguradora' => 'tbaseguradora',
								'mensajes' => 'dbmensajes',
								'cuestionarios' => 'dbcuestionarios',
								'tiporespuesta' => 'tbtiporespuesta',
								'preguntascuestionario' => 'dbpreguntascuestionario',
								'respuestascuestionario' => 'dbrespuestascuestionario',
								'cuestionariodetalle' => 'dbcuestionariodetalle',
								'procesocotizacion' => 'tbprocesocotizacion',
								'productosexclusivos' => 'dbproductosexclusivos',
								'comerciofin' => 'dbcomerciofin',
								'comercioinicio' => 'dbcomercioinicio',
								'afiliados' => 'tbafiliados',
								'origencomercio' => 'tborigencomercio',
								'estadotransaccion' => 'tbestadotransaccion',
								'ordenpago' => 'dbordenpago',
								'mejorarcondiciones' => 'dbmejorarcondiciones',
								'mejorarcondicionesarchivos' => 'dbmejorarcondicionesarchivos',
								'tipoparentesco' => 'tbtipoparentesco',
								'tbproductosweb' => 'tbproductosweb',
								'autologin' => 'autologin',
								'motivorechazocotizaciones' => 'tbmotivorechazocotizaciones',
								'valoredad' => 'dbvaloredad',
								'paquetes' => 'dbpaquetes',
								'paquetedetalles' => 'dbpaquetedetalles',
								'tipofirma' => 'tbtipofirma',
								'tokens' => 'dbtokens',
								'firmarcontratos' => 'dbfirmarcontratos',
								'metodopago' => 'dbmetodopago',
								'pagos' => 'dbpagos'
							);

	$tablasArAux	= array('rolhogar' => 1,
								'tipopromotores' => 1,
								'promotorestados' => 1,
								'estadocivil' => 1,
								'entidadnacimiento' => 1,
								'entidades' => 1,
								'promotores' => 5,
								'sucursales' => 2,
								'clientes' => 5,
								'tipoclientes' => 1,
								'solicitudes' => 4,
								'tiposolicitudes' => 1,
								'estadosolicitudes' => 1,
								'tipoingreso' => 1,
								'documentaciones' => 2,
								'documentacionsolicitudes' => 4,
								'asesores' => 2,
								'documentacionasesores' => 4,
								'postulantes' => 3,
								'estadopostulantes' => 1,
								'estadodocumentaciones' => 1,
								'tipodocumentaciones' => 1,
								'entrevistas' => 4,
								'estadoentrevistas' => 1,
								'preguntas' => 1,
								'ip' => 1,
								'correoselectronicos' => 1,
								'entrevistasucursales' => 1,
								'respuestadetalles' => 1,
								'segurosempresas' => 1,
								'postulanteseguros' => 1,
								'contactos' => 1,
								'productos' => 1,
								'contactoproductos' => 1,
								'esquemadocumentosestados' => 1,
								'guias' => 1,
								'seguimientos' => 1,
								'reclutadorasores' => 3,
								'oportunidades' => 3,
								'entrevistaoportunidades' => 2,
								'referentes' => 1,
								'estadooportunidad' => 1,
								'motivorechazos' => 1,
								'asociados' => 3,
								'tipopersonas' => 1,
								'tiposeguimientos' => 1,
								'alertas' => 2,
								'cotizaciones' => 5,
								'estadocotizaciones' => 1,
								'reasignaciones' => 1,
								'estadoasociado' => 1,
								'tipoasociados' => 1,
								'estadoasesor' => 1,
								'documentacioncotizaciones' => 3,
								'directorioasesores' => 1,
								'clientesasesores' => 1,
								'domicilios' => 1,
								'estadogeneraloportunidad' => 1,
								'socios' => 1,
								'perfilasesores' => 1,
								'perfilasesoresespecialidades' => 1,
								'tipofigura' => 1,
								'especialidades' => 1,
								'comisiones' => 1,
								'tabla' => 1,
								'constancias' => 2,
								'bonogestion' => 1,
								'constanciasseguimiento' => 2,
								'clientescartera' => 3,
								'estadopago' => 1,
								'tipocobranza' => 1,
								'tipoperiodicidad' => 1,
								'estadoventa' => 1,
								'periodicidadventaspagos' => 2,
								'periodicidadventasdetalle' => 2,
								'periodicidadventas' => 3,
								'tipoproductorama' => 1,
								'tipoproducto' => 1,
								'aseguradora' => 1,
								'mensajes' => 1,
								'cuestionarios' => 1,
								'tiporespuesta' => 1,
								'preguntascuestionario' => 2,
								'respuestascuestionario' => 1,
								'cuestionariodetalle' => 2,
								'procesocotizacion' => 1,
								'productosexclusivos' => 1,
								'comerciofin' => 1,
								'comercioinicio' => 1,
								'afiliados' => 1,
								'origencomercio' => 1,
								'estadotransaccion' => 1,
								'ordenpago' => 1,
								'mejorarcondiciones' => 1,
								'mejorarcondicionesarchivos' => 1,
								'tipoparentesco' => 1,
								'tbproductosweb' => 1,
								'autologin' => 1,
								'motivorechazocotizaciones' => 1,
								'valoredad' => 1,
								'paquetes' => 1,
								'paquetedetalles' => 2,
								'tipofirma' => 1,
								'tokens' => 1,
								'firmarcontratos' => 1,
								'metodopago' => 3,
								'pagos' => 1
							);

	$inner= '';
	$sql	=	"show columns from ".$tabla;
	$res 	=	query($sql,0);

	while ($row = mysql_fetch_array($res)) {
		if ($row[3] == 'MUL') {
			$TableReferencia 	= str_replace('ref','',$row[0]);
			//if ($tablasArAux[$TableReferencia] == 1) {
				recursiveTablas($tablasArAux2, $ar[$TableReferencia], $aliasTablaMadre);
			//}
			//recursiveTablas($ar, $ar[$TableReferencia], $aliasTablaMadre);

			$sqlTR	=	"show columns from ".$ar[$TableReferencia];
			//die(var_dump($tablasAr['clientes']));
			$resTR 	=	query($sqlTR,0);
			$inner .= " inner join ".$ar[$TableReferencia]." ".substr($TableReferencia,0,2)." ON ".substr($TableReferencia,0,2).".".mysql_result($resTR,0,0)." = ".$aliasTablaMadre.".".$row[0]." <br>";

		}
	}

	return $inner;
}

$ajaxFunciones = '';
$ajaxFuncionesController = '';

$servicios	= "Referencias";

$sqlMapaer	= "SHOW FULL TABLES FROM u115752684_asesores";
$resMapeo 	=	query($sqlMapaer,0);

$aliasTablaMadre = '';

$includesajax = '';

while ($rowM = mysql_fetch_array($resMapeo)) {

$sql	=	"show columns from ".$rowM[0];
$res 	=	query($sql,0);

$aliasTablaMadre = substr(str_replace('tb','',str_replace('db','',$rowM[0])),0,1);

$tabla 		= $rowM[0];
$nombre 	= ucwords(str_replace('tb','',str_replace('db','',$rowM[0])));


if ($res == false) {
	return 'Error al traer datos';
} else {

	$ajax		=	'';
	$includes	=	'';


	$cuerpoVariableComunes = "";
	$cuerpoVariable = "'',";
	$cuerpoSQL = '';

	$cuerpoVariableUpdate = "";
	$cuerpoVariablePOST = "";

	$ajaxFunciones .= "

		case 'insertar".$nombre."': <br>
			insertar".$nombre."("."$"."servicios".$servicios."); <br>
			break; <br>
		case 'modificar".$nombre."': <br>
			modificar".$nombre."("."$"."servicios".$servicios."); <br>
			break; <br>
		case 'eliminar".$nombre."': <br>
			eliminar".$nombre."("."$"."servicios".$servicios."); <br>
			break; <br>
		case 'traer".$nombre."': <br>
			traer".$nombre."("."$"."servicios".$servicios."); <br>
			break; <br>
		case 'traer".$nombre."PorId': <br>
			traer".$nombre."PorId("."$"."servicios".$servicios."); <br>
			break; <br>



	";




	$inner = '';
	while ($row = mysql_fetch_array($res)) {
		if ($row[3] == 'PRI') {
			$clave = $row[0];
		} else {


			// trato las tablas con referencias

			if ($row[3] == 'MUL') {
				$TableReferencia 	= str_replace('ref','',$row[0]);
				$sqlTR	=	"show columns from ".$tablasAr[$TableReferencia];
				//die(var_dump($tablasAr['clientes']));
				$resTR 	=	query($sqlTR,0);
				$inner .= " inner join ".$tablasAr[$TableReferencia]." ".substr($TableReferencia,0,3)." ON ".substr($TableReferencia,0,3).".".mysql_result($resTR,0,0)." = ".$aliasTablaMadre.".".$row[0]." <br>";
				/*if ($TableReferencia == 'clientevehiculos') {
					die(var_dump('aca'));
				}*/
				$inner .= recursiveTablas($tablasAr, $tablasAr[$TableReferencia], substr($TableReferencia,0,3));
			}


			switch ($row[1]) {
				case "date":
					$cuerpoVariablePOST 	= $cuerpoVariablePOST."$".$row[0]." = "."$"."_POST['".$row[0]."']; <br>";
					$cuerpoVariable 		= $cuerpoVariable."'".'".$'.$row[0].'."'."',";
					$cuerpoVariableComunes	= $cuerpoVariableComunes."$".$row[0].",";
					$cuerpoSQL 				= $cuerpoSQL.$row[0].",";

					$cuerpoVariableUpdate = $cuerpoVariableUpdate.$row[0].' = '."'".'".$'.$row[0].'."'."',";
					break;
				case "datetime":
					$cuerpoVariablePOST 	= $cuerpoVariablePOST."$".$row[0]." = "."$"."_POST['".$row[0]."']; <br>";
					$cuerpoVariable = $cuerpoVariable."'".'".$'.$row[0].'."'."',";
					$cuerpoVariableComunes = $cuerpoVariableComunes."$".$row[0].",";
					$cuerpoSQL = $cuerpoSQL.$row[0].",";
					$cuerpoVariableUpdate = $cuerpoVariableUpdate.$row[0].' = '."'".'".$'.$row[0].'."'."',";
					break;
				default:
					if (strpos($row[1],"varchar") !== false) {
						$cuerpoVariablePOST 	= $cuerpoVariablePOST."$".$row[0]." = "."$"."_POST['".$row[0]."']; <br>";
						$cuerpoVariable = $cuerpoVariable."'".'".$'.$row[0].'."'."',";
						$cuerpoVariableComunes = $cuerpoVariableComunes."$".$row[0].",";
						$cuerpoSQL = $cuerpoSQL.$row[0].",";
						$cuerpoVariableUpdate = $cuerpoVariableUpdate.$row[0].' = '."'".'".$'.$row[0].'."'."',";
					} else {
						if (strpos($row[1],"bit") !== false) {
							$cuerpoVariablePOST 	= $cuerpoVariablePOST."
									if (isset("."$"."_POST['".$row[0]."'])) { <br>
										"."$".$row[0]."	= 1; <br>
									} else { <br>
										"."$".$row[0]." = 0; <br>
									} <br>

							";
							//$cuerpoSQL = $cuerpoSQL."(case when ".$row[0]." = 1 then 'Si' else 'No' end) as ".$row[0].",";
						} else {
							$cuerpoVariablePOST 	= $cuerpoVariablePOST."$".$row[0]." = "."$"."_POST['".$row[0]."']; <br>";
							//$cuerpoSQL = $cuerpoSQL.$row[0].",";
						}
						$cuerpoVariable = $cuerpoVariable.'".$'.$row[0].'.",';
						$cuerpoVariableComunes = $cuerpoVariableComunes."$".$row[0].",";
						$cuerpoSQL = $cuerpoSQL.$row[0].",";
						$cuerpoVariableUpdate = $cuerpoVariableUpdate.$row[0].' = '.'".$'.$row[0].'."'.",";
					}

					break;
			}

		}

	}



	$cuerpoVariable			= substr($cuerpoVariable,0,strlen($cuerpoVariable)-1);
	$cuerpoVariableUpdate	= substr($cuerpoVariableUpdate,0,strlen($cuerpoVariableUpdate)-1);
	$cuerpoVariableComunes	= substr($cuerpoVariableComunes,0,strlen($cuerpoVariableComunes)-1);
	$cuerpoSQL				= substr($cuerpoSQL,0,strlen($cuerpoSQL)-1);


	//$ajaxFuncionesController = '';

	$ajaxFuncionesController .= "

		function insertar".$nombre."("."$"."servicios".$servicios.") { <br>
			".$cuerpoVariablePOST."

			"."$"."res = "."$"."servicios".$servicios."->insertar".$nombre."(".$cuerpoVariableComunes."); <br>

			if ((integer)"."$"."res > 0) { <br>
				echo ''; <br>
			} else { <br>
				echo 'Hubo un error al insertar datos';	 <br>
			} <br>

		} <br>

		function modificar".$nombre."("."$"."servicios".$servicios.") { <br>

			"."$"."id = 	"."$"."_POST['id']; <br>
			".$cuerpoVariablePOST."

			"."$"."res = "."$"."servicios".$servicios."->modificar".$nombre."("."$"."id,".$cuerpoVariableComunes."); <br>

			if ("."$"."res == true) { <br>
				echo ''; <br>
			} else { <br>
				echo 'Hubo un error al modificar datos'; <br>
			} <br>
		} <br>

		function eliminar".$nombre."("."$"."servicios".$servicios.") { <br>
			"."$"."id = 	"."$"."_POST['id']; <br>

			"."$"."res = "."$"."servicios".$servicios."->eliminar".$nombre."("."$"."id); <br>
			if ("."$"."res == true) { <br>
				echo ''; <br>
			} else { <br>
				echo 'Hubo un error al eliminar datos'; <br>
			} <br>
		} <br>


		function traer".$nombre."("."$"."servicios".$servicios.") { <br>

			"."$"."res = "."$"."servicios".$servicios."->traer".$nombre."(); <br>

			"."$"."ar = array(); <br>

			while ("."$"."row = mysql_fetch_array("."$"."res)) { <br>
				array_push("."$"."ar, "."$"."row); <br>
			} <br>

			"."$"."resV['datos'] = "."$"."ar; <br>

			header('Content-type: application/json'); <br>
			echo json_encode("."$"."resV); <br>
		} <br>


	";





	//$includes = '';

	$includes = $includes.'

		function insertar'.$nombre.'('.$cuerpoVariableComunes.') { <br>
			$sql = "insert into '.$tabla.'('.$clave.','.$cuerpoSQL.') <br>
											values ('.$cuerpoVariable.')"; <br>
			$res = $this->query($sql,1); <br>
			return $res; <br>
		} <br>


		<br>
		<br>
		function modificar'.$nombre.'($id,'.$cuerpoVariableComunes.') { <br>
			$sql = "update '.$tabla.' <br>
					set <br>
						'.$cuerpoVariableUpdate.' <br>
						where '.$clave.' =".$id; <br>
			$res = $this->query($sql,0); <br>
			return $res; <br>
		} <br>
		<br>
		<br>
		function eliminar'.$nombre.'($id) { <br>
			$sql = "delete from '.$tabla.' where '.$clave.' =".$id; <br>
			$res = $this->query($sql,0); <br>
			return $res; <br>
		} <br>
		 <br>
		  <br>
		function traer'.$nombre.'() { <br>
			$sql = "select <br>'.$aliasTablaMadre.".".$clave.',<br>'.$aliasTablaMadre.".".str_replace(",",",<br>".$aliasTablaMadre.".",$cuerpoSQL).'<br> from '.$tabla." ".$aliasTablaMadre." <br>".$inner.' order by 1"; <br>
			$res = $this->query($sql,0); <br>
			return $res; <br>
		} <br>
		 <br>
		  <br>
		function traer'.$nombre.'PorId($id) { <br>
			$sql = "select '.$clave.','.$cuerpoSQL.' from '.$tabla.' where '.$clave.' =".$id; <br>
			$res = $this->query($sql,0); <br>
			return $res; <br>
		} <br>
		<br>


	';

	$includesajax .= '
		function traer'.$nombre.'ajax($length, $start, $busqueda,$colSort,$colSortDir) { <br>
			 <br>
			$where = '."'"."'".'; <br>
			 <br>
			$busqueda = str_replace("'."'".'","",$busqueda); <br>
			if ($busqueda != "") { <br>
				$where = " where variables "; <br>
			} <br>
			 <br>
			$sql = "select  <br>
				<br>'.$aliasTablaMadre.".".$clave.',<br>'.$aliasTablaMadre.".".str_replace(",",",<br>".$aliasTablaMadre.".",$cuerpoSQL).'<br> from '.$tabla." ".$aliasTablaMadre." <br>".$inner.'
			".$where." <br>
			ORDER BY ".$colSort." ".$colSortDir." <br>
			limit ".$start.",".$length; <br>
			 <br>
			$res = $this->query($sql,0); <br>
			return $res; <br>
		} <br>
		 <br>
	';



//	echo "<br><br>/*   PARA ".$nombre." */<br><br>".$includes."<br>/* Fin */<br>/*   PARA ".$nombre." */<br>".$ajaxFunciones."<br>/* Fin */<br><br>/*   PARA ".$nombre." */<br>".$ajaxFuncionesController."<br>/* Fin */";

	echo "<br><br>/*   PARA ".$nombre." */<br><br>".$includes."<br>/* Fin */<br>/*";

}

	//echo '<hr>';
	echo ' /* Fin de la Tabla: '.$rowM[0]."*/<br>";

}
echo "********************************************************************************<br>";
//echo "<br><br>/*   PARA AJAX */<br><br>".$includesajax."<br>/* Fin */<br>/*";
echo "********************************************************************************<br>";
echo "<br><br>/*   PARA ".$nombre." */<br><br>".$ajaxFunciones."<br>/* Fin */<br>/*";
echo "<br><br>/*   PARA ".$nombre." */<br><br>".$ajaxFuncionesController."<br>/* Fin */<br>/*";

?>
</body>
</html>
