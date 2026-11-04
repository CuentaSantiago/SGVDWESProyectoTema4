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
            require_once '../core/ConexionDB.php'; //archivo para conexion a la base de datos
            $miDB = new PDO($host,$USER,$PASSWORD); //conexion a la base de datos
        ?>
        <?php
        try{
            if(isset($_POST["submit"])){
                switch($_POST['formatos']){
                    case "XML":
                        $sql = 'SELECT * FROM T02_DEPARTAMENTO';
                        $consultaPreparada = $miDB->prepare($sql);
                        $consultaPreparada->execute();
                        // Si hay registros, comenzamos a generar el XML
                        if ($consultaPreparada->rowCount() > 0) {
                            // Instanciamos el objeto DOMDocument
                            $documentoXML = new DOMDocument('1.0', 'UTF-8');
                            $documentoXML->formatOutput = true; // salida para que el XML tenga saltos de línea
                            $inicio= $documentoXML->createElement('departamentos'); //crear elemento
                            $documentoXML->appendChild($inicio);
                            while($CamposD = $consultaPreparada->fetchObject()){
                                $Camposxml = $documentoXML->createElement('departamento');
                                // Creamos el codigo, añadimos un texto y lo colgamos como departamento
                                $sCodigo = $documentoXML->createElement('T02_CodDepartamento');
                                // Crea texto y Usos de appendChild
                                $sCodigo->appendChild($documentoXML->createTextNode($CamposD->T02_CodDepartamento));
                                $Camposxml->appendChild($sCodigo);
                                // Creamos la descripcion, añadimos un texto y lo colgamos de departamento
                                $sDescripcion = $documentoXML->createElement('T02_DescDepartamento');
                                $sDescripcion->appendChild($documentoXML->createTextNode($CamposD->T02_DescDepartamento));
                                $Camposxml->appendChild($sDescripcion);
                                // Creamos el FechaCreacion, añadimos un texto y lo colgamos como departamento
                                $sFechaCreacion = $documentoXML->createElement('T02_FechaCreacionDepartamento');
                                $sFechaCreacion->appendChild($documentoXML->createTextNode($CamposD->T02_FechaCreacionDepartamento));
                                $Camposxml->appendChild($sFechaCreacion);
                                // Creamos la volumen, añadimos un texto y lo colgamos de departamento
                                $sVolumen = $documentoXML->createElement('T02_VolumenDeNegocio');
                                $sVolumen->appendChild($documentoXML->createTextNode($CamposD->T02_VolumenDeNegocio));
                                $Camposxml->appendChild($sVolumen);
                                // Creamos la descripcion, añadimos un texto y lo colgamos de departamento
                                $sFechaBaja = $documentoXML->createElement('T02_FechaBajaDepartamento');
                                $sFechaBaja->appendChild($documentoXML->createTextNode($CamposD->T02_FechaBajaDepartamento ?? ''));
                                $Camposxml->appendChild($sFechaBaja);
                                // Colgamos el departamento completo de la raiz departamentos
                                $inicio->appendChild($Camposxml);
                            }
                            $directorio = dirname(__DIR__).'/tmp/';
                            // Ruta absoluta para que el servidor guarde el archivo fuera del direcotio de ejercicios pero dentro del tema 4
                            $Guardar = $directorio . 'departamentos.xml';
                            // Guardamos el archivo XML generado en el servidor
                            // Guarda el documento XML en un fichero
                            $documentoXML->save($Guardar);
                            // Mostramos el mensaje y el enlace web
                            echo "<div class='mensaje-exito'>";
                            echo "<h3>Exportacion completada con exito.</h3>";
                            echo "<p>El archivo se ha guardado en: <b>{$Guardar}</b></p>";
                            echo "<a href='../tmp/departamentos.xml' target='_blank' style='color: #155724; font-weight: bold; text-decoration: underline;'>Ver archivo XML</a>";
                            $server=$_SERVER['PHP_SELF'];
                            echo "<a href=$server><h3>volver al formulario</h3></a>";
                            echo "</div>";
                        }
                    break;
                    case "JSON":
                        $sql = 'SELECT * FROM T02_DEPARTAMENTO';
                        $consultaPreparada = $miDB->prepare($sql);
                        $consultaPreparada->execute();
                        $num=0;
                        // Si hay registros, comenzamos a generar el JSON
                        if ($consultaPreparada->rowCount() > 0) {
                            // Instanciamos el objeto DOMDocument
                            $documentoJSON = new DOMDocument('1.0', 'UTF-8');
                            $documentoJSON->formatOutput = true; // salida para que el XML tenga saltos de línea
                            $datos = array(array());
                            // Guardar cada fila en un array asociativo
                            while($fila = $consultaPreparada->fetchObject()) {
                                $datos[$num] = $fila;
                                $num++;
                            }
                            $json_datos = json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                            // 5. Guardar el contenido en un archivo JSON físico en el servidor
                            $directorio = dirname(__DIR__).'/tmp/';
                            // Ruta absoluta para que el servidor guarde el archivo fuera del direcotio de ejercicios pero dentro del tema 4
                            $Guardar = $directorio . 'departamentos.json';
                            file_put_contents($Guardar, $json_datos);
                            echo "<div class='mensaje-exito'>";
                            echo "<h3>Exportacion completada con exito.</h3>";
                            echo "<p>El archivo se ha guardado en: <b>{$Guardar}</b></p>";
                            echo "<a href='../tmp/departamentos.json' target='_blank' style='color: #155724; font-weight: bold; text-decoration: underline;'>Ver archivo XML</a>";
                            $server=$_SERVER['PHP_SELF'];
                            echo "<a href=$server><h3>volver al formulario</h3></a>";
                            echo "</div>";
                        }
                    break;
                }
        ?>
        <?php
            }
            else{
        ?>
        <!-- Mostrar formulario -->
        <div>
            <form name="input" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label for="formatos">Escoje un formato: </label>
                <input list="lenguajes" type="text" id="formatos" name="formatos">
                    <datalist id="lenguajes">
                        <option value="XML">
                        <option value="JSON">
                    </datalist>
                </input>
                <input type="submit" name="submit" value="Enviar">
            </form>
        </div>
        <?php
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