<?php
// Archivo CSV con los datos
$csvFile = 'estudiantes.csv';

// Verifica si el archivo existe
if (!file_exists($csvFile)) {
    die("Error: El archivo CSV no se encuentra.");
}

// Abrir el archivo CSV
if (($handle = fopen($csvFile, 'r')) !== FALSE) {
    fgetcsv($handle); // Saltar la primera fila (encabezados)
    
    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
        $nombre = $data[0];
        $correo = $data[1];
        $materias = explode(';', $data[2]);
        $notas = explode(';', $data[3]);
        
        // Construir el mensaje
        $mensaje = "Estimado $nombre,\n\nAquí están tus notas:\n";
        foreach ($materias as $index => $materia) {
            $mensaje .= "$materia: $notas[$index]\n";
        }
        $mensaje .= "\nAtentamente, Tu Institución.";
        
        // Encabezados del correo
        $headers = "From: ernespee@gmail.com";
        
        // Enviar correo
        if (mail($correo, "Tus Notas", $mensaje, $headers)) {
            echo "Correo enviado a $nombre ($correo)\n";
        } else {
            echo "Error al enviar el correo a $nombre ($correo)\n";
        }
    }
    fclose($handle);
}
?>
