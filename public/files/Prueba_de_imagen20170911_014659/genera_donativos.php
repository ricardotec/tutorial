<?php

require('../inc/PDF/fpdf.php');
include('../inc/conexion.php');
require('../inc/CNumeroaLetra.php');
include "phpqrcode/qrlib.php";

$numero = count($_GET);
$tags = array_keys($_GET);
$valores = array_values($_GET);
for($i=0;$i<$numero;$i++){
$$tags[$i]=$valores[$i];
}
$numerop = count($_POST);
$tagsp = array_keys($_POST);
$valoresp = array_values($_POST);
for($i=0;$i<$numerop;$i++){
$$tagsp[$i]=$valoresp[$i];
}

$id_donataria=addslashes($id_donativo);
$link = Conectarse($sucursal);

$sql="SELECT DISTINCT
		b.fecha_creacion,
		a.numero_certificado,
		a.razon_social empresa_rs,
		a.id_empresa,
		CONCAT(a.calle,', ',a.num_ext,' ',a.num_int,', ',a.colonia,' ',IFNULL(a.referencia,' '),' ',IFNULL(a.ciudad,' '),' ',IFNULL(a.estado,' '),' CP.',IFNULL(a.cp,' ')) direccion,
		a.rfc rfc_empresa,
		c.razon_social,
		CONCAT(IFNULL(c.calle,' '),' No.', IFNULL(c.num_ext,' '),', COL. ', IFNULL(c.colonia,' '),' ',IFNULL(c.municipio,''),' ',IFNULL(c.estado,''),' CP. ',IFNULL(c.cp,'')) dir_rs,
		c.rfc rfc_rs,
		'' AS concepto_donativo,
		b.importe,
		b.iva,
		b.subtotal,
		b.importe_neto,
		b.porciva,
		d.cantidad,
		IFNULL(d.concepto,0) concepto,
		IFNULL(d.importe_unitario,0) importe_unitario,
		b.condiciones,
		b.numero_donativo,
		f.uuid,
		f.cadena_original,
		f.num_certificado,
		f.sello_sat,
		f.sello_cfd,
		e.no_autorizacion,
		IF(numero_donativo<16,'2013-02-13',e.fecha_autorizacion) fecha_autorizacion,
		b.b_capital,
		e.num_expediente,
		b.fecha_cancelacion,
		CASE 
		MONTH(NOW())
			WHEN 1 THEN CONCAT(DAY(CURDATE()),' de enero del ',YEAR(CURDATE()))
			WHEN 2 THEN CONCAT(DAY(CURDATE()),' de febrero del ',YEAR(CURDATE()))
			WHEN 3 THEN CONCAT(DAY(CURDATE()),' de marzo del ',YEAR(CURDATE()))
			WHEN 4 THEN CONCAT(DAY(CURDATE()),' de abril del ',YEAR(CURDATE()))
			WHEN 5 THEN CONCAT(DAY(CURDATE()),' de mayo del ',YEAR(CURDATE()))
			WHEN 6 THEN CONCAT(DAY(CURDATE()),' de junio del ',YEAR(CURDATE()))
			WHEN 7 THEN CONCAT(DAY(CURDATE()),' de julio del ',YEAR(CURDATE()))
			WHEN 8 THEN CONCAT(DAY(CURDATE()),' de agosto del ',YEAR(CURDATE()))
			WHEN 9 THEN CONCAT(DAY(CURDATE()),' de septiembre del ',YEAR(CURDATE()))
			WHEN 10 THEN CONCAT(DAY(CURDATE()),' de octubre del ',YEAR(CURDATE()))
			WHEN 11 THEN CONCAT(DAY(CURDATE()),' de noviembre del ',YEAR(CURDATE()))
			WHEN 12 THEN CONCAT(DAY(CURDATE()),' de diciembre del ',YEAR(CURDATE()))
			ELSE 'NULL' END mes ,CASE 
		MONTH(b.fecha_creacion )
			WHEN 1 THEN CONCAT(DAY(b.fecha_creacion),' de enero del ',YEAR(b.fecha_creacion))
			WHEN 2 THEN CONCAT(DAY(b.fecha_creacion),' de febrero del ',YEAR(b.fecha_creacion))
			WHEN 3 THEN CONCAT(DAY(b.fecha_creacion),' de marzo del ',YEAR(b.fecha_creacion))
			WHEN 4 THEN CONCAT(DAY(b.fecha_creacion),' de abril del ',YEAR(b.fecha_creacion))
			WHEN 5 THEN CONCAT(DAY(b.fecha_creacion),' de mayo del ',YEAR(b.fecha_creacion))
			WHEN 6 THEN CONCAT(DAY(b.fecha_creacion),' de junio del ',YEAR(b.fecha_creacion))
			WHEN 7 THEN CONCAT(DAY(b.fecha_creacion),' de julio del ',YEAR(b.fecha_creacion))
			WHEN 8 THEN CONCAT(DAY(b.fecha_creacion),' de agosto del ',YEAR(b.fecha_creacion))
			WHEN 9 THEN CONCAT(DAY(b.fecha_creacion),' de septiembre del ',YEAR(b.fecha_creacion))
			WHEN 10 THEN CONCAT(DAY(b.fecha_creacion),' de octubre del ',YEAR(b.fecha_creacion))
			WHEN 11 THEN CONCAT(DAY(b.fecha_creacion),' de noviembre del ',YEAR(b.fecha_creacion))
			WHEN 12 THEN CONCAT(DAY(b.fecha_creacion),' de diciembre del ',YEAR(b.fecha_creacion))
			ELSE 'NULL' END mes_creacion,
			b.metodo_pago
		FROM empresa a
		INNER JOIN cat_donativos b ON a.id_empresa=b.id_facturadora
		INNER JOIN razon_social c ON c.id_razon_social = b.id_razon_social
		INNER JOIN cat_donativos_detalle d ON d.id_donativo=b.id_donativo
		INNER JOIN autorizacion_civil e ON e.id_empresa=a.id_empresa AND e.b_activa=1
		LEFT JOIN xml_pac_donativos f ON f.id_donativo = b.id_donativo
		WHERE b.id_donativo = {$id_donataria}";
	// echo $sql;
	// exit;
