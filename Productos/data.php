<?php

include_once 'conexion.php';

$fecha1 = $_POST["Fecha1"];
$fecha2 = $_POST["Fecha2"];
$estaciones = explode(",", $_POST["Estacion"]);
$count = count($estaciones);

$filename2 = "Productos.zip";
$zip = new ZipArchive();
$zip->open($filename2, ZIPARCHIVE::CREATE);
$afilename = array();

$error = false;
$errorStations = array();

$fields = array('FECHA');
if (isset($_POST["Presion"])) {
    array_push($fields, 'PRESION');
}
if (isset($_POST["Temperatura"])) {
    array_push($fields, 'TEMPERATURA');
}
if (isset($_POST["IWV"])) {
    array_push($fields, 'IWV');
}
if (isset($_POST["ZTD"])) {
    array_push($fields, 'ZTD');
    array_push($fields, 'O');
    array_push($fields, 'n');
}


for ($i = 0; $i < $count; $i++) {
    $estacion = $estaciones[$i];
    $consulta = "SELECT * FROM productos WHERE Fecha BETWEEN :a AND :b AND estacion = :c";

    try {

        $query = $bd->prepare($consulta);
        $query->execute([':a' => $fecha1, ':b' => $fecha2, ':c' => $estacion]);

        if ($query->rowCount() > 0) {
            $delimiter = ",";
            $filename = $estacion . date('Y-m-d') . ".csv";
            array_push($afilename, $filename);
            //create a file pointer
            $f = fopen($filename, 'w');

            //set column headers

            fputcsv($f, $fields, $delimiter);

            //output each row of the data, format line as csv and write to file pointer
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $lineData = array($row['FECHA']);
                for ($ii = 1; $ii < count($fields); $ii++) {
                    array_push($lineData, $row[$fields[$ii]]);
                }
                fputcsv($f, $lineData, $delimiter);
            }

            fclose($f);

            $zip->addFile($filename);
        }else{
            array_push($errorStations, $estacion);
            $error =true;
        }
    } catch (Exception $e) {
        
        array_push($errorStations, $estacion);
        $error =true;
    }
}

$zip->close();

if ($error) {

    header("Location:productos.php?error=2&est=" . $estacion);

}

if (filesize($filename2) != false) {

    header("Content-type: application/zip;\n");
    header("Content-Transfer-Encoding: Binary");
    header("Content-length: " . filesize($filename2) . ";\n");
    header("Content-disposition: attachment; filename=\"" . basename($filename2) . "\"");
    ob_clean();
    flush();
    readfile($filename2);

    for ($i = 0; $i < $count; $i++) {

        unlink($afilename[$i]);

    }

    unlink($filename2);


} else {

    header("Location:productos.php?error=1");

}
