<?php

/**
 * @Usuarios clase en donde se accede a la base de datos
 * @ABM consultas sobre las tablas de usuarios y usarios-clientes
 */

date_default_timezone_set('America/Mexico_City');

class ServiciosReferencias {



	/* /* Fin de la Tabla: tbtiposolicitudes*/

   function GUID()
   {
       if (function_exists('com_create_guid') === true)
       {
           return trim(com_create_guid(), '{}');
       }

       return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
   }


///**********  PARA SUBIR ARCHIVOS  ***********************//////////////////////////
	function borrarDirecctorio($dir) {
		array_map('unlink', glob($dir."/*.*"));

	}

	function borrarArchivo($id,$archivo) {
		$sql	=	"delete from images where idfoto =".$id;

		$res =  unlink("./../archivos/".$archivo);
		if ($res)
		{
			$this->query($sql,0);
		}
		return $res;
	}


	function existeArchivo($id,$nombre,$type) {
		$sql		=	"select * from images where refproyecto =".$id." and imagen = '".$nombre."' and type = '".$type."'";
		$resultado  =   $this->query($sql,0);

			   if(mysql_num_rows($resultado)>0){

				   return mysql_result($resultado,0,0);
			   }

			   return 0;
	}

	function sanear_string($string)
   {

       $string = trim($string);

       $string = str_replace(
           array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
           array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
           $string
       );

       $string = str_replace(
           array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
           array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
           $string
       );

       $string = str_replace(
           array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
           array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
           $string
       );

       $string = str_replace(
           array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
           array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
           $string
       );

       $string = str_replace(
           array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
           array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
           $string
       );

       $string = str_replace(
           array('ñ', 'Ñ', 'ç', 'Ç'),
           array('n', 'N', 'c', 'C',),
           $string
       );

       $string = str_replace(
           array('(', ')', '{', '}',' '),
           array('', '', '', '',''),
           $string
       );



       return $string;
   }

   function crearDirectorioPrincipal($dir) {
   	if (!file_exists($dir)) {
   		mkdir($dir, 0777);
   	}
   }



