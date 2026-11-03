<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ejercicio 6</title>
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
            <h2>Ejercicio 6</h2>
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
                $aregistros=array(
                    ["T02_CodDepartamento"=> "TRB",
                    "T02_DescDepartamento"=> "Despartamentop de derechos de los trabajadores",
                    "T02_FechaCreacionDepartamento"=> "2024-01-15 09:00:00", 
                    "T02_VolumenDeNegocio"=> 5000, 
                    "T02_FechaBajaDepartamento"=> "2030-01-15 09:00:00"],
                    ["T02_CodDepartamento"=> "SOS",
                    "T02_DescDepartamento"=>"Despartamentop de sostenivilidad",
                    "T02_FechaCreacionDepartamento"=>"2020-01-15 09:00:00",
                    "T02_VolumenDeNegocio"=>3000,
                    "T02_FechaBajaDepartamento"=> "2040-01-15 09:00:00"],
                    ["T02_CodDepartamento"=> "EEE",
                    "T02_DescDepartamento"=> "EEE",
                    "T02_FechaCreacionDepartamento"=>"2020-01-15 09:00:00",
                    "T02_VolumenDeNegocio"=>30,
                    "T02_FechaBajaDepartamento"=> "2030-01-15 09:00:00"]
                    );
                $Transaccion->beginTransaction();
                $sqlInsert = <<<sql
                                INSERT INTO T02_DEPARTAMENTO (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento)
                                VALUES (:T02_CodDepartamento, :T02_DescDepartamento, :T02_FechaCreacionDepartamento, :T02_VolumenDeNegocio, :T02_FechaBajaDepartamento)
                            sql;
                $registosPreparados = $Transaccion->prepare($sqlInsert); //para empezar a probas los nuevos registros
                
                foreach($aregistros as $registros){
                    $registosPreparados->bindParam(":T02_CodDepartamento", $registros["T02_CodDepartamento"]);
                    $registosPreparados->bindParam(":T02_DescDepartamento", $registros["T02_DescDepartamento"]);
                    $registosPreparados->bindParam(":T02_FechaCreacionDepartamento", $registros["T02_FechaCreacionDepartamento"]);
                    $registosPreparados->bindParam(":T02_VolumenDeNegocio", $registros["T02_VolumenDeNegocio"]);
                    $registosPreparados->bindParam(":T02_FechaBajaDepartamento", $registros["T02_FechaBajaDepartamento"]);
                    $registosPreparados->execute();
                }
                $Transaccion->commit(); // Confirma los cambios y los consolida
                $resultadoConsulta = $Transaccion->query('select * from T02_DEPARTAMENTO');//consulta
                echo "<table>";
                echo "<tr>";
                echo "<th>Codigo</th>";
                echo "<th>Nombre</th>";
                echo "<th>Fecha Creacion</th>";
                echo "<th>Valor de Departmento</th>";
                echo "<th>FechaBaja</th>";
                echo "</tr>";
                while ($registro = $resultadoConsulta ->fetch()){//mostrar resultados
                    echo "<tr>";
                    echo '<td>'.$registro['T02_CodDepartamento'].'</td>';
                    echo '<td>'.$registro["T02_DescDepartamento"].'</td>';
                    $FechaCreacion = new DateTime($registro["T02_FechaCreacionDepartamento"]);
                    echo '<td>'.$FechaCreacion->format('d/m/Y').'</td>';
                    echo '<td>'.number_format($registro["T02_VolumenDeNegocio"],2,',','.').' €</td>';
                    if ($registro["T02_FechaBajaDepartamento"]!==null) {//comprobacion null
                        $FechaBaja = new DateTime($registro["T02_FechaBajaDepartamento"]);
                        echo '<td>'.$FechaBaja->format('d/m/Y').'</td>';
                    } else {
                        echo '<td></td>';
                    }
                    echo "<tr>";
                }
                echo "<table>";
            }catch(PDOException $e){//para atrapar excepciones
                $Transaccion->rollback(); 
                if(str_contains($e,"1062 Duplicate entry")){
                    echo "<h3>Este ejercicio ya se ha ejecutado, espere unos segundos para que se borren los campos para probarlo de nuevo</h3>";
                    $Transaccion->beginTransaction(); //para empezar a probas los nuevos registros
                    $Transaccion->exec("delete from T02_DEPARTAMENTO where T02_CodDepartamento='TRB';");
                    $Transaccion->exec("delete from T02_DEPARTAMENTO where T02_CodDepartamento='SOS';");
                    $Transaccion->exec("delete from T02_DEPARTAMENTO where T02_CodDepartamento='EEE';");
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