$resEmp = mysql_query($sql, $link) or die(mysql_error());
$RESULTADO = mysql_fetch_array($resEmp);

$metodoPago = $RESULTADO["metodo_pago"];

$empresa=array($RESULTADO['empresa_rs'],$RESULTADO['direccion'],$RESULTADO['codigo_p'],$RESULTADO['rfc_empresa'],);
$donador=array($RESULTADO['razon_social'],$RESULTADO['dir_rs'],$RESULTADO['rfc_rs'],$RESULTADO['concepto_donativo'],$RESULTADO['importe'],$RESULTADO['importe']);
$concepto=array($RESULTADO['razon_social'],$RESULTADO['dir_rs'],$RESULTADO['rfc_rs'],$RESULTADO['cantidad'],$RESULTADO['concepto'],$RESULTADO['importe_unitario']);
$leyenda_correcta="ESTE COMPROBANTE TENDRA VIGENCIA DE DOS AÑOS CONTANDO A PARTIR DE LA FECHA DE APROBACION DE LA ASIGNACION DE FOLIOS, LA CUAL ES 2013-11-01";
if($RESULTADO['numero_donativo']>=16){
	$leyenda_correcta="ESTE COMPROBANTE TENDRA VIGENCIA DE CUATRO AÑOS CONTANDO A PARTIR DE LA FECHA DE APROBACION DE LA ASIGNACION DE FOLIOS, LA CUAL ES 2013-02-13";
}
if($RESULTADO["numero_donativo"]==4 or $RESULTADO["numero_donativo"]=="4"){
	$leyenda_correcta = "ESTE DONATIVO ES DEDUCIBLE PARA EFECTOS DEL IMPUESTO SOBRE LA RENTA DE ACUERDO AL OFICIO: No.
600-04-02-2013-16216, EXPEDIENTE 12104 DE FECHA 2013-02-13";
}
$leyendas=array("LA DONATARIA SE OBLIGA A DESTINAR LOS BIENES DONADOS A LOS FINES PROPIOS DE SU OBJETO SOCIAL",
"EN CASO DE QUE LOS BIENES DONADOS HAYAN SIDO DEDUCIDOS PREVIAMENTE PARA LOS EFECTOS DEL IMPUESTO SOBRE LA RENTA, ESTE DONATIVO NO ES DEDUCIBLE",
"ESTE DONATIVO ES DEDUCIBLE PARA EFECTOS DEL IMPUESTO SOBRE LA RENTA DE ACUERDO AL OFICIO: No. {$RESULTADO['no_autorizacion']}, EXPEDIENTE {$RESULTADO['num_expediente']} DE FECHA {$RESULTADO['fecha_autorizacion']}",
"AUTORIZADO PARA RECIBIR DONATIVOS DE ACUERDO A LA PUBLICACION EN EL DIARIO OFICIAL DE LA FEDERACION CON FECHA: {$RESULTADO['fecha_autorizacion']}",
"EFECTOS FISCALES AL PAGO-{$RESULTADO['condiciones']}",
"LA REPRODUCCION APOCRIFA DE ESTE DOCUMENTO CONSTITUYE UN DELITO EN LOS TERMINOS DE LAS DISPOSICIONES FISCALES",
$leyenda_correcta);
$encabezados=array("RECIBIMOS DE:","DOMICILIO: ","RFC: ","POR CONCEPTO DE DONATIVO EN: "," ","CANTIDAD CON LETRA: ");
$encabezados2=array("RECIBIMOS DE:","DOMICILIO: ","RFC: ","ESPECIE ","CONSISTENTE EN: ","CANTIDAD: ","DESCRIPCION: ","VALOR: ");