	function subirArchivo($file,$carpeta,$id,$token,$observacion, $refcategorias, $anio, $mes, $reftipoarchivos, $asunto) {


		$dir_destino_padre = '../archivos/'.$carpeta.'/';
		$dir_destino = '../archivos/'.$carpeta.'/'.$id.'/';
		$imagen_subida = $dir_destino . $this->sanear_string(str_replace(' ','',basename($_FILES[$file]['name'])));

		$noentrar = '../imagenes/index.php';
		$nuevo_noentrar = '../archivos/'.$carpeta.'/'.$id.'/'.'index.php';

		//die(var_dump($dir_destino));
		if (!file_exists($dir_destino_padre)) {
			mkdir($dir_destino_padre, 0777);
		}

		if (!file_exists($dir_destino)) {
			mkdir($dir_destino, 0777);
		}


		if(!is_writable($dir_destino)){

			echo "no tiene permisos";

		}	else	{
			if ($_FILES[$file]['tmp_name'] != '') {
				if(is_uploaded_file($_FILES[$file]['tmp_name'])){
					//la carpeta de libros solo los piso
					if ($carpeta == 'galeria') {
						$this->eliminarFotoPorObjeto($id);
					}
					/*echo "Archivo ". $_FILES['foto']['name'] ." subido con éxtio.\n";
					echo "Mostrar contenido\n";
					echo $imagen_subida;*/
					if (move_uploaded_file($_FILES[$file]['tmp_name'], $imagen_subida)) {

						$archivo = $this->sanear_string($_FILES[$file]["name"]);
						$tipoarchivo = $_FILES[$file]["type"];

						$filename = $dir_destino.'descarga.zip';
						$zip = new ZipArchive();

						if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
						exit('cannot open <$filename>\n');
						}

						$zip->addFile($dir_destino.$archivo, $archivo);

						$zip->close();

                  copy($noentrar, $nuevo_noentrar);

						$this->insertarArchivos($carpeta,$token,str_replace(' ','',$archivo),$tipoarchivo, $observacion, $refcategorias, $anio, $mes,$reftipoarchivos,$asunto);

                  //$this->modificarClienteImagenPorId($carpeta,$archivo);

						echo "";

						copy($noentrar, $nuevo_noentrar);

					} else {
						echo "Posible ataque de carga de archivos!\n";
					}
				}else{
					echo "Posible ataque del archivo subido: ";
					echo "nombre del archivo '". $_FILES[$file]['tmp_name'] . "'.";
				}
			}
		}
	}


   function subirFoto($file,$carpeta,$id) {

      // carpeta = 'idcliente'
      // id = 'foto frente 1 o foto dorsal 2'


		$dir_destino_padre = '../data/'.$carpeta.'/';

		$dir_destino = '../data/'.$carpeta.'/'.$id.'/';

      $this->borrarDirecctorio($dir_destino);

		$imagen_subida = $dir_destino . $this->sanear_string(str_replace(' ','',basename($_FILES[$file]['name'])));

		$noentrar = '../imagenes/index.php';
		$nuevo_noentrar = '../data/'.$carpeta.'/'.$id.'/'.'index.php';

		//die(var_dump($dir_destino));
		if (!file_exists($dir_destino_padre)) {
			mkdir($dir_destino_padre, 0777);
		}

		if (!file_exists($dir_destino)) {
			mkdir($dir_destino, 0777);
		}


		if(!is_writable($dir_destino)){

			echo "no tiene permisos";

		}	else	{
			if ($_FILES[$file]['tmp_name'] != '') {
				if(is_uploaded_file($_FILES[$file]['tmp_name'])){
					//la carpeta de libros solo los piso
					if ($carpeta == 'galeria') {
						$this->eliminarFotoPorObjeto($id);
					}
					/*echo "Archivo ". $_FILES['foto']['name'] ." subido con éxtio.\n";
					echo "Mostrar contenido\n";
					echo $imagen_subida;*/
					if (move_uploaded_file($_FILES[$file]['tmp_name'], $imagen_subida)) {

						$archivo = $this->sanear_string($_FILES[$file]["name"]);
						$tipoarchivo = $_FILES[$file]["type"];

						$filename = $dir_destino.'descarga.zip';
						$zip = new ZipArchive();

						if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
						exit('cannot open <$filename>\n');
						}

						$zip->addFile($dir_destino.$archivo, $archivo);

						$zip->close();

                  if ($id == 1) {
                     $resMod = $this->modificarClienteImagenFrentePorId($carpeta, $archivo);
                  } else {
                     $resMod = $this->modificarClienteImagenDorsalPorId($carpeta, $archivo);
                  }

						echo '';

						copy($noentrar, $nuevo_noentrar);

					} else {
						echo "Posible ataque de carga de archivos!\n";
					}
				}else{
					echo "Posible ataque del archivo subido: ";
					echo "nombre del archivo '". $_FILES[$file]['tmp_name'] . "'.";
				}
			}
		}
	}



	function TraerFotosRelacion($id) {
		$sql    =   "select 'galeria',s.idproducto,f.imagen,f.idfoto,f.type
							from dbproductos s

							inner
							join images f
							on	s.idproducto = f.refproyecto

							where s.idproducto = ".$id;
		$result =   $this->query($sql, 0);
		return $result;
	}


	function eliminarFoto($id)
	{

		$sql		=	"select concat('galeria','/',s.idproducto,'/',f.imagen) as archivo
							from dbproductos s

							inner
							join images f
							on	s.idproducto = f.refproyecto

							where f.idfoto =".$id;
		$resImg		=	$this->query($sql,0);

		if (mysql_num_rows($resImg)>0) {
			$res 		=	$this->borrarArchivo($id,mysql_result($resImg,0,0));
		} else {
			$res = true;
		}
		if ($res == false) {
			return 'Error al eliminar datos';
		} else {
			return '';
		}
	}


   function zerofill($valor, $longitud){
    $res = str_pad($valor, $longitud, '0', STR_PAD_LEFT);
    return $res;
   }

   function existeDevuelveId($sql) {

   	$res = $this->query($sql,0);

   	if (mysql_num_rows($res)>0) {
   		return mysql_result($res,0,0);
   	}
   	return 0;
   }



   /* PARA Estados */

   function insertarEstados($estado,$color,$icono) {
   $sql = "insert into tbestados(idestado,estado,color,icono)
   values (null,'".$estado."','".$color."','".$icono."')";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarEstados($id,$estado,$color,$icono) {
   $sql = "update tbestados
   set
   estado = '".$estado."',color = '".$color."',icono = '".$icono."'
   where idestado =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarEstados($id) {
   $sql = "delete from tbestados where idestado =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function traerEstados() {
   $sql = "select
   e.idestado,
   e.estado,
   e.color,
   e.icono
   from tbestados e
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }

	function traerEstadosPorId($id) {
   $sql = "select
   e.idestado,
   e.estado,
   e.color,
   e.icono
   from tbestados e
	where e.idestado = ".$id."
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }

	function traerEstadodocumentaciones() {
   $sql = "select
   e.idestadodocumentacion,
   e.estadodocumentacion,
   e.color
   from tbestadodocumentaciones e
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }

   function traerEstadodocumentacionesPorId($id) {
   $sql = "select
   e.idestadodocumentacion,
   e.estadodocumentacion,
   e.color
   from tbestadodocumentaciones e
   where e.idestadodocumentacion = ".$id."
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: tbestados*/

   /* PARA Meses */

   function insertarMeses($meses,$desde,$hasta) {
   $sql = "insert into tbmeses(idmes,meses,desde,hasta)
   values (null,'".$meses."',".$desde.",".$hasta.")";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarMeses($id,$meses,$desde,$hasta) {
   $sql = "update tbmeses
   set
   meses = '".$meses."',desde = ".$desde.",hasta = ".$hasta."
   where idmes =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarMeses($id) {
   $sql = "delete from tbmeses where idmes =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function traerMeses() {
   $sql = "select
   m.idmes,
   m.meses,
   m.desde,
   m.hasta
   from tbmeses m
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerMesesPorMes($mes) {
   $sql = "select
   m.idmes,
   m.meses,
   m.desde,
   m.hasta
   from tbmeses m
   where ".$mes." between m.desde and m.hasta
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerMesesPorId($id) {
   $sql = "select idmes,meses,desde,hasta from tbmeses where idmes =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

   /* Fin */
   /* /* Fin de la Tabla: tbmeses*/



   /* PARA Clientes */

   function existeCliente($nrodocumento, $modifica = 0, $id = 0) {
      if ($modifica == 1) {
         $sql = "select * from dbclientes where curp = '".$nrodocumento."' and idcliente <> ".$id;
      } else {
         $sql = "select * from dbclientes where curp = '".$nrodocumento."'";
      }

   	$res = $this->query($sql,0);
   	if (mysql_num_rows($res)>0) {
   		return true;
   	} else {
   		return false;
   	}
   }



   /* PARA Usuarios */

   function insertarUsuarios($usuario,$password,$refroles,$email,$nombrecompleto,$activo, $refsocios) {
   $sql = "insert into dbusuarios(idusuario,usuario,password,refroles,email,nombrecompleto,activo, refsocios)
   values (null,'".$usuario."','".$password."',".$refroles.",'".$email."','".$nombrecompleto."',".$activo.",".$refsocios.")";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarUsuarios($id,$usuario,$password,$refroles,$email,$nombrecompleto,$activo,$refsocios) {
   $sql = "update dbusuarios
   set
   usuario = '".$usuario."',password = '".$password."',refroles = ".$refroles.",email = '".$email."',nombrecompleto = '".$nombrecompleto."',activo = ".$activo." ,refsocios = ".($refsocios)."
   where idusuario =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarUsuarios($id) {
   $sql = "update dbusuarios set activo = 0 where idusuario =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

	function eliminarUsuariosDefinitivamente($id) {
   $sql = "delete from dbusuarios where idusuario =".$id;
   $res = $this->query($sql,0);
   return $sql;
   }


   function traerUsuarios() {
   $sql = "select
   u.idusuario,
   u.usuario,
   u.password,
   u.refroles,
   u.email,
   u.nombrecompleto,
   u.reflocatarios
   from dbusuarios u
   inner join tbroles rol ON rol.idrol = u.refroles
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerUsuariosPorId($id) {
   $sql = "select idusuario,usuario,password,refroles,email,nombrecompleto,(case when activo = 1 then 'Si' else 'No' end) as activo,refsocios from dbusuarios where idusuario =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

   function modPassword($id, $pass) {
      $sql = "update dbusuarios set password = '".$pass."' where idusuario = ".$id;
      $res = $this->query($sql,0);
      return $res;
   }

	function traerUsuariosPorRol($idrol) {
		$sql = "select u.idusuario,u.usuario, u.email , u.nombrecompleto
				from dbusuarios u
				inner join tbroles r on u.refroles = r.idrol
				where r.idrol = ".$idrol."
				order by nombrecompleto";
		$res = $this->query($sql,0);
		if ($res == false) {
			return 'Error al traer datos';
		} else {
			return $res;
		}
	}

   /* Fin */
   /* /* Fin de la Tabla: dbusuarios*/

	/* PARA Correoselectronicos */

	function insertarCorreoselectronicos($refusuarios,$refpostulantes,$email,$cuerpo,$asunto) {
	$sql = "insert into dbcorreoselectronicos(iddcorreoelectronico,refusuarios,refpostulantes,email,cuerpo,asunto)
	values ('',".$refusuarios.",".$refpostulantes.",'".$email."',".$cuerpo.",'".$asunto."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarCorreoselectronicos($id,$refusuarios,$refpostulantes,$email,$cuerpo,$asunto) {
	$sql = "update dbcorreoselectronicos
	set
	refusuarios = ".$refusuarios.",refpostulantes = ".$refpostulantes.",email = '".$email."',cuerpo = ".$cuerpo.",asunto = '".$asunto."'
	where iddcorreoelectronico =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarCorreoselectronicos($id) {
	$sql = "delete from dbcorreoselectronicos where iddcorreoelectronico =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerCorreoselectronicos() {
	$sql = "select
	c.iddcorreoelectronico,
	c.refusuarios,
	c.refpostulantes,
	c.email,
	c.cuerpo,
	c.asunto
	from dbcorreoselectronicos c
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerCorreoselectronicosPorId($id) {
	$sql = "select iddcorreoelectronico,refusuarios,refpostulantes,email,cuerpo,asunto from dbcorreoselectronicos where iddcorreoelectronico =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbcorreoselectronicos*/


   /* PARA Predio_menu */

   function insertarPredio_menu($url,$icono,$nombre,$Orden,$hover,$permiso) {
   $sql = "insert into predio_menu(idmenu,url,icono,nombre,Orden,hover,permiso)
   values (null,'".$url."','".$icono."','".$nombre."',".$Orden.",'".$hover."','".$permiso."')";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarPredio_menu($id,$url,$icono,$nombre,$Orden,$hover,$permiso) {
   $sql = "update predio_menu
   set
   url = '".$url."',icono = '".$icono."',nombre = '".$nombre."',Orden = ".$Orden.",hover = '".$hover."',permiso = '".$permiso."'
   where idmenu =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarPredio_menu($id) {
   $sql = "delete from predio_menu where idmenu =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function traerPredio_menu() {
   $sql = "select
   p.idmenu,
   p.url,
   p.icono,
   p.nombre,
   p.Orden,
   p.hover,
   p.permiso
   from predio_menu p
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerPredio_menuPorId($id) {
   $sql = "select idmenu,url,icono,nombre,Orden,hover,permiso from predio_menu where idmenu =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

   /* Fin */
   /* /* Fin de la Tabla: predio_menu*/



   /* PARA Roles */

   function insertarRoles($descripcion,$activo) {
   $sql = "insert into tbroles(idrol,descripcion,activo)
   values (null,'".$descripcion."',".$activo.")";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarRoles($id,$descripcion,$activo) {
   $sql = "update tbroles
   set
   descripcion = '".$descripcion."',activo = ".$activo."
   where idrol =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarRoles($id) {
   $sql = "delete from tbroles where idrol =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function traerRoles() {
   $sql = "select
   r.idrol,
   r.descripcion,
   r.activo
   from tbroles r
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerRolesPorId($id) {
   $sql = "select idrol,descripcion,activo from tbroles where idrol =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

   /* Fin */
   /* /* Fin de la Tabla: tbroles*/




   /* PARA Configuracion */

   function insertarConfiguracion($razonsocial,$empresa,$sistema,$direccion,$telefono,$email) {
   $sql = "insert into tbconfiguracion(idconfiguracion,razonsocial,empresa,sistema,direccion,telefono,email)
   values (null,'".$razonsocial."','".$empresa."','".$sistema."','".$direccion."','".$telefono."','".$email."')";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarConfiguracion($id,$razonsocial,$empresa,$sistema,$direccion,$telefono,$email) {
   $sql = "update tbconfiguracion
   set
   razonsocial = '".$razonsocial."',empresa = '".$empresa."',sistema = '".$sistema."',direccion = '".$direccion."',telefono = '".$telefono."',email = '".$email."'
   where idconfiguracion =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarConfiguracion($id) {
   $sql = "delete from tbconfiguracion where idconfiguracion =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function traerConfiguracion() {
   $sql = "select
   c.idconfiguracion,
   c.razonsocial,
   c.empresa,
   c.sistema,
   c.direccion,
   c.telefono,
   c.email
   from tbconfiguracion c
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerConfiguracionPorId($id) {
   $sql = "select idconfiguracion,razonsocial,empresa,sistema,direccion,telefono,email from tbconfiguracion where idconfiguracion =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

   /* Fin */
   /* /* Fin de la Tabla: tbconfiguracion*/

	/* PARA Taxa */

	function insertarTaxa($taxaper,$taxaturistico,$maxtaxa) {
	$sql = "insert into tbtaxa(idtaxa,taxaper,taxaturistico,maxtaxa)
	values ('',".$taxaper.",".$taxaturistico.")";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarTaxa($id,$taxaper,$taxaturistico,$maxtaxa) {
	$sql = "update tbtaxa
	set
	taxaper = ".$taxaper.",taxaturistico = ".$taxaturistico.",maxtaxa = ".$maxtaxa."
	where idtaxa =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarTaxa($id) {
	$sql = "delete from tbtaxa where idtaxa =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerTaxa() {
	$sql = "select
	t.idtaxa,
	t.taxaper,
	t.taxaturistico,
	t.maxtaxa
	from tbtaxa t
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerTaxaPorId($id) {
	$sql = "select idtaxa,taxaper,taxaturistico,maxtaxa from tbtaxa where idtaxa =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: tbtaxa*/

 /*******************   auditoria   **************************************************************/
 /* PARA Auditoria */

	function insertarAuditoria($tabla,$operacion,$campo,$valornuevo,$valorviejo,$id,$usuario,$token,$visible,$idpostulante) {
		$sql = "insert into dbauditoria(idauditoriapostulante,tabla,operacion,campo,valornuevo,valorviejo,id,usuario,fecha,token,idusuario,visible)
		values ('','".$tabla."','".$operacion."','".$campo."','".$valornuevo."','".$valorviejo."',".$id.",'".$usuario."',now(),'".$token."',".$_SESSION['id_usuariopredio'].",".$visible.",".$idpostulante.")";

		$res = $this->query($sql,1);
		return $res;
	}

	function insertAuditoria($tabla, $operacion,$id,$usuario, $ar=null,$token=null,$visible,$idpostulante) {
		$sql = "SHOW COLUMNS FROM ".$tabla;
		$res = $this->query($sql,0);
		$resAux = $this->query($sql,0);

		$idnombre = mysql_result($res,0,0);

		if ($token == null) {
			$token = $this->GUID();
		}


		$i = 0;

		while ($row = mysql_fetch_array($resAux)) {

		//$sqlValor = "SELECT ".$row[0].' from '.$tabla.' where '.$idnombre.' = '.$id;

			if (strpos($row[1],"bit") !== false) {
				$sqlValor = "SELECT (case when ".$row[0]." = 1 then 'Si' else 'No' end) as ".$row[0]." from ".$tabla.' where '.$idnombre.' = '.$id;
			} else {
				$sqlValor = "SELECT ".$row[0].' from '.$tabla.' where '.$idnombre.' = '.$id;
			}

			$resValor = $this->query($sqlValor,0);
			$valornuevo = mysql_result($resValor,0,0);


			$valorviejo = '';
			if (count($ar)>0) {
				$insert = $this->insertarAuditoria($tabla,$operacion,$row[0],$valornuevo,$ar[$i][$row[0]],$id,$usuario,$token,$visible,$idpostulante);
				$i += 1;
			} else {
				$insert = $this->insertarAuditoria($tabla,$operacion,$row[0],$valornuevo,$valorviejo,$id,$usuario,$token,$visible,$idpostulante);
			}


		//array_push($ar,array($row[0]=> $valornuevo));
		}

		return $insert;
	}

	function modiAuditoria($tabla, $operacion,$id,$usuario) {
		$sql = "SHOW COLUMNS FROM ".$tabla;
		$res = $this->query($sql,0);
		$resAux = $this->query($sql,0);

		$idnombre = mysql_result($res,0,0);

		$ar = array();

		while ($row = mysql_fetch_array($resAux)) {

			if (strpos($row[1],"bit") !== false) {
				$sqlValor = "SELECT (case when ".$row[0]." = 1 then 'Si' else 'No' end) as ".$row[0]." from ".$tabla.' where '.$idnombre.' = '.$id;
			} else {
				$sqlValor = "SELECT ".$row[0].' from '.$tabla.' where '.$idnombre.' = '.$id;
			}


			$resValor = $this->query($sqlValor,0);
			$valornuevo = '';

			$valorviejo = mysql_result($resValor,0,0);

			//$insert = $this->insertarAuditoria($tabla,$operacion,$row[0],$valornuevo,$valorviejo,$id,$usuario);
			array_push($ar,array($row[0]=> $valorviejo));

		}

		return $ar;
	}



   /* PARA Autologin */

   function insertarAutologin($refusuarios,$token,$url,$usado) {
      $sql = "insert into autologin(idautologin,refusuarios,token,url,usado)
      values ('',".$refusuarios.",'".$token."','".$url."','".$usado."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarAutologin($id,$refusuarios,$token,$url,$usado) {
      $sql = "update autologin
      set
      refusuarios = ".$refusuarios.",token = '".$token."',url = '".$url."',usado = '".$usado."'
      where idautologin =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarAutologin($id) {
      $sql = "delete from autologin where idautologin =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerAutologin() {
      $sql = "select
      a.idautologin,
      a.refusuarios,
      a.token,
      a.url,
      a.usado
      from autologin a
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerAutologinPorId($id) {
      $sql = "select idautologin,refusuarios,token,url,usado from autologin where idautologin =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerAutologinPorToken($token) {
      $sql = "select idautologin,refusuarios,token,url,usado from autologin where token ='".$token."'";
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: autologin*/


 /*****************************       fin         ************************************************/

   function limpiar() {
      $sql = "delete from dbcomercioinicio;
            delete from dbcomerciofin;
            delete from dbclientesasesores;
            delete from dbclientescartera;
            delete from dblead;
            delete from dbasegurados;

            delete from dbperiodicidadventaspagos;
            delete from dbperiodicidadventasdetalle;
            delete from dbperiodicidadventas;
            delete from dbventas;
            delete from dbmetodopago;
            delete from dbtokens;
            delete from dbpagos;
            delete from dbfirmarcontratos;
            delete from dbventas;
            delete from dbcotizaciones;
            delete from dbdocumentacionclientes;";
      $res = $this->query($sql,0);

      return $res;
   }

   function encryptIt( $q ) {
      $cryptKey  = 'asiu2837hFSDFef2#$23sd9823asesorescrea';
      $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
      return( $qEncoded );
   }

   function decryptIt( $q ) {
      $cryptKey  = 'asiu2837hFSDFef2#$23sd9823asesorescrea';
      $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
      return( $qDecoded );
   }

   function hiddenString($str, $start = 1, $end = 1)
   {
      $len = strlen($str);
      return substr($str, 0, $start) . str_repeat('*', $len - ($start + $end)) . substr($str, $len - $end, $end);
   }


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

		        $error = 0;
		mysql_query("BEGIN");
		$result=mysql_query($sql,$conex);
		if ($accion && $result) {
			$result = mysql_insert_id();
		}
		if(!$result){
			$error=1;
		}
		if($error==1){
			mysql_query("ROLLBACK");
			return false;
		}
		 else{
			mysql_query("COMMIT");
			return $result;
		}

	}

}

?>
