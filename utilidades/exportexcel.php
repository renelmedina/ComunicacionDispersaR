<?php
require '../vendor/autoload.php';
    use vendor\PhpOffice\PhpSpreadsheet\Spreadsheet;
    use vendor\PhpOffice\PhpSpreadsheet\Writer\Xlsx;
if ($_GET["valor"]=="1") {
    # code...
    $directions = json_decode($_POST['json']);
    //$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('plantillappto.xlsx');
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $worksheet = $spreadsheet->getActiveSheet();
    $Letrainicial=2;

    $worksheet->getCell('A1')->setValue('Item');
    $worksheet->getCell('B1')->setValue('Suministro');
    $worksheet->getCell('C1')->setValue('Tipo');
    $worksheet->getCell('D1')->setValue('Fecha Ejecucion');
    $worksheet->getCell('E1')->setValue('Asignado A');
    $worksheet->getCell('F1')->setValue('Dato1');
    $worksheet->getCell('G1')->setValue('Dato2');
    $worksheet->getCell('H1')->setValue('Dato3');
    $worksheet->getCell('I1')->setValue('Dato4');


    foreach ($directions as $DatosJson) {
        //echo "Contrato : ". $DatosJson->idTrabajador;
        $TrabajadorID=$DatosJson->idTrabajador;
        $ContratosListas=$DatosJson->contratos;       
        $FechaActual=date("Y-m-d");
        $sqlAsignarPersonalDocumento="";
        foreach ($ContratosListas as $ListarContratos) {
            //echo $ListarContratos."<br>";
            //$sqlAsignarPersonalDocumento.="call AsignarPersonalDocumentosTrabajo($ListarContratos,$TrabajadorID,'$FechaActual');";
            $worksheet->getCell('A'.$Letrainicial)->setValue(''.$ListarContratos[0]);
            $worksheet->getCell('B'.$Letrainicial)->setValue(''.$ListarContratos[3]);
            $worksheet->getCell('C'.$Letrainicial)->setValue(''.$ListarContratos[1]);
            $worksheet->getCell('D'.$Letrainicial)->setValue(''.$ListarContratos[2]);
            $worksheet->getCell('E'.$Letrainicial)->setValue(''.$TrabajadorID);
            $worksheet->getCell('F'.$Letrainicial)->setValue(''.$ListarContratos[4]);
            $worksheet->getCell('G'.$Letrainicial)->setValue(''.$ListarContratos[5]);
            $worksheet->getCell('H'.$Letrainicial)->setValue(''.$ListarContratos[6]);
            $worksheet->getCell('I'.$Letrainicial)->setValue(''.$ListarContratos[7]);

            $Letrainicial+=1;

        }    
    }
    // Redirect output to a client’s web browser (Xlsx)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="PPTO-ejemploti.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('ejemploti.xlsx');
}
?>