//objeto pdf
$pdf = new FPDF("p", "mm", "Letter");
$pdf->SetAutoPageBreak(false,0.01);		
$pdf->addPage();

if($RESULTADO['fecha_cancelacion']!=null){
	$png="cancelado.jpg";
	$pdf->Image($png, 50,50);
}

$pdf->SetTextColor(0);
$pdf->setFont('Arial','B',12);
$png = "../gen_facturas/logos/{$RESULTADO['id_empresa']}.jpg";
if(file_exists($png)){
	$pdf->Image($png,20, 10, 40,40);
}else;
$x=50;
$y=25;
//Encabezados del recivo
for($i=0; $i<sizeof($empresa); $i++){
	if($i==0){
		$pdf->setFont('Arial','B',10);
		$pdf->setXY($x+10,$y);
		$pdf->MultiCell(100,4, $empresa[$i], 0, 'C');
		$y+=9;
	}else{
		$pdf->setFont('Arial','B',8);
		$pdf->setXY($x+20,$y);
		$pdf->MultiCell(80,5, $empresa[$i], 0, 'C');
		$y+=5;
	}
}
$pdf->setXY(20,$y+10);
$pdf->MultiCell(180, 5, "México, D.F, a {$RESULTADO['mes_creacion']}", 0, 'C');
$pdf->setXY(165,13);
$pdf->MultiCell(40, 5, "RECIBO DE DONATIVO", 1, 'C');
$pdf->setXY(165,18);
$pdf->MultiCell(40, 5, "Folio: {$RESULTADO['numero_donativo']}", 1, 'C');
$x=20;
$y=195;
$pdf->setFont('Arial','B',5);
//Agrega las leyendas
for($i=0; $i<sizeof($leyendas); $i++){
if($i==1){
	$pdf->setXY($x, $y);
	$pdf->MultiCell(120, 4, $leyendas[$i], 0, 'L');
	$y+=10;
	}else if($i==2){
	$pdf->setXY($x, $y);
	$pdf->MultiCell(100, 4, $leyendas[$i], 0, 'L');
	$y+=15;
	}else if($i==4){
		$pdf->setXY($x, $y);
		$pdf->setFont('Arial','B',8);
		$pdf->MultiCell(120, 4, $leyendas[$i], 0, 'L');
		$pdf->setFont('Arial','B',5);
		$y+=8;
	}else{
		$pdf->setXY($x, $y);
		$pdf->MultiCell(100, 4, $leyendas[$i], 0, 'L');
		$y+=8;
	}
}//end leyendas
$x=20;
$y=70;
$cad="";
$valx=0;
$numalet= new CNumeroaletra;
//Primer cuadro..............
if($RESULTADO['b_capital']==1){
$pdf->setXY($x, $y);
$pdf->MultiCell(180, 55, '', 1, 'L');
	$uno=0;
	for($i=0; $i<6; $i++){
		$fontZise = 7.5;
		if($i==2){$x=100;}
		else{$x=20;}
		$uno=1;
		if($i==3){
			$uno=0;
			$pdf->setFont('Arial','B',6);
			if($RESULTADO['b_capital']==1){
				$cad=strtoupper($RESULTADO['concepto']);
			}else{$cad='';}
		}else if($i==5){
		$pdf->setFont('Arial','B',8);
			$numalet->setNumero($donador[$i]);
			$cad=$numalet->letra();
			
		}else{
			if($i==2)
				$pdf->setFont('Arial','B',8);
			else
				$pdf->setFont('Arial','B',8);
			$cad=$donador[$i];
			if($i==4 || $i==5)
				$cad=number_format($cad,2,".",",");
		}
		MultiCell_aux($pdf, $x, $y, 40, 12, $encabezados[$i], 0, 'R', $cad, $uno, $fontZise);
		$y+=8;	
	}
	
	$pdf->setXY($x, ($y + 3));
	$pdf->MultiCell(160, 4, "METODO DE PAGO: ".$metodoPago, 0, 'R');
	
	$y+=10;
}
else{
$pdf->setXY($x, $y);
$pdf->MultiCell(180, 65, '', 1, 'L');
	$cad;
	$j=0;
	$aux=0;
	$pdf->setFont('Arial','B',8);
	$j=0;
	for($i=0; $i<count($encabezados2); $i++){
		$fontZise = 7.5;
		$valorYl = 10;
		if($i==2){$x=100;}else{$x=20;}
			if($i==3 || $i==4){
				$cad='';
				$aux=0;
				MultiCell_aux($pdf, $x, $y, 35, 10, $encabezados2[$i], 0, 'R', $cad, $aux);
			}else{
				$cad=$concepto[$j];
				if($j==4){
					$cad = nl2br($cad);
					$cad = preg_replace('/\<br(\s*)?\/?\>/i', PHP_EOL, $cad);
					$fontZise = 4.5;
					$valorYl = 2;
				}
				$aux=1;
				MultiCell_aux($pdf, $x, $y, 10, $valorYl, $encabezados2[$i], 0, 'R', $cad, $aux, $fontZise);
				$j=$j+1;
			}
			$y+=8;
	}
}

