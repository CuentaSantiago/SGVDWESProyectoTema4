<html>
    <head>
        <title>Ejercicio 7</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <h1><a href='../indexProyectoTema4.php'>volver</a></h1>
        <?php
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL); //para ver errores
            $rutaFicheroXML = '../tmp/departamentos.xml';
        ?>
        <?php
        require_once '../core/ConexionDB.php'; //archivo para conexion a la base de datos
            try{
                $miDB = new PDO($host,$USER,$PASSWORD); //conexion a la base de datos
                // Instanciamos DOMDocument y cargamos el archivo XML
                $documentoXML = new DOMDocument();
                $documentoXML->load($rutaFicheroXML);
                $listaDepartamentosXML = $documentoXML->getElementsByTagName('departamento');
                if ($listaDepartamentosXML->length > 0) {
                    $miDB->beginTransaction();
                    $sqlInsert = <<<sql
                                INSERT INTO T02_DEPARTAMENTO (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento)
                                VALUES (:T02_CodDepartamento, :T02_DescDepartamento, :T02_FechaCreacionDepartamento, :T02_VolumenDeNegocio, :T02_FechaBajaDepartamento)
                            sql;
                    $registosPreparados = $miDB->prepare($sqlInsert); //para empezar a probas los nuevos registros
                    $directorioXml = file_get_contents("../tmp/departamentos.xml");
                    // Lo convierte en un json
                    $con = json_encode($directorioXml);
                    // lom Comvierte en un array
                    $newArr = json_decode($con, true);
                    foreach($listaDepartamentosXML as $registros){
                        $registosPreparados->bindParam(":T02_CodDepartamento", $registros->getElementsByTagName("T02_CodDepartamento")->item(0)->nodeValue);
                        $registosPreparados->bindParam(":T02_DescDepartamento", $registros->getElementsByTagName("T02_DescDepartamento")->item(0)->nodeValue);
                        $registosPreparados->bindParam(":T02_FechaCreacionDepartamento", $registros->getElementsByTagName("T02_FechaCreacionDepartamento")->item(0)->nodeValue);
                        $registosPreparados->bindParam(":T02_VolumenDeNegocio", $registros->getElementsByTagName("T02_VolumenDeNegocio")->item(0)->nodeValue);
                        $fechaBaja=$registros->getElementsByTagName("T02_FechaBajaDepartamento")->item(0);
                        $registosPreparados->bindParam(":T02_FechaBajaDepartamento", ($fechaBaja && trim($fechaBaja->nodeValue) !== '') ? $fechaBaja->nodeValue : null );
                        $registosPreparados->execute();
                    }
                    $miDB->commit(); // Confirma los cambios y los consolida
                    echo "<h3>Check: <a href='ejercicio02.php'>Link Ejercicio 2</a></h3>";
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