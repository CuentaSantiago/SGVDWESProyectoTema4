<html>
    <head>
        <title>Ejercicio 8</title>
        <link rel="stylesheet" type="text/css" href="webroot/css/estilos.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <h1><a href='../indexProyectoTema4.php'>volver</a></h1>
        <?php
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL); //para ver errores
        ?>
        <?php
        require_once '../core/ConexionDB.php'; //archivo para conexion a la base de datos
            try{
                $miDB = new PDO($host,$USER,$PASSWORD); //conexion a la base de datos
                $sql = 'SELECT * FROM T02_DEPARTAMENTO';
                $consultaPreparada = $miDB->prepare($sql);
                $consultaPreparada->execute();
                // Si hay registros, comenzamos a generar el XML
                if ($consultaPreparada->rowCount() > 0) {
                    // Instanciamos el objeto DOMDocument
                    $dXML = new DOMDocument('1.0', 'UTF-8');
                    $dXML->formatOutput = true; // salida para que el XML tenga saltos de línea
                    $inicio= $dXML->createElement('departamentos'); //crear elemento
                    $dXML->appendChild($inicio);
                    while($CamposD = $consultaPreparada->fetchObject()){
                        $Camposxml = $dXML->createElement('departamento');
                        // Creamos el codigo, añadimos un texto y lo colgamos como departamento
                        $sCod = $dXML->createElement('T02_CodDepartamento');
                        // Crea texto y Usos de appendChild
                        $sCod->appendChild($dXML->createTextNode($CamposD->T02_CodDepartamento));
                        $Camposxml->appendChild($sCod);
                        // Creamos la descripcion, añadimos un texto y lo colgamos de departamento
                        $sDesc = $dXML->createElement('T02_DescDepartamento');
                        $sDesc->appendChild($dXML->createTextNode($CamposD->T02_DescDepartamento));
                        $Camposxml->appendChild($sDesc);
                        // Creamos el FechaCreacion, añadimos un texto y lo colgamos como departamento
                        $sFechaCreacion = $dXML->createElement('T02_FechaCreacionDepartamento');
                        $sFechaCreacion->appendChild($dXML->createTextNode($CamposD->T02_FechaCreacionDepartamento));
                        $Camposxml->appendChild($sFechaCreacion);
                        // Creamos la volumen, añadimos un texto y lo colgamos de departamento
                        $sVolumen = $dXML->createElement('T02_VolumenDeNegocio');
                        $sVolumen->appendChild($dXML->createTextNode($CamposD->T02_VolumenDeNegocio));
                        $Camposxml->appendChild($sVolumen);
                        // Creamos la descripcion, añadimos un texto y lo colgamos de departamento
                        $sFechaBaja = $dXML->createElement('T02_FechaBajaDepartamento');
                        $sFechaBaja->appendChild($dXML->createTextNode($CamposD->T02_FechaBajaDepartamento ?? ''));
                        $Camposxml->appendChild($sFechaBaja);
                        // Colgamos el departamento completo de la raiz departamentos
                        $inicio->appendChild($Camposxml);
                    }
                    $directorio = dirname(__DIR__).'/tmp/';
                    // Ruta absoluta para que el servidor guarde el archivo fuera del direcotio de ejercicios pero dentro del tema 4
                    $Guardar = $directorio . 'departamentos.xml';
                    // Guardamos el archivo XML generado en el servidor
                    // Guarda el documento XML en un fichero
                    $dXML->save($Guardar);
                    // Mostramos el mensaje y el enlace web
                    echo "<div class='mensaje-exito'>";
                    echo "<h3>Exportacion completada con exito.</h3>";
                    echo "<p>El archivo se ha guardado en: <b>{$Guardar}</b></p>";
                    echo "<a href='../tmp/departamentos.xml' target='_blank' style='color: #155724; font-weight: bold; text-decoration: underline;'>Ver archivo XML</a>";
                    echo "</div>";
                }
            }catch(PDOException $e){//para atrapar excepciones
                echo $e->getMessage()."<br>";
            }
            finally {
            // Cierra la conexion con la base de datos
                unset($miDB);
            }
        ?>
    </body>
</html>