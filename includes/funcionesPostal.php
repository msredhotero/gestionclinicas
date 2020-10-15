<?php

/**
 * @Usuarios clase en donde se accede a la base de datos
 * @ABM consultas sobre las tablas de usuarios y usarios-clientes
 */

date_default_timezone_set('America/Mexico_City');

class ServiciosPostal {

   function devolverComboHTML($dato, $filtro) {
      switch ($dato) {
         case 'estado':
            $res = $this->traerEstados();
         break;
         case 'municipio':
            $res = $this->traerMunicipiosPorEstado($filtro->estado);
         break;
         case 'colonia':
            $res = $this->traerColoniaPorMunicipio($filtro->municipio);
         break;
         case 'codigopostal':
            $res = $this->traerPostalPorMunicipioColonia($filtro->municipio,$filtro->colonia);
         break;
      }

      return $res;
   }

   function traerEstados() {
      $sql = "SELECT estado FROM postal
            group by estado
            order by 1";
      $res = $this->query($sql,0);

      return $res;
   }


   function traerMunicipiosPorEstado($estado) {
      $sql = "SELECT municipio,estado FROM postal
            where estado = '".$estado."'
            group by estado,municipio
            order by 1";
      $res = $this->query($sql,0);

      return $res;
   }

   function traerColoniaPorMunicipio($municipio) {
      $sql = "SELECT colonia,estado,municipio FROM postal
            where municipio = '".$municipio."'
            group by estado,municipio,colonia
            order by 1";
      $res = $this->query($sql,0);

      return $res;
   }


   function traerPostalPorMunicipioColonia($municipio, $colonia) {
      $sql = "SELECT codigo,estado,municipio,colonia FROM postal
            where municipio = '".$municipio."' and colonia = '".$colonia."'
            group by estado,municipio,colonia,codigo
            order by 1";
      $res = $this->query($sql,0);

      return $res;
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
