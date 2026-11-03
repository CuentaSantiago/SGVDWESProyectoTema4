<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ejercicio 4</title>
        <link rel="stylesheet" type="text/css" href="webroot/css/estilos.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            main{
                display: flex;
            }
            table, td, tr, th{
                border: 3px solid black;
                border-collapse: collapse;
            }
            main>div{
                padding-left: 300px
            }
            footer{
                right:0px;
            }
        </style>
    </head>
    <body>
        <header>
            <h2>Ejercicio 4</h2>
        </header>
        <main>
        <?php
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            require_once '../core/ConexionDB.php'; //archivo para conexion a la base de datos
            require_once'../core/231018libreriaValidacion.php'; //archivo para validaciones
            $miDB = new PDO($host,$USER,$PASSWORD); //conexion a la base de datos
        ?>
        <?php
             // importación de la librería
             require_once  '../core/231018libreriaValidacion.php';

            // Inicialización de variables
            $entradaOk = true; // Variable que nos indica que todo va bien
            $aErrores = [
                'TDescripcion' => ''
            ]; // Array donde recogemos los mensajes de error
            $aRespuestas = [
                'TDescripcion' => ''
            ]; // Array donde recogeremos las respuestas correctas (si $entradaOK)
                    if(isset($_POST["submit"])){
                        // Validamos los datos para cada campo del formulario.
                        $aRespuestas['TDescripcion'] = $_POST['TDescripcion'] ?? '';
                        $aErrores['TDescripcion'] = validacionFormularios::comprobarAlfabetico($aRespuestas['TDescripcion'],100,0,1);// comprobamos si hay algun error.
                        if($aErrores['TDescripcion'] == " Campo vacío."){$aErrores['TDescripcion'] = '';}
                        // true: la variable booleana $entradaOk recibe el valor false.
                        foreach ($aErrores as $campo => $valor) {
                            if($valor !== null){
                                $entradaOk = false;
                            }
                        }
                    } else{
                        $entradaOk = false;        // Si el formulario no se ha rellenado nunca.
                    }
                ?>
                <!-- Mostrar formulario -->
                <div>
                    <form name="input" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <!-- Mostrar los datos tecleados correctamente en intentos anteriores (en los value) -->
                        Nombre: <input type="text" name="TDescripcion" value="<?php echo htmlspecialchars($aRespuestas['TDescripcion']); ?>"/>
                        <?php
                        // Mostrar mensajes de error (si los hay y el formulario no se muestra por primera vez)
                        if(!empty($aErrores['TDescripcion'])) {echo "<span style='color:red; display:block; font-size:13px;'>{$aErrores['TDescripcion']}</span>";}
                        ?>
                        <input type="submit" name="submit" value="Enviar"/>
                    </form>
                </div>
                <div>
                <?php
                    // Tratamiento del formulario
                    try{
                    if($entradaOk){
                        $miDB = new PDO($host,$USER,$PASSWORD); //conexion a la base de datos
                        $resultadoConsulta = $miDB->query("select * from T02_DEPARTAMENTO where T02_DescDepartamento like '%".$aRespuestas['TDescripcion']."%'");//consulta
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
                    }
                    else{
                        $miDB = new PDO($host,$USER,$PASSWORD); //conexion a la base de datos
                        $resultadoConsulta = $miDB->query('select * from T02_DEPARTAMENTO');//consulta
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
                    }
                    }catch(PDOException $e){//para atrapar excepciones
                        echo $e->getMessage()."<br>";
                    }
                    finally {
                    // Cierra la conexion con la base de datos
                        unset($Transaccion);
                    }
                ?>
            </div><!-- Espacio del form -->
        </main>
        <footer>
            <div>
            <p><time datetime="2026-10-22">2026-2027</time> IES LOS SAUCES. ©Todos los derechos reservados</p>
            <p>Santiago González Vicente. 14/09/2026</p>
            <a href="../indexProyectoTema4.php"><i class="fa fa-home" style="font-size:40px; margin-right: 15px;"></i></a>
            </div>
        </footer>
    </body>
</html>