<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ejercicio 5</title>
        <style>
            table, td, tr, th{
                border: 3px solid black;
                border-collapse: collapse;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="webroot/css/estilos.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <header>
            <h2>Ejercicio 5</h2>
        </header>
        <?php
        /**
         * Pagina web que añade tres registros a nuestra tabla Departamento utilizando tres instrucciones
         * insert y una transacción, de tal forma que se añadan los tres registros o no se añada ninguno.
         */
            require_once '../core/ConexionDB.php'; //archivo para conexion a la base de datos
            $ok = true;
            try{
                $Transaccion=new PDO($host,$USER,$PASSWORD);
                $Transaccion->beginTransaction(); //para empezar a probas los nuevos registros
                if($Transaccion->exec("insert into T02_DEPARTAMENTO() values('SAN','Departamento de Sanidad','2024-01-15 09:00:00',40000,'2029-01-15 09:00:00');") == 0) $ok = false;
                if($Transaccion->exec("insert into T02_DEPARTAMENTO() values('PUB','Departamento de Publicidad','2024-01-15 09:00:00',40000,'2029-01-15 09:00:00');") == 0) $ok = false;
                if($Transaccion->exec("insert into T02_DEPARTAMENTO() values('PRO','Departamento de Programación','2024-01-15 09:00:00',40000,'2029-01-15 09:00:00');") == 0) $ok = false;
                if ($ok){
                    $Transaccion->commit(); // Si todo fue bien confirma los cambios
                    echo "<h3>Check: <a href='ejercicio02.php'>Link Ejercicio 2</a></h3>";
                }
                else $Transaccion->rollback(); // y si no, los revierte
                }
            catch(PDOException $e){//para atrapar excepciones
                $Transaccion->rollback(); 
                if(str_contains($e,"1062 Duplicate entry")){
                    echo "<h3>Este ejercicio ya se ha ejecutado, espere unos segundos para que se borren los campos para probarlo de nuevo</h3>";
                    $Transaccion->beginTransaction(); //para empezar a probas los nuevos registros
                    $Transaccion->exec("delete from T02_DEPARTAMENTO where T02_CodDepartamento='SAN';");
                    $Transaccion->exec("delete from T02_DEPARTAMENTO where T02_CodDepartamento='PUB';");
                    $Transaccion->exec("delete from T02_DEPARTAMENTO where T02_CodDepartamento='PRO';");
                    $Transaccion->commit();
                    $self = $_SERVER['PHP_SELF'];
                    header("refresh:5; url=$self");
                }
                else{
                    echo $e->getMessage()."<br>";
                }
            }
            finally {
            // Cierra la conexion con la base de datos
                unset($Transaccion);
            }
        ?>
        <footer>
            <div>
            <p><time datetime="2026-10-22">2026-2027</time> IES LOS SAUCES. ©Todos los derechos reservados</p>
            <p>Santiago González Vicente. 14/09/2026</p>
            <a href="../indexProyectoTema4.php"><i class="fa fa-home" style="font-size:40px; margin-right: 15px;"></i></a>
            </div>
        </footer>
    </body>
</html>