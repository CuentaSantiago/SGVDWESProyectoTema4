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
                //lo pasamos a JSON
                $documentoXML->load($rutaFicheroXML);
                //lo pasamos de JSON a un array
                $listaDepartamentosXML = $documentoXML->getElementsByTagName('departamento');
                if ($listaDepartamentosXML->length > 0) {
                    $miDB->beginTransaction();//empezamos la transaccion
                    $sqlInsert = <<<sql
                                INSERT INTO T02_DEPARTAMENTO (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento)
                                VALUES (:T02_CodDepartamento, :T02_DescDepartamento, :T02_FechaCreacionDepartamento, :T02_VolumenDeNegocio, :T02_FechaBajaDepartamento)
                            sql;
                    $registosPreparados = $miDB->prepare($sqlInsert); //para empezar a probas los nuevos registros
                    foreach($listaDepartamentosXML as $registros){
                        //metemos los valores correspondientes a sus campos
                        $registosPreparados->bindParam(":T02_CodDepartamento", $registros->getElementsByTagName("T02_CodDepartamento")->item(0)->nodeValue);
                        $registosPreparados->bindParam(":T02_DescDepartamento", $registros->getElementsByTagName("T02_DescDepartamento")->item(0)->nodeValue);
                        $registosPreparados->bindParam(":T02_FechaCreacionDepartamento", $registros->getElementsByTagName("T02_FechaCreacionDepartamento")->item(0)->nodeValue);
                        $registosPreparados->bindParam(":T02_VolumenDeNegocio", $registros->getElementsByTagName("T02_VolumenDeNegocio")->item(0)->nodeValue);
                        //comprobamos si es null o no la fecha baja paa que no de error
                        $nullFechaBaja=$registros->getElementsByTagName(":T02_FechaBajaDepartamento")->item(0);
                        $FechaBaja=($nullFechaBaja && trim($nullFechaBaja->nodeValue) !== '') ? $nullFechaBaja->nodeValue : null;
                        $registosPreparados->bindParam(":T02_FechaBajaDepartamento", $FechaBaja);
                        $registosPreparados->execute(); // lo ejecutamos
                    }
                    $miDB->commit(); // Confirma los cambios y los consolida
                    echo "<h3>Consulta exitosa</h3>";
                    echo "<h3>Check: <a href='ejercicio02.php'>Link Ejercicio 2</a></h3>"; //comprobar cambios
                }
            }catch(PDOException $e){//para atrapar excepciones
                if(str_contains($e,"1062 Duplicate entry")){
                    echo "<h3>Consulta exitosa</h3>";
                    echo "<h3>Check: <a href='ejercicio02.php'>Link Ejercicio 2</a></h3>"; //comprobar cambios
                }
                else{
                    echo $e->getMessage()."<br>";
                }
            }
            finally {
            // Cierra la conexion con la base de datos
                unset($miDB);
            }
        ?>
    </body>
</html>