////Agrega los datos de sellado
$pdf->setXY($x, $y+2);
$pdf->MultiCell(100, 5, "Serie del certificado del emisor:  ".$RESULTADO['num_certificado'], 0, 'L');
//Sello Cfd
$pdf->setXY($x, $y+11);
$pdf->Line($x, $y+9, 200, $y+9);
$pdf->MultiCell(180, 5, "Sello digital: ", 0, 'L');
$pdf->setFont('Arial','B',8);
$pdf->setXY($x, $y+15);
$pdf->MultiCell(180, 4, $RESULTADO['sello_cfd'], 0, 'L');


$pdf->setFont('Arial','B',9);
$pdf->setXY($x, $y+25);
$pdf->Line($x, $y+23, 200, $y+23);
$pdf->MultiCell(180, 5, "Sello digital SAT: ", 0, 'L');
$pdf->setFont('Arial','B',8);
$pdf->setXY($x, $y+29);
$pdf->MultiCell(180, 4, $RESULTADO['sello_sat'], 0, 'L');

$pdf->setFont('Arial','B',9);
$pdf->setXY($x, $y+39);
$pdf->Line($x, $y+37, 200, $y+37);
$pdf->MultiCell(180, 5, "Cadena original del complemento de certificación digital del SAT: ", 0, 'L');
$pdf->setXY($x, $y+43);
$pdf->setFont('Arial','B',8);
$pdf->MultiCell(180, 4, $RESULTADO['cadena_original'], 0, 'L');

$pdf->Line($x, $y+56, 200, $y+56);

$pdf->setXY(148, 195);
$pdf->MultiCell(50, 4, "FIRMA", 1, 'C');
$pdf->setXY(148, 199);
$pdf->MultiCell(50, 15, "", 1, 'L');
$png = "../gen_facturas/cedulas/{$RESULTADO['id_empresa']}.jpg";
if(file_exists($png)){
	$pdf->Image($png,120, 215, 25,40);
}else;

if($RESULTADO["uuid"]!=null){
	$total=(($RESULTADO['importe_neto']*($RESULTADO['porciva']*100))/100) + $RESULTADO['importe_neto'];
	$datosCodigoBarras="?re=".$RESULTADO["rfc_empresa"]."&rr=".$RESULTADO["rfc_rs"]."&tt=".$total."&id=".$RESULTADO["uuid"];
	$filename="qrcode.png";
	QRcode::png($datosCodigoBarras,$filename);
	$pdf->Image($filename,162, 215, 40,40);
	@unlink($filename);
}

$pdf->Output();

function MultiCell_aux($pdf, $x, $y, $lx, $ly, $leyenda, $linea, $just, $valorB, $aux, $fontZise=7.5){
	$pdf->setXY($x, $y);
	if($aux==1){
		$pdf->Line($x+$lx, $y+7, 195,$y+7);
	}
	$pdf->MultiCell($lx, $ly, $leyenda, $linea, $just);
	$pdf->setXY($x+45, $y);
	$pdf->setFont('Arial','B', $fontZise);
	$pdf->MultiCell(140, 4, $valorB, $linea, 'L');
}
?>