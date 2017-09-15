<?php
include "../inc/conexion.php";
/*nunca se ponen datos de conexion en el scrip, usa la libreria*/
$link = mysqli_connect("pradosgn.dynalias.org", "excelmexico", "VsS&jC1923MZvzkzboys3x");
mysqli_select_db($link, "prueba2");
$tildes = $link->query("SET NAMES 'utf8'");
/*Solo estan para hacer la prueba, abajo esta la conexion con la libreria*/

/*$con=mysql_connect($SERVER,$USERNAME,$PASSWD)or die("Problemas al conectar");
mysql_select_db("prueba2",$con)or die("Error al seleccionar base de datos");*/

$consulta = mysql_query("SELECT * FROM comprobantes_tmp");
$ids_nomina="23341,27121";
while($row=mysql_fetch_array($consulta)) {

	$sql_pago=mysql_query("SELECT p.id_pago, p.id_nomina, t.curp, t.rfc, p.id_sucursal, t.id_trabajador FROM pagos p
							INNER JOIN trabajador t ON t.id_trabajador=p.id_trabajador
							WHERE id_nomina IN (".$ids_nomina.") and folio=(".$row[1].")",$link);

	$row2 = mysql_fetch_array($sql_pago);

	 mysqli_query("INSERT into cat_pagos_ele (id_pago,folio_x,status,fecha_sello,id_sucursal_empresa,id_usuario,curp,rfc,UUID) VALUES (".$row2[0].",".$row[1].",1,".$row[5].",".$row2[4].",1,".$row2[2].", ".$row2[3].",".$row[9].")",$link);
	 /*$sql.="set @id_pago_pac:=last_insert_id();";*/
	 mysqli_query("INSERT into xml_pac_recubocfdi (id_nomina,id_pago,id_trabajador,UUID,v_real_viurtial,id_pago_pac,total_pago,folio) VALUES (".$row2[1].",".$row2[0].",".$row2[5].",".$row[9].",3,@id_pago_pac,".$row[7].",".$row[1].")",$link);
	 /*transaction($sql);*/
	
}

		function transaction($sql){
			$base="excelmexico";
			$sql = explode(";",$sql);
			$link = Conectarsei($base,$usuario,$pwd);
			$band = true; /* estoy aceptando el primer insert que ocurra */

			$vocalesNormales = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "'");
			$vocalesAcentuadas = array("�", "�", "�", "��", "�", "�", "�", "�", "�", "�", "\'");

			set_time_limit(0);

			mysqli_autocommit($link, FALSE);
			$id=-1;
			for($i=0; $i<count($sql); $i++) {
				$sql_correcto = str_replace($vocalesAcentuadas, $vocalesNormales, utf8_decode($sql[$i]));
				if(strlen(trim($sql_correcto))!=0)
					$result = @mysqli_query($link, $sql_correcto);
					if(($band) && (mysqli_insert_id($link)!=0) ) {
						$id = mysqli_insert_id($link);
						$band = false;
					}

				if(!$result) {
					throw new Exception("No se pudo procesar su consulta,Intentelo Nuevamente!:".mysqli_error($link));
					$error="No se proceso consulta:".mysqli_error($link);
					echo $error;
					mysqli_commit($link);
					mysqli_rollback($link);
					break;
				}
			}
			mysqli_commit($link);
			mysqli_close($link);
			return $id;

		}
?>