<?php
require_once("../libreria.php");
require '../vendor/autoload.php';
verificarsession("No ha iniciado session");
use vendor\PhpOffice\PhpSpreadsheet\Spreadsheet;
use vendor\PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('../plantillasxls/ResporteSeal.xlsx');
//$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
$worksheet = $spreadsheet->getActiveSheet();
$Letrainicial=7;
$SqlConsultar="select dt.NroDocumento,dt.ContratoID,dt.FechaEmisionDoc,td.Nombre as AreaNombre,tdd.Nombre as NombreTD,tddd.Nombre as NombreTDD from DocumentosTrabajo as dt";
$SqlConsultar.=" left join TDD_Detalle as tddd on tddd.idTDD_Detalle=dt.IdTDD_Detalle";
$SqlConsultar.=" left join TipoDocumentoDetalle as tdd on tdd.idTipoDocumentoDetalle=tddd.IdTipoDocumentoDetalle";
$SqlConsultar.=" left join TipoDocumento as td on td.idTipoDocumento=tdd.IdTipoDocumento";
$SqlConsultar.=" where idDocumentostrabajo in(";
for($i=0;$i<count($_SESSION['codigosdocumentos']);$i++){
    //echo $_SESSION['codigosdocumentos'][$i]."<br>";
    $SqlConsultar.=$_SESSION['codigosdocumentos'][$i].",";
}
$SqlConsultar= trim($SqlConsultar, ',');
$SqlConsultar.=")";
//echo $SqlConsultar;
$ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
$stmt = $ConexionSealDBComunicacionDispersa->prepare($SqlConsultar);
$stmt->execute();
//$rows = $stmt->execute();
$fechaActual=date("Y-m-d");
$worksheet->getCell('C5')->setValue('Fecha de Entrega: '.$fechaActual);

$numero=0;
foreach ($stmt as $ListaReporte) {
    $numero+=1;
    $worksheet->getCell('A'.$Letrainicial)->setValue(''.$numero);
    $worksheet->getCell('B'.$Letrainicial)->setValue(''.$ListaReporte['NroDocumento']);
    $worksheet->getCell('C'.$Letrainicial)->setValue(''.$ListaReporte['ContratoID']);
    $worksheet->getCell('D'.$Letrainicial)->setValue(''.$ListaReporte['FechaEmisionDoc']);
    $worksheet->getCell('E'.$Letrainicial)->setValue(''.$ListaReporte['AreaNombre'].'::'.$ListaReporte['NombreTD'].'::'.$ListaReporte['NombreTDD']);
    $spreadsheet->getActiveSheet()->insertNewRowBefore($Letrainicial+1, 1);
    $Letrainicial+=1;
}
$spreadsheet->getActiveSheet()->removeRow($Letrainicial, 2);
// Redirect output to a client’s web browser (Xlsx)
// Redirect output to a client’s web browser (Xlsx)
$fechaActual=date("Ymd");
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ReporteSEAL'.$fechaActual.'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0
$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
